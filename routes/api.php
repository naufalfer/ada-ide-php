<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\TransferMethodController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('project', ProjectController::class);
Route::resource('type', TypeController::class);
Route::resource('transfermethod', TransferMethodController::class);
