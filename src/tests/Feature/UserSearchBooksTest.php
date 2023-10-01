<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserSearchBooksTest extends TestCase
{
    // consider whitespace and trim accordingly
    // consider pagination after initial functionality built

    public function test_display_all_books_when_no_input() 
    {
       $response = $this->get('/');

       $response->assertStatus(400);
    }

    public function test_display_no_books_found_when_no_titles_or_authors_contain_word_with_beginning_characters_matching_input() 
    {
       $response = $this->get('/');

       $response->assertStatus(400);
    }

    public function test_filter_books_with_title_or_author_containing_a_word_with_beginning_charcters_matching_input() 
    {
       $response = $this->get('/');

       $response->assertStatus(400);
    }

}
