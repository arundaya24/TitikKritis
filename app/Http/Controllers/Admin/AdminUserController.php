<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AdminUserController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $admins = User::role('admin')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.users.index', compact('admins'));
    }

    public function create()
    {
        $provinces = Province::orderBy('name')->get();
        return view('admin.users.create', compact('provinces'));
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
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $admin = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'province_id' => $request->province_id,
            'regency_id' => $request->regency_id,
            'district_id' => $request->district_id,
            'address' => $request->address,
            'role' => 'admin',
        ]);

        $admin->assignRole('admin');

        return redirect()->route('admin.users.index')
            ->with('success', 'Admin berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $admin = User::findOrFail($id);

        if ($admin->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun sendiri!');
        }

        $admin->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Admin berhasil dihapus!');
    }
}
