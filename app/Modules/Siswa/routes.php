<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Siswa\Controllers\SiswaController;

Route::controller(SiswaController::class)->middleware(['web','auth'])->name('siswa.')->group(function(){
	//custom route untuk biodata siswa
	Route::get('/biodata', 'biodata')->name('biodata.index');
	Route::get('/biodata/admin', 'biodata_admin')->name('biodata.admin.index');
	Route::get('/biodata/upload', 'upload_file')->name('file.index');
	Route::get('/biodata/{file}/lihat_file/{jenis}', 'lihat_file')->name('lihat_file.index');
	Route::post('/biodata/upload', 'aksi_upload')->name('aksi_upload.index');
	Route::post('/biodata', 'store_biodata')->name('biodata.store.index');
	Route::get('/hasil_abm', 'hasil_abm')->name('abm.index');
	Route::get('/detail/{siswa}', 'detail_siswa')->name('detail.index');


	//custom route untuk download
	Route::get('/downloads', 'downloads')->name('download.index');
	Route::get('/downloads/biodata', 'download_biodata')->name('download.biodata.index');

	//custom route untuk pengumuman kelulusan
	Route::get('/kelulusan', 'kelulusan')->name('kelulusan.index');

	Route::get('/siswa', 'index')->name('index');
	Route::get('/siswa/data', 'data')->name('data.index');
	Route::get('/siswa/create', 'create')->name('create');
	Route::post('/siswa', 'store')->name('store');
	Route::get('/siswa/{siswa}', 'show')->name('show');
	Route::get('/siswa/{siswa}/edit', 'edit')->name('edit');
	Route::patch('/siswa/{siswa}', 'update')->name('update');
	Route::get('/siswa/{siswa}/delete', 'destroy')->name('destroy');
});