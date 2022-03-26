<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\API\AuthController;
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

Route::get('/', function () {
    // if(Auth::check()){return Redirect::to('dashboard');}
    // return view('auth.login');
    return view('login');
});

// Route::get('/login', function () {
//     // if(Auth::check()){return Redirect::to('dashboard');}
//     // return view('auth.login');
//     return view('login');
// });

Route::post('login', [AuthController::class, 'login']);
// Route::post('logout', [AuthController::class, 'logout']);
// Route::post('logout', [AuthController::class, 'logout']);

// Route::middleware('auth')->group(function () {
// });
    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/mahasiswa', function () {
        return view('admin/mahasiswa');
    });
    
    Route::get('/jurusan', function () {
        return view('admin/jurusan');
    });
    
    Route::get('/matkul', function () {
        return view('admin/matkul');
    });
    
    Route::get('/dosen', function () {
        return view('admin/dosen');
    });


     



