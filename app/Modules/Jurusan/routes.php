<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Jurusan\Controllers\JurusanController;

Route::controller(JurusanController::class)->middleware(['web','auth'])->name('jurusan.')->group(function(){
	Route::get('/jurusan', 'index')->name('index');
	Route::get('/jurusan/data', 'data')->name('data.index');
	Route::get('/jurusan/create', 'create')->name('create');
	Route::post('/jurusan', 'store')->name('store');
	Route::get('/jurusan/{jurusan}', 'show')->name('show');
	Route::get('/jurusan/{jurusan}/edit', 'edit')->name('edit');
	Route::patch('/jurusan/{jurusan}', 'update')->name('update');
	Route::get('/jurusan/{jurusan}/delete', 'destroy')->name('destroy');
});