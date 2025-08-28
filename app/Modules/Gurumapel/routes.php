<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Gurumapel\Controllers\GurumapelController;

Route::controller(GurumapelController::class)->middleware(['web','auth'])->name('gurumapel.')->group(function(){
	Route::get('/gurumapel', 'index')->name('index');
	Route::get('/gurumapel/data', 'data')->name('data.index');
	Route::get('/gurumapel/create', 'create')->name('create');
	Route::post('/gurumapel', 'store')->name('store');
	Route::get('/gurumapel/{gurumapel}', 'show')->name('show');
	Route::get('/gurumapel/{gurumapel}/edit', 'edit')->name('edit');
	Route::patch('/gurumapel/{gurumapel}', 'update')->name('update');
	Route::get('/gurumapel/{gurumapel}/delete', 'destroy')->name('destroy');
	Route::get('/gurumapel/{gurumapel}/lihat/{jenis}', 'lihat_file')->name('lihat.index');
	
	
	//route untuk guru
	Route::get('/pas', 'index_guru')->name('pas.index');
	Route::get('/pas/upload/{gurumapel}', 'upload_file')->name('pas.upload.index');
	Route::post('/pas/upload/', 'aksi_upload')->name('pas.aksi_upload.index');
});