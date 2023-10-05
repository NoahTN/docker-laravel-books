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


Route::get('books/search/{query?}/{orderBy?}/{order?}', [BookController::class, 'getBooksByQuery']);
Route::get('books/{orderBy?}/{order?}', [BookController::class, 'getAllBooks']);
Route::post('books/add', [BookController::class, 'addBook']);
Route::delete('books/{id}', [BookController::class, 'deleteBook']);
Route::put('update-book-author/{d}', [BookController::class, 'updateBookAuthor']);

