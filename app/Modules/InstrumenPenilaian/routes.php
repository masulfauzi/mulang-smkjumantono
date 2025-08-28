<?php

use Illuminate\Support\Facades\Route;
use App\Modules\InstrumenPenilaian\Controllers\InstrumenPenilaianController;

Route::controller(InstrumenPenilaianController::class)->middleware(['web','auth'])->name('instrumenpenilaian.')->group(function(){
	Route::get('/instrumenpenilaian', 'index')->name('index');
	Route::get('/instrumenpenilaian/data', 'data')->name('data.index');
	Route::get('/instrumenpenilaian/create', 'create')->name('create');
	Route::post('/instrumenpenilaian', 'store')->name('store');
	Route::get('/instrumenpenilaian/{instrumenpenilaian}', 'show')->name('show');
	Route::get('/instrumenpenilaian/{instrumenpenilaian}/edit', 'edit')->name('edit');
	Route::patch('/instrumenpenilaian/{instrumenpenilaian}', 'update')->name('update');
	Route::get('/instrumenpenilaian/{instrumenpenilaian}/delete', 'destroy')->name('destroy');
});