<?php

use Illuminate\Support\Facades\Route;
use App\Modules\BagianTu\Controllers\BagianTuController;

Route::controller(BagianTuController::class)->middleware(['web','auth'])->name('bagiantu.')->group(function(){
	Route::get('/bagiantu', 'index')->name('index');
	Route::get('/bagiantu/data', 'data')->name('data.index');
	Route::get('/bagiantu/create', 'create')->name('create');
	Route::post('/bagiantu', 'store')->name('store');
	Route::get('/bagiantu/{bagiantu}', 'show')->name('show');
	Route::get('/bagiantu/{bagiantu}/edit', 'edit')->name('edit');
	Route::patch('/bagiantu/{bagiantu}', 'update')->name('update');
	Route::get('/bagiantu/{bagiantu}/delete', 'destroy')->name('destroy');
});