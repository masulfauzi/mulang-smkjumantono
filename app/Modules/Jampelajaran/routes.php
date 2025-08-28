<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Jampelajaran\Controllers\JampelajaranController;

Route::controller(JampelajaranController::class)->middleware(['web','auth'])->name('jampelajaran.')->group(function(){
	Route::get('/jampelajaran', 'index')->name('index');
	Route::get('/jampelajaran/data', 'data')->name('data.index');
	Route::get('/jampelajaran/create', 'create')->name('create');
	Route::post('/jampelajaran', 'store')->name('store');
	Route::get('/jampelajaran/{jampelajaran}', 'show')->name('show');
	Route::get('/jampelajaran/{jampelajaran}/edit', 'edit')->name('edit');
	Route::patch('/jampelajaran/{jampelajaran}', 'update')->name('update');
	Route::get('/jampelajaran/{jampelajaran}/delete', 'destroy')->name('destroy');
});