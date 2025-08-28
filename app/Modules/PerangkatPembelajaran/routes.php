<?php

use Illuminate\Support\Facades\Route;
use App\Modules\PerangkatPembelajaran\Controllers\PerangkatPembelajaranController;
use App\Modules\PerangkatPembelajaran\Models\PerangkatPembelajaran;

Route::controller(PerangkatPembelajaranController::class)->middleware(['web','auth'])->name('perangkatpembelajaran.')->group(function(){
	Route::get('/perangkatpembelajaran/upload/{id}', 'upload')->name('upload.index');
	Route::get('/perangkatpembelajaran/admin', 'index_admin')->name('admin.index');
	Route::get('/perangkatpembelajaran/lihat/{id}', 'lihat')->name('lihat.index');
	Route::get('/perangkatpembelajaran/detail/{id}', 'detail')->name('detail.index');
	
	
	
	
	Route::get('/perangkatpembelajaran', 'index')->name('index');
	Route::get('/perangkatpembelajaran/data', 'data')->name('data.index');
	Route::get('/perangkatpembelajaran/create', 'create')->name('create');
	Route::post('/perangkatpembelajaran', 'store')->name('store');
	Route::get('/perangkatpembelajaran/{perangkatpembelajaran}', 'show')->name('show');
	Route::get('/perangkatpembelajaran/{perangkatpembelajaran}/edit', 'edit')->name('edit');
	Route::patch('/perangkatpembelajaran/{perangkatpembelajaran}', 'update')->name('update');
	Route::get('/perangkatpembelajaran/{perangkatpembelajaran}/delete', 'destroy')->name('destroy');
});

Route::get('/perangkat/{id}/{jenis}', [PerangkatPembelajaranController::class, 'lihat_perangkat'])->name('perangkat.atp.index');