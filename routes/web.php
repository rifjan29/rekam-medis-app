<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PoliController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\UserController;
use App\Models\RekamMedisModel;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard',[DashboardController::class,'index'])->name('dashboard');
    Route::prefix('dashboard')->group(function () {
        // user
        Route::get('/search-user', [UserController::class, 'index'])->name('user.search');
        Route::resource('user', UserController::class);
        // Poli
        Route::get('/search-poli', [PoliController::class, 'index'])->name('poli.search');
        Route::resource('poli', PoliController::class);
        // Rekam medis
        Route::get('search-medis',[RekamMedisController::class,'index'])->name('rekam-medis.search');
        Route::resource('rekam-medis',RekamMedisController::class);
        // Peminjaman
        Route::get('cetak-tracer/{id}',[PeminjamanController::class,'cetakTracer'])->name('peminjaman.tracer');
        Route::get('search-peminjaman',[PeminjamanController::class,'index'])->name('peminjaman.search');
        Route::post('peminjaman/set-tanggal',[PeminjamanController::class,'setTanggal'])->name('peminjaman.set');
        Route::post('peminjaman/kembali',[PeminjamanController::class,'kembali'])->name('peminjaman.kembali');
        Route::post('peminjaman/verifikasi',[PeminjamanController::class,'verifikasi'])->name('peminjaman.verifikasi');
        Route::resource('peminjaman',PeminjamanController::class);
        // Reminder
        Route::get('reminder',[ReminderController::class,'index'])->name('reminder.index');
        Route::get('reminder/test',[ReminderController::class,'sendWhatsAppMessage'])->name('reminder.test');
        Route::middleware(['auth','role:admin,petugas-rm'])->group(function () {
            //Laporan
            Route::get('laporan/search',[LaporanController::class,'index'])->name('laporan.search');
            Route::get('laporan',[LaporanController::class,'index'])->name('laporan.index');
            Route::get('laporan/export',[LaporanController::class,'export'])->name('laporan.export');
        });

    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
