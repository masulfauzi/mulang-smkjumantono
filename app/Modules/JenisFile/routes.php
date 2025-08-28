<?php

use Illuminate\Support\Facades\Route;
use App\Modules\JenisFile\Controllers\JenisFileController;

Route::controller(JenisFileController::class)->middleware(['web','auth'])->name('jenisfile.')->group(function(){
	Route::get('/jenisfile', 'index')->name('index');
	Route::get('/jenisfile/data', 'data')->name('data.index');
	Route::get('/jenisfile/create', 'create')->name('create');
	Route::post('/jenisfile', 'store')->name('store');
	Route::get('/jenisfile/{jenisfile}', 'show')->name('show');
	Route::get('/jenisfile/{jenisfile}/edit', 'edit')->name('edit');
	Route::patch('/jenisfile/{jenisfile}', 'update')->name('update');
	Route::get('/jenisfile/{jenisfile}/delete', 'destroy')->name('destroy');
});