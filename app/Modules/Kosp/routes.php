<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Kosp\Controllers\KospController;

Route::controller(KospController::class)->middleware(['web','auth'])->name('kosp.')->group(function(){
	Route::get('/kosp', 'index')->name('index');
	Route::get('/kosp/data', 'data')->name('data.index');
	Route::get('/kosp/create', 'create')->name('create');
	Route::post('/kosp', 'store')->name('store');
	Route::get('/kosp/{kosp}', 'show')->name('show');
	Route::get('/kosp/{kosp}/edit', 'edit')->name('edit');
	Route::patch('/kosp/{kosp}', 'update')->name('update');
	Route::get('/kosp/{kosp}/delete', 'destroy')->name('destroy');
});