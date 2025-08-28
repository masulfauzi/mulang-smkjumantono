<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Prestasi\Controllers\PrestasiController;

Route::controller(PrestasiController::class)->middleware(['web', 'auth'])->name('prestasi.')->group(function () {
	// route custom admin
	Route::get('/prestasi/admin', 'index_admin')->name('admin.index');
	Route::get('/prestasi/ubah_status/{prestasi}/{status}', 'ubah_status')->name('ubah_status.edit');
	Route::get('/verif_prestasi', 'verif_prestasi')->name('verif_prestasi.index');
	Route::post('/verif_prestasi', 'aksi_verif_prestasi')->name('verif_prestasi.store');
	Route::get('/verif_prestasi/siswa/{id_kelas}', 'daftar_siswa')->name('daftar_siswa.index');
	Route::get('/verif_prestasi/prestasi/{id_siswa}', 'daftar_prestasi')->name('daftar_prestasi.index');
	Route::get('/verif_prestasi/detail_prestasi', 'detail_prestasi')->name('detail.index');



	Route::get('/prestasi', 'index')->name('index');
	Route::get('/prestasi/data', 'data')->name('data.index');
	Route::get('/prestasi/create', 'create')->name('create');
	Route::post('/prestasi', 'store')->name('store');
	Route::get('/prestasi/{prestasi}', 'show')->name('show');
	Route::get('/prestasi/{prestasi}/edit', 'edit')->name('edit');
	Route::patch('/prestasi/{prestasi}', 'update')->name('update');
	Route::get('/prestasi/{prestasi}/delete', 'destroy')->name('destroy');
});
