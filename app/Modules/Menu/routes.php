<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Menu\Controllers\MenuController;

Route::controller(MenuController::class)->middleware(['web','auth'])->name('menu.')->group(function(){
	Route::get('/menu', 'index')->name('index');
	Route::get('/menu/data', 'data')->name('data.index');
	Route::get('/menu/create', 'create')->name('create');
	Route::post('/menu', 'store')->name('store');
	Route::get('/menu/{menu}', 'show')->name('show');
	Route::get('/menu/{menu}/edit', 'edit')->name('edit');
	Route::patch('/menu/{menu}', 'update')->name('update');
	Route::get('/menu/{menu}/delete', 'destroy')->name('destroy');
});