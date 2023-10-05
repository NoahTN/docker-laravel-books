<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserSearchBooksTest extends DuskTestCase
{
    // consider whitespace and trim accordingly
    // consider pagination after initial functionality built

    public function test_searchBooks_noInput_allBoks() 
    {
       $response = $this->get('/');

       $response->assertStatus(400);
    }

    public function test_searchBooks_noMatchingTitlesOrAuthors_noBooks()
    {
       $response = $this->get('/');

       $response->assertStatus(400);
    }

    public function test_searchBooks_matchingTitlesOrAuthors_matchedBooks()
    {
       $response = $this->get('/');

       $response->assertStatus(400);
    }

}
