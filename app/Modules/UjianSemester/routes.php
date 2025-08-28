<?php

use Illuminate\Support\Facades\Route;
use App\Modules\UjianSemester\Controllers\UjianSemesterController;

Route::controller(UjianSemesterController::class)->middleware(['web','auth'])->name('ujiansemester.')->group(function(){
	// route custom
	Route::get('/ujiansemester/upload/{ujiansemester}', 'upload')->name('upload.index');
	Route::get('/ujiansemester/export/{ujiansemester}', 'export')->name('export.index');
	Route::get('/ujiansemester/admin/', 'index_admin')->name('admin.index');
	Route::post('/ujiansemester/aksi_upload', 'aksi_upload')->name('aksi_upload.store');

	
	
	// route bawaan
	Route::get('/ujiansemester', 'index')->name('index');
	Route::get('/ujiansemester/data', 'data')->name('data.index');
	Route::get('/ujiansemester/create', 'create')->name('create');
	Route::post('/ujiansemester', 'store')->name('store');
	Route::get('/ujiansemester/{ujiansemester}', 'show')->name('show');
	Route::get('/ujiansemester/{ujiansemester}/edit', 'edit')->name('edit');
	Route::patch('/ujiansemester/{ujiansemester}', 'update')->name('update');
	Route::get('/ujiansemester/{ujiansemester}/delete', 'destroy')->name('destroy');
});