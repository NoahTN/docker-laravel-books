<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Book;

class BookTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A feature test to add a book
     *
     * @return void
     */
    public function test_add_book() {
        $book = Book::create([
            'title' => 'Japanese the Manga Way: An Illustrated Guide to Grammar and Structure',
            'author' => 'Wayne P. Lammers'
        ]);

        $payload = [
            'book_title' => $book->title,
            'book_author' => $book->author
        ];

        $this->json('POST', 'api/add-book', $payload)
            ->assertStatus(200)
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
        $book = Book::create([
            'title' => 'Japanese the Manga Way: An Illustrated Guide to Grammar and Structure',
            'author' => 'Wayne P. Lammers'
        ]);

        $payload = [
            'book_title' => $book->title,
            'book_author' => $book->author
        ];

        $this->json('POST', 'api/add-book', $payload);

        $response = $this->get('/api/books')
            ->assertStatus(200)
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

}
