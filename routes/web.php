<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeasiswaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LaporanMagangController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MahasiswaMagangController;
use App\Http\Controllers\MahasiswaPengumumanController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\ProgramStudiController;
use App\Http\Controllers\TahunAjarController;
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
            Route::resource('data', BeasiswaController::class);
        });

        // Pengumuman Management
        Route::resource('pengumuman', PengumumanController::class)->parameters([
            'pengumuman' => 'pengumuman'
        ]);

        // Laporan Beasiswa Management (Admin)
        Route::prefix('laporan')->name('laporan.')->group(function () {
            Route::get('/', [LaporanController::class, 'adminIndex'])->name('index');
            Route::get('/{laporan}', [LaporanController::class, 'adminShow'])->name('show');
            Route::get('/{laporan}/download-pdf', [LaporanController::class, 'downloadPdf'])->name('download-pdf');
            Route::post('/download-multiple-pdf', [LaporanController::class, 'downloadMultiplePdf'])->name('download-multiple-pdf');
            Route::post('/{laporan}/approve', [LaporanController::class, 'adminApprove'])->name('approve');
            Route::post('/{laporan}/reject', [LaporanController::class, 'adminReject'])->name('reject');
        });

        // Tahun Ajar Management (Admin)
        Route::prefix('tahun-ajar')->name('tahun-ajar.')->group(function () {
            Route::get('/', [TahunAjarController::class, 'index'])->name('index');
            Route::get('/create', [TahunAjarController::class, 'create'])->name('create');
            Route::post('/', [TahunAjarController::class, 'store'])->name('store');
            Route::get('/{tahunAjar}', [TahunAjarController::class, 'show'])->name('show');
            Route::get('/{tahunAjar}/edit', [TahunAjarController::class, 'edit'])->name('edit');
            Route::put('/{tahunAjar}', [TahunAjarController::class, 'update'])->name('update');
            Route::post('/{tahunAjar}/set-active', [TahunAjarController::class, 'setActive'])->name('set-active');
            Route::delete('/{tahunAjar}', [TahunAjarController::class, 'destroy'])->name('destroy');
        });

        // Mahasiswa Magang Management (Admin)
        Route::prefix('magang')->name('magang.')->group(function () {
            Route::get('/', [MahasiswaMagangController::class, 'index'])->name('index');
            Route::get('/create', [MahasiswaMagangController::class, 'create'])->name('create');
            Route::post('/', [MahasiswaMagangController::class, 'store'])->name('store');
            Route::get('/{magang}', [MahasiswaMagangController::class, 'show'])->name('show');
            Route::get('/{magang}/edit', [MahasiswaMagangController::class, 'edit'])->name('edit');
            Route::put('/{magang}', [MahasiswaMagangController::class, 'update'])->name('update');
            Route::delete('/{magang}', [MahasiswaMagangController::class, 'destroy'])->name('destroy');
        });

        // Laporan Magang Management (Admin)
        Route::prefix('laporan-magang')->name('laporan-magang.')->group(function () {
            Route::get('/', [LaporanMagangController::class, 'adminIndex'])->name('index');
            Route::get('/mahasiswa/{mahasiswaId}', [LaporanMagangController::class, 'adminShowMahasiswa'])->name('mahasiswa');
            Route::get('/{laporanMagang}', [LaporanMagangController::class, 'adminShow'])->name('show');
            Route::get('/{laporanMagang}/download-pdf', [LaporanMagangController::class, 'downloadPdf'])->name('download-pdf');
            Route::post('/download-multiple-pdf', [LaporanMagangController::class, 'downloadMultiplePdf'])->name('download-multiple-pdf');
            Route::post('/{laporanMagang}/approve', [LaporanMagangController::class, 'adminApprove'])->name('approve');
            Route::post('/{laporanMagang}/reject', [LaporanMagangController::class, 'adminReject'])->name('reject');
        });
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
        
        // Laporan Beasiswa Routes for Mahasiswa
        Route::prefix('laporan')->name('laporan.')->group(function () {
            Route::get('/', [LaporanController::class, 'index'])->name('index');
            Route::get('/create', [LaporanController::class, 'create'])->name('create');
            Route::post('/', [LaporanController::class, 'store'])->name('store');
            Route::get('/{laporan}', [LaporanController::class, 'show'])->name('show');
            Route::get('/{laporan}/edit', [LaporanController::class, 'edit'])->name('edit');
            Route::put('/{laporan}', [LaporanController::class, 'update'])->name('update');
            Route::post('/{laporan}/submit', [LaporanController::class, 'submit'])->name('submit');
            Route::delete('/{laporan}', [LaporanController::class, 'destroy'])->name('destroy');
        });

        // Laporan Magang Routes for Mahasiswa
        Route::prefix('laporan-magang')->name('laporan-magang.')->group(function () {
            Route::get('/', [LaporanMagangController::class, 'index'])->name('index');
            Route::get('/create', [LaporanMagangController::class, 'create'])->name('create');
            Route::post('/', [LaporanMagangController::class, 'store'])->name('store');
            Route::get('/{laporan}', [LaporanMagangController::class, 'show'])->name('show');
            Route::get('/{laporan}/edit', [LaporanMagangController::class, 'edit'])->name('edit');
            Route::put('/{laporan}', [LaporanMagangController::class, 'update'])->name('update');
            Route::post('/{laporan}/submit', [LaporanMagangController::class, 'submit'])->name('submit');
            Route::delete('/{laporan}', [LaporanMagangController::class, 'destroy'])->name('destroy');
        });
    });
});
