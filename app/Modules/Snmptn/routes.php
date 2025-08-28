<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Snmptn\Controllers\SnmptnController;

Route::controller(SnmptnController::class)->middleware(['web','auth'])->name('snmptn.')->group(function(){
	Route::get('/snmptn', 'index')->name('index');
	Route::get('/snmptn/data', 'data')->name('data.index');
	Route::get('/snmptn/create', 'create')->name('create');
	Route::post('/snmptn', 'store')->name('store');
	Route::get('/snmptn/{snmptn}', 'show')->name('show');
	Route::get('/snmptn/{snmptn}/edit', 'edit')->name('edit');
	Route::patch('/snmptn/{snmptn}', 'update')->name('update');
	Route::get('/snmptn/{snmptn}/delete', 'destroy')->name('destroy');


	//custom
	Route::get('/snmptn/{jurusan}/peringkat', 'peringkat')->name('peringkat.index');
	Route::get('/snmptn/{jurusan}/hitung', 'hitung')->name('hitung.index');
	Route::get('/snmptn/{jurusan}/edit_snmptn', 'edit_snmptn')->name('edit.index');
	
	
	//peringkat
	// Route::get('/peringkat', 'peringkat_kelas')->name('peringkat.kelas.index');
});