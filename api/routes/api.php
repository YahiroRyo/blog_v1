<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\WorkController;
use App\Http\Controllers\AuthController;

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
Route::get('/blogs/get', [BlogController::class, 'index']);
Route::get('/blog/get', [BlogController::class, 'show']);
Route::post('/blog/create', [BlogController::class, 'create']);

Route::get('/works/get', [WorkController::class, 'index']);
Route::get('/work/get', [WorkController::class, 'show']);
Route::post('/work/create', [WorkController::class, 'create']);

Route::get('/is-auth', [AuthController::class, 'is_auth']);
Route::post('/auth', [AuthController::class, 'auth']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
