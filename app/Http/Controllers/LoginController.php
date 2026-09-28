<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class LoginController extends Controller
{

    protected $maxAttempts = 3;
    protected $decayMinutes = 2;

    public function __construct()
    {
        $this->middleware('guest:web')->except('postLogout');
    }

    public function getLogin()
    {
        return view('admin.login');
    }

    public function postLogin(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        try {
            $response = Http::timeout(8)
                ->withOptions(['connect_timeout' => 5])
                ->withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])->post('https://siakad.sugenghartono.ac.id/api/login', [
                    'email' => $email,
                    'password' => $password,
                ]);

            if ($response->successful()) {
                $data = $response->json('data') ?? [];
                $token = $data['access_token'] ?? null;
                $siakadUser = $data['user'] ?? [];
                $userEmail = $siakadUser['email'] ?? $email;

                if ($token && $userEmail) {
                    $user = User::whereRaw('LOWER(email) = ?', [strtolower($userEmail)])->first();

                    if (!$user) {
                        $user = User::create([
                            'name' => $siakadUser['name'] ?? 'Pengguna',
                            'email' => $userEmail,
                            'password' => Hash::make(Str::random(40)),
                            'role' => 'dosen',
                        ]);
                    }

                    Auth::login($user);
                    $request->session()->regenerate();

                    session([
                        'siakad_token' => $token,
                        'siakad_user_name' => $siakadUser['name'] ?? $user->name,
                        'siakad_user_email' => $userEmail,
                    ]);

                    AuditLog::record([
                        'action' => 'LOGIN',
                        'module' => 'Auth',
                        'record_id' => (string) $user->id,
                        'record_label' => $user->name,
                        'description' => "Pengguna {$user->name} ({$user->role}) berhasil masuk melalui SIAKAD",
                    ]);

                    return redirect('/home');
                }
            }
        } catch (\Throwable $e) {
            // SIAKAD down atau timeout: lanjut ke akun lokal.
        }

        $credentials = [
            'email' => $email,
            'password' => $password,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            AuditLog::record([
                'action'      => 'LOGIN',
                'module'      => 'Auth',
                'record_id'   => (string)$user->id,
                'record_label'=> $user->name,
                'description' => "Pengguna {$user->name} ({$user->role}) berhasil masuk ke dalam sistem",
            ]);
            return redirect('/home');
        }

        return back()->with('error', 'Email atau password salah.');
    }

    public function postLogout()
    {
        $user = Auth::user();
        if ($user) {
            \App\Models\AuditLog::record([
                'action'      => 'LOGOUT',
                'module'      => 'Auth',
                'record_id'   => (string)$user->id,
                'record_label'=> $user->name,
                'description' => "Pengguna {$user->name} ({$user->role}) keluar dari sistem",
            ]);
        }
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    }
}