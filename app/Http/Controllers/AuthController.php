<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'password' => 'required',
        ]);

        // Ambil data dari .env
        $id = $request->input('id');
        $password = $request->input('password');

        $envId = env('ADMIN_ID'); // ID dari .env
        $envPassword = env('ADMIN_PASSWORD'); // Password dari .env

        if ($id === $envId && $password === $envPassword) {
            // Simpan ke sesi
            $request->session()->put('user_id', $id);
            return redirect()->intended('/dashboard')->with('success', 'Login berhasil!');
        }

        return back()->withErrors(['id' => 'ID atau password salah.'])->withInput();
    }

    public function logout(Request $request)
    {
        $request->session()->forget('user_id');
        return redirect('/login')->with('success', 'Logout berhasil!');
    }
}
