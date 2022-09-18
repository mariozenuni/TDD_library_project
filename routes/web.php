<?php

use App\Http\Controllers\AuthorsController;
use App\Http\Controllers\BooksController;
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
// books
Route::post('/books',[BooksController::class,'store']);
Route::put('/books/{book}',[BooksController::class,'update']);
Route::delete('/books/{book}',[BooksController::class,'destroy']);

//author routes

Route::post('/authors',[AuthorsController::class,'store']);;

