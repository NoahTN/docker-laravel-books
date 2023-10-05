<?php

namespace App\http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Libraries\CommonHelper;
use Validator;
use App\Models\Book;
use Illuminate\Http\JsonResponse;

class BookController extends Controller
{
    /**
     * Used to get all books
     * 
     * @param  \Illuminate\Http\Request  $request 
     * @return Illuminate\Http\JsonResponse
     */
    public function getAllBooks(Request $request, string $orderBy=null, string $order=null): JsonResponse
    {   
        $validator = Validator::make(compact('orderBy', 'order'), [
            'orderBy' => 'nullable|max:255|in:title,author',
            'order' => 'nullable|max:255|in:ASC,DESC'
        ]);

        if($validator->fails()) 
        {
            $customError = CommonHelper::customErrorResponse($validator->messages()->get("*"));
            return response()->json([
                'code' => 400,
                'message' => $customError
            ]);
        }
        
        $bookData = null;
        if($orderBy) 
        {
            $bookData = Book::orderBy($orderBy, $order)
                            ->get();
        }
        else 
        {
            $bookData = Book::all();
        }
        
        if(!empty($bookData->count())) 
        {
            return response()->json([
                'code' => 200,
                'message' => "Returned books",
                'data' => $bookData
            ]);
        }
        else
        {
            return response()->json([
                'code' => 204,
                'message' => "No books in database",
            ]);
        }
    }

       /**
     * Used to search for books by title or author
     * 
     * @param  \Illuminate\Http\Request  $request 
     * @return Illuminate\Http\JsonResponse
     */
    public function getBooksByQuery(Request $request, string $query, string $orderBy=null, string $order=null): JsonResponse
    {
        $bookData = Book::where('title', 'like', $query . '%')
                        ->orWhere('title', 'like', '% ' . $query . '%')
                        ->orWhere('author', 'like', $query . '%')
                        ->orWhere('author', 'like', '% ' . $query . '%')
                        ->get();


        if(empty($bookData->count())) 
        {
            return response()->json([
                'code' => 204,
                'message' => 'No books found matching "' . $query . '"',
            ]);
        }  
        else
        {
            return response()->json([
                'code' => 200,
                'message' => 'Found book(s) matching "' . $query . '"',  
                'data' => $bookData
            ]);
        }
    }

    /**
     * Used to add a new book
     * 
     * @param  \Illuminate\Http\Request  $request 
     * @return Illuminate\Http\JsonResponse
     */
    public function addBook(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'book_title' => 'required|max:255',
            'book_author' => 'required|max:255'
        ]);

        if($validator->fails()) {
            $customError = CommonHelper::customErrorResponse($validator->messages()->get("*"));
            return response()->json([
                'code' => 400,
                'message' => $customError
            ]);
        }

        $existingBook = Book::where('title', $request->book_title)
                            ->where('author', $request->book_author)
                            ->first();
        if(!$existingBook) {
            $bookData = new Book();
            $bookData->title = $request->book_title;
            $bookData->author = $request->book_author;
            $bookData->save();
            if($bookData->id > 0) {
                return response()->json([
                    'code' => 200,
                    'message' => "Book added",
                    'data' => $bookData
                ]);
            }
            else {
                return response()->json([
                    'code' => 400,
                    'message' => 'Book was not added, please try again'
                ]);
            }
        }
        else {
            return response()->json([
                'code' => 400,
                'message' => 'Book with Title and Author already exists'
            ]);
        }
    }

    /**
     * Used to delete a book by its id
     * 
     * @param  \Illuminate\Http\Request  $request 
     * @return Illuminate\Http\JsonResponse
     */
    public function deleteBook(Request $request, int $id): JsonResponse
    {
        $bookDeleted = Book::where('id', $id)->delete();

        if($bookDeleted) 
        {
            return response()->json([
                'code' => 200,
                'message' => 'Book with id: ' . $id . ' successfully deleted'
            ]);
        }  
        else
        {
            return response()->json([
                'code' => 400,
                'message' => 'Failed to delete book with id: ' . $id,  
            ]);
        }
    }





}