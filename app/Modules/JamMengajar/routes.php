<?php

use Illuminate\Support\Facades\Route;
use App\Modules\JamMengajar\Controllers\JamMengajarController;

Route::controller(JamMengajarController::class)->middleware(['web','auth'])->name('jammengajar.')->group(function(){
	Route::get('/jammengajar/generate_sk', 'sk_mengajar')->name('sk.index');
	Route::get('/jammengajar/cetak_jam_mengajar', 'cetak_jam_mengajar')->name('cetak.index');
	Route::get('/jammengajar', 'index')->name('index');
	Route::get('/jammengajar/data', 'data')->name('data.index');
	Route::get('/jammengajar/{jammengajar}/create', 'create')->name('create');
	Route::post('/jammengajar', 'store')->name('store');
	Route::get('/jammengajar/{jammengajar}', 'show')->name('show');
	Route::get('/jammengajar/{jammengajar}/edit', 'edit')->name('edit');
	Route::patch('/jammengajar/{jammengajar}', 'update')->name('update');
	Route::get('/jammengajar/{jammengajar}/delete', 'destroy')->name('destroy');

	Route::get('/jammengajar/{jammengajar}/guru', 'guru')->name('guru.index');
	Route::get('/jammengajar/{jammengajar}/kelas', 'kelas')->name('kelas.index');
});