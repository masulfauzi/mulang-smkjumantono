<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Kegiatan\Controllers\KegiatanController;

Route::controller(KegiatanController::class)->middleware(['web','auth'])->name('kegiatan.')->group(function(){
	Route::get('/kegiatan', 'index')->name('index');
	Route::get('/kegiatan/data', 'data')->name('data.index');
	Route::get('/kegiatan/create', 'create')->name('create');
	Route::post('/kegiatan', 'store')->name('store');
	Route::get('/kegiatan/{kegiatan}', 'show')->name('show');
	Route::get('/kegiatan/{kegiatan}/edit', 'edit')->name('edit');
	Route::patch('/kegiatan/{kegiatan}', 'update')->name('update');
	Route::get('/kegiatan/{kegiatan}/delete', 'destroy')->name('destroy');
});