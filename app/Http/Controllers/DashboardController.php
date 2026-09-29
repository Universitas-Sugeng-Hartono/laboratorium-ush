<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Jurnal;
use App\Models\Pemakaian;
use App\Models\Jadwal;
use App\Models\Absensi;
use App\Models\Alat;
use App\Models\Bahan;
use App\Models\Laboratorium;
use App\Models\Ta;
use Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();
        $dates = Carbon::now();

        // Month & Year navigation support
        $year = (int)$request->input('year', $dates->year);
        $month = (int)$request->input('month', $dates->month);

        if ($month < 1) {
            $month = 12;
            $year--;
        } elseif ($month > 12) {
            $month = 1;
            $year++;
        }

        $currentMonthDate = Carbon::createFromDate($year, $month, 1);
        $daysInMonth = $currentMonthDate->daysInMonth;
        $startOfMonth = $currentMonthDate->copy();

        // Previous and Next month calculations for navigation links
        $prevDate = $currentMonthDate->copy()->subMonth();
        $nextDate = $currentMonthDate->copy()->addMonth();

        // Core Metrics
        $user = User::count();
        $tamu = Absensi::count();
        $pemakaian = Pemakaian::where('keterangan', 'setuju')->count();
        $pemakaian1 = Pemakaian::where(function($q) {
            $q->whereIn('keterangan', ['proses', 'ditolak'])
              ->orWhereNull('keterangan');
        })->count();
        $pemakaian2 = Pemakaian::whereNull('status_pengembalian')->count();
        $jurnal = Jurnal::count();

        // Extended Metrics
        $totalAlat = Alat::count();
        $totalBahan = Bahan::count();
        $totalLab = Laboratorium::count();
        $taAktif = Ta::where('status', 'aktif')->first();

        // Eager load schedules for the selected month to avoid N+1 queries
        $peringatanTa = Ta::pesanJikaTidakAktif();
        $jadwal = Jadwal::with(['matkulId', 'labId', 'programId'])
            ->padaTaAktif()
            ->whereMonth('jadwal', $month)
            ->whereYear('jadwal', $year)
            ->orderBy('jadwal', 'asc')
            ->get();

        // Group schedules by Y-m-d for O(1) lookup in Blade calendar
        $jadwalByDate = $jadwal->groupBy(function($item) {
            return Carbon::parse($item->jadwal)->format('Y-m-d');
        });

        // Schedules for today
        $jadwalHariIni = Jadwal::with(['matkulId', 'labId', 'programId'])
            ->padaTaAktif()
            ->whereDate('jadwal', $today)
            ->orderBy('jadwal', 'asc')
            ->get();

        // Indonesian Month Names
        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        $namaBulanTeks = $namaBulan[$month] ?? $currentMonthDate->format('F');

        return view('layout.app', compact(
            'dates',
            'today',
            'user',
            'jurnal',
            'pemakaian',
            'pemakaian1',
            'pemakaian2',
            'totalAlat',
            'totalBahan',
            'totalLab',
            'taAktif',
            'peringatanTa',
            'jadwal',
            'jadwalByDate',
            'jadwalHariIni',
            'year',
            'month',
            'namaBulanTeks',
            'startOfMonth',
            'daysInMonth',
            'prevDate',
            'nextDate',
            'tamu'
        ));
    }
}