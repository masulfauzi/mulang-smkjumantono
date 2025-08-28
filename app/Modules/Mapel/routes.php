<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Mapel\Controllers\MapelController;

Route::controller(MapelController::class)->middleware(['web','auth'])->name('mapel.')->group(function(){
	Route::get('/mapel', 'index')->name('index');
	Route::get('/mapel/data', 'data')->name('data.index');
	Route::get('/mapel/create', 'create')->name('create');
	Route::post('/mapel', 'store')->name('store');
	Route::get('/mapel/{mapel}', 'show')->name('show');
	Route::get('/mapel/{mapel}/edit', 'edit')->name('edit');
	Route::patch('/mapel/{mapel}', 'update')->name('update');
	Route::get('/mapel/{mapel}/delete', 'destroy')->name('destroy');
});