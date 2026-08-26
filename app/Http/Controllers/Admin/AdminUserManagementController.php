<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Critique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminUserManagementController extends Controller
{
    public function index()
    {
        // HANYA TAMPILKAN USER DENGAN ROLE 'user' (BUKAN ADMIN)
        $users = User::where('role', 'user')
            ->withCount(['critiques' => function($query) {
                $query->whereNotNull('submitted_at');
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $totalUsers = User::where('role', 'user')->count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalUsersRole = User::where('role', 'user')->count();
        $totalCritiques = Critique::count();
        $activeUsers = User::where('role', 'user')->whereHas('critiques')->count();

        return view('admin.users.manage', compact(
            'users',
            'totalUsers',
            'totalAdmins',
            'totalUsersRole',
            'totalCritiques',
            'activeUsers'
        ));
    }

    public function show($id)
    {
        // PASTIKAN YANG DILIHAT ADALAH USER BUKAN ADMIN
        $user = User::where('role', 'user')->with(['critiques' => function($query) {
                $query->orderBy('created_at', 'desc');
            }, 'critiques.category'])
            ->findOrFail($id);

        $totalCritiques = $user->critiques->count();
        $critiqueStatus = $user->critiques->groupBy('status')->map->count();
        $lastCritique = $user->critiques->first();

        return view('admin.users.detail', compact('user', 'totalCritiques', 'critiqueStatus', 'lastCritique'));
    }

    public function destroy($id)
    {
        // PASTIKAN YANG DIHAPUS ADALAH USER BUKAN ADMIN
        $user = User::where('role', 'user')->findOrFail($id);

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
        // PASTIKAN YANG DIUBAH ADALAH USER BUKAN ADMIN
        $user = User::where('role', 'user')->findOrFail($id);

        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.manage')
                ->with('error', 'Anda tidak dapat mengubah role sendiri!');
        }

        $user->role = 'admin';
        $user->save();

        return redirect()->route('admin.users.manage')
            ->with('success', 'User berhasil dijadikan Admin!');
    }
}
