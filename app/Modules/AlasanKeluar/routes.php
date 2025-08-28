<?php

use Illuminate\Support\Facades\Route;
use App\Modules\AlasanKeluar\Controllers\AlasanKeluarController;

Route::controller(AlasanKeluarController::class)->middleware(['web','auth'])->name('alasankeluar.')->group(function(){
	Route::get('/alasankeluar', 'index')->name('index');
	Route::get('/alasankeluar/data', 'data')->name('data.index');
	Route::get('/alasankeluar/create', 'create')->name('create');
	Route::post('/alasankeluar', 'store')->name('store');
	Route::get('/alasankeluar/{alasankeluar}', 'show')->name('show');
	Route::get('/alasankeluar/{alasankeluar}/edit', 'edit')->name('edit');
	Route::patch('/alasankeluar/{alasankeluar}', 'update')->name('update');
	Route::get('/alasankeluar/{alasankeluar}/delete', 'destroy')->name('destroy');
});