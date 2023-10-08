<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Book;

class BookTest extends TestCase
{
    use RefreshDatabase;

    private function addBook(string $title, string $author): object
    {
        return $this->json('POST', 'api/books/add', compact('title', 'author'));
    }

    /**
     * It successfully adds a book
     */
    public function test_addBook_single_success() {
        $this->addBook('Japanese the Manga Way: An Illustrated Guide to Grammar and Structure', 'Wayne P. Lammers')
            ->assertJson([
                'message' => 'Successfully added book',
                'data' => [
                    'title' => 'Japanese the Manga Way: An Illustrated Guide to Grammar and Structure',
                    'author' => 'Wayne P. Lammers'
                ]
            ]);
    }

    /**
     * It fails when adding a book with a duplicate title and author of one in the database
     */
    public function test_addBook_duplicateTitleAndAuthor_fail() {
        $this->addBook('Japanese the Manga Way: An Illustrated Guide to Grammar and Structure', 'Wayne P. Lammers');
        $this->addBook('Japanese the Manga Way: An Illustrated Guide to Grammar and Structure', 'Wayne P. Lammers')
            ->assertJson([
                'message' => 'Failed to add book, "Japanese the Manga Way: An Illustrated Guide to Grammar and Structure" by "Wayne P. Lammers" already exists'
            ]);
    }

    /**
     * It successfully finds and deletes a book by its id
     */
    public function test_deleteBook_exists_success()
    {
        $book = $this->addBook('Japanese the Manga Way: An Illustrated Guide to Grammar and Structure', 'Wayne P. Lammers')
                    ->getData()->data;
        $this->json('DELETE', '/api/books/' . $book->id)
            ->assertJson([
                'message' => 'Successfully deleted book with id: ' . $book->id
            ]);
    }

    /**
     * It fails to delete a book when the id is not found
     */
    public function test_deleteBook_notFound_failure()
    {
        $this->json('DELETE', '/api/books/' . 10)
        ->assertJson([
            'message' => 'Failed to delete book with id: 10'
        ]);
    }

    /**
     * It updates the author of a book by its id
     */
    public function test_updateBookAuthor_exists_success()
    {
        $book = $this->addBook('Japanese the Manga Way: An Illustrated Guide to Grammar and Structure', 'Wayne P. Lammers')
                    ->getData()->data;

        $payload = [
            'id' => $book->id,
            'new_author' => 'Lammers P. Wayne'
        ];

        $this->json('PUT', '/api/books/author', $payload)
            ->assertJson([
                'message' => 'Successfully updated book with id: '. $book->id .' to author: "Lammers P. Wayne"'
            ]);
    }

    /**
     * It fails to update the author of a book by its id when the author is empty
     */
    public function test_updateBookAuthor_noAuthor_failure()
    {
        $book = $this->addBook('Japanese the Manga Way: An Illustrated Guide to Grammar and Structure', 'Wayne P. Lammers')
                    ->getData()->data;

        $payload = [
            'id' => $book->id,
            'new_author' => ''
        ];

        $this->json('PUT', '/api/books/author', $payload)
            ->assertJson([
                'message' => 'The new author field is required'
            ]);
    }

    /**
     * It gets all books
     */
    public function test_getAllBooks_populated_success()
    {
        $this->addBook('Japanese the Manga Way: An Illustrated Guide to Grammar and Structure', 'Wayne P. Lammers');
        $this->addBook('Basic Human Anatomy: An Essential Visual Guide for Artists', 'Roberto Osti');
        $this->addBook('How To Draw Comics The Marvel Way', 'Stan Lee, John Buscema');

        $this->get('/api/books')
            ->assertJsonStructure(
                [
                    'message',
                    'data' => [
                        '*' => [
                            'id',
                            'title',
                            'author',
                        ]
                    ]
                ]
            );
    }


    /**
     *  It gets all the books that have a title or author containing a word that starts with the query
     */
    public function test_getBooksByQuery_populated_booksWithTitleOrAuthorContainingWordStartingWithQuery()
    {
        $this->addBook('Japanese the Manga Way: An Illustrated Guide to Grammar and Structure', 'Wayne P. Lammers');
        $this->addBook('Basic Human Anatomy: An Essential Visual Guide for Artists', 'Roberto Osti');
        $this->addBook('How To Draw Comics The Marvel Way', 'Stan Lee, John Buscema');
        $this->addBook('Voices In the Park', 'Anthony Browne');
        $this->addBook('A Nonexistant Book', 'Browne Anthony');

        $this->get('/api/books/search?query=An')
            ->assertJson([
                'message' => 'Successfully found books matching "An"',
                'data' => [
                    ['title' => 'Japanese the Manga Way: An Illustrated Guide to Grammar and Structure'],
                    ['title' => 'Basic Human Anatomy: An Essential Visual Guide for Artists'],
                    ['title' => 'Voices In the Park'],
                    ['title' => 'A Nonexistant Book'],
                ]
            ]);
    }

    /*
     * It gets the list of books sorted by title ascending
     */
    public function test_getAllBooks_populated_sortedByTitleAscending() 
    {
        $this->addBook('Japanese the Manga Way: An Illustrated Guide to Grammar and Structure', 'Wayne P. Lammers');
        $this->addBook('Basic Human Anatomy: An Essential Visual Guide for Artists', 'Roberto Osti');
        $this->addBook('How To Draw Comics The Marvel Way 1', 'Stan Lee, John Buscema');
        $this->addBook('How To Draw Comics The Marvel Way 11', 'Stan Lee, John Buscema');
        $this->get('/api/books/search?orderBy=title&order=ASC')
            ->assertJson([
                'data' => [
                    ['title' => 'Basic Human Anatomy: An Essential Visual Guide for Artists'],
                    ['title' => 'How To Draw Comics The Marvel Way 1'],
                    ['title' => 'How To Draw Comics The Marvel Way 11'],
                    ['title' => 'Japanese the Manga Way: An Illustrated Guide to Grammar and Structure']
                ]
            ]);
    }

    /*
     * It gets the list of books sorted by title descending
     */
    public function test_getAllBooks_populated_sortedByTitleDescending() 
    {
        $this->addBook('Japanese the Manga Way: An Illustrated Guide to Grammar and Structure', 'Wayne P. Lammers');
        $this->addBook('Basic Human Anatomy: An Essential Visual Guide for Artists', 'Roberto Osti');
        $this->addBook('How To Draw Comics The Marvel Way 1', 'Stan Lee, John Buscema');
        $this->addBook('How To Draw Comics The Marvel Way 11', 'Stan Lee, John Buscema');
        $this->get('/api/books/search?orderBy=title&order=DESC')
            ->assertJson([
                'data' => [
                    ['title' => 'Japanese the Manga Way: An Illustrated Guide to Grammar and Structure'],
                    ['title' => 'How To Draw Comics The Marvel Way 11'],
                    ['title' => 'How To Draw Comics The Marvel Way 1'],
                    ['title' => 'Basic Human Anatomy: An Essential Visual Guide for Artists'],
                ]
            ]);
    }

    /*
     * It gets the list of books sorted by author asscending
     */
    public function test_getAllBooks_populated_sortedByAuthorAscending() 
    {
        $this->addBook('Japanese the Manga Way: An Illustrated Guide to Grammar and Structure', 'Wayne P. Lammers');
        $this->addBook('Basic Human Anatomy: An Essential Visual Guide for Artists', 'Roberto Osti');
        $this->addBook('How To Draw Comics The Marvel Way 11', 'Stan Lee, John Buscema');
        $this->addBook('How To Draw Comics The Marvel Way 1', 'Stan Lee, John Buscema');
        $this->get('/api/books/search?orderBy=author&order=ASC')
            ->assertJson([
                'data' => [
                    ['title' => 'Basic Human Anatomy: An Essential Visual Guide for Artists'],
                    ['title' => 'How To Draw Comics The Marvel Way 11'],
                    ['title' => 'How To Draw Comics The Marvel Way 1'],
                    ['title' => 'Japanese the Manga Way: An Illustrated Guide to Grammar and Structure'],
                ]
            ]);
    }

    /*
     * It gets the list of books sorted by author descending
     */
    public function test_getAllBooks_populated_sortedByAuthorDescending() 
    {
        $this->addBook('Japanese the Manga Way: An Illustrated Guide to Grammar and Structure', 'Wayne P. Lammers');
        $this->addBook('Basic Human Anatomy: An Essential Visual Guide for Artists', 'Roberto Osti');
        $this->addBook('How To Draw Comics The Marvel Way 11', 'Stan Lee, John Buscema');
        $this->addBook('How To Draw Comics The Marvel Way 1', 'Stan Lee, John Buscema');
        $this->get('/api/books/search?orderBy=author&order=DESC')
            ->assertJson([
                'data' => [
                    ['title' => 'Japanese the Manga Way: An Illustrated Guide to Grammar and Structure'],
                    ['title' => 'How To Draw Comics The Marvel Way 11'],
                    ['title' => 'How To Draw Comics The Marvel Way 1'],
                    ['title' => 'Basic Human Anatomy: An Essential Visual Guide for Artists'],
                ]
            ]);
    }

    /*
     * It gets the list of books that have a title or author containing a word that starts with the query, sorted by title ascending
     */
    public function test_getBooksByQuery_populated_sortedByTitleAscending() 
    {
        $this->addBook('Japanese the Manga Way: An Illustrated Guide to Grammar and Structure', 'Wayne P. Lammers');
        $this->addBook('Basic Human Anatomy: An Essential Visual Guide for Artists', 'Roberto Osti');
        $this->addBook('How To Draw Comics The Marvel Way 1', 'Stan Lee, John Buscema');
        $this->addBook('How To Draw Comics The Marvel Way 11', 'Stan Lee, John Buscema');
        $this->get('/api/books/search?query=the&orderBy=title&order=ASC')
            ->assertJson([
                'data' => [
                    ['title' => 'How To Draw Comics The Marvel Way 1'],
                    ['title' => 'How To Draw Comics The Marvel Way 11'],
                    ['title' => 'Japanese the Manga Way: An Illustrated Guide to Grammar and Structure']
                ]
            ]);
    }

    /*
     * It gets the list of books that have a title or author containing a word that starts with the query, sorted by title descending
     */
    public function test_getBooksByQuery_populated_sortedByTitleDescending() 
    {
        $this->addBook('Japanese the Manga Way: An Illustrated Guide to Grammar and Structure', 'Wayne P. Lammers');
        $this->addBook('Basic Human Anatomy: An Essential Visual Guide for Artists', 'Roberto Osti');
        $this->addBook('How To Draw Comics The Marvel Way 1', 'Stan Lee, John Buscema');
        $this->addBook('How To Draw Comics The Marvel Way 11', 'Stan Lee, John Buscema');

        $this->get('/api/books/search?query=the&orderBy=title&order=DESC')
            ->assertJson([
                'data' => [
                    ['title' => 'Japanese the Manga Way: An Illustrated Guide to Grammar and Structure'],
                    ['title' => 'How To Draw Comics The Marvel Way 11'],
                    ['title' => 'How To Draw Comics The Marvel Way 1'],
                ]
            ]);
    }

    /*
     * It gets the list of books that have a title or author containing a word that starts with the query, sorted by author ascending
     */
    public function test_getBooksByQuery_populated_sortedByAuthorAscending() 
    {
        $this->addBook('Japanese the Manga Way: An Illustrated Guide to Grammar and Structure', 'Wayne P. Lammers');
        $this->addBook('Basic Human Anatomy: An Essential Visual Guide for Artists', 'Roberto Osti');
        $this->addBook('How To Draw Comics The Marvel Way 1', 'Stan Lee, John Buscema');
        $this->addBook('How To Draw Comics The Marvel Way 11', 'Stan Lee, John Buscema');

        $this->get('/api/books/search?query=the&orderBy=author&order=ASC')
            ->assertJson([
                'data' => [
                    ['title' => 'How To Draw Comics The Marvel Way 1'],
                    ['title' => 'How To Draw Comics The Marvel Way 11'],
                    ['title' => 'Japanese the Manga Way: An Illustrated Guide to Grammar and Structure'],
                ]
            ]);
    }

    /*
     * It gets the list of books that have a title or author containing a word that starts with the query, sorted by author descending
     */
    public function test_getBooksByQuery_populated_sortedByAuthorDescending() 
    {
        $this->addBook('Japanese the Manga Way: An Illustrated Guide to Grammar and Structure', 'Wayne P. Lammers');
        $this->addBook('Basic Human Anatomy: An Essential Visual Guide for Artists', 'Roberto Osti');
        $this->addBook('How To Draw Comics The Marvel Way 1', 'Stan Lee, John Buscema');
        $this->addBook('How To Draw Comics The Marvel Way 11', 'Stan Lee, John Buscema');

        $this->get('/api/books/search?query=the&orderBy=author&order=DESC')
            ->assertJson([
                'data' => [
                    ['title' => 'Japanese the Manga Way: An Illustrated Guide to Grammar and Structure'],
                    ['title' => 'How To Draw Comics The Marvel Way 1'],
                    ['title' => 'How To Draw Comics The Marvel Way 11'],
                ]
            ]);
    }

    

}
