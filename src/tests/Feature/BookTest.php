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
        $payload = [
            'book_title' => $title,
            'book_author' => $author
        ];

        return $this->json('POST', 'api/books/add', $payload);
    }

    /**
     * It successfully adds a book
     */
    public function test_addBook_single_success() {
        $this->addBook('Japanese the Manga Way: An Illustrated Guide to Grammar and Structure', 'Wayne P. Lammers')
            ->assertJson([
                'code' => '200',
                'message' => 'Book added',
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
                'code' => '400',
                'message' => 'Book with Title and Author already exists'
            ]);
    }

    /**
     * It gets all books in the database
     */
    public function test_getAllBooks_populated_success()
    {
        $this->addBook('Japanese the Manga Way: An Illustrated Guide to Grammar and Structure', 'Wayne P. Lammers');
        $this->addBook('Basic Human Anatomy: An Essential Visual Guide for Artists', 'Roberto Osti');
        $this->addBook('How To Draw Comics The Marvel Way', 'Stan Lee, John Buscema');

        $this->get('/api/books')
            ->assertJsonStructure(
                [
                    'code',
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
     *  It gets all the books in the database that have a title or author containg a word that starts with the query
     */
    public function test_getBooksByQuery_populated_booksWithTitleOrAuthorContainingWordStartingWithQuery()
    {
        $this->addBook('Japanese the Manga Way: An Illustrated Guide to Grammar and Structure', 'Wayne P. Lammers');
        $this->addBook('Basic Human Anatomy: An Essential Visual Guide for Artists', 'Roberto Osti');
        $this->addBook('How To Draw Comics The Marvel Way', 'Stan Lee, John Buscema');
        $this->addBook('Voices In the Park', 'Anthony Browne');
        $this->addBook('A Nonexistant Book', 'Browne Anthony');

        $this->get('/api/books/search/' . 'An')
            ->assertJson([
                'code' => 200,
                'message' => 'Found book(s) matching "An"',
                'data' => [
                    ['title' => 'Japanese the Manga Way: An Illustrated Guide to Grammar and Structure'],
                    ['title' => 'Basic Human Anatomy: An Essential Visual Guide for Artists'],
                    ['title' => 'Voices In the Park'],
                    ['title' => 'A Nonexistant Book'],
                ]
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
                'code' => 200,
                'message' => 'Book with id: ' . $book->id . ' successfully deleted'
            ]);
    }

    /**
     * It fails to delete a book when the id is not found
     */
    public function test_deleteBook_notFound_failure()
    {
        $this->json('DELETE', '/api/books/' . 10)
        ->assertJson([
            'code' => 400,
            'message' => 'Failed to delete book with id: 10'
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
        $this->get('/api/books/title/ASC')
            ->assertJson([
                'code' => 200,
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
        $this->get('/api/books/title/DESC')
            ->assertJson([
                'code' => 200,
                'data' => [
                    ['title' => 'Japanese the Manga Way: An Illustrated Guide to Grammar and Structure'],
                    ['title' => 'How To Draw Comics The Marvel Way 11'],
                    ['title' => 'How To Draw Comics The Marvel Way 1'],
                    ['title' => 'Basic Human Anatomy: An Essential Visual Guide for Artists'],
                ]
            ]);
    }

    /*
     * It gets the list of books sorted by author descending
     */
    public function test_getAllBooks_populated_sortedByAuthorAscending() 
    {
        $this->addBook('Japanese the Manga Way: An Illustrated Guide to Grammar and Structure', 'Wayne P. Lammers');
        $this->addBook('Basic Human Anatomy: An Essential Visual Guide for Artists', 'Roberto Osti');
        $this->addBook('How To Draw Comics The Marvel Way 11', 'Stan Lee, John Buscema');
        $this->addBook('How To Draw Comics The Marvel Way 1', 'Stan Lee, John Buscema');
        $this->get('/api/books/author/ASC')
            ->assertJson([
                'code' => 200,
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
        $this->get('/api/books/author/DESC')
            ->assertJson([
                'code' => 200,
                'data' => [
                    ['title' => 'Japanese the Manga Way: An Illustrated Guide to Grammar and Structure'],
                    ['title' => 'How To Draw Comics The Marvel Way 11'],
                    ['title' => 'How To Draw Comics The Marvel Way 1'],
                    ['title' => 'Basic Human Anatomy: An Essential Visual Guide for Artists'],
                ]
            ]);
    }

    

}
