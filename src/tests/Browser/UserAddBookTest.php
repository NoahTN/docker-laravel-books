<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserAddBookTest extends DuskTestCase
{
    use RefreshDatabase;


    /**
     * It prevents the user from adding a book with no title and no author
     */
    public function test_addBook_noTitleNoAuthor_reject() 
    {
        $this->browse(function ($browser) {
            $browser->visit('http://localhost')
                ->press('Add Book')
                ->waitForText("Missing title")
                ->waitForText("Missing author");
        });
    }

    public function test_addBook_noTitleAuthor_reject() 
    {
        $response = $this->get('/');

        $response->assertStatus(400);
    }

    public function test_addBook_titleNoAuthor_reject() 
    {
        $response = $this->get('/');

        $response->assertStatus(400);
    }

    public function test_addBook_existingTitleAndAuthor_reject() 
    {
        $response = $this->get('/');

        $response->assertStatus(400);
    }

    public function test_addBook_existingTitleDifferentAuthor_succeed() 
    {
        $response = $this->get('/');

        $response->assertStatus(400);
    }

    public function test_addBook_differentTitleExistingAuthor_succeed() 
    {
        $response = $this->get('/');

        $response->assertStatus(400);
    }

    public function test_addBook_titleLongerThan255Characters_reject() 
    {
        $response = $this->get('/');

        $response->assertStatus(400);
    }

    public function test_addBook_authorLongerThan255Characters_reject() 
    {
        $response = $this->get('/');

        $response->assertStatus(400);
    }

}
