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

        return $this->json('POST', 'api/add-book', $payload);
    }

    /**
     * A feature test to add a book
     *
     * @return void
     */
    public function test_add_book() {
        $this->addBook('Japanese the Manga Way: An Illustrated Guide to Grammar and Structure', 'Wayne P. Lammers')
            ->assertJson([
                'code' => '200',
                'message' => 'Book added'
            ]);
    }

    /**
     * A feature test to get all book data
     *
     * @return void
     */
    public function test_get_all_books()
    {
        $this->addBook('Japanese the Manga Way: An Illustrated Guide to Grammar and Structure', 'Wayne P. Lammers');
        $this->addBook('Basic Human Anatomy: An Essential Visual Guide for Artists', 'Roberto Osti');
        $this->addBook('How To Draw Comics The Marvel Way', 'Stan Lee, John Buscema');

        $response = $this->get('/api/books')
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
     * A feature test to get all books containing words with beginning characters that match the query
     *
     * @return void
     */
    public function test_get_all_books_with_title_or_author_containing_words_with_beginning_characters_matching_query()
    {
        $this->addBook('Japanese the Manga Way: An Illustrated Guide to Grammar and Structure', 'Wayne P. Lammers');
        $this->addBook('Basic Human Anatomy: An Essential Visual Guide for Artists', 'Roberto Osti');
        $this->addBook('How To Draw Comics The Marvel Way', 'Stan Lee, John Buscema');
        $this->addBook('Voices In the Park', 'Anthony Browne');
        $this->addBook('A Nonexistant Book', 'Browne Anthony');

        $expected = [
            'code' => 200,
            'message' => 'Found book(s) matching "An"',
            'data' => [
                ['title' => 'Japanese the Manga Way: An Illustrated Guide to Grammar and Structure', 'author' => 'Wayne P. Lammers'],
                ['title' => 'Basic Human Anatomy: An Essential Visual Guide for Artists', 'author' => 'Roberto Osti'],
                ['title' => 'Voices In the Park', 'author' => 'Anthony Browne'],
                ['title' => 'A Nonexistant Book', 'author' => 'Browne Anthony'],
            ]
        ];

        $response = $this->get('/api/books/' . 'An')
            ->assertJson($expected);
    }

    /**
     * A feature test to get all books containing words with beginning characters that match the query when no query
     *
     * @return void
     */
    // public function test_get_all_books_when_no_query()
    // {

    // }

}
