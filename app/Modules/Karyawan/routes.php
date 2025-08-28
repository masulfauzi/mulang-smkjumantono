<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Karyawan\Controllers\KaryawanController;

Route::controller(KaryawanController::class)->middleware(['web','auth'])->name('karyawan.')->group(function(){
	Route::get('/karyawan', 'index')->name('index');
	Route::get('/karyawan/data', 'data')->name('data.index');
	Route::get('/karyawan/create', 'create')->name('create');
	Route::post('/karyawan', 'store')->name('store');
	Route::get('/karyawan/{karyawan}', 'show')->name('show');
	Route::get('/karyawan/{karyawan}/edit', 'edit')->name('edit');
	Route::patch('/karyawan/{karyawan}', 'update')->name('update');
	Route::get('/karyawan/{karyawan}/delete', 'destroy')->name('destroy');
});