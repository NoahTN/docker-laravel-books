<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserSortsAndSearchesTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * It gets all books matching the query ordered alphabetically by title scending
     */
    public function test_searchBooksSortBooks_searchQuerytitleAscending_matchingOrderedAlphabeticallyByTitleAscending() 
    {  
        $this->browse(function ($browser) {
            $browser->visit('http://localhost')
                ->type("title", "Test Book")
                ->type("author", "An Author")
                ->press('Add Book')
                ->type("title", "Another Book")
                ->type("author", "Yet Another Author")
                ->press('Add Book')
                ->type("title", "Yet Unread Book")
                ->type("author", "An Author")
                ->press('Add Book')
                ->waitForText("Fetching books...")
                ->waitUntilMissingText("Fetching books...")
                ->waitFor(".row-item:nth-child(3)")
                ->type("query", "Ye")
                ->waitForText("Fetching books...")
                ->waitUntilMissingText("Fetching books...")
                ->select("sortBy", "title-asc")
                ->waitForText("Fetching books...")
                ->waitUntilMissingText("Fetching books...")
                ->whenAvailable('.row-item:nth-child(1)', function ($row) {
                    $row->assertSee("Another Book");
                })
                ->whenAvailable('.row-item:nth-child(2)', function ($row) {
                    $row->assertSee("Yet Unread Book");
                })
                ->assertMissing(".row-item:nth-child(3)");
         });
    } 

    /**
     * It gets all books matching the query ordered alphabetically by title descending
     */
    public function test_searchBooksSortBooks_searchQuerytitleDescending_matchingOrderedAlphabeticallyByTitlDescending() 
    {  
        $this->browse(function ($browser) {
            $browser->visit('http://localhost')
                ->type("title", "Test Book")
                ->type("author", "An Author")
                ->press('Add Book')
                ->type("title", "Another Book")
                ->type("author", "Yet Another Author")
                ->press('Add Book')
                ->type("title", "Yet Unread Book")
                ->type("author", "An Author")
                ->press('Add Book')
                ->waitForText("Fetching books...")
                ->waitUntilMissingText("Fetching books...")
                ->waitFor(".row-item:nth-child(3)")
                ->type("query", "Ye")
                ->waitForText("Fetching books...")
                ->waitUntilMissingText("Fetching books...")
                ->select("sortBy", "title-desc")
                ->waitForText("Fetching books...")
                ->waitUntilMissingText("Fetching books...")
                ->whenAvailable('.row-item:nth-child(1)', function ($row) {
                    $row->assertSee("Yet Unread Book");
                })
                ->whenAvailable('.row-item:nth-child(2)', function ($row) {
                    $row->assertSee("Another Book");
                })
                ->assertMissing(".row-item:nth-child(3)");
         });
    } 

    /**
     * It gets all books matching the query ordered alphabetically by author ascending
     */
    public function test_searchBooksSortBooks_searchQueryauthorAsccending_matchingOrderedAlphabeticallyByAuthorAscending() 
    {  
        $this->browse(function ($browser) {
            $browser->visit('http://localhost')
                ->type("title", "Test Book")
                ->type("author", "An Author")
                ->press('Add Book')
                ->type("title", "Another Book")
                ->type("author", "Yet Another Author")
                ->press('Add Book')
                ->type("title", "Yet Unread Book")
                ->type("author", "An Author")
                ->press('Add Book')
                ->waitForText("Fetching books...")
                ->waitUntilMissingText("Fetching books...")
                ->waitFor(".row-item:nth-child(3)")
                ->type("query", "Ye")
                ->waitForText("Fetching books...")
                ->waitUntilMissingText("Fetching books...")
                ->select("sortBy", "author-asc")
                ->waitForText("Fetching books...")
                ->waitUntilMissingText("Fetching books...")
                ->whenAvailable('.row-item:nth-child(1)', function ($row) {
                    $row->assertSee("Yet Unread Book");
                })
                ->whenAvailable('.row-item:nth-child(2)', function ($row) {
                    $row->assertSee("Test Book");
                })
                ->assertMissing(".row-item:nth-child(3)");
         });
    }
    
    /**
     * It gets all books matching the query ordered alphabetically by author descending
     */
    public function test_searchBooksSortBooks_searchQueryauthorDescending_matchingOrderedAlphabeticallyByAuthorDescending() 
    {  
        $this->browse(function ($browser) {
            $browser->visit('http://localhost')
                ->type("title", "Test Book")
                ->type("author", "An Author")
                ->press('Add Book')
                ->type("title", "Another Book")
                ->type("author", "Yet Another Author")
                ->press('Add Book')
                ->type("title", "Yet Unread Book")
                ->type("author", "An Author")
                ->press('Add Book')
                ->waitForText("Fetching books...")
                ->waitUntilMissingText("Fetching books...")
                ->waitFor(".row-item:nth-child(3)")
                ->type("query", "Ye")
                ->waitForText("Fetching books...")
                ->waitUntilMissingText("Fetching books...")
                ->select("sortBy", "author-desc")
                ->waitForText("Fetching books...")
                ->waitUntilMissingText("Fetching books...")
                ->whenAvailable('.row-item:nth-child(1)', function ($row) {
                    $row->assertSee("Another Book");
                })
                ->whenAvailable('.row-item:nth-child(2)', function ($row) {
                    $row->assertSee("Yet Unread Book");
                })
                ->assertMissing(".row-item:nth-child(3)");
         });
    } 
}
