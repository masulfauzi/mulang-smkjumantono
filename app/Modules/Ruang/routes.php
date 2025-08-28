<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Ruang\Controllers\RuangController;

Route::controller(RuangController::class)->middleware(['web','auth'])->name('ruang.')->group(function(){
	Route::get('/ruang', 'index')->name('index');
	Route::get('/ruang/data', 'data')->name('data.index');
	Route::get('/ruang/create', 'create')->name('create');
	Route::post('/ruang', 'store')->name('store');
	Route::get('/ruang/{ruang}', 'show')->name('show');
	Route::get('/ruang/{ruang}/edit', 'edit')->name('edit');
	Route::patch('/ruang/{ruang}', 'update')->name('update');
	Route::get('/ruang/{ruang}/delete', 'destroy')->name('destroy');
});