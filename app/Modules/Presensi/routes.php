<?php

use App\Modules\Presensi\Controllers\PresensiController;
use Illuminate\Support\Facades\Route;

Route::controller(PresensiController::class)->middleware(['web', 'auth'])->name('presensi.')->group(function () {
    //custom
    Route::get('/presensijurnal/{jurnal}', 'presensi_jurnal')->name('jurnal.index');
    Route::post('/presensijurnal', 'presensi_jurnal_store')->name('jurnal.store');
    Route::get('/rekappresensi', 'rekap_presensi')->name('rekap.index');
    Route::get('/rekappresensi/export', 'export_presensi')->name('export.index');

    Route::post('/statussiswa', 'get_siswa_kehadiran')->name('dashboard.index');

    Route::get('/presensi', 'index')->name('index');
    Route::get('/presensi/data', 'data')->name('data.index');
    Route::get('/presensi/create', 'create')->name('create');
    Route::post('/presensi', 'store')->name('store');
    Route::get('/presensi/{presensi}', 'show')->name('show');
    Route::get('/presensi/{presensi}/edit', 'edit')->name('edit');
    Route::patch('/presensi/{presensi}', 'update')->name('update');
    Route::get('/presensi/{presensi}/delete', 'destroy')->name('destroy');

});
