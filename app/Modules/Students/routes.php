<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Students\Controllers\StudentsController;

Route::controller(StudentsController::class)->middleware(['web','auth'])->name('students.')->group(function(){
	Route::get('/students', 'index')->name('index');
	Route::get('/students/data', 'data')->name('data.index');
	Route::get('/students/create', 'create')->name('create');
	Route::post('/students', 'store')->name('store');
	Route::get('/students/{students}', 'show')->name('show');
	Route::get('/students/{students}/edit', 'edit')->name('edit');
	Route::patch('/students/{students}', 'update')->name('update');
	Route::get('/students/{students}/delete', 'destroy')->name('destroy');
});