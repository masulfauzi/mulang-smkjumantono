<?php

use Illuminate\Support\Facades\Route;
use App\Modules\JenisWorkshop\Controllers\JenisWorkshopController;

Route::controller(JenisWorkshopController::class)->middleware(['web','auth'])->name('jenisworkshop.')->group(function(){
	Route::get('/jenisworkshop', 'index')->name('index');
	Route::get('/jenisworkshop/data', 'data')->name('data.index');
	Route::get('/jenisworkshop/create', 'create')->name('create');
	Route::post('/jenisworkshop', 'store')->name('store');
	Route::get('/jenisworkshop/{jenisworkshop}', 'show')->name('show');
	Route::get('/jenisworkshop/{jenisworkshop}/edit', 'edit')->name('edit');
	Route::patch('/jenisworkshop/{jenisworkshop}', 'update')->name('update');
	Route::get('/jenisworkshop/{jenisworkshop}/delete', 'destroy')->name('destroy');
});