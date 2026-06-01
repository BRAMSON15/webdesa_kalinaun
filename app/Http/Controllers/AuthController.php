<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\AuthService;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    // ===== ADMIN/KADES LOGIN =====
    public function showAdminLogin()
    {
        return view('auth.admin-login');
    }

    public function adminLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        try {
            $user = $this->authService->loginAdmin($request->email, $request->password);

            if ($user) {
                $route = $this->authService->getRedirectRoute($user);
                return redirect()->route($route);
            }

            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ]);
        } catch (\Exception $e) {
            return back()->withErrors([
                'email' => $e->getMessage(),
            ]);
        }
    }

    // ===== MASYARAKAT LOGIN =====
    public function showMasyarakatLogin()
    {
        return view('auth.masyarakat-login');
    }

    public function masyarakatLogin(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'nik' => 'required|string|size:16',
        ], [
            'name.required' => 'Nama lengkap harus diisi',
            'nik.required' => 'NIK harus diisi',
            'nik.size' => 'NIK harus 16 digit',
        ]);

        try {
            $user = $this->authService->loginMasyarakat($request->name, $request->nik);

            if ($user) {
                return redirect()->route('masyarakat.dashboard');
            }

            return back()->withErrors([
                'name' => 'Nama lengkap atau NIK tidak sesuai.',
            ])->withInput();
        } catch (\Exception $e) {
            return back()->withErrors([
                'name' => $e->getMessage(),
            ])->withInput();
        }
    }

    // ===== GENERIC LOGIN (DEPRECATED - kept for backward compatibility) =====
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

        try {
            $user = $this->authService->login($request->email, $request->password);

            if ($user) {
                $route = $this->authService->getRedirectRoute($user);
                return redirect()->route($route);
            }

            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ]);
        } catch (\Exception $e) {
            return back()->withErrors([
                'email' => $e->getMessage(),
            ]);
        }
    }

    // ===== REGISTRATION (MASYARAKAT ONLY) =====
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

        $user = $this->authService->register($request->all());
        Auth::login($user);

        return redirect()->route('masyarakat.dashboard');
    }

    // ===== LOGOUT =====
    public function logout()
    {
        $this->authService->logout();
        return redirect()->route('login');
    }

    // ===== FORGOT PASSWORD =====
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

        $result = $this->authService->sendResetToken($request->email);

        if (!$result) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        return redirect()->route('reset-password', [
            'token' => $result['token'],
            'email' => $result['email'],
        ])->with('success', 'Token reset telah dikirim. Silakan gunakan token di bawah untuk reset password Anda.');
    }

    public function showResetPassword($token, $email)
    {
        $user = $this->authService->validateResetToken($token, $email);

        if (!$user) {
            return redirect()->route('login')->withErrors(['error' => 'Token tidak valid atau sudah kadaluarsa.']);
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

        $success = $this->authService->updatePassword($request->token, $request->email, $request->password);

        if (!$success) {
            return back()->withErrors(['error' => 'Token tidak valid atau sudah kadaluarsa.']);
        }

        return redirect()->route('login')->with('success', 'Password berhasil direset. Silakan login dengan password baru Anda.');
    }
}
