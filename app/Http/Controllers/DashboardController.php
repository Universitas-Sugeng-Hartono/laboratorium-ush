<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Paper;
use App\Models\User;
use App\Models\Jurnal;
use App\Models\Pemakaian;
use App\Models\Jadwal;
use App\Models\Absensi;
use Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $dates = Carbon::now();
        $user = User::select('id')->count();
        $tamu = Absensi::select('id')->count();
        $pemakaian = Pemakaian::where('keterangan', 'setuju')->count();
        $pemakaian1 = Pemakaian::whereIn('keterangan', ['proses', 'ditolak'])->orWhereNull('keterangan')->count();
        $pemakaian2 = Pemakaian::whereNull('status_pengembalian')->count();
        $jurnal = Jurnal::select('id')->count();

        $year = $dates->year;
        $month = $dates->month;
        $startOfMonth = Carbon::createFromDate($year, $month, 1);
        $daysInMonth = $startOfMonth->daysInMonth;
        $jadwal = Jadwal::whereMonth('jadwal', $month)
            ->whereYear('jadwal', $year)
            ->get();
        return view('layout.app', compact('dates', 'user', 'jurnal', 'pemakaian', 'pemakaian1', 'jadwal', 'year', 'month', 'startOfMonth', 'daysInMonth','tamu', 'pemakaian2'));
    }
}