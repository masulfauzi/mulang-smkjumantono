<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Tingkat\Controllers\TingkatController;

Route::controller(TingkatController::class)->middleware(['web','auth'])->name('tingkat.')->group(function(){
	Route::get('/tingkat', 'index')->name('index');
	Route::get('/tingkat/data', 'data')->name('data.index');
	Route::get('/tingkat/create', 'create')->name('create');
	Route::post('/tingkat', 'store')->name('store');
	Route::get('/tingkat/{tingkat}', 'show')->name('show');
	Route::get('/tingkat/{tingkat}/edit', 'edit')->name('edit');
	Route::patch('/tingkat/{tingkat}', 'update')->name('update');
	Route::get('/tingkat/{tingkat}/delete', 'destroy')->name('destroy');
});