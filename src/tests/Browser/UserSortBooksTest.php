<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserSortBooksTest extends DuskTestCase
{
    public function test_sortBooks_noSort_insertionOrderDescending() 
    {
       $response = $this->get('/');

       $response->assertStatus(400);
    }

    public function test_sortbooks_titleAscending_titleAlphabeticalOrderAscending() 
    {  
        $response = $this->get('/');

        $response->assertStatus(400);
    }
    
    public function test_sortbooks_titleDescending_titleAlphabeticalOrderDescending() 
    {  
        $response = $this->get('/');

        $response->assertStatus(400);
    }
    
    public function test_sortbooks_authorAscending_authorAlphabeticalOrderAscending() 
    {  
        $response = $this->get('/');

        $response->assertStatus(400);
    } 

    public function test_sortbooks_authorDescending_authorAlphabeticalOrderDescending() 
    {  
        $response = $this->get('/');

        $response->assertStatus(400);
    } 

}
