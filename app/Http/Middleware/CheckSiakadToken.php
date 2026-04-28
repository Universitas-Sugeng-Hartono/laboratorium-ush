<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckSiakadToken
{
    public function handle(Request $request, Closure $next)
    {
        \Log::info('Middleware CheckSiakadToken: ', [
            'session' => session()->all(),
        ]);

        if (!session()->has('siakad_token')) {
            return redirect('/')->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}