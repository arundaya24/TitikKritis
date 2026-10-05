<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Critique;
use App\Models\CritiqueHistory;
use App\Models\Response;
use App\Notifications\CritiqueResponded;
use App\Notifications\CritiqueStatusUpdated;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\CritiqueUpdate;
use App\Models\CritiqueUpdateFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;


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
                $q->where('title', 'like', '%'.$search.'%')
                    ->orWhere('content', 'like', '%'.$search.'%');
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
                $q->where('title', 'like', '%'.$search.'%')
                    ->orWhere('content', 'like', '%'.$search.'%');
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

    /**
     * Route lama (ubah status saja). Tetap dipertahankan agar route
     * admin.critiques.status tidak error. Form baru memakai respond().
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => [
                'required',
                'in:dikirim,ditinjau,diproses,selesai,ditolak',
            ],
            'files' => [
                'required',
                'array',
                'min:1',
            ],
            'files.*' => [
                'file',
                'mimes:jpg,jpeg,png,webp,pdf,doc,docx',
                'max:10240',
            ],
        ]);

        $critique = Critique::findOrFail($id);

        DB::transaction(function () use ($request, $critique) {
            $this->applyStatusChange($request, $critique);
        });

        return redirect()
            ->back()
            ->with(
                'success',
                'Status dan bukti berhasil diperbarui.'
            );
    }

    /**
     * Tindak lanjut gabungan:
     * - tanggapan saja            -> boleh tanpa bukti
     * - bukti (files)             -> wajib disertai tanggapan
     * - ubah status               -> wajib bukti + tanggapan
     */
    public function respond(Request $request, $id)
    {
        $critique = Critique::findOrFail($id);

        $allowedStatuses = [
            'dikirim'  => ['ditinjau', 'ditolak'],
            'ditinjau' => ['diproses', 'ditolak'],
            'diproses' => ['selesai'],
        ][$critique->status] ?? [];

        $validator = Validator::make($request->all(), [
            'status' => [
                'nullable',
                Rule::in($allowedStatuses),
            ],
            'files' => [
                'required_with:status',
                'array',
                'min:1',
            ],
            'files.*' => [
                'file',
                'mimes:jpg,jpeg,png,webp,pdf,doc,docx',
                'max:10240',
            ],
            'content' => [
                'nullable',
                'required_with:files,status',
                'string',
                'min:10',
                'max:5000',
            ],
        ], [
            'content.required_with' => 'Tanggapan wajib diisi jika mengunggah bukti atau mengubah status.',
            'content.min'           => 'Tanggapan minimal 10 karakter.',
            'files.required_with'   => 'Bukti wajib diunggah saat mengubah status.',
            'status.in'             => 'Perubahan status tidak valid untuk status laporan saat ini.',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        if (
            ! $request->filled('content')
            && ! $request->filled('status')
        ) {
            return redirect()
                ->back()
                ->withErrors('Isi tanggapan atau pilih perubahan status.')
                ->withInput();
        }

        DB::transaction(function () use ($request, $critique) {
            if ($request->filled('status')) {
                $this->applyStatusChange($request, $critique);
            }

            if ($request->filled('content')) {
                $this->saveResponse($request, $critique);
            }
        });

        // Notifikasi dikirim setelah transaksi sukses
        if ($request->filled('content') && $critique->user) {
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
                'Tindak lanjut berhasil disimpan!'
            );
    }

    /**
     * Ubah status + simpan bukti + catat riwayat.
     */
    private function applyStatusChange(Request $request, Critique $critique): void
    {
        $oldStatus = $critique->status;
        $newStatus = $request->input('status');

        $update = CritiqueUpdate::create([
            'critique_id' => $critique->id,
            'user_id'     => Auth::id(),
            'old_status'  => $oldStatus,
            'new_status'  => $newStatus,
        ]);

        foreach ($request->file('files', []) as $file) {
            $path = $file->store(
                'critique_updates',
                'public'
            );

            CritiqueUpdateFile::create([
                'critique_update_id' => $update->id,
                'file_path'          => $path,
                'original_name'      => $file->getClientOriginalName(),
            ]);
        }

        $critique->update([
            'status' => $newStatus,
        ]);

        CritiqueHistory::create([
            'critique_id' => $critique->id,
            'old_status'  => $oldStatus,
            'new_status'  => $newStatus,
            'changed_by'  => Auth::id(),
            'note'        => 'Status diperbarui oleh admin',
        ]);
    }

    /**
     * Simpan tanggapan admin (tanpa notifikasi; notifikasi dikirim di respond()).
     */
    private function saveResponse(Request $request, Critique $critique): void
    {
        Response::updateOrCreate(
            [
                'critique_id' => $critique->id,
            ],
            [
                'admin_id' => Auth::id(),
                'content'  => $request->input('content'),
            ]
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
                'Kritik yang ditolak berhasil dihapus.'
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
                'Kritik berhasil diarsipkan.'
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
                'Kritik berhasil dikembalikan dari arsip.'
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
                'Kritik arsip berhasil dihapus.'
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
