<?php

use Illuminate\Support\Facades\Route;
use App\Modules\JurnalTu\Controllers\JurnalTuController;

Route::controller(JurnalTuController::class)->middleware(['web','auth'])->name('jurnaltu.')->group(function(){
	Route::get('/jurnaltu', 'index')->name('index');
	Route::get('/jurnaltu/data', 'data')->name('data.index');
	Route::get('/jurnaltu/create', 'create')->name('create');
	Route::post('/jurnaltu', 'store')->name('store');
	Route::get('/jurnaltu/{jurnaltu}', 'show')->name('show');
	Route::get('/jurnaltu/{jurnaltu}/edit', 'edit')->name('edit');
	Route::patch('/jurnaltu/{jurnaltu}', 'update')->name('update');
	Route::get('/jurnaltu/{jurnaltu}/delete', 'destroy')->name('destroy');
});