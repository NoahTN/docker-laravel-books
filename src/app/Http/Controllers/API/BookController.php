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
                'message' => 'Succeeded in getting books',
                'data' => $bookData
            ]);
        }
        else
        {
            return response()->json([
                'code' => 204,
                'message' => 'Succeeded, but no books exist in database',
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

        $bookData = Book::where('title', 'like', $query . '%')
                        ->orWhere('title', 'like', '% ' . $query . '%')
                        ->orWhere('author', 'like', $query . '%')
                        ->orWhere('author', 'like', '% ' . $query . '%');
        if($orderBy) 
        {
            $bookData = $bookData->orderBy($orderBy, $order)
                            ->get();
        }
        else 
        {
            $bookData = $bookData->get();
        }    
                  

        if(empty($bookData->count())) 
        {
            return response()->json([
                'code' => 204,
                'message' => 'Failed to find books matching "' . $query . '"'
            ]);
        }  
        else
        {
            return response()->json([
                'code' => 200,
                'message' => 'Successfully found books matching "' . $query . '"',  
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
            'title' => 'required|max:255',
            'author' => 'required|max:255'
        ]);

        if($validator->fails()) {
            $customError = CommonHelper::customErrorResponse($validator->messages()->get("*"));
            return response()->json([
                'code' => 400,
                'message' => $customError
            ]);
        }

        $existingBook = Book::where('title', $request->title)
                            ->where('author', $request->uthor)
                            ->first();
        if(!$existingBook) {
            $bookData = new Book();
            $bookData->title = $request->title;
            $bookData->author = $request->author;
            $bookData->save();
            if($bookData->id > 0) {
                return response()->json([
                    'code' => 200,
                    'message' => 'Successfully added book',
                    'data' => $bookData
                ]);
            }
            else {
                return response()->json([
                    'code' => 400,
                    'message' => 'Failed to add book'
                ]);
            }
        }
        else {
            return response()->json([
                'code' => 400,
                'message' => 'Failed to add book, "'. $request->title .'" by "'. $request->author .'" already exists'
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
        $bookDeleted = Book::where('id', $id)
                            ->delete();

        if($bookDeleted) 
        {
            return response()->json([
                'code' => 200,
                'message' => 'Successfully deleted book with id: ' . $id
            ]);
        }  
        else
        {
            return response()->json([
                'code' => 400,
                'message' => 'Failed to delete book with id: ' . $id
            ]);
        }
    }

    /**
     * Used to change the author of a book by its id
     * 
     * @param  \Illuminate\Http\Request  $request 
     * @return Illuminate\Http\JsonResponse
     */
    public function updateBookAuthor(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'new_author' => 'required|max:255'
        ]);

        if($validator->fails()) {
            $customError = CommonHelper::customErrorResponse($validator->messages()->get("*"));
            return response()->json([
                'code' => 400,
                'message' => $customError
            ]);
        }

        $bookUpdated = Book::where('id', $request->id)
                            ->update(array('author' => $request->new_author));

        if($bookUpdated) 
        {
            return response()->json([
                'code' => 200,
                'message' => 'Successfully updated book with id: ' . $request->id . ' to author: "' . $request->new_author . '"'
            ]);
        }  
        else
        {
            return response()->json([
                'code' => 400,
                'message' => 'Failed to update book with id: ' . $request->id
            ]);
        }
    }




}