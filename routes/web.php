<?php

use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', [MemberController::class, 'showLoginForm'])->name('login');
Route::post('/login', [MemberController::class, 'login']);
Route::get('/dashboard-anggota', [MemberController::class, 'dashboardAnggota'])->name('dashboard-anggota');
Route::post('/logout', [MemberController::class, 'logout'])->name('logout');
