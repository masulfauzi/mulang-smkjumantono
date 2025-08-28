<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Device\Controllers\DeviceController;

Route::controller(DeviceController::class)->middleware(['web','auth'])->name('device.')->group(function(){
	Route::get('/device', 'index')->name('index');
	Route::get('/device/data', 'data')->name('data.index');
	Route::get('/device/create', 'create')->name('create');
	Route::post('/device', 'store')->name('store');
	Route::get('/device/{device}', 'show')->name('show');
	Route::get('/device/{device}/edit', 'edit')->name('edit');
	Route::patch('/device/{device}', 'update')->name('update');
	Route::get('/device/{device}/delete', 'destroy')->name('destroy');
});