<?php

use App\Http\Controllers\laporanTransaksiController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\SteeringCommitteeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', [MemberController::class, 'showLoginForm'])->name('login');
Route::post('/login', [MemberController::class, 'login']);

Route::prefix('sc')->name('sc.')->group(function () {
    Route::get('login', [SteeringCommitteeController::class, 'showLoginForm'])->name('login');
    Route::post('login', [SteeringCommitteeController::class, 'login'])->name('login.submit');
    Route::post('logout', [SteeringCommitteeController::class, 'logout'])->name('logout');

    Route::middleware('auth:sc')->group(function () {
        Route::get('dashboard', [SteeringCommitteeController::class, 'index'])->name('dashboard');
        Route::get('riwayat-pinjaman/{member}', [SteeringCommitteeController::class, 'riwayatPinjamanAnggota'])->name('riwayat-pinjaman.anggota');
        Route::post('loan/{loan}/approve', [SteeringCommitteeController::class, 'approve'])->name('loan.approve');
        Route::post('loan/{loan}/reject', [SteeringCommitteeController::class, 'reject'])->name('loan.reject');
    });
});


Route::post('/pinjaman/{id}/diterima', [LoanController::class, 'diterima'])->name('pinjaman.diterima');
Route::post('/pinjaman/{id}/ditolak', [LoanController::class, 'ditolak'])->name('pinjaman.ditolak');

Route::get('/dashboard-anggota', [MemberController::class, 'dashboardAnggota'])->name('dashboard-anggota');
Route::post('/logout', [MemberController::class, 'logout'])->name('logout');
Route::get('/laporan-transaksi-pinjaman', [laporanTransaksiController::class, 'laporan_transaksi_pinjaman'])->name('laporan-transaksi-pinjaman');
Route::get('/laporan-transaksi-simpanan', [laporanTransaksiController::class, 'laporan_transaksi_simpanan'])->name('laporan-transaksi-simpanan');
Route::get('/laporan-anggota/{id}', [laporanTransaksiController::class, 'laporan_anggota'])->name('laporan-anggota');
