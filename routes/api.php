<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/matkul-by-program/{program_id}', function ($program_id) {
    $taAktif = \App\Models\Ta::where('status', 'aktif')->first();
    if (!$taAktif) {
        return response()->json([]);
    }
    $matkuls = \App\Models\Matkul::where('program_id', $program_id)
        ->where('ta_id', $taAktif->id)
        ->orderBy('matakuliah', 'asc')
        ->get(['id', 'matakuliah']);
    return response()->json($matkuls);
});
