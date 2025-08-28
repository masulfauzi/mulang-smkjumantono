<?php

use Illuminate\Support\Facades\Route;
use App\Modules\TahunAjaran\Controllers\TahunAjaranController;

Route::controller(TahunAjaranController::class)->middleware(['web','auth'])->name('tahunajaran.')->group(function(){
	Route::get('/tahunajaran', 'index')->name('index');
	Route::get('/tahunajaran/data', 'data')->name('data.index');
	Route::get('/tahunajaran/create', 'create')->name('create');
	Route::post('/tahunajaran', 'store')->name('store');
	Route::get('/tahunajaran/{tahunajaran}', 'show')->name('show');
	Route::get('/tahunajaran/{tahunajaran}/edit', 'edit')->name('edit');
	Route::patch('/tahunajaran/{tahunajaran}', 'update')->name('update');
	Route::get('/tahunajaran/{tahunajaran}/delete', 'destroy')->name('destroy');
});