<?php

use Illuminate\Support\Facades\Route;
use App\Modules\PengembanganDiri\Controllers\PengembanganDiriController;

Route::controller(PengembanganDiriController::class)->middleware(['web','auth'])->name('pengembangandiri.')->group(function(){
	// route custom
	Route::get('/pengembangandiri/cetak', 'cetak_pd')->name('cetak.show');
	
	
	
	Route::get('/pengembangandiri', 'index')->name('index');
	Route::get('/pengembangandiri/data', 'data')->name('data.index');
	Route::get('/pengembangandiri/create', 'create')->name('create');
	Route::post('/pengembangandiri', 'store')->name('store');
	Route::get('/pengembangandiri/{pengembangandiri}', 'show')->name('show');
	Route::get('/pengembangandiri/{pengembangandiri}/edit', 'edit')->name('edit');
	Route::patch('/pengembangandiri/{pengembangandiri}', 'update')->name('update');
	Route::get('/pengembangandiri/{pengembangandiri}/delete', 'destroy')->name('destroy');
});