<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function proseslogin(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Cek kredensial
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Jika berhasil, lakukan login
            Auth::login($user);

            // Redirect ke dashboard
            return redirect()->route('dashboard');
        } else {
            // Jika gagal, simpan pesan peringatan ke session
            Session::flash('warning', 'Email atau password salah');

            // Redirect kembali ke halaman login
            return redirect()->route('login');
        }
    }

    public function proseslogout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = \App\Models\User::find(Auth::id());

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
    public function forgotPassword()
    {
        return view('auth.forgot-password'); // Sesuaikan dengan nama file blade Anda
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'Email tidak terdaftar di sistem kami.'
        ]);

        // Logika: 
        // 1. Buat Token unik
        // 2. Simpan ke tabel password_resets
        // 3. Kirim email ke user (memerlukan setup Mail)

        // Contoh simulasi pesan sukses
        return redirect()->back()->with('status', 'Kami telah mengirimkan link reset password ke email Anda!');
    }
}
