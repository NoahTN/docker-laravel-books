<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserAddBookTest extends DuskTestCase
{

    public function test_addBook_noTitleNoAuthor_reject() 
    {
        $response = $this->get('/');
        $response->assertSee([
                '<table>',
                '</table>'
            ], false);
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
