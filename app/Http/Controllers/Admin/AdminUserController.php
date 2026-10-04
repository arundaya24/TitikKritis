<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminUserController extends Controller
{
    public function index()
    {
        $admins = User::role(['admin', 'superadmin'])
            ->with('roles')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $totalAdmins = User::role('admin')->count();
        $totalSuperAdmins = User::role('superadmin')->count();

        return view('admin.users.index', compact(
            'admins',
            'totalAdmins',
            'totalSuperAdmins'
        ));
    }

    public function create()
    {
        $provinces = Province::orderBy('name')->get();

        $canCreateSuperAdmin = auth()->user()->hasRole('superadmin');

        return view('admin.users.create', compact(
            'provinces',
            'canCreateSuperAdmin'
        ));
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
            'role' => 'nullable|in:admin,superadmin',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $role = $request->role ?? 'admin';

        if ($role === 'superadmin' && !auth()->user()->hasRole('superadmin')) {
            return redirect()->back()
                ->with('error', 'Anda tidak memiliki izin untuk membuat Super Admin!')
                ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'province_id' => $request->province_id,
            'regency_id' => $request->regency_id,
            'district_id' => $request->district_id,
            'address' => $request->address,
        ]);

        $user->syncRoles([$role]);

        $roleName = $role === 'superadmin' ? 'Super Admin' : 'Admin';

        return redirect()->route('admin.users.index')
            ->with('success', $roleName . ' berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun sendiri!');
        }

        if ($user->hasRole('superadmin') && !auth()->user()->hasRole('superadmin')) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Hanya Super Admin yang bisa menghapus Super Admin!');
        }

        $adminCount = User::role(['admin', 'superadmin'])->count();

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

        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Anda tidak dapat menurunkan role sendiri!');
        }

        if ($user->hasRole('superadmin') && !auth()->user()->hasRole('superadmin')) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Hanya Super Admin yang bisa menurunkan Super Admin!');
        }

        $adminCount = User::role(['admin', 'superadmin'])->count();

        if ($adminCount <= 1) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Tidak dapat menurunkan admin terakhir! Minimal harus ada 1 admin.');
        }

        $user->syncRoles(['user']);

        return redirect()->route('admin.users.index')
            ->with('success', $user->name . ' berhasil diturunkan menjadi user biasa!');
    }

    public function promote($id)
    {
        if (!auth()->user()->hasRole('superadmin')) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Hanya Super Admin yang bisa membuat Super Admin baru!');
        }

        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Anda sudah Super Admin!');
        }

        $user->syncRoles(['superadmin']);

        return redirect()->route('admin.users.index')
            ->with('success', $user->name . ' berhasil dijadikan Super Admin!');
    }
}
