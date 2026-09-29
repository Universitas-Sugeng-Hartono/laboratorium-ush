<?php

namespace App\Http\Controllers;

use App\Models\Laboratorium;
use App\Models\Ta;
use App\Support\LaporanPimpinan;
use Illuminate\Http\Request;
use PDF;

class LaporanPimpinanController extends Controller
{
    public function index(Request $request)
    {
        $laboratories = Laboratorium::orderBy('laboratorium')->get();
        $tahun = Ta::orderByDesc('id')->get();
        $laporan = $this->laporanJikaLengkap($request);

        return view('laporan.pimpinan', compact('laboratories', 'tahun', 'laporan'));
    }

    public function pdf(Request $request)
    {
        $request->validate([
            'lab_id' => 'required|exists:laboratorium,id',
            'ta_id' => 'required|exists:ta,id',
        ]);

        $laporan = LaporanPimpinan::susun((int) $request->lab_id, (int) $request->ta_id);
        $pdf = PDF::loadView('laporan.pimpinan-pdf', compact('laporan'))->setPaper('a4', 'portrait');

        return $pdf->download('laporan-pimpinan.pdf');
    }

    private function laporanJikaLengkap(Request $request): ?array
    {
        if (!$request->filled('lab_id') || !$request->filled('ta_id')) {
            return null;
        }

        $request->validate([
            'lab_id' => 'required|exists:laboratorium,id',
            'ta_id' => 'required|exists:ta,id',
        ]);

        return LaporanPimpinan::susun((int) $request->lab_id, (int) $request->ta_id);
    }
}
