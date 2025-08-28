<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Users\Controllers\UsersController;

Route::controller(UsersController::class)->middleware(['web','auth'])->name('users.')->group(function(){
	Route::get('/users', 'index')->name('index');
	Route::get('/users/data', 'data')->name('data.index');
	Route::get('/users/create', 'create')->name('create');
	Route::post('/users', 'store')->name('store');
	Route::get('/users/{user}', 'show')->name('show');
	Route::get('/users/{user}/edit', 'edit')->name('edit');
	Route::patch('/users/{user}', 'update')->name('update');
	Route::get('/users/{user}/delete', 'destroy')->name('destroy');
});