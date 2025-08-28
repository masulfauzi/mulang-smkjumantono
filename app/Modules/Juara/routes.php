<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Juara\Controllers\JuaraController;

Route::controller(JuaraController::class)->middleware(['web','auth'])->name('juara.')->group(function(){
	Route::get('/juara', 'index')->name('index');
	Route::get('/juara/data', 'data')->name('data.index');
	Route::get('/juara/create', 'create')->name('create');
	Route::post('/juara', 'store')->name('store');
	Route::get('/juara/{juara}', 'show')->name('show');
	Route::get('/juara/{juara}/edit', 'edit')->name('edit');
	Route::patch('/juara/{juara}', 'update')->name('update');
	Route::get('/juara/{juara}/delete', 'destroy')->name('destroy');
});