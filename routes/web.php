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
    #pengaduan
    Route::get('/pengaduan/create',[PengaduanController::class,'create'])->name('pengaduan.create');
    Route::get('/pengaduan',[PengaduanController::class,'index'])->name('pengaduan.index');
    Route::post('/pengaduan',[PengaduanController::class,'store'])->name('pengaduan.store');
    Route::delete('/pengaduan/{id}',[PengaduanController::class,'delete'])->name('pengaduan.delete');
    Route::get('/pengaduan/{id}',[PengaduanController::class,'show'])->name('pengaduan.show');
    Route::post('/pengaduan/{id}',[PengaduanController::class,'update'])->name('pengaduan.update');

      Route::resource('kamar', KamarController::class)
            ->except('index');
    #kontrak
    // Route::get('/kontrak',[KontrakController::class,'index'])->name('kontrak.index');
    // Route::get('/kontrak/create',[KontrakController::class,'create'])->name('kontrak.create');
    // Route::get('/kontrak/{id}',[KontrakController::class,'show'])->name('kontrak.show');
    // Route::get('/kontrak/{id}',[KontrakController::class,'edit'])->name('kontrak.edit');
    // Route::put('/kontrak/{id}',[KontrakController::class,'update'])->name('kontrak.update');
    // Route::delete('/kontrak/{id}',[KontrakController::class,'destroy'])->name('kontrak.destroy');
    // Route::post('/kontrak',[KontrakController::class,'store'])->name('kontrak.store');
Route::resource('kontrak', KontrakController::class);

    Route::middleware('admin')->group(function () {
      Route::put('/kontrak/{kontrak}/approve', [KontrakController::class, 'approve'])->name('kontrak.approve');
    });
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('user', UserController::class);
   
});

require __DIR__.'/auth.php';
