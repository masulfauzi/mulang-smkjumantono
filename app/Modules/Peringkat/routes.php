<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Peringkat\Controllers\PeringkatController;

Route::controller(PeringkatController::class)->middleware(['web','auth'])->name('peringkat.')->group(function(){
	// route custom
	Route::get('/peringkat/generate/{id_semester}', 'generate')->name('generate.index');
	

	// route bawaan
	Route::get('/peringkat', 'index')->name('index');
	Route::get('/peringkat/data', 'data')->name('data.index');
	Route::get('/peringkat/create', 'create')->name('create');
	Route::post('/peringkat', 'store')->name('store');
	Route::get('/peringkat/{peringkat}', 'show')->name('show');
	Route::get('/peringkat/{peringkat}/edit', 'edit')->name('edit');
	Route::patch('/peringkat/{peringkat}', 'update')->name('update');
	Route::get('/peringkat/{peringkat}/delete', 'destroy')->name('destroy');
});