<?php

use Illuminate\Support\Facades\Route;
use App\Modules\UserRole\Controllers\UserRoleController;

Route::controller(UserRoleController::class)->middleware(['web','auth'])->name('userrole.')->group(function(){
	Route::get('/userrole', 'index')->name('index');
	Route::get('/userrole/data', 'data')->name('data.index');
	Route::get('/userrole/create', 'create')->name('create');
	Route::post('/userrole', 'store')->name('store');
	Route::get('/userrole/{userrole}', 'show')->name('show');
	Route::get('/userrole/{userrole}/edit', 'edit')->name('edit');
	Route::patch('/userrole/{userrole}', 'update')->name('update');
	Route::get('/userrole/{userrole}/delete', 'destroy')->name('destroy');
});