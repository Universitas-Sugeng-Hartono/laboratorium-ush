<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Session;
use Illuminate\Support\Facades\Http;

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

    // public function postLogin(Request $request)
    // {
    //     $input = $request->input('email');
    //     $password = $request->input('password');

    //     $credentials = [
    //         'email' => $input,
    //         'password' => $password,
    //     ];

    //     if (Auth::attempt($credentials)) {
    //         return redirect('/home');
    //     } else {
    //         Session::flash('error', 'Email/Nomor atau Password Salah');
    //         return redirect('/');
    //     }
    // }
    
    public function postLogin(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
    
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post('https://siakad.sugenghartono.ac.id/api/login', [
            'email' => $email,
            'password' => $password,
        ]);
    
        if ($response->successful()) {
            $data = $response->json('data');
            $token = $data['access_token'] ?? null;
            $user = $data['user'] ?? [];
    
            if ($token) {
                session([
                    'siakad_token' => $token,
                    'siakad_user_name' => $user['name'] ?? 'Pengguna',
                    'siakad_user_email' => $user['email'] ?? null,
                ]);
                return redirect('/home');
            }
        }
    
        $credentials = [
            'email' => $email,
            'password' => $password,
        ];
    
        if (Auth::attempt($credentials)) {
            return redirect('/home');
        }
    
        return back()->with('error', 'Email atau password salah (API & lokal gagal).');
    }

    public function postLogout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    }
}