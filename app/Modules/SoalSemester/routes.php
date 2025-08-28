<?php

use Illuminate\Support\Facades\Route;
use App\Modules\SoalSemester\Controllers\SoalSemesterController;

Route::controller(SoalSemesterController::class)->middleware(['web','auth'])->name('soalsemester.')->group(function(){
	// route custom
	Route::get('/soalsemester/input/{id_ujiansemester}/{no_soal}', 'input')->name('input.create');
	Route::get('/soalsemester/hapus_gambar/{id_soal}/{jenis}', 'hapus_gambar')->name('hapus_gambar.destroy');
	Route::get('/soalsemester/lihat_soal/{id_soal}', 'lihat_soal')->name('lihat_soal.index');
	
	
	// route bawaan
	Route::get('/soalsemester', 'index')->name('index');
	Route::get('/soalsemester/data', 'data')->name('data.index');
	Route::get('/soalsemester/create', 'create')->name('create');
	Route::post('/soalsemester', 'store')->name('store');
	Route::get('/soalsemester/{soalsemester}', 'show')->name('show');
	Route::get('/soalsemester/{soalsemester}/edit', 'edit')->name('edit');
	Route::patch('/soalsemester/{soalsemester}', 'update')->name('update');
	Route::get('/soalsemester/{soalsemester}/delete', 'destroy')->name('destroy');
});