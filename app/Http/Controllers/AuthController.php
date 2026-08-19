<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            AuditLog::create([
                'user_id' => $user->id,
                'user_name' => $user->name,
                'action' => 'LOGIN_SUCCESS',
                'details' => "Pengguna {$user->name} ({$user->email}) berhasil masuk ke sistem sebagai {$user->role} ({$user->opd_name})",
                'ip_address' => $request->ip(),
            ]);

            return redirect()->intended('/dashboard')->with('success', 'Selamat datang kembali, ' . $user->name);
        }

        AuditLog::create([
            'user_id' => null,
            'user_name' => 'Tamu / Unknown',
            'action' => 'LOGIN_FAILED',
            'details' => "Percobaan login gagal untuk email: {$request->email}",
            'ip_address' => $request->ip(),
        ]);

        return back()->withErrors([
            'email' => 'Email atau kata sandi tidak cocok dengan data terdaftar.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        $opdList = [
            'Dinas Perhubungan',
            'Dinas Perdagangan',
            'Dinas Perkim',
            'Dinas Lingkungan Hidup',
            'Dinas Kesehatan',
            'Dinas Pariwisata & Kebudayaan',
            'Badan Pendapatan Daerah',
        ];

        return view('auth.register', compact('opdList'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:admin,user_opd'],
            'opd_name' => ['required', 'string'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'opd_name' => $request->opd_name,
        ]);

        AuditLog::create([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'action' => 'REGISTER_ACCOUNT',
            'details' => "Pendaftaran akun resmi berhasil untuk {$user->name} (Role: {$user->role}, OPD: {$user->opd_name})",
            'ip_address' => $request->ip(),
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Registrasi berhasil! Anda telah masuk sebagai ' . $user->name);
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            AuditLog::create([
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name,
                'action' => 'LOGOUT',
                'details' => 'Pengguna melepaskan sesi dan keluar dari sistem',
                'ip_address' => $request->ip(),
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('info', 'Anda telah keluar secara aman dari aplikasi.');
    }
}
