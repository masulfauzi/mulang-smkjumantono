<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Statuskehadiran\Controllers\StatuskehadiranController;

Route::controller(StatuskehadiranController::class)->middleware(['web','auth'])->name('statuskehadiran.')->group(function(){
	Route::get('/statuskehadiran', 'index')->name('index');
	Route::get('/statuskehadiran/data', 'data')->name('data.index');
	Route::get('/statuskehadiran/create', 'create')->name('create');
	Route::post('/statuskehadiran', 'store')->name('store');
	Route::get('/statuskehadiran/{statuskehadiran}', 'show')->name('show');
	Route::get('/statuskehadiran/{statuskehadiran}/edit', 'edit')->name('edit');
	Route::patch('/statuskehadiran/{statuskehadiran}', 'update')->name('update');
	Route::get('/statuskehadiran/{statuskehadiran}/delete', 'destroy')->name('destroy');
});