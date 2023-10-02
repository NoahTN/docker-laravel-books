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


// Fetch all book data
Route::get('books', [BookController::class, 'getAllBookData']);

// Fetch books by search query
Route::get('books/{query}', [BookController::class, 'getBookDataByQuery']);

// Add a new book
Route::post('add-book', [BookController::class, 'addBookData']);

// Delete a book
Route::delete('books/{book_id}', [BookController::class, 'deleteBookData']);

// Update book author
Route::put('update-book-author/{book_id}', [BookController::class, 'updateBookAuthorData']);

