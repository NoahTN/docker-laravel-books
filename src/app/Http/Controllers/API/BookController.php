<?php

namespace App\http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
                'message' => 'Succeeded in getting books',
                'data' => $bookData
            ], 200);
        }
        else
        {
            return response()->json([
                'message' => 'No books found',
            ], 200);
        }
    }

       /**
     * Used to search for books by title or author
     * 
     * @param  \Illuminate\Http\Request  $request 
     * @return Illuminate\Http\JsonResponse
     */
    public function getBooksByQuery(Request $request): JsonResponse
    {
        $orderBy = $request->get('orderBy');
        $order = $request->get('order');
        
        $validator = Validator::make(['orderBy' => $orderBy, 'order' => $order], [
            'orderBy' => 'nullable|max:255|in:title,author',
            'order' => 'nullable|max:255|in:ASC,DESC'
        ]);

        if($validator->fails()) 
        {
            $customError = CommonHelper::customErrorResponse($validator->messages()->get("*"));
            return response()->json([
                'message' => $customError
            ], 400);
        }

        $bookData = DB::table('books');
        $query = $request->get('query');
        if($query) {
                $bookData = $bookData->where('title', 'like', $query . '%')
                ->orWhere('title', 'like', '% ' . $query . '%')
                ->orWhere('author', 'like', $query . '%')
                ->orWhere('author', 'like', '% ' . $query . '%');
        }
       
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
                'message' => 'Failed to find books matching "' . $query . '"'
            ], 200);
        }  
        else
        {
            return response()->json([
                'message' => 'Successfully found books matching "' . $query . '"',  
                'data' => $bookData
            ], 200);
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

        if($validator->fails()) 
        {
            $customError = CommonHelper::customErrorResponse($validator->messages()->get("*"));
            return response()->json([
                'message' => $customError
            ], 400);
        }

        $existingBook = Book::where('title', $request->title)
                            ->where('author', $request->author)
                            ->first();
        if(!$existingBook) 
        {
            $bookData = new Book();
            $bookData->title = $request->title;
            $bookData->author = $request->author;
            $bookData->save();
            if($bookData->id > 0) 
            {
                return response()->json([
                    'message' => 'Successfully added book',
                    'data' => $bookData
                ], 200);
            }
            else 
            {
                return response()->json([
                    'message' => 'Failed to add book'
                ], 400);
            }
        }
        else 
        {
            return response()->json([
                'message' => 'Failed to add book, "'. $request->title .'" by "'. $request->author .'" already exists'
            ], 409);
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
                'message' => 'Successfully deleted book with id: ' . $id
            ], 200);
        }  
        else
        {
            return response()->json([
                'message' => 'Failed to delete book with id: ' . $id
            ], 400);
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

        if($validator->fails()) 
        {
            $customError = CommonHelper::customErrorResponse($validator->messages()->get("*"));
            return response()->json([
                'message' => $customError
            ], 400);
        }
        
        $book = Book::find($request->id);
        $existingBook = Book::where('title', $book->title)
                            ->where('author', $request->new_author)
                            ->where('id', '!=', $request->id)
                            ->first();

        if(!$existingBook) 
        {
            $bookUpdated = Book::where('id', $request->id)
                            ->update(array('author' => $request->new_author));

            if($bookUpdated) 
            {
                return response()->json([
                    'message' => 'Successfully updated book with id: ' . $request->id . ' to author: "' . $request->new_author . '"'
                ], 200);
            }  
            else
            {
                return response()->json([
                    'message' => 'Failed to update book with id: ' . $request->id
                ], 400);
            }
        }
        else 
        {
            return response()->json([
                'message' => 'Failed to update book with id: ' . $request->id .', duplicate entry found'
            ], 400);
        }

        
    }




}