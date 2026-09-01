<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Critique;
use App\Models\CritiqueHistory;
use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use App\Models\User;
use App\Notifications\NewCritiqueSubmitted;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CritiqueController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = Critique::where('user_id', Auth::id());

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        if ($request->filled('archived')) {
            $query->where('is_archived', $request->input('archived'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%'.$search.'%')
                    ->orWhere('content', 'like', '%'.$search.'%');
            });
        }

        $critiques = $query
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $categories = Category::orderBy('name')->get();

        $statuses = [
            'dikirim',
            'ditinjau',
            'diproses',
            'selesai',
            'ditolak',
        ];

        return view(
            'critique.index',
            compact('critiques', 'categories', 'statuses')
        );
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $provinces = Province::orderBy('name')->get();
        $user = Auth::user();

        $recentCritiques = Critique::with(['user', 'category'])
            ->orderBy('submitted_at', 'desc')
            ->get();

        return view('critique.create', compact(
            'categories',
            'provinces',
            'user',
            'recentCritiques'
        ));
    }

    public function store(Request $request)
    {
        $validator = $this->validateCritique($request);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $content = $request->input('content');

        $badWords = $this->checkBadWords($content);

        if (! empty($badWords)) {
            return redirect()->back()
                ->withErrors([
                    'content' => 'Kritik mengandung kata-kata yang tidak diperbolehkan: '
                        .implode(', ', $badWords),
                ])
                ->withInput();
        }

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('critique_images', 'public');
        }

        $critique = Critique::create([
            'user_id' => Auth::id(),
            'category_id' => $request->input('category_id'),
            'province_id' => $request->input('province_id'),
            'regency_id' => $request->input('regency_id'),
            'district_id' => $request->input('district_id'),
            'government_level' => $request->input('government_level'),
            'title' => $request->input('title'),
            'content' => $content,
            'image' => $imagePath,
            'is_anonymous' => $request->boolean('is_anonymous'),
            'status' => 'dikirim',
            'submitted_at' => now(),
        ]);

        CritiqueHistory::create([
            'critique_id' => $critique->id,
            'old_status' => null,
            'new_status' => 'dikirim',
            'changed_by' => Auth::id(),
            'note' => 'Kritik dikirim oleh pengguna',
        ]);

        $admins = User::whereIn('role', ['admin', 'super_admin'])->get();

        if ($admins->isNotEmpty()) {
            Notification::send($admins, new NewCritiqueSubmitted($critique));
        }

        return redirect()
            ->route('critique.show', $critique->id)
            ->with('success', 'Kritik berhasil dikirim!');
    }

    public function show($id)
    {
        $critique = Critique::with([
            'user',
            'category',
            'province',
            'regency',
            'district',
            'histories',
            'response',
        ])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        $this->authorize('view', $critique);

        return view('critique.show', compact('critique'));
    }

    public function edit($id)
    {
        $critique = Critique::where('user_id', Auth::id())
            ->findOrFail($id);

        $this->authorize('update', $critique);

        if ($critique->status !== 'dikirim') {
            return redirect()
                ->route('critique.show', $critique->id)
                ->with(
                    'error',
                    'Kritik tidak dapat diedit karena sudah diproses.'
                );
        }

        $categories = Category::orderBy('name')->get();
        $provinces = Province::orderBy('name')->get();

        $regencies = Regency::where(
            'province_id',
            $critique->province_id
        )
            ->orderBy('name')
            ->get();

        $districts = collect();

        if ($critique->regency_id) {
            $districts = District::where(
                'regency_id',
                $critique->regency_id
            )
                ->orderBy('name')
                ->get();
        }

        return view('critique.edit', compact(
            'critique',
            'categories',
            'provinces',
            'regencies',
            'districts'
        ));
    }

    public function update(Request $request, $id)
    {
        $critique = Critique::where('user_id', Auth::id())
            ->findOrFail($id);

        $this->authorize('update', $critique);

        if ($critique->status !== 'dikirim') {
            return redirect()
                ->route('critique.show', $critique->id)
                ->with(
                    'error',
                    'Kritik tidak dapat diedit karena sudah diproses.'
                );
        }

        $validator = $this->validateCritique($request);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $content = $request->input('content');

        $badWords = $this->checkBadWords($content);

        if (! empty($badWords)) {
            return redirect()->back()
                ->withErrors([
                    'content' => 'Kritik mengandung kata-kata yang tidak diperbolehkan: '
                        .implode(', ', $badWords),
                ])
                ->withInput();
        }

        if ($request->hasFile('image')) {
            if ($critique->image) {
                Storage::disk('public')->delete($critique->image);
            }

            $imagePath = $request->file('image')
                ->store('critique_images', 'public');

            $critique->image = $imagePath;
        }

        $critique->update([
            'category_id' => $request->input('category_id'),
            'province_id' => $request->input('province_id'),
            'regency_id' => $request->input('regency_id'),
            'district_id' => $request->input('district_id'),
            'government_level' => $request->input('government_level'),
            'title' => $request->input('title'),
            'content' => $content,
            'is_anonymous' => $request->boolean('is_anonymous'),
        ]);

        return redirect()
            ->route('critique.show', $critique->id)
            ->with('success', 'Kritik berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $critique = Critique::where('user_id', Auth::id())
            ->findOrFail($id);

        $this->authorize('delete', $critique);

        if ($critique->status !== 'dikirim') {
            return redirect()
                ->route('critique.show', $critique->id)
                ->with(
                    'error',
                    'Kritik tidak dapat dihapus karena sudah diproses.'
                );
        }

        if ($critique->image) {
            Storage::disk('public')->delete($critique->image);
        }

        $critique->delete();

        return redirect()
            ->route('critique.index')
            ->with('success', 'Kritik berhasil dihapus!');
    }

    public function history()
    {
        $activeCritiques = Critique::where('user_id', Auth::id())
            ->where('is_archived', false)
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'active_page');

        $archivedCritiques = Critique::where('user_id', Auth::id())
            ->where('is_archived', true)
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'archived_page');

        return view('critique.history', compact('activeCritiques', 'archivedCritiques'));
    }

    protected function validateCritique(Request $request)
    {
        return Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'government_level' => 'required|in:kecamatan,kabupaten,provinsi',
            'province_id' => 'required|exists:provinces,id',
            'regency_id' => 'nullable|exists:regencies,id',
            'district_id' => 'nullable|exists:districts,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:10',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:10240',
        ]);
    }

    protected function checkBadWords($content)
    {
        $badWords = [
            'anjing',
            'bangsat',
            'brengsek',
            'keparat',
            'setan',
            'sialan',
            'tolol',
            'bego',
            'goblog',
            'kontol',
            'memek',
            'ngentot',
            'tai',
            'monyet',
            'babi',
            'goblok',
            'idiot',
            'dongo',
            'asu',
            'ngewe',
            'bodoh',
            'berak',
            'titit',
            'pantat',
            'bool',
            'kampang',
            'fuck',
            'shit',
            'goddamn',
        ];

        $found = [];

        foreach ($badWords as $word) {
            if (stripos($content, $word) !== false) {
                $found[] = $word;
            }
        }

        return $found;
    }

    public function getRegencies(Request $request)
    {
        $regencies = Regency::where(
            'province_id',
            $request->input('province_id')
        )
            ->orderBy('name')
            ->get();

        return response()->json($regencies);
    }

    public function getDistricts(Request $request)
    {
        $districts = District::where(
            'regency_id',
            $request->input('regency_id')
        )
            ->orderBy('name')
            ->get();

        return response()->json($districts);
    }

    // ===== HAPUS KRITIK YANG DITOLAK =====
    public function forceDelete($id)
    {
        $critique = Critique::where('user_id', Auth::id())
            ->where('status', 'ditolak')
            ->findOrFail($id);

        if ($critique->image) {
            Storage::disk('public')->delete($critique->image);
        }

        $critique->delete();

        return redirect()->route('critique.history')
            ->with('success', 'Kritik yang ditolak berhasil dihapus!');
    }

    // ===== ARSIP KRITIK YANG SELESAI =====
    public function archive($id)
    {
        $critique = Critique::where('user_id', Auth::id())
            ->where('status', 'selesai')
            ->findOrFail($id);

        $critique->is_archived = true;
        $critique->save();

        return redirect()->route('critique.history')
            ->with('success', 'Kritik berhasil diarsipkan!');
    }

    // ===== KEMBALIKAN DARI ARSIP =====
    public function unarchive($id)
    {
        $critique = Critique::where('user_id', Auth::id())
            ->where('is_archived', true)
            ->findOrFail($id);

        $critique->is_archived = false;
        $critique->save();

        return redirect()->route('critique.history')
            ->with('success', 'Kritik berhasil dikembalikan dari arsip!');
    }

    // ===== HAPUS DARI ARSIP =====
    public function deleteArchived($id)
    {
        $critique = Critique::where('user_id', Auth::id())
            ->where('is_archived', true)
            ->findOrFail($id);

        if ($critique->image) {
            Storage::disk('public')->delete($critique->image);
        }

        $critique->delete();

        return redirect()->route('critique.history')
            ->with('success', 'Kritik arsip berhasil dihapus!');
    }
}
