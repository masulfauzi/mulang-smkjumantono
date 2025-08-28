<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SnbpController;
use App\Http\Controllers\AktivasiController;
use App\Http\Controllers\ApiController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::view('/', 'welcome')->name('frontend.index');
Route::get('/snbp', [SnbpController::class, 'index'])->name('snbp')->middleware(['guest']);
Route::post('/snbp', [SnbpController::class, 'cek_siswa'])->name('snbp.store')->middleware(['guest']);
Route::get('/aktivasi', [AktivasiController::class, 'index'])->name('aktivasi')->middleware(['guest']);
Route::post('/aktivasi', [AktivasiController::class, 'store'])->name('aktivasi.store')->middleware(['guest']);
Route::get('/aktivasi/inputdata/{id}', [AktivasiController::class, 'input_data'])->name('aktivasi.input')->middleware(['guest']);
Route::get('/aktivasi/radius', [AktivasiController::class, 'radius'])->name('aktivasi.radius')->middleware(['guest']);
Route::post('/registrasi', [AktivasiController::class, 'registrasi'])->name('registrasi')->middleware(['guest']);
Route::get('/kirimemail', [ApiController::class, 'kirimemail'])->name('kirimemail')->middleware(['guest']);

Route::middleware(['auth'])->group(function(){
    Route::get('/', [DashboardController::class, 'index'])->name('frontend.index');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/role/set/{id_role}', [DashboardController::class,'changeRole'])->name('dashboard.change.role');
    Route::get('/role/semester/{id_semester}', [DashboardController::class,'changeSemester'])->name('dashboard.change.semester');
    Route::get('/forcelogout', [DashboardController::class,'forceLogout'])->name('dashboard.force.logout');
});

require __DIR__.'/auth.php';
