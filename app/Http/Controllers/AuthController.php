<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

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
        $user = Auth::user();

        // Jika user tidak ditemukan di session, jangan paksa akses array
        if (!$user) {
            return redirect()->route('login')->with('warning', 'Sesi Anda telah berakhir.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            // Gunakan $user->id (object syntax) bukan $user['id'] (array syntax)
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        // Simpan password lama jika input password kosong
        $newPassword = $request->filled('password') ? Hash::make($request->password) : $user->password;

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $newPassword,
        ]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'Email tidak terdaftar di sistem kami.'
        ]);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? redirect()->back()->with('status', 'Kami telah mengirimkan link reset password ke email Anda!')
            : redirect()->back()->withErrors(['email' => 'Gagal mengirim email reset password.']);
    }

    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }


    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
                $user->save();
                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Password berhasil diubah!')
            : redirect()->back()->withErrors(['email' => [__($status)]]);
    }
}
