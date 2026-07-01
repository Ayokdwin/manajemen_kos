<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\KontrakController;

Route::get('/',[WelcomeController::class,'index'])->name('index');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/kamar', [KamarController::class, 'index'])
        ->name('kamar.index');
    Route::get('/pengaduan/create',[PengaduanController::class,'create'])->name('pengaduan.create');
    Route::get('/pengaduan',[PengaduanController::class,'index'])->name('pengaduan.index');
    Route::post('/pengaduan',[PengaduanController::class,'store'])->name('pengaduan.store');
    Route::middleware('admin')->group(function () {
        Route::resource('kamar', KamarController::class)
            ->except('index');
    });
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('user', UserController::class);
    Route::resource('kontrak', KontrakController::class);
});

require __DIR__.'/auth.php';
