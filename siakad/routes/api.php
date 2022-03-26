<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\MahasiswaController;
use App\Http\Controllers\API\JurusanController;
use App\Http\Controllers\API\MatkulController;
use App\Http\Controllers\API\JurusancomboController;
use App\Http\Controllers\API\DosenController;
use App\Http\Controllers\API\MatkulcomboController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function() {
    Route::resource('mahasiswa', MahasiswaController::class);
    Route::resource('jurusan', JurusanController::class);
    Route::resource('matkul', MatkulController::class);
    Route::resource('dosen', DosenController::class);
    // Route::get('search/{keyword}', [JurusanController::class, 'search']);
    Route::get('jurusancombo', [JurusancomboController::class, 'combo']);
    Route::get('matkulcombo', [MatkulcomboController::class, 'combo']);
    Route::post('logout', [AuthController::class, 'logout']);
});