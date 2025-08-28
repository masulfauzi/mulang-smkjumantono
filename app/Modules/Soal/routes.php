<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Soal\Controllers\SoalController;

Route::controller(SoalController::class)->middleware(['web','auth'])->name('soal.')->group(function(){
	Route::get('/soal', 'index')->name('index');
	Route::get('/soal/data', 'data')->name('data.index');
	Route::get('/soal/create', 'create')->name('create');
	Route::post('/soal', 'store')->name('store');
	Route::get('/soal/{soal}', 'show')->name('show');
	Route::get('/soal/{soal}/edit', 'edit')->name('edit');
	Route::post('/soal/{soal}', 'update')->name('update');
	Route::get('/soal/{soal}/delete', 'destroy')->name('destroy');



	Route::get('/soal/lihat/{id_ujian}/{id_jenissoal}', 'lihat_soal')->name('lihat_soal.index');
	Route::get('/soal/input/{id_ujian}/{id_jenissoal}/{no_soal}', 'input_soal')->name('input_soal.create');
	Route::get('/soal/hapus_gambar/{id_soal}/{gambar}', 'hapus_gambar')->name('hapus_gambar.destroy');
});