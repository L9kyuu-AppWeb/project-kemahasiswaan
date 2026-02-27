<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeasiswaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MahasiswaPengumumanController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\ProgramStudiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Home Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Unified Login Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Logout Route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('admin')->group(function () {
        Route::post('/logout', [AuthController::class, 'adminLogout'])->name('logout');
        Route::get('/dashboard', [AuthController::class, 'adminDashboard'])->name('dashboard');
        Route::get('/profile', [AuthController::class, 'adminProfile'])->name('profile');
        Route::put('/profile', [AuthController::class, 'adminProfileUpdate'])->name('profile.update');

        // Mahasiswa Management
        Route::resource('mahasiswa', MahasiswaController::class);
        
        // Program Studi Management
        Route::resource('program-studi', ProgramStudiController::class)->parameters([
            'program-studi' => 'programStudi'
        ]);

        // Beasiswa Management
        Route::prefix('beasiswa')->name('beasiswa.')->group(function () {
            // Beasiswa Tipe (Master)
            Route::get('/tipe', [BeasiswaController::class, 'indexTipe'])->name('tipe.index');
            Route::get('/tipe/create', [BeasiswaController::class, 'createTipe'])->name('tipe.create');
            Route::post('/tipe', [BeasiswaController::class, 'storeTipe'])->name('tipe.store');
            Route::get('/tipe/{beasiswaTipe}/edit', [BeasiswaController::class, 'editTipe'])->name('tipe.edit');
            Route::put('/tipe/{beasiswaTipe}', [BeasiswaController::class, 'updateTipe'])->name('tipe.update');
            Route::delete('/tipe/{beasiswaTipe}', [BeasiswaController::class, 'destroyTipe'])->name('tipe.destroy');
            
            // Mahasiswa Beasiswa (Transaction)
            Route::get('/', [BeasiswaController::class, 'index'])->name('index');
            Route::resource('/', BeasiswaController::class)->except(['index']);
        });

        // Pengumuman Management
        Route::resource('pengumuman', PengumumanController::class)->parameters([
            'pengumuman' => 'pengumuman'
        ]);
    });
});

// Mahasiswa Routes
Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::middleware('mahasiswa')->group(function () {
        Route::post('/logout', [AuthController::class, 'mahasiswaLogout'])->name('logout');
        Route::get('/dashboard', [AuthController::class, 'mahasiswaDashboard'])->name('dashboard');
        Route::get('/profile', [AuthController::class, 'mahasiswaProfile'])->name('profile');
        Route::put('/profile', [AuthController::class, 'mahasiswaProfileUpdate'])->name('profile.update');
        
        // Pengumuman Routes for Mahasiswa
        Route::get('/pengumuman', [MahasiswaPengumumanController::class, 'index'])->name('pengumuman.index');
        Route::get('/pengumuman/{pengumuman}', [MahasiswaPengumumanController::class, 'show'])->name('pengumuman.show');
    });
});
