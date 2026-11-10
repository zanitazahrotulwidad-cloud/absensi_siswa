
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrtuController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\MapelController;
use App\Http\Controllers\Guru\JadwalController as GuruJadwalController;
use App\Http\Controllers\Guru\AbsensiController as GuruAbsensiController;
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;
use App\Http\Controllers\Guru\MapelController as GuruMapelController;
use App\Http\Controllers\Guru\SiswaController as GuruSiswaController;
use App\Http\Controllers\Siswa\JadwalController as SiswaJadwalController;
use App\Http\Controllers\Siswa\MapelController as SiswaMapelController;
use App\Http\Controllers\Siswa\AbsensiController as SiswaAbsensiController;

// Halaman utama
Route::get('/', function () {
    return view('home');
})->name('home');

// Autentikasi
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.process');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Dashboard berdasarkan role
Route::get('/dashboard', function (\Illuminate\Http\Request $request) {
    return match ($request->user()->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'guru' => redirect()->route('guru.dashboard'),
        'siswa' => redirect()->route('siswa.dashboard'),
        default => abort(403),
    };
})->middleware('auth')->name('dashboard');

// Dashboard admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/logs', [
        \Rap2hpoutre\LaravelLogViewer\LogViewerController::class,
        'index'
    ])->name('logs.index');
});

Route::get('/admin/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'role:admin'])
    ->name('admin.dashboard');

// Dashboard dan jadwal guru
Route::get('/guru/dashboard', [GuruDashboardController::class, 'index'])
    ->middleware(['auth', 'role:guru'])
    ->name('guru.dashboard');

Route::get('/guru/jadwal', [GuruJadwalController::class, 'index'])
    ->middleware(['auth', 'role:guru'])
    ->name('guru.jadwal.index');

// Fitur guru
Route::middleware(['auth', 'role:guru'])
    ->prefix('guru')
    ->name('guru.')
    ->group(function () {
        Route::get('/absensi', [GuruAbsensiController::class, 'index'])
            ->name('absensi.index');

        Route::get('/absensi/create', [GuruAbsensiController::class, 'create'])
            ->name('absensi.create');

        Route::post('/absensi', [GuruAbsensiController::class, 'store'])
            ->name('absensi.store');

        Route::get('/absensi/{absensi}/edit', [GuruAbsensiController::class, 'edit'])
            ->name('absensi.edit');

        Route::put('/absensi/{absensi}', [GuruAbsensiController::class, 'update'])
            ->name('absensi.update');

        Route::delete('/absensi/{absensi}', [GuruAbsensiController::class, 'destroy'])
            ->name('absensi.destroy');

        Route::get('/mapel', [GuruMapelController::class, 'index'])
            ->name('mapel.index');

        Route::get('/siswa', [GuruSiswaController::class, 'index'])
            ->name('siswa.index');
    });

// Dashboard siswa
Route::get('/siswa/dashboard', function () {
    return view('siswa.dashboard');
})->middleware(['auth', 'role:siswa'])->name('siswa.dashboard');

// Fitur siswa
Route::middleware(['auth', 'role:siswa'])
    ->prefix('siswa')
    ->name('siswa.')
    ->group(function () {
        Route::get('/jadwal', [SiswaJadwalController::class, 'index'])
            ->name('jadwal.index');

        Route::get('/mapel', [SiswaMapelController::class, 'index'])
            ->name('mapel.index');

        Route::get('/absensi', [SiswaAbsensiController::class, 'index'])
            ->name('absensi.index');
    });

// Fitur admin
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('mapel', MapelController::class)
            ->except(['show']);

        Route::resource('guru', \App\Http\Controllers\Admin\GuruController::class)
            ->except(['show']);

        Route::resource('siswa', \App\Http\Controllers\Admin\SiswaController::class)
            ->except(['show']);

        Route::resource('jadwal', JadwalController::class)
            ->except(['show']);

        Route::resource('absensi', \App\Http\Controllers\Admin\AbsensiController::class)
            ->except(['show']);
    });

// Halaman publik untuk orang tua mengecek absensi siswa
Route::get('/cek-absensi', [OrtuController::class, 'index'])
    ->name('ortu.index');
