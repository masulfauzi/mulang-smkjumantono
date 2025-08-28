<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Role\Controllers\RoleController;

Route::controller(RoleController::class)->middleware(['web','auth'])->name('role.')->group(function(){
	Route::get('/role', 'index')->name('index');
	Route::get('/role/data', 'data')->name('data.index');
	Route::get('/role/create', 'create')->name('create');
	Route::post('/role', 'store')->name('store');
	Route::get('/role/{role}', 'show')->name('show');
	Route::get('/role/{role}/edit', 'edit')->name('edit');
	Route::patch('/role/{role}', 'update')->name('update');
	Route::get('/role/{role}/delete', 'destroy')->name('destroy');
});