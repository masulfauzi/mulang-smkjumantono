<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Hari\Controllers\HariController;

Route::controller(HariController::class)->middleware(['web','auth'])->name('hari.')->group(function(){
	Route::get('/hari', 'index')->name('index');
	Route::get('/hari/data', 'data')->name('data.index');
	Route::get('/hari/create', 'create')->name('create');
	Route::post('/hari', 'store')->name('store');
	Route::get('/hari/{hari}', 'show')->name('show');
	Route::get('/hari/{hari}/edit', 'edit')->name('edit');
	Route::patch('/hari/{hari}', 'update')->name('update');
	Route::get('/hari/{hari}/delete', 'destroy')->name('destroy');
});