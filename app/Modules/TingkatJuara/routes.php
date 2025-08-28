<?php

use Illuminate\Support\Facades\Route;
use App\Modules\TingkatJuara\Controllers\TingkatJuaraController;

Route::controller(TingkatJuaraController::class)->middleware(['web','auth'])->name('tingkatjuara.')->group(function(){
	Route::get('/tingkatjuara', 'index')->name('index');
	Route::get('/tingkatjuara/data', 'data')->name('data.index');
	Route::get('/tingkatjuara/create', 'create')->name('create');
	Route::post('/tingkatjuara', 'store')->name('store');
	Route::get('/tingkatjuara/{tingkatjuara}', 'show')->name('show');
	Route::get('/tingkatjuara/{tingkatjuara}/edit', 'edit')->name('edit');
	Route::patch('/tingkatjuara/{tingkatjuara}', 'update')->name('update');
	Route::get('/tingkatjuara/{tingkatjuara}/delete', 'destroy')->name('destroy');
});