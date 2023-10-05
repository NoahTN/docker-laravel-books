<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserSortsAndSearchesTest extends DuskTestCase
{
    public function test_searchBooksSortBooks_searchQuerytitleAscending_matchingOrderedAlphabeticallyByTitleAscending() 
    {  
        $response = $this->get('/');

        $response->assertStatus(400);
    } 

    public function test_searchBooksSortBooks_searchQuerytitleDescending_matchingOrderedAlphabeticallyByTitlDescending() 
    {  
        $response = $this->get('/');

        $response->assertStatus(400);
    } 

    public function test_searchBooksSortBooks_searchQueryauthorAsccending_matchingOrderedAlphabeticallyByAuthorAscending() 
    {  
        $response = $this->get('/');

        $response->assertStatus(400);
    }
    
    public function test_searchBooksSortBooks_searchQueryauthorDescending_matchingOrderedAlphabeticallyByAuthorDescending() 
    {  
        $response = $this->get('/');

        $response->assertStatus(400);
    } 
}
