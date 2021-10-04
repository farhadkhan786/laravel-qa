<?php

use App\Http\Controllers\AnswersController;
use App\Http\Controllers\QuestionsController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('questions', QuestionsController::class)->except('show');
//Route::post('/questions/{question}/answers', 'AnswersController@store')->name('answers.store');
Route::resource('questions.answers', AnswersController::class)->only(['store', 'edit', 'update', 'destroy']);
Route::get('/questions/{slug}', [QuestionsController::class,'show'])->name('questions.show');
