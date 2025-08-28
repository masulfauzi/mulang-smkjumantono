<?php

use Illuminate\Support\Facades\Route;
use App\Modules\StatusPekerjaan\Controllers\StatusPekerjaanController;

Route::controller(StatusPekerjaanController::class)->middleware(['web','auth'])->name('statuspekerjaan.')->group(function(){
	Route::get('/statuspekerjaan', 'index')->name('index');
	Route::get('/statuspekerjaan/data', 'data')->name('data.index');
	Route::get('/statuspekerjaan/create', 'create')->name('create');
	Route::post('/statuspekerjaan', 'store')->name('store');
	Route::get('/statuspekerjaan/{statuspekerjaan}', 'show')->name('show');
	Route::get('/statuspekerjaan/{statuspekerjaan}/edit', 'edit')->name('edit');
	Route::patch('/statuspekerjaan/{statuspekerjaan}', 'update')->name('update');
	Route::get('/statuspekerjaan/{statuspekerjaan}/delete', 'destroy')->name('destroy');
});