<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Critique;
use App\Models\CritiqueHistory;
use App\Models\Response;
use App\Notifications\CritiqueResponded;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminCritiqueController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = Critique::with([
            'user',
            'category',
            'province',
            'regency',
            'district',
        ]);

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        $archived = $request->input('archived', 0);

        $query->where('is_archived', $archived);

        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('content', 'like', '%' . $search . '%');
            });
        }

        $critiques = $query
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $categories = Category::orderBy('name')->get();

        $statuses = [
            'dikirim',
            'ditinjau',
            'diproses',
            'selesai',
            'ditolak',
        ];

        return view(
            'admin.critiques.index',
            compact(
                'critiques',
                'categories',
                'statuses'
            )
        );
    }

    public function archiveIndex(Request $request)
    {
        $query = Critique::with([
            'user',
            'category',
            'province',
            'regency',
            'district',
        ])
            ->where('is_archived', true);

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('content', 'like', '%' . $search . '%');
            });
        }

        $critiques = $query
            ->orderBy('updated_at', 'desc')
            ->paginate(15);

        $categories = Category::orderBy('name')->get();

        $statuses = [
            'dikirim',
            'ditinjau',
            'diproses',
            'selesai',
            'ditolak',
        ];

        return view(
            'admin.critiques.archive',
            compact(
                'critiques',
                'categories',
                'statuses'
            )
        );
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
            'messages.user',
        ])->findOrFail($id);

        $statuses = [
            'dikirim',
            'ditinjau',
            'diproses',
            'selesai',
            'ditolak',
        ];

        return view(
            'admin.critiques.show',
            compact(
                'critique',
                'statuses'
            )
        );
    }

    public function updateStatus(Request $request, $id)
    {
        $critique = Critique::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:dikirim,ditinjau,diproses,selesai,ditolak',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $oldStatus = $critique->status;
        $newStatus = $request->input('status');

        if ($oldStatus === $newStatus) {
            return redirect()
                ->route('admin.critiques.show', $critique->id)
                ->with(
                    'error',
                    'Status tidak berubah.'
                );
        }

        $allowedTransitions = [
            'dikirim' => [
                'ditinjau',
                'ditolak',
            ],

            'ditinjau' => [
                'diproses',
                'ditolak',
            ],

            'diproses' => [
                'selesai',
            ],

            'selesai' => [],

            'ditolak' => [],
        ];

        if (
            !isset($allowedTransitions[$oldStatus]) ||
            !in_array(
                $newStatus,
                $allowedTransitions[$oldStatus]
            )
        ) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    "Status tidak dapat diubah dari {$oldStatus} menjadi {$newStatus}."
                );
        }

        $isClosed = in_array(
            $newStatus,
            ['selesai', 'ditolak']
        );

        $critique->update([
            'status' => $newStatus,
            'user_can_reply' => !$isClosed,
        ]);

        CritiqueHistory::create([
            'critique_id' => $critique->id,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'changed_by' => Auth::id(),
            'note' => 'Status diubah oleh admin',
        ]);

        return redirect()
            ->route(
                'admin.critiques.show',
                $critique->id
            )
            ->with(
                'success',
                'Status kritik berhasil diperbarui!'
            );
    }

    public function respond(Request $request, $id)
    {
        $critique = Critique::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'content' => 'required|string|min:10',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $content = $request->input('content');

        Response::updateOrCreate(
            [
                'critique_id' => $critique->id,
            ],
            [
                'admin_id' => Auth::id(),
                'content' => $content,
            ]
        );

        if ($critique->user) {
            $critique->user->notify(
                new CritiqueResponded($critique)
            );
        }

        return redirect()
            ->route(
                'admin.critiques.show',
                $critique->id
            )
            ->with(
                'success',
                'Tanggapan berhasil dikirim!'
            );
    }

    public function forceDelete($id)
    {
        $critique = Critique::where(
            'status',
            'ditolak'
        )->findOrFail($id);

        if ($critique->image) {
            Storage::disk('public')->delete(
                $critique->image
            );
        }

        $critique->delete();

        return redirect()
            ->route('admin.critiques.index')
            ->with(
                'success',
                'Kritik yang ditolak berhasil dihapus!'
            );
    }

    public function archive($id)
    {
        $critique = Critique::where(
            'status',
            'selesai'
        )->findOrFail($id);

        $critique->is_archived = true;
        $critique->save();

        return redirect()
            ->route('admin.critiques.index')
            ->with(
                'success',
                'Kritik berhasil diarsipkan!'
            );
    }

    public function unarchive($id)
    {
        $critique = Critique::where(
            'is_archived',
            true
        )->findOrFail($id);

        $critique->is_archived = false;
        $critique->save();

        return redirect()
            ->route('admin.critiques.archive.index')
            ->with(
                'success',
                'Kritik berhasil dikembalikan dari arsip!'
            );
    }

    public function deleteArchived($id)
    {
        $critique = Critique::where(
            'is_archived',
            true
        )->findOrFail($id);

        if ($critique->image) {
            Storage::disk('public')->delete(
                $critique->image
            );
        }

        $critique->delete();

        return redirect()
            ->route('admin.critiques.archive.index')
            ->with(
                'success',
                'Kritik arsip berhasil dihapus!'
            );
    }

    public function message(Request $request, $id)
    {
        $critique = Critique::findOrFail($id);

        if (in_array(
            $critique->status,
            ['selesai', 'ditolak']
        )) {
            return back()->with(
                'error',
                'Laporan ini sudah ditutup.'
            );
        }

        $request->validate([
            'message' => 'required|string|min:1|max:5000',
        ]);

        $critique->messages()->create([
            'user_id' => Auth::id(),
            'message' => $request->input('message'),
        ]);

        if ($critique->user) {
            $critique->user->notify(
                new CritiqueResponded($critique)
            );
        }

        return back()->with(
            'success',
            'Balasan berhasil dikirim.'
        );
    }
}
