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
    public function getAllBooks(Request $request): JsonResponse
    {
        $bookData = Book::all();

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

        $bookTitleExist = Book::find($request->book_title);
        $bookAuthorExist = Book::find($request->book_author);
        if(empty($bookTitleExist) && empty($bookAuthorExist)) {
            $bookData = new Book();
            $bookData->title = $request->book_title;
            $bookData->author = $request->book_author;
            $bookData->save();
            if($bookData->id > 0) {
                return response()->json([
                    'code' => 200,
                    'message' => "Book added"
                ]);
            }
            else {
                return response()->json([
                    'code' => 400,
                    'message' => "Book was not added, please try again"
                ]);
            }
        }
        else {
            return response()->json([
                'code' => 400,
                'message' => "Book with Title and Author already exists"
            ]);
        }
    }

    /**
     * Used to search for books by title or author
     * 
     * @param  \Illuminate\Http\Request  $request 
     * @return Illuminate\Http\JsonResponse
     */
    public function getBooksByQuery(Request $request, string $query): JsonResponse
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





}