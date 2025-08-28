<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Files\Controllers\FilesController;

Route::controller(FilesController::class)->middleware(['web','auth'])->name('files.')->group(function(){
	Route::get('/files', 'index')->name('index');
	Route::get('/files/data', 'data')->name('data.index');
	Route::get('/files/create', 'create')->name('create');
	Route::post('/files', 'store')->name('store');
	Route::get('/files/{files}', 'show')->name('show');
	Route::get('/files/{files}/edit', 'edit')->name('edit');
	Route::patch('/files/{files}', 'update')->name('update');
	Route::get('/files/{files}/delete', 'destroy')->name('destroy');
});