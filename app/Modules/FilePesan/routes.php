<?php

use Illuminate\Support\Facades\Route;
use App\Modules\FilePesan\Controllers\FilePesanController;

Route::controller(FilePesanController::class)->middleware(['web','auth'])->name('filepesan.')->group(function(){
	Route::get('/filepesan', 'index')->name('index');
	Route::get('/filepesan/data', 'data')->name('data.index');
	Route::get('/filepesan/create', 'create')->name('create');
	Route::post('/filepesan', 'store')->name('store');
	Route::get('/filepesan/{filepesan}', 'show')->name('show');
	Route::get('/filepesan/{filepesan}/edit', 'edit')->name('edit');
	Route::patch('/filepesan/{filepesan}', 'update')->name('update');
	Route::get('/filepesan/{filepesan}/delete', 'destroy')->name('destroy');
});