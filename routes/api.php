<?php

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

Route::post('/token', [\App\Http\Controllers\Auth\LoginController::class, 'getToken']);
Route::get('/questions', [\App\Http\Controllers\Api\QuestionsController::class, 'index']);
Route::middleware(['auth:api'])->group(function () {
    Route::apiResource('/questions', \App\Http\Controllers\Api\QuestionsController::class)->except('index');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
