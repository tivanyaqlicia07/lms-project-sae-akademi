<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {
    // Menampilkan halaman login
    public function showLogin() {
        return view('auth.login');
    }

    // Menampilkan halaman register
    public function showRegister() {
        return view('auth.register');
    }

    // Proses login
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Redirect berdasarkan role
            return match ($user->role) {
                'admin' => redirect()->route('admin.dashboard'),
                'editor' => redirect()->route('editor.dashboard'),
                'fasilitator' => redirect()->route('fasilitator.dashboard'),
                'mentor' => redirect()->route('mentor.dashboard'),
                default => redirect()->route('login')->withErrors(['email' => 'Role tidak dikenali.']),
            };
        }

        return back()->withErrors(['email' => 'Email atau password salah!']);
    }

    // Proses registrasi
    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:fasilitator,mentor'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan login.');
    }

    // Proses logout
    public function logout() {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Berhasil logout.');
    }
}