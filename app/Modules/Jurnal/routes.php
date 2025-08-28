<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Jurnal\Controllers\JurnalController;
use App\Modules\Jurnal\Controllers\MonitoringurnalController;

Route::controller(JurnalController::class)->middleware(['web','auth'])->name('jurnal.')->group(function(){
	Route::get('/jurnal', 'index')->name('index');
	Route::get('/jurnal/data', 'data')->name('data.index');
	Route::get('/jurnal/create', 'create')->name('create');
	Route::post('/jurnal', 'store')->name('store');
	Route::get('/jurnal/{jurnal}', 'show')->name('show');
	Route::get('/jurnal/{jurnal}/edit', 'edit')->name('edit');
	Route::patch('/jurnal/{jurnal}', 'update')->name('update');
	Route::get('/jurnal/{jurnal}/delete', 'destroy')->name('destroy');


	Route::get('/jurnalguru', 'index_guru')->name('guru.index');
	Route::get('/jurnal/detail/{jurnal}', 'detail_jurnal')->name('detail.index');

	//custom route cetak jurnal
	Route::get('/cetakjurnal', 'cetak_jurnal')->name('cetak.index');
	Route::get('/cetakjurnal/jurnalmengajar', 'cetak_jurnalmengajar')->name('cetakjurnal.index');

	//custom route cetak presensi
	Route::post('/cetakpresensi', 'aksi_cetak_presensi')->name('cetakpresensi.index');
});