<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TblMasyarakat;
use App\Models\TblSekdes;
use App\Models\TblAdmin;

class ClassDiagramAuthController extends Controller
{
    public function showLogin()
    {
        return view('class-diagram.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'user_type' => 'required|in:masyarakat,sekdes,admin'
        ]);

        $credentials = $request->only('username', 'password');
        $userType = $request->user_type;

        switch ($userType) {
            case 'masyarakat':
                // Login untuk masyarakat menggunakan email
                $user = TblMasyarakat::where('email', $credentials['username'])->first();
                if ($user && $user->login($credentials['username'], $credentials['password'])) {
                    Auth::guard('masyarakat')->login($user);
                    return redirect()->route('class-diagram.masyarakat.dashboard');
                }
                break;

            case 'sekdes':
                // Login untuk sekdes
                if (Auth::guard('sekdes')->attempt(['username' => $credentials['username'], 'password' => $credentials['password']])) {
                    return redirect()->route('class-diagram.sekdes.dashboard');
                }
                break;

            case 'admin':
                // Login untuk admin
                if (Auth::guard('admin')->attempt(['username' => $credentials['username'], 'password' => $credentials['password']])) {
                    return redirect()->route('class-diagram.admin.dashboard');
                }
                break;
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ]);
    }

    public function showRegister()
    {
        return view('class-diagram.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|size:16|unique:tbl_masyarakat,nik',
            'nama' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:tbl_masyarakat,email',
            'no_hp' => 'required|string|max:15',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $masyarakat = new TblMasyarakat();
        $user = $masyarakat->register($request->all());

        if ($user) {
            Auth::guard('masyarakat')->login($user);
            return redirect()->route('class-diagram.masyarakat.dashboard')
                ->with('success', 'Registrasi berhasil! Selamat datang.');
        }

        return back()->withErrors(['error' => 'Registrasi gagal. Silakan coba lagi.']);
    }

    public function logout(Request $request)
    {
        // Logout dari semua guard
        Auth::guard('masyarakat')->logout();
        Auth::guard('sekdes')->logout();
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('class-diagram.login');
    }
}
