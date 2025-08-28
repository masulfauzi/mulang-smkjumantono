<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Log\Controllers\LogController;

Route::controller(LogController::class)->middleware(['web','auth'])->name('log.')->group(function(){
	Route::get('/log', 'index')->name('index');
	Route::get('/log/data', 'data')->name('data.index');
	Route::get('/log/create', 'create')->name('create');
	Route::post('/log', 'store')->name('store');
	Route::get('/log/{log}', 'show')->name('show');
	Route::get('/log/{log}/edit', 'edit')->name('edit');
	Route::patch('/log/{log}', 'update')->name('update');
	Route::get('/log/{log}/delete', 'destroy')->name('destroy');
});