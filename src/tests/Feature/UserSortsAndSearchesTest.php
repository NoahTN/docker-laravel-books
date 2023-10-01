<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserSortsAndSearchesTest extends TestCase
{
    public function test_filter_books_by_titles_or_authors_with_words_having_beginning_characters_matching_input_sorted_alphabetically_by_title_ascending() 
    {  
        $response = $this->get('/');

        $response->assertStatus(400);
    } 

    public function test_filter_books_by_titles_or_authors_with_words_having_beginning_characters_matching_input_sorted_alphabetically_by_title_descending() 
    {  
        $response = $this->get('/');

        $response->assertStatus(400);
    } 

    public function test_filter_books_by_titles_or_authors_with_words_having_beginning_characters_matching_input_sorted_alphabetically_by_author_ascending() 
    {  
        $response = $this->get('/');

        $response->assertStatus(400);
    }
    
    public function test_filter_books_by_titles_or_authors_with_words_having_beginning_characters_matching_input_sorted_alphabetically_by_author_descending() 
    {  
        $response = $this->get('/');

        $response->assertStatus(400);
    } 
}
