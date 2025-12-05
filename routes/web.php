<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PesanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\AlternatifController;
use App\Http\Controllers\Admin\KriteriaController;
use App\Http\Controllers\Admin\SubKriteriaController;
use App\Http\Controllers\Admin\ProsesController;
use App\Http\Controllers\Admin\HasilController;
use App\Http\Controllers\Kades\DashboardController as KadesDashboard;

Route::get('/', fn() => auth()->check()
    ? (auth()->user()->role==='admin' ? redirect()->route('admin.dashboard') : redirect()->route('kades.dashboard'))
    : redirect()->route('login.form'));

Route::get('/login', [AuthController::class,'showLogin'])->name('login.form');
Route::post('/login', [AuthController::class,'login'])->name('login');
Route::post('/logout', [AuthController::class,'logout'])->name('logout');

// Pesan routes
Route::middleware(['auth'])->group(function(){
    Route::resource('pesan', PesanController::class)->only(['index','create','store','show','destroy']);
});

// Profile routes
Route::middleware(['auth'])->group(function(){
    Route::get('profile', [ProfileController::class,'index'])->name('profile.index');
    Route::get('profile/edit', [ProfileController::class,'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class,'update'])->name('profile.update');
});

Route::middleware(['auth','role:admin'])->prefix('admin')->name('admin.')->group(function(){
    Route::get('/dashboard', [AdminDashboard::class,'index'])->name('dashboard');
    Route::resource('alternatif', AlternatifController::class)->only(['index','store','destroy']);
    Route::get('alternatif/{id}/nilai', [AlternatifController::class,'nilaiForm'])->name('alternatif.nilai.form');
    Route::post('alternatif/{id}/nilai', [AlternatifController::class,'nilaiStore'])->name('alternatif.nilai.store');
    Route::resource('kriteria', KriteriaController::class)->only(['index','store','update','destroy']);
    Route::resource('sub-kriteria', SubKriteriaController::class)->only(['index','store','update','destroy']);
    Route::get('proses', [ProsesController::class,'index'])->name('proses');
    Route::post('proses/run', [ProsesController::class,'run'])->name('proses.run');
    Route::get('hasil', [HasilController::class,'index'])->name('hasil');
    Route::get('hasil/pdf', [HasilController::class,'pdf'])->name('hasil.pdf');
    Route::get('hasil/{id}', [HasilController::class,'show'])->name('hasil.show');
});

Route::middleware(['auth','role:kepala_desa'])->prefix('kades')->name('kades.')->group(function(){
    Route::get('/dashboard', [KadesDashboard::class,'index'])->name('dashboard');
    Route::get('/alternatif', [KadesDashboard::class,'alternatif'])->name('alternatif');
    Route::get('/hasil', [HasilController::class,'index'])->name('hasil');
    Route::get('/hasil/pdf', [HasilController::class,'pdf'])->name('hasil.pdf');
});

