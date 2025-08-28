<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Jeniskelamin\Controllers\JeniskelaminController;

Route::controller(JeniskelaminController::class)->middleware(['web','auth'])->name('jeniskelamin.')->group(function(){
	Route::get('/jeniskelamin', 'index')->name('index');
	Route::get('/jeniskelamin/data', 'data')->name('data.index');
	Route::get('/jeniskelamin/create', 'create')->name('create');
	Route::post('/jeniskelamin', 'store')->name('store');
	Route::get('/jeniskelamin/{jeniskelamin}', 'show')->name('show');
	Route::get('/jeniskelamin/{jeniskelamin}/edit', 'edit')->name('edit');
	Route::patch('/jeniskelamin/{jeniskelamin}', 'update')->name('update');
	Route::get('/jeniskelamin/{jeniskelamin}/delete', 'destroy')->name('destroy');
});