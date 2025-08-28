<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Kelas\Controllers\KelasController;

Route::controller(KelasController::class)->middleware(['web','auth'])->name('kelas.')->group(function(){
	// asesmen diagnostik
	Route::get('/kelas/asesmen', 'asesmen')->name('asesmen.index');
	Route::get('/kelas/asesmen/{kelas}', 'detail_asesmen')->name('detail_asesmen.show');
	Route::get('/kelas/download_file_smp_pdf/{kelas}', 'download_file_smp_pdf')->name('download_file_smp_pdf.show');
	Route::get('/kelas/download_file_smp_image/{kelas}', 'download_file_smp_image')->name('download_file_smp_image.show');

	
	Route::get('/kelas', 'index')->name('index');
	
	Route::get('/kelas/data', 'data')->name('data.index');
	Route::get('/kelas/create', 'create')->name('create');
	Route::post('/kelas', 'store')->name('store');
	Route::get('/kelas/{kelas}', 'show')->name('show');
	Route::get('/kelas/{kelas}/edit', 'edit')->name('edit');
	Route::patch('/kelas/{kelas}', 'update')->name('update');
	Route::get('/kelas/{kelas}/delete', 'destroy')->name('destroy');

	Route::get('/kelas/naik/{id_kelas}', 'naik_kelas')->name('naik.index');
	Route::post('/kelas/naik', 'aksi_naik_kelas')->name('naik.store');
	
	


});