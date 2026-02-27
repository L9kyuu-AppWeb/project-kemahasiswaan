<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MahasiswaController;
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
    });
});

// Mahasiswa Routes
Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::middleware('mahasiswa')->group(function () {
        Route::post('/logout', [AuthController::class, 'mahasiswaLogout'])->name('logout');
        Route::get('/dashboard', [AuthController::class, 'mahasiswaDashboard'])->name('dashboard');
        Route::get('/profile', [AuthController::class, 'mahasiswaProfile'])->name('profile');
        Route::put('/profile', [AuthController::class, 'mahasiswaProfileUpdate'])->name('profile.update');
    });
});
