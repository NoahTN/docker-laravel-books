<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserAddBookTest extends TestCase
{

    public function test_reject_adding_book_with_no_title_and_no_author() 
    {
        $response = $this->get('/');

        $response->assertStatus(400);
    }

    public function ttest_reject_adding_book_wit_author_but_no_title() 
    {
        $response = $this->get('/');

        $response->assertStatus(400);
    }

    public function test_reject_adding_book_with_title_but_no_author() 
    {
        $response = $this->get('/');

        $response->assertStatus(400);
    }

    public function test_reject_adding_book_with_existing_title_and_existing_author() 
    {
        $response = $this->get('/');

        $response->assertStatus(400);
    }

    public function testAllowAddingBookWithExistingTitleButDifferentAuthor() 
    {
        $response = $this->get('/');

        $response->assertStatus(400);
    }

    public function test_allow_adding_book_with_existing_title_but_different_author() 
    {
        $response = $this->get('/');

        $response->assertStatus(400);
    }

    public function test_reject_adding_book_with_title_longer_than_255_characters() 
    {
        $response = $this->get('/');

        $response->assertStatus(400);
    }

    public function test_reject_adding_book_with_author_longer_than_255_characters() 
    {
        $response = $this->get('/');

        $response->assertStatus(400);
    }

}
