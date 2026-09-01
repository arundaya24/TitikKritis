<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        $provinces = Province::orderBy('name')->get();

        return view('auth.register', compact('provinces'));
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login dengan akun Anda.');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
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
    }

    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'] ?? null,
            'province_id' => $data['province_id'],
            'regency_id' => $data['regency_id'],
            'district_id' => $data['district_id'],
            'address' => $data['address'] ?? null,
            'role' => 'user',
        ]);

        return $user;
    }

    public function getRegencies(Request $request)
    {
        $regencies = Regency::where('province_id', $request->province_id)->orderBy('name')->get();

        return response()->json($regencies);
    }

    public function getDistricts(Request $request)
    {
        $districts = District::where('regency_id', $request->regency_id)->orderBy('name')->get();

        return response()->json($districts);
    }
}
