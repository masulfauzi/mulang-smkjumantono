<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Konfirmasinilai\Controllers\KonfirmasinilaiController;

Route::controller(KonfirmasinilaiController::class)->middleware(['web', 'auth'])->name('konfirmasinilai.')->group(function () {
	Route::get('/konfirmasinilai/batal/{konfirmasinilai}', 'batal_konfirmasi')->name('batal_konfirmasi.store');









	Route::get('/konfirmasinilai', 'index')->name('index');
	Route::get('/konfirmasinilai/data', 'data')->name('data.index');
	Route::get('/konfirmasinilai/create', 'create')->name('create');
	Route::post('/konfirmasinilai', 'store')->name('store');
	Route::get('/konfirmasinilai/{konfirmasinilai}', 'show')->name('show');
	Route::get('/konfirmasinilai/{konfirmasinilai}/edit', 'edit')->name('edit');
	Route::patch('/konfirmasinilai/{konfirmasinilai}', 'update')->name('update');
	Route::get('/konfirmasinilai/{konfirmasinilai}/delete', 'destroy')->name('destroy');
});
