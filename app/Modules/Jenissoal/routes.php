<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Jenissoal\Controllers\JenissoalController;

Route::controller(JenissoalController::class)->middleware(['web','auth'])->name('jenissoal.')->group(function(){
	Route::get('/jenissoal', 'index')->name('index');
	Route::get('/jenissoal/data', 'data')->name('data.index');
	Route::get('/jenissoal/create', 'create')->name('create');
	Route::post('/jenissoal', 'store')->name('store');
	Route::get('/jenissoal/{jenissoal}', 'show')->name('show');
	Route::get('/jenissoal/{jenissoal}/edit', 'edit')->name('edit');
	Route::patch('/jenissoal/{jenissoal}', 'update')->name('update');
	Route::get('/jenissoal/{jenissoal}/delete', 'destroy')->name('destroy');
});