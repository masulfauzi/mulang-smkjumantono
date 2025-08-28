<?php

use Illuminate\Support\Facades\Route;
use App\Modules\JenisPerangkat\Controllers\JenisPerangkatController;

Route::controller(JenisPerangkatController::class)->middleware(['web','auth'])->name('jenisperangkat.')->group(function(){
	Route::get('/jenisperangkat', 'index')->name('index');
	Route::get('/jenisperangkat/data', 'data')->name('data.index');
	Route::get('/jenisperangkat/create', 'create')->name('create');
	Route::post('/jenisperangkat', 'store')->name('store');
	Route::get('/jenisperangkat/{jenisperangkat}', 'show')->name('show');
	Route::get('/jenisperangkat/{jenisperangkat}/edit', 'edit')->name('edit');
	Route::patch('/jenisperangkat/{jenisperangkat}', 'update')->name('update');
	Route::get('/jenisperangkat/{jenisperangkat}/delete', 'destroy')->name('destroy');
});