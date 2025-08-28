<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Jadwal\Controllers\JadwalController;

Route::controller(JadwalController::class)->middleware(['web','auth'])->name('jadwal.')->group(function(){
	Route::get('/jadwal/mapping_guru', 'mapping_guru')->name('mapping_guru.index');
	Route::get('/jadwal/import', 'import')->name('import.index');
	Route::post('/jadwal/mapping_guru', 'aksi_mapping')->name('mapping_guru.store');
	Route::get('/jadwal', 'index')->name('index');
	Route::get('/jadwal/data', 'data')->name('data.index');
	Route::get('/jadwal/create', 'create')->name('create');
	Route::post('/jadwal', 'store')->name('store');
	Route::get('/jadwal/{jadwal}', 'show')->name('show');
	Route::get('/jadwal/{jadwal}/edit', 'edit')->name('edit');
	Route::patch('/jadwal/{jadwal}', 'update')->name('update');
	Route::get('/jadwal/{jadwal}/delete', 'destroy')->name('destroy');


	//routing untuk guru
	Route::get('/jadwalguru', 'index_guru')->name('guru.index');
	Route::get('/jadwalguru/{guru}', 'detail_guru')->name('guru.detail.index');
	
	
	//routing monitoring
	Route::get('/monitoring', 'detail_guru')->name('monitoring.index');




});
