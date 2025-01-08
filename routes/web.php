<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NormalController;
use App\Http\Controllers\VillaController;
use App\Http\Controllers\KosController;
use App\Http\Controllers\AuthController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



Route::middleware(['auth.user'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard'); // Ganti dengan view dashboard Anda
    })->name('dashboard');
    Route::get('/', function () {
        return view('layouts/app');
    });

Route::get('/normal/downloadpdf/{id}', [NormalController::class,'downloadpdf']);
Route::get('/normal', [NormalController::class, 'index'])->name('normal.index');
Route::get('/normal/tambah', [NormalController::class, 'create']);
Route::post('/normal/store', [NormalController::class, 'store']);
Route::get('/normal/edit/{id}', [NormalController::class, 'edit']);
Route::put('/normal/update/{id}', [NormalController::class, 'update']);
Route::get('/normal/hapus/{id}', [NormalController::class, 'delete']);
Route::get('/normal/destroy/{id}', [NormalController::class, 'destroy']);

Route::get('/villa/downloadpdf/{id}', [VillaController::class,'downloadpdf']);
Route::get('/villa', [VillaController::class, 'index'])->name('villa.index');
Route::get('/villa/tambah', [VillaController::class, 'create']);
Route::post('/villa/store', [VillaController::class, 'store']);
Route::get('/villa/edit/{id}', [VillaController::class, 'edit']);
Route::put('/villa/update/{id}', [VillaController::class, 'update']);
Route::get('/villa/hapus/{id}', [VillaController::class, 'delete']);
Route::get('/villa/destroy/{id}', [VillaController::class, 'destroy']);

Route::get('/kos/downloadpdf/{id}', [KosController::class,'downloadpdf']);
Route::get('/kos', [KosController::class, 'index'])->name('kos.index');
Route::get('/kos/tambah', [KosController::class, 'create']);
Route::post('/kos/store', [KosController::class, 'store']);
Route::get('/kos/edit/{id}', [KosController::class, 'edit']);
Route::put('/kos/update/{id}', [KosController::class, 'update']);
Route::get('/kos/hapus/{id}', [KosController::class, 'delete']);
Route::get('/kos/destroy/{id}', [KosController::class, 'destroy']);
});


