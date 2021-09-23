<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\WorkController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('/blog/delete', [BlogController::class, 'delete']);
Route::post('/blog/edit', [BlogController::class, 'edit']);

Route::get('/works/get', [WorkController::class, 'index']);
Route::get('/work/get', [WorkController::class, 'show']);
Route::post('/work/create', [WorkController::class, 'create']);
Route::post('/work/delete', [WorkController::class, 'delete']);
Route::post('/work/edit', [WorkController::class, 'edit']);

Route::get('/tag/contents/get', [TagController::class, 'index']);

Route::get('/is-auth', [AuthController::class, 'is_auth']);
Route::post('/auth', [AuthController::class, 'auth']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
