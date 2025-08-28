<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Config\Controllers\ConfigController;

Route::controller(ConfigController::class)->middleware(['web','auth'])->name('config.')->group(function(){
	Route::get('/config', 'index')->name('index');
	Route::get('/config/data', 'data')->name('data.index');
	Route::get('/config/create', 'create')->name('create');
	Route::post('/config', 'store')->name('store');
	Route::get('/config/{config}', 'show')->name('show');
	Route::get('/config/{config}/edit', 'edit')->name('edit');
	Route::patch('/config/{config}', 'update')->name('update');
	Route::get('/config/{config}/delete', 'destroy')->name('destroy');
});