<?php

use Illuminate\Support\Facades\Route;
use App\Modules\UnitKerja\Controllers\UnitKerjaController;

Route::controller(UnitKerjaController::class)->middleware(['web','auth'])->name('unitkerja.')->group(function(){
	Route::get('/unitkerja', 'index')->name('index');
	Route::get('/unitkerja/data', 'data')->name('data.index');
	Route::get('/unitkerja/create', 'create')->name('create');
	Route::post('/unitkerja', 'store')->name('store');
	Route::get('/unitkerja/{unitkerja}', 'show')->name('show');
	Route::get('/unitkerja/{unitkerja}/edit', 'edit')->name('edit');
	Route::patch('/unitkerja/{unitkerja}', 'update')->name('update');
	Route::get('/unitkerja/{unitkerja}/delete', 'destroy')->name('destroy');
});