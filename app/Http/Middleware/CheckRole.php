<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * Menerima satu atau lebih role yang diperbolehkan.
     * Contoh penggunaan di route:
     *   ->middleware('role:super')
     *   ->middleware('role:super,laboran')
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if (in_array($user->role, $roles, true)) {
            return $next($request);
        }

        // Role lab lama (labict, labgizi, dll.) ikut hak laboran.
        if (in_array('laboran', $roles, true) && $user->isLaboran()) {
            return $next($request);
        }

        // Jika tidak punya akses, return 403
        abort(403, 'Anda tidak memiliki hak akses untuk halaman ini.');
    }
}
