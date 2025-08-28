<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Semester\Controllers\SemesterController;

Route::controller(SemesterController::class)->middleware(['web','auth'])->name('semester.')->group(function(){
	Route::get('/semester', 'index')->name('index');
	Route::get('/semester/data', 'data')->name('data.index');
	Route::get('/semester/create', 'create')->name('create');
	Route::post('/semester', 'store')->name('store');
	Route::get('/semester/{semester}', 'show')->name('show');
	Route::get('/semester/{semester}/edit', 'edit')->name('edit');
	Route::patch('/semester/{semester}', 'update')->name('update');
	Route::get('/semester/{semester}/delete', 'destroy')->name('destroy');
});