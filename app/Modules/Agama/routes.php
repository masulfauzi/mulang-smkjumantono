<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Agama\Controllers\AgamaController;

Route::controller(AgamaController::class)->middleware(['web','auth'])->name('agama.')->group(function(){
	Route::get('/agama', 'index')->name('index');
	Route::get('/agama/data', 'data')->name('data.index');
	Route::get('/agama/create', 'create')->name('create');
	Route::post('/agama', 'store')->name('store');
	Route::get('/agama/{agama}', 'show')->name('show');
	Route::get('/agama/{agama}/edit', 'edit')->name('edit');
	Route::patch('/agama/{agama}', 'update')->name('update');
	Route::get('/agama/{agama}/delete', 'destroy')->name('destroy');
});