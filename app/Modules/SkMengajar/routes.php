<?php

use Illuminate\Support\Facades\Route;
use App\Modules\SkMengajar\Controllers\SkMengajarController;

Route::controller(SkMengajarController::class)->middleware(['web','auth'])->name('skmengajar.')->group(function(){
	Route::get('/skmengajar', 'index')->name('index');
	Route::get('/skmengajar/data', 'data')->name('data.index');
	Route::get('/skmengajar/create', 'create')->name('create');
	Route::post('/skmengajar', 'store')->name('store');
	Route::get('/skmengajar/{skmengajar}', 'show')->name('show');
	Route::get('/skmengajar/{skmengajar}/edit', 'edit')->name('edit');
	Route::patch('/skmengajar/{skmengajar}', 'update')->name('update');
	Route::get('/skmengajar/{skmengajar}/delete', 'destroy')->name('destroy');
});