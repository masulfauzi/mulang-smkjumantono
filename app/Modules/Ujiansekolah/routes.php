<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Ujiansekolah\Controllers\UjiansekolahController;

Route::controller(UjiansekolahController::class)->middleware(['web','auth'])->name('ujiansekolah.')->group(function(){
	Route::get('/ujiansekolah', 'index')->name('index');
	Route::get('/ujiansekolah/data', 'data')->name('data.index');
	Route::get('/ujiansekolah/create', 'create')->name('create');
	Route::post('/ujiansekolah', 'store')->name('store');
	Route::get('/ujiansekolah/{ujiansekolah}', 'show')->name('show');
	Route::get('/ujiansekolah/{ujiansekolah}/edit', 'edit')->name('edit');
	Route::patch('/ujiansekolah/{ujiansekolah}', 'update')->name('update');
	Route::get('/ujiansekolah/{ujiansekolah}/delete', 'destroy')->name('destroy');

	//route untuk guru
	Route::get('/us/kelengkapan', 'index_guru')->name('guru.index');
	Route::get('/us/upload/{id}', 'upload')->name('guru.upload.index');
	Route::post('/us/upload', 'aksi_upload')->name('guru.aksi_upload.index');
	Route::post('/us/upload_excel', 'upload_excel')->name('guru.upload_excel.index');
});