<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\GenerateController;
use App\Http\Controllers\LokasiController;

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
Route::get('/auth/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth/login', [AuthController::class, 'postLogin']);

Route::group(['middleware' => 'auth'], function () {
    // lokasi
    Route::get('/lokasi/getkabupaten', [LokasiController::class, 'getKab']);
    Route::get('/lokasi/getkecamatan', [LokasiController::class, 'getKec']);
    Route::get('/lokasi/getkelurahan', [LokasiController::class, 'getKel']);
    Route::get('/lokasi/ongkir-provinsi', [LokasiController::class, 'ongkirProvinsi']);

    Route::get('/', [ClaimController::class, 'dashboard']);
    Route::get('/dashboard', [ClaimController::class, 'dashboard'])->name('dashboard');
    Route::post('/claim', [ClaimController::class, 'claim']);
    Route::post('/generate-certificate', [GenerateController::class, 'certificate']);

    Route::get('/logout', [AuthController::class, 'logout'])->name('dashboard.logout');
});
