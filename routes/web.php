<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WaliKelasController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\AlternatifController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\PerhitunganController;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/cek-kelas', [HomeController::class, 'cekKelas'])->name('cek.kelas');
Route::get('/login', [AuthController::class, 'index'])->name('login');


Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::post('/proseslogin', [AuthController::class, 'proseslogin'])->name('proseslogin');

Route::middleware(['auth:web'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Alternatif Routes
    Route::get('/alternatif', [AlternatifController::class, 'index'])->name('alternatif.index');
    Route::post('/alternatif/store', [AlternatifController::class, 'store'])->name('alternatif.store');
    Route::post('/alternatif/edit', [AlternatifController::class, 'edit'])->name('alternatif.edit');
    Route::put('/alternatif/{id}/update', [AlternatifController::class, 'update'])->name('alternatif.update');
    Route::delete('/alternatif/{id}/delete', [AlternatifController::class, 'delete'])->name('alternatif.delete');
    Route::get('/alternatif/template', [AlternatifController::class, 'downloadTemplate'])->name('alternatif.template');
    Route::post('/alternatif/import', [AlternatifController::class, 'import'])->name('alternatif.import');
    
    // Wali Kelas Routes
    Route::get('/walikelas', [WaliKelasController::class, 'index'])->name('walikelas.index');
    Route::post('/walikelas/store', [WaliKelasController::class, 'store'])->name('walikelas.store');
    Route::post('/walikelas/edit', [WaliKelasController::class, 'edit'])->name('walikelas.edit');
    Route::put('/walikelas/{id}/update', [WaliKelasController::class, 'update'])->name('walikelas.update');
    Route::delete('/walikelas/{id}/delete', [WaliKelasController::class, 'delete'])->name('walikelas.delete');

    // Kriteria Routes
    Route::get('/kriteria', [KriteriaController::class, 'index'])->name('kriteria.index');
    Route::post('/kriteria/store', [KriteriaController::class, 'store'])->name('kriteria.store');
    Route::post('/kriteria/edit', [KriteriaController::class, 'edit'])->name('kriteria.edit');
    Route::put('/kriteria/{id}/update', [KriteriaController::class, 'update'])->name('kriteria.update');
    Route::delete('/kriteria/{id}/delete', [KriteriaController::class, 'delete'])->name('kriteria.delete');

    // Penilai Routes
    Route::get('/penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');
    Route::post('/penilaian/store', [PenilaianController::class, 'store'])->name('penilaian.store');
    Route::get('/penilaian/export', [PenilaianController::class, 'export'])->name('penilaian.export');
    Route::post('/penilaian/import', [PenilaianController::class, 'import'])->name('penilaian.import');

    Route::get('/perangkingan', [PerhitunganController::class, 'index'])->name('perangkingan.index');

    // Route untuk memproses tombol "Hitung SMART"
    Route::post('/perangkingan/hitung', [PerhitunganController::class, 'hitung'])->name('perangkingan.hitung');
    Route::get('/perangkingan/cetak', [PerhitunganController::class, 'cetak'])->name('perangkingan.cetak');

    // Profile Routes
    Route::get('/profile', [AuthController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [AuthController::class, 'update'])->name('profile.update');
});
