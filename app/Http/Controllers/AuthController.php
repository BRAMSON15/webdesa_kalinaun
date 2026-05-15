<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            // Redirect berdasarkan role
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'kades':
                    return redirect()->route('kades.dashboard');
                case 'masyarakat':
                    return redirect()->route('masyarakat.dashboard');
                default:
                    return redirect()->route('home');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'nik' => 'required|string|unique:users|size:16',
            'alamat' => 'required|string',
            'no_hp' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'masyarakat', // Default role
            'nik' => $request->nik,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
        ]);

        Auth::login($user);

        return redirect()->route('masyarakat.dashboard');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    // Forgot Password Methods
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendResetToken(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'Email tidak ditemukan dalam sistem.',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        // Generate token reset
        $resetToken = Str::random(32);
        $expiresAt = Carbon::now()->addHours(24); // Token berlaku 24 jam

        // Simpan token ke database
        $user->update([
            'reset_token' => $resetToken,
            'reset_token_expires_at' => $expiresAt,
        ]);

        // Redirect ke halaman reset password dengan token
        return redirect()->route('reset-password', [
            'token' => $resetToken,
            'email' => $user->email,
        ])->with('success', 'Token reset telah dikirim. Silakan gunakan token di bawah untuk reset password Anda.');
    }

    public function showResetPassword($token, $email)
    {
        $user = User::where('email', $email)
            ->where('reset_token', $token)
            ->first();

        if (!$user) {
            return redirect()->route('login')->withErrors(['error' => 'Token tidak valid.']);
        }

        // Cek apakah token sudah expired
        if ($user->reset_token_expires_at && Carbon::now()->isAfter($user->reset_token_expires_at)) {
            return redirect()->route('login')->withErrors(['error' => 'Token sudah kadaluarsa. Silakan minta token baru.']);
        }

        return view('auth.reset-password', [
            'token' => $token,
            'email' => $email,
            'resetToken' => $token,
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)
            ->where('reset_token', $request->token)
            ->first();

        if (!$user) {
            return back()->withErrors(['error' => 'Token tidak valid.']);
        }

        // Cek apakah token sudah expired
        if ($user->reset_token_expires_at && Carbon::now()->isAfter($user->reset_token_expires_at)) {
            return back()->withErrors(['error' => 'Token sudah kadaluarsa.']);
        }

        // Update password dan hapus token
        $user->update([
            'password' => Hash::make($request->password),
            'reset_token' => null,
            'reset_token_expires_at' => null,
        ]);

        return redirect()->route('login')->with('success', 'Password berhasil direset. Silakan login dengan password baru Anda.');
    }
}
