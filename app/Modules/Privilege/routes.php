<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Privilege\Controllers\PrivilegeController;

Route::controller(PrivilegeController::class)->middleware(['web','auth'])->name('privilege.')->group(function(){
	Route::get('/privilege', 'index')->name('index');
	Route::get('/privilege/data', 'data')->name('data.index');
	Route::get('/privilege/create', 'create')->name('create');
	Route::post('/privilege', 'store')->name('store');
	Route::get('/privilege/{privilege}', 'show')->name('show');
	Route::get('/privilege/{privilege}/edit', 'edit')->name('edit');
	Route::patch('/privilege/{privilege}', 'update')->name('update');
	Route::get('/privilege/{privilege}/delete', 'destroy')->name('destroy');
});