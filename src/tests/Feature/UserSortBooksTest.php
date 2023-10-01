<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserSortBooksTest extends TestCase
{
    public function test_display_books_in_chronologically_inputted_order_when_default_sort_selected() 
    {
       $response = $this->get('/');

       $response->assertStatus(400);
    }

    public function test_display_books_sorted_alphabetically_by_title_ascending() 
    {  
        $response = $this->get('/');

        $response->assertStatus(400);
    }
    
    public function test_display_books_sorted_alphabetically_by_title_descending() 
    {  
        $response = $this->get('/');

        $response->assertStatus(400);
    }
    
    public function test_display_books_sorted_alphabetically_by_author_descending() 
    {  
        $response = $this->get('/');

        $response->assertStatus(400);
    } 

    public function test_display_books_sorted_alphabetically_by_author_descending() 
    {  
        $response = $this->get('/');

        $response->assertStatus(400);
    } 

}
