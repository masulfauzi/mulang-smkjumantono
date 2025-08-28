<?php

use Illuminate\Support\Facades\Route;
use App\Modules\JenisPengembangan\Controllers\JenisPengembanganController;

Route::controller(JenisPengembanganController::class)->middleware(['web','auth'])->name('jenispengembangan.')->group(function(){
	Route::get('/jenispengembangan', 'index')->name('index');
	Route::get('/jenispengembangan/data', 'data')->name('data.index');
	Route::get('/jenispengembangan/create', 'create')->name('create');
	Route::post('/jenispengembangan', 'store')->name('store');
	Route::get('/jenispengembangan/{jenispengembangan}', 'show')->name('show');
	Route::get('/jenispengembangan/{jenispengembangan}/edit', 'edit')->name('edit');
	Route::patch('/jenispengembangan/{jenispengembangan}', 'update')->name('update');
	Route::get('/jenispengembangan/{jenispengembangan}/delete', 'destroy')->name('destroy');
});