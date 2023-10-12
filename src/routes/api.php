<?php

use Illuminate\Http\Request;
use App\Http\Controllers\API\BookController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('books/search', [BookController::class, 'getBooksByQuery']);
Route::get('books', [BookController::class, 'getAllBooks']);
Route::post('books/add', [BookController::class, 'addBook']);
Route::delete('books/{id}', [BookController::class, 'deleteBook']);
Route::put('books/author', [BookController::class, 'updateBookAuthor']);
Route::get('books/export', [BookController::class, 'exportBooks']);

