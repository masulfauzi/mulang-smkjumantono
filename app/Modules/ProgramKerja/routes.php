<?php

use Illuminate\Support\Facades\Route;
use App\Modules\ProgramKerja\Controllers\ProgramKerjaController;

Route::controller(ProgramKerjaController::class)->middleware(['web','auth'])->name('programkerja.')->group(function(){
	// custom route
	Route::get('/programkerja/child/{unit}', 'show_child')->name('child.index');
	Route::get('/programkerja/upload/{unit}', 'upload')->name('upload.create');
	
	Route::get('/programkerja', 'index')->name('index');
	Route::get('/programkerja/data', 'data')->name('data.index');
	Route::get('/programkerja/create', 'create')->name('create');
	Route::post('/programkerja', 'store')->name('store');
	Route::get('/programkerja/{programkerja}', 'show')->name('show');
	Route::get('/programkerja/{programkerja}/edit', 'edit')->name('edit');
	Route::patch('/programkerja/{programkerja}', 'update')->name('update');
	Route::get('/programkerja/{programkerja}/delete', 'destroy')->name('destroy');
});