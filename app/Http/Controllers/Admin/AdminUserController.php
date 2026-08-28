<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminUserController extends Controller
{
    public function index()
    {
        // Tampilkan semua admin dan super_admin
        $admins = User::whereIn('role', ['admin', 'super_admin'])
            ->orderByRaw("FIELD(role, 'super_admin', 'admin')")
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.users.index', compact('admins'));
    }

    public function create()
    {
        $provinces = Province::orderBy('name')->get();
        // Cek apakah user yang login bisa membuat super admin
        $canCreateSuperAdmin = auth()->user()->canCreateSuperAdmin();
        return view('admin.users.create', compact('provinces', 'canCreateSuperAdmin'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'province_id' => 'required|exists:provinces,id',
            'regency_id' => 'required|exists:regencies,id',
            'district_id' => 'required|exists:districts,id',
            'address' => 'nullable|string',
            'role' => 'nullable|in:admin,super_admin',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Tentukan role
        $role = $request->role ?? 'admin';

        // Hanya super admin yang bisa membuat super admin
        if ($role === 'super_admin' && !auth()->user()->canCreateSuperAdmin()) {
            return redirect()->back()
                ->with('error', 'Anda tidak memiliki izin untuk membuat Super Admin!')
                ->withInput();
        }

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'province_id' => $request->province_id,
            'regency_id' => $request->regency_id,
            'district_id' => $request->district_id,
            'address' => $request->address,
            'role' => $role,
        ]);

        $roleName = $role === 'super_admin' ? 'Super Admin' : 'Admin';
        return redirect()->route('admin.users.index')
            ->with('success', $roleName . ' berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Tidak bisa hapus diri sendiri
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun sendiri!');
        }

        // Hanya super admin yang bisa hapus super admin
        if ($user->role === 'super_admin' && !auth()->user()->canManageAdmins()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Hanya Super Admin yang bisa menghapus Super Admin!');
        }

        // Cek apakah user yang dihapus adalah user terakhir dengan role admin/super_admin
        $adminCount = User::whereIn('role', ['admin', 'super_admin'])->count();
        if ($adminCount <= 1) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Tidak dapat menghapus admin terakhir! Minimal harus ada 1 admin.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus!');
    }

    public function demote($id)
    {
        $user = User::findOrFail($id);

        // Tidak bisa turunkan diri sendiri
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Anda tidak dapat menurunkan role sendiri!');
        }

        // Hanya super admin yang bisa turunkan super admin
        if ($user->role === 'super_admin' && !auth()->user()->canManageAdmins()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Hanya Super Admin yang bisa menurunkan Super Admin!');
        }

        // Cek apakah user yang diturunkan adalah user terakhir dengan role admin/super_admin
        $adminCount = User::whereIn('role', ['admin', 'super_admin'])->count();
        if ($adminCount <= 1) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Tidak dapat menurunkan admin terakhir! Minimal harus ada 1 admin.');
        }

        // Turunkan ke user biasa
        $user->role = 'user';
        $user->save();

        return redirect()->route('admin.users.index')
            ->with('success', $user->name . ' berhasil diturunkan menjadi user biasa!');
    }

    // ===== PROMOTE: User/Admin menjadi Super Admin =====
    public function promote($id)
    {
        // Hanya super admin yang bisa promote
        if (!auth()->user()->canCreateSuperAdmin()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Hanya Super Admin yang bisa membuat Super Admin baru!');
        }

        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Anda sudah Super Admin!');
        }

        $user->role = 'super_admin';
        $user->save();

        return redirect()->route('admin.users.index')
            ->with('success', $user->name . ' berhasil dijadikan Super Admin!');
    }
}
