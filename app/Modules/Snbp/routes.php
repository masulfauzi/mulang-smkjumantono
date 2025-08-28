<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Snbp\Controllers\SnbpController;

Route::controller(SnbpController::class)->middleware(['web', 'auth'])->name('snbp.')->group(function () {
	// ROUTE CUSTOM 
	Route::get('/snbp/jurusan/{jurusan}', 'index_jurusan')->name('jurusan.index');
	Route::get('/snbp/nilai_jurusan/{jurusan}', 'nilai_jurusan')->name('nilai_jurusan.index');
	Route::get('/snbp/skl_jurusan/{jurusan}', 'skl_jurusan')->name('skl_jurusan.index');
	Route::get('/snbp/generate_jurusan/{jurusan}', 'generate_jurusan')->name('generate.create');
	Route::get('/snbp/finalisasi/{jurusan}', 'finalisasi')->name('finalisasi.create');

	// ROUTE UNTUK SISWA
	Route::get('/snbp/siswa', 'index_siswa')->name('siswa.index');
	Route::post('/snbp/update_minat/{snbp}', 'update_minat')->name('berminat.update');
	Route::post('/snbp/upload_super/{snbp}', 'upload_super')->name('super.store');



	Route::get('/snbp', 'index')->name('index');
	Route::get('/snbp/data', 'data')->name('data.index');
	Route::get('/snbp/create', 'create')->name('create');
	Route::post('/snbp', 'store')->name('store');
	Route::get('/snbp/{snbp}', 'show')->name('show');
	Route::get('/snbp/{snbp}/edit', 'edit')->name('edit');
	Route::patch('/snbp/{snbp}', 'update')->name('update');
	Route::get('/snbp/{snbp}/delete', 'destroy')->name('destroy');
});
