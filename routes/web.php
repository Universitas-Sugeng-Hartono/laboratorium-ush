<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{TaController, AbsensiController, HalamanController, UserController, LoginController, ProgramController, AlatController, BahanController, LaboratoriumController, MataKuliahController, JadwalController, PemakaianController, JurnalController, AuditLogController, FakultasController};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HalamanController::class, 'PilihanCourse'])->name('awal');
Route::get('/jadwallab', [HalamanController::class, 'JadwalLab'])->name('jadwallab');
Route::get('/tamuumum', [HalamanController::class, 'TamuLab'])->name('tamuumum');
Route::post('/tamu/store', [HalamanController::class, 'storeTamu']);
Route::get('/create-jurnal/{id}', [HalamanController::class, 'sessionJurnal']);
Route::put('/jurnal/{id}/update', [HalamanController::class, 'updateJurnal']);
Route::get('/lihat-jurnal/{id}', [HalamanController::class, 'sessionLihatJurnal']);
Route::post('/jurnal/store', [HalamanController::class, 'store']);
Route::get('/lihatpeminjaman', [HalamanController::class, 'JadwalPinjam']);
Route::get('/create-peminjaman', [HalamanController::class, 'sessionCreatePeminjaman']);
Route::post('/peminjaman/store', [HalamanController::class, 'storePeminjaman']);
Route::get('/peminjaman/{id}/cetak', [HalamanController::class, 'exportPinPdf']);
Route::get('/stokopname', [HalamanController::class, 'StokOpname']);
Route::get('/autokirimwa', [HalamanController::class, 'AutoKirimWA'])->name('auto.kirim.wa');
Route::get('/api/reminder-jurnal', [HalamanController::class, 'ReminderJurnalWA'])->name('reminder.jurnal.wa');
Route::get('/admin', [LoginController::class, 'getLogin'])->name('admin.login');
Route::get('/login', [LoginController::class, 'getLogin'])->name('login');
Route::post('/login', [LoginController::class, 'postLogin'])->middleware('throttle:5,1');
Route::post('/logout', [LoginController::class, 'postLogout'])->name('auth.login');
Route::middleware('auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\DashboardController::class, 'index'])->name('layout.app');

    Route::get('/viewuser', [UserController::class, 'profile'])->name('user.profile');
    Route::put('/viewuser', [UserController::class, 'updateProfile'])->name('user.profile.update');

    Route::middleware('role:super,laboran,dosen')->group(function () {
        Route::post('/jadwal/import', [JadwalController::class, 'import'])->name('jadwal.import');
        Route::resource('jadwal', JadwalController::class);
        Route::resource('pemakaian', PemakaianController::class);
        Route::post('/pengembalian/{id}', [PemakaianController::class, 'storePemakaian'])->name('pengembalian.store');
        Route::get('/kirim-was/{id}', [PemakaianController::class, 'kirimWA'])->name('kirim.was');
        Route::get('/kirim-wa/{jadwal_id}', [HalamanController::class, 'kirimWA'])->name('kirim.wa');
        Route::resource('jurnal', JurnalController::class);
        Route::resource('absensi', AbsensiController::class);
        Route::get('/get-jurnal-export', [JurnalController::class, 'getCsv']);
        Route::get('/jurnal-export-csv', [JurnalController::class, 'exportCsv']);
        Route::get('/jurnal-export-pdf', [JurnalController::class, 'exportPdf']);
        Route::get('/jurnal-export-pdf-no-ttd', [JurnalController::class, 'exportPdfNoTtd']);
        Route::get('/jurnal-perkuliahan-pdf', [JurnalController::class, 'exportPdfPkh']);
        Route::get('/tamu-export-pdf', [AbsensiController::class, 'exportPdf']);
        Route::get('/pemakaian-export-pdf', [PemakaianController::class, 'exportPdf']);
    });

    Route::middleware('role:super,laboran')->group(function () {
        Route::get('/alat/template', [AlatController::class, 'downloadTemplate'])->name('alat.template');
        Route::post('/alat/import', [AlatController::class, 'import'])->name('alat.import');
        Route::get('/bahan/template', [BahanController::class, 'downloadTemplate'])->name('bahan.template');
        Route::post('/bahan/import', [BahanController::class, 'import'])->name('bahan.import');
        Route::get('/alat/cetak-qr-batch', [AlatController::class, 'cetakQrBatch'])->name('alat.cetak.qr.batch');
        Route::get('/alat/{id}/cetak-qr', [AlatController::class, 'cetakQr'])->name('alat.cetak.qr');
        Route::resource('alat', AlatController::class);
        Route::resource('bahan', BahanController::class);
        Route::get('/ta/otomatis', [TaController::class, 'generateTA'])->name('ta.otomatis');
        Route::resource('ta', TaController::class);
        Route::resource('laboratorium', LaboratoriumController::class);
        Route::get('/matkul/template', [MataKuliahController::class, 'downloadTemplate'])->name('matkul.template');
        Route::post('/matkul/import', [MataKuliahController::class, 'import'])->name('matkul.import');
        Route::resource('matkul', MataKuliahController::class);
        Route::resource('program', ProgramController::class);
        Route::resource('fakultas', FakultasController::class);
    });

    Route::middleware('role:super')->group(function () {
        Route::resource('user', UserController::class);
        Route::get('/audit-log', [AuditLogController::class, 'index'])->name('audit.index');
        Route::get('/audit-log/{id}', [AuditLogController::class, 'show'])->name('audit.show');
    });
});