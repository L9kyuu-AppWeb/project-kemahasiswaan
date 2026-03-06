<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AntrianVerifikasiController;
use App\Http\Controllers\BeasiswaController;
use App\Http\Controllers\DetailKegiatanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JenisKegiatanController;
use App\Http\Controllers\JenisRekognisiController;
use App\Http\Controllers\KompetisiMahasiswaDosenController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LaporanMagangController;
use App\Http\Controllers\LombaKategoriController;
use App\Http\Controllers\MahasiswaAntrianVerifikasiController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MahasiswaMagangController;
use App\Http\Controllers\MahasiswaPengumumanController;
use App\Http\Controllers\NilaiKegiatanController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\ProgramStudiController;
use App\Http\Controllers\RekognisiController;
use App\Http\Controllers\RuangLingkupController;
use App\Http\Controllers\SertifikasiController;
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
        // Import Excel routes for Mahasiswa (MUST be before resource route)
        Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
            Route::get('/import', [MahasiswaController::class, 'showImportForm'])->name('import');
            Route::post('/import-excel', [MahasiswaController::class, 'importExcel'])->name('import-excel');
            Route::get('/download-template', [MahasiswaController::class, 'downloadTemplate'])->name('download-template');
        });
        Route::resource('mahasiswa', MahasiswaController::class);
        
        // Program Studi Management
        Route::resource('program-studi', ProgramStudiController::class)->parameters([
            'program-studi' => 'programStudi'
        ]);

        // Lomba Kategori Management
        Route::prefix('lomba-kategori')->name('lomba-kategori.')->group(function () {
            Route::get('/', [LombaKategoriController::class, 'index'])->name('index');
            Route::get('/create', [LombaKategoriController::class, 'create'])->name('create');
            Route::post('/', [LombaKategoriController::class, 'store'])->name('store');
            Route::get('/{lombaKategori}', [LombaKategoriController::class, 'show'])->name('show');
            Route::get('/{lombaKategori}/edit', [LombaKategoriController::class, 'edit'])->name('edit');
            Route::put('/{lombaKategori}', [LombaKategoriController::class, 'update'])->name('update');
            Route::delete('/{lombaKategori}', [LombaKategoriController::class, 'destroy'])->name('destroy');
        });

        // Kompetisi Mahasiswa Management
        Route::prefix('kompetisi')->name('kompetisi.')->group(function () {
            Route::get('/', [KompetisiMahasiswaDosenController::class, 'adminIndex'])->name('index');
            Route::get('/{kompetisi}', [KompetisiMahasiswaDosenController::class, 'adminShow'])->name('show');
            Route::get('/{kompetisi}/edit', [KompetisiMahasiswaDosenController::class, 'adminEdit'])->name('edit');
            Route::put('/{kompetisi}', [KompetisiMahasiswaDosenController::class, 'adminUpdate'])->name('update');
            Route::delete('/{kompetisi}', [KompetisiMahasiswaDosenController::class, 'adminDestroy'])->name('destroy');
            Route::post('/{kompetisi}/approve', [KompetisiMahasiswaDosenController::class, 'adminApprove'])->name('approve');
        });

        // Jenis Rekognisi Management
        Route::prefix('jenis-rekognisi')->name('jenis-rekognisi.')->group(function () {
            Route::get('/', [JenisRekognisiController::class, 'index'])->name('index');
            Route::get('/create', [JenisRekognisiController::class, 'create'])->name('create');
            Route::post('/', [JenisRekognisiController::class, 'store'])->name('store');
            Route::get('/{jenisRekognisi}/edit', [JenisRekognisiController::class, 'edit'])->name('edit');
            Route::put('/{jenisRekognisi}', [JenisRekognisiController::class, 'update'])->name('update');
            Route::delete('/{jenisRekognisi}', [JenisRekognisiController::class, 'destroy'])->name('destroy');
        });

        // Rekognisi Management
        Route::prefix('rekognisi')->name('rekognisi.')->group(function () {
            Route::get('/', [RekognisiController::class, 'adminIndex'])->name('index');
            Route::get('/{rekognisi}', [RekognisiController::class, 'adminShow'])->name('show');
            Route::get('/{rekognisi}/edit', [RekognisiController::class, 'adminEdit'])->name('edit');
            Route::put('/{rekognisi}', [RekognisiController::class, 'adminUpdate'])->name('update');
            Route::delete('/{rekognisi}', [RekognisiController::class, 'adminDestroy'])->name('destroy');
            Route::post('/{rekognisi}/approve', [RekognisiController::class, 'adminApprove'])->name('approve');
        });

        // Sertifikasi Management
        Route::prefix('sertifikasi')->name('sertifikasi.')->group(function () {
            Route::get('/', [SertifikasiController::class, 'adminIndex'])->name('index');
            Route::get('/{sertifikasi}', [SertifikasiController::class, 'adminShow'])->name('show');
            Route::get('/{sertifikasi}/edit', [SertifikasiController::class, 'adminEdit'])->name('edit');
            Route::put('/{sertifikasi}', [SertifikasiController::class, 'adminUpdate'])->name('update');
            Route::delete('/{sertifikasi}', [SertifikasiController::class, 'adminDestroy'])->name('destroy');
            Route::post('/{sertifikasi}/approve', [SertifikasiController::class, 'adminApprove'])->name('approve');
        });

        // Master Data Kegiatan Management
        Route::prefix('master-kegiatan')->name('master-kegiatan.')->group(function () {
            // Jenis Kegiatan
            Route::prefix('jenis')->name('jenis.')->group(function () {
                Route::get('/', [JenisKegiatanController::class, 'index'])->name('index');
                Route::get('/create', [JenisKegiatanController::class, 'create'])->name('create');
                Route::post('/', [JenisKegiatanController::class, 'store'])->name('store');
                Route::get('/{jenisKegiatan}/edit', [JenisKegiatanController::class, 'edit'])->name('edit');
                Route::put('/{jenisKegiatan}', [JenisKegiatanController::class, 'update'])->name('update');
                Route::delete('/{jenisKegiatan}', [JenisKegiatanController::class, 'destroy'])->name('destroy');
            });

            // Ruang Lingkup
            Route::prefix('ruang-lingkup')->name('ruang-lingkup.')->group(function () {
                Route::get('/', [RuangLingkupController::class, 'index'])->name('index');
                Route::get('/create', [RuangLingkupController::class, 'create'])->name('create');
                Route::post('/', [RuangLingkupController::class, 'store'])->name('store');
                Route::get('/{ruangLingkup}/edit', [RuangLingkupController::class, 'edit'])->name('edit');
                Route::put('/{ruangLingkup}', [RuangLingkupController::class, 'update'])->name('update');
                Route::delete('/{ruangLingkup}', [RuangLingkupController::class, 'destroy'])->name('destroy');
            });

            // Detail Kegiatan
            Route::prefix('detail')->name('detail.')->group(function () {
                Route::get('/', [DetailKegiatanController::class, 'index'])->name('index');
                Route::get('/create', [DetailKegiatanController::class, 'create'])->name('create');
                Route::post('/', [DetailKegiatanController::class, 'store'])->name('store');
                Route::get('/{detailKegiatan}/edit', [DetailKegiatanController::class, 'edit'])->name('edit');
                Route::put('/{detailKegiatan}', [DetailKegiatanController::class, 'update'])->name('update');
                Route::delete('/{detailKegiatan}', [DetailKegiatanController::class, 'destroy'])->name('destroy');
            });

            // Nilai Kegiatan
            Route::prefix('nilai')->name('nilai.')->group(function () {
                Route::get('/', [NilaiKegiatanController::class, 'index'])->name('index');
                Route::get('/create', [NilaiKegiatanController::class, 'create'])->name('create');
                Route::post('/', [NilaiKegiatanController::class, 'store'])->name('store');
                Route::get('/{nilaiKegiatan}/edit', [NilaiKegiatanController::class, 'edit'])->name('edit');
                Route::put('/{nilaiKegiatan}', [NilaiKegiatanController::class, 'update'])->name('update');
                Route::delete('/{nilaiKegiatan}', [NilaiKegiatanController::class, 'destroy'])->name('destroy');
            });

            // API for dynamic dropdown
            Route::get('/api/detail-kegiatan', [NilaiKegiatanController::class, 'getDetails']);
        });

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
            Route::get('/mahasiswa/{mahasiswaId}', [LaporanController::class, 'adminShowMahasiswa'])->name('mahasiswa');
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

        // Antrian Verifikasi Management (Admin)
        Route::prefix('antrian-verifikasi')->name('antrian-verifikasi.')->group(function () {
            Route::get('/', [AntrianVerifikasiController::class, 'index'])->name('index');
            Route::get('/create', [AntrianVerifikasiController::class, 'create'])->name('create');
            Route::post('/', [AntrianVerifikasiController::class, 'store'])->name('store');
            Route::get('/{antrianVerifikasi}', [AntrianVerifikasiController::class, 'show'])->name('show');
            Route::get('/{antrianVerifikasi}/edit', [AntrianVerifikasiController::class, 'edit'])->name('edit');
            Route::put('/{antrianVerifikasi}', [AntrianVerifikasiController::class, 'update'])->name('update');
            Route::delete('/{antrianVerifikasi}', [AntrianVerifikasiController::class, 'destroy'])->name('destroy');
            Route::post('/detail/{detailId}/mark-attendance', [AntrianVerifikasiController::class, 'markAttendance'])->name('mark-attendance');
            Route::post('/detail/{detailId}/update-status', [AntrianVerifikasiController::class, 'updateStatus'])->name('update-status');
            Route::post('/detail/{detailId}/cancel', [AntrianVerifikasiController::class, 'cancelRegistration'])->name('cancel');
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

        // Antrian Verifikasi Routes for Mahasiswa
        Route::prefix('antrian-verifikasi')->name('antrian-verifikasi.')->group(function () {
            Route::get('/', [MahasiswaAntrianVerifikasiController::class, 'index'])->name('index');
            Route::get('/{id}/register', [MahasiswaAntrianVerifikasiController::class, 'register'])->name('register');
            Route::post('/{id}/register', [MahasiswaAntrianVerifikasiController::class, 'store'])->name('store');
            Route::get('/bukti/{id}', [MahasiswaAntrianVerifikasiController::class, 'bukti'])->name('bukti');
            Route::get('/bukti/{id}/download', [MahasiswaAntrianVerifikasiController::class, 'downloadBukti'])->name('download-bukti');
            Route::post('/{id}/cancel', [MahasiswaAntrianVerifikasiController::class, 'cancel'])->name('cancel');
        });

        // Kompetisi Routes for Mahasiswa
        Route::prefix('kompetisi')->name('kompetisi.')->group(function () {
            Route::get('/', [KompetisiMahasiswaDosenController::class, 'index'])->name('index');
            Route::get('/create', [KompetisiMahasiswaDosenController::class, 'create'])->name('create');
            Route::post('/', [KompetisiMahasiswaDosenController::class, 'store'])->name('store');
            Route::get('/{kompetisi}', [KompetisiMahasiswaDosenController::class, 'show'])->name('show');
            Route::get('/{kompetisi}/edit', [KompetisiMahasiswaDosenController::class, 'edit'])->name('edit');
            Route::put('/{kompetisi}', [KompetisiMahasiswaDosenController::class, 'update'])->name('update');
            Route::delete('/{kompetisi}', [KompetisiMahasiswaDosenController::class, 'destroy'])->name('destroy');
        });

        // Rekognisi Routes for Mahasiswa
        Route::prefix('rekognisi')->name('rekognisi.')->group(function () {
            Route::get('/', [RekognisiController::class, 'index'])->name('index');
            Route::get('/create', [RekognisiController::class, 'create'])->name('create');
            Route::post('/', [RekognisiController::class, 'store'])->name('store');
            Route::get('/{rekognisi}', [RekognisiController::class, 'show'])->name('show');
            Route::get('/{rekognisi}/edit', [RekognisiController::class, 'edit'])->name('edit');
            Route::put('/{rekognisi}', [RekognisiController::class, 'update'])->name('update');
            Route::delete('/{rekognisi}', [RekognisiController::class, 'destroy'])->name('destroy');
        });

        // Sertifikasi Routes for Mahasiswa
        Route::prefix('sertifikasi')->name('sertifikasi.')->group(function () {
            Route::get('/', [SertifikasiController::class, 'index'])->name('index');
            Route::get('/create', [SertifikasiController::class, 'create'])->name('create');
            Route::post('/', [SertifikasiController::class, 'store'])->name('store');
            Route::get('/{sertifikasi}', [SertifikasiController::class, 'show'])->name('show');
            Route::get('/{sertifikasi}/edit', [SertifikasiController::class, 'edit'])->name('edit');
            Route::put('/{sertifikasi}', [SertifikasiController::class, 'update'])->name('update');
            Route::delete('/{sertifikasi}', [SertifikasiController::class, 'destroy'])->name('destroy');
        });
    });
});
