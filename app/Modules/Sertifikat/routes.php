<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Sertifikat\Controllers\SertifikatController;

Route::controller(SertifikatController::class)->middleware(['web','auth'])->name('sertifikat.')->group(function(){
	Route::get('/sertifikat', 'index')->name('index');
	Route::get('/sertifikat/data', 'data')->name('data.index');
	Route::get('/sertifikat/create', 'create')->name('create');
	Route::post('/sertifikat', 'store')->name('store');
	Route::get('/sertifikat/{sertifikat}', 'show')->name('show');
	Route::get('/sertifikat/{sertifikat}/edit', 'edit')->name('edit');
	Route::patch('/sertifikat/{sertifikat}', 'update')->name('update');
	Route::get('/sertifikat/{sertifikat}/delete', 'destroy')->name('destroy');
});