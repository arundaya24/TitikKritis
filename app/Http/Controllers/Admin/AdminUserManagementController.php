<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Critique;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class AdminUserManagementController extends Controller
{
    public function index()
    {
        $users = User::role('user')
            ->withCount('critiques')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $totalUsers = User::role('user')->count();
        $totalAdmins = User::role('admin')->count();
        $totalSuperAdmins = User::role('superadmin')->count();
        $totalCritiques = Critique::count();

        $activeUsers = User::role('user')
            ->whereHas('critiques')
            ->count();

        return view('admin.users.manage', compact(
            'users',
            'totalUsers',
            'totalAdmins',
            'totalSuperAdmins',
            'totalCritiques',
            'activeUsers'
        ));
    }

    public function show($id)
    {
        $user = User::role('user')
            ->with([
                'critiques' => function ($query) {
                    $query->orderBy('created_at', 'desc');
                },
                'critiques.category'
            ])
            ->findOrFail($id);

        $totalCritiques = $user->critiques->count();
        $critiqueStatus = $user->critiques->groupBy('status')->map->count();
        $lastCritique = $user->critiques->first();

        return view('admin.users.detail', compact(
            'user',
            'totalCritiques',
            'critiqueStatus',
            'lastCritique'
        ));
    }

    public function destroy($id)
    {
        $user = User::role('user')->findOrFail($id);

        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.manage')
                ->with('error', 'Anda tidak dapat menghapus akun sendiri!');
        }

        foreach ($user->critiques as $critique) {
            if ($critique->image) {
                Storage::disk('public')->delete($critique->image);
            }

            $critique->delete();
        }

        $user->delete();

        return redirect()->route('admin.users.manage')
            ->with('success', 'User berhasil dihapus!');
    }

    public function toggleAdmin($id)
    {
        $user = User::role('user')->findOrFail($id);

        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.manage')
                ->with('error', 'Anda tidak dapat mengubah role sendiri!');
        }

        $user->syncRoles(['admin']);

        return redirect()->route('admin.users.manage')
            ->with('success', 'User berhasil dijadikan Admin!');
    }
}
