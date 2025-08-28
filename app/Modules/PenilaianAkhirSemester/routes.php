<?php

use Illuminate\Support\Facades\Route;
use App\Modules\PenilaianAkhirSemester\Controllers\PenilaianAkhirSemesterController;

Route::controller(PenilaianAkhirSemesterController::class)->middleware(['web', 'auth'])->name('penilaianakhirsemester.')->group(function () {
	// route custom
	Route::get('/penilaianakhirsemester/upload/{penilaianakhirsemester}', 'upload')->name('upload.index');
	Route::post('/penilaianakhirsemester/aksi_upload', 'aksi_upload')->name('aksi_upload.index');





	Route::get('/penilaianakhirsemester', 'index')->name('index');
	Route::get('/penilaianakhirsemester/data', 'data')->name('data.index');
	Route::get('/penilaianakhirsemester/create', 'create')->name('create');
	Route::post('/penilaianakhirsemester', 'store')->name('store');
	Route::get('/penilaianakhirsemester/{penilaianakhirsemester}', 'show')->name('show');
	Route::get('/penilaianakhirsemester/{penilaianakhirsemester}/edit', 'edit')->name('edit');
	Route::patch('/penilaianakhirsemester/{penilaianakhirsemester}', 'update')->name('update');
	Route::get('/penilaianakhirsemester/{penilaianakhirsemester}/delete', 'destroy')->name('destroy');
});
