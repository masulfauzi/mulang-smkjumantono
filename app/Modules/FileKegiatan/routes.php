<?php

use Illuminate\Support\Facades\Route;
use App\Modules\FileKegiatan\Controllers\FileKegiatanController;

Route::controller(FileKegiatanController::class)->middleware(['web','auth'])->name('filekegiatan.')->group(function(){
	Route::get('/filekegiatan', 'index')->name('index');
	Route::get('/filekegiatan/data', 'data')->name('data.index');
	Route::get('/filekegiatan/{kegiatan}/create', 'create')->name('create');
	Route::post('/filekegiatan', 'store')->name('store');
	Route::get('/filekegiatan/{filekegiatan}', 'show')->name('show');
	Route::get('/filekegiatan/{filekegiatan}/edit', 'edit')->name('edit');
	Route::patch('/filekegiatan/{filekegiatan}', 'update')->name('update');
	Route::get('/filekegiatan/{filekegiatan}/delete', 'destroy')->name('destroy');
});