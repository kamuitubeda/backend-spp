<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\ItemController; 
use App\Http\Controllers\API\InstitusiController; 
use App\Http\Controllers\API\KelasController; 
use App\Http\Controllers\API\SantriController; 
use App\Http\Controllers\API\TagihanController; 
use App\Http\Controllers\API\RekeningController; 
use App\Http\Controllers\API\RincianRekeningController; 
use App\Http\Controllers\API\UserController;
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

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);

Route::middleware('auth:api')->group( function () {
    Route::get('/user', [UserController::class, 'getUserInfo']);
    Route::post('logout', [UserController::class, 'logout']);

    Route::get('/santri/kelas/{id}', [SantriController::class, 'getSantriFromSpecificKelas']);
    Route::get('/item/rekening/{id}', [RekeningController::class, 'getItemByRekening']);

    Route::resource('item', ItemController::class);
    Route::resource('institusi', InstitusiController::class);
    Route::resource('kelas', KelasController::class);
    Route::resource('santri', SantriController::class);
    Route::resource('tagihan', TagihanController::class);
    Route::resource('rekening', RekeningController::class);
    Route::resource('rincian-rekening', RincianRekeningController::class);
});
