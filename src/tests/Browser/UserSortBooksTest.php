<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserSortBooksTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * It sorts all books in alphabetical order by title ascending
     */
    public function test_sortbooks_titleAscending_titleAlphabeticalOrderAscending() 
    {  
        $this->browse(function ($browser) {
            $browser->visit('http://localhost')
                ->type("title", "Test Book")
                ->type("author", "An Author")
                ->press('Add Book')
                ->waitForText("Fetching books...")
                ->waitUntilMissingText("Fetching books...")
                ->type("title", "Another Book")
                ->type("author", "Yet Another Author")
                ->press('Add Book')
                ->waitForText("Fetching books...")
                ->waitUntilMissingText("Fetching books...")
                ->waitFor(".row-item:nth-child(2)")
                ->select("sortBy", "title-asc")
                ->waitForText("Fetching books...")
                ->waitUntilMissingText("Fetching books...")
                ->whenAvailable('.row-item:nth-child(1)', function ($row) {
                    $row->assertSee("Another Book");
                })
                ->whenAvailable('.row-item:nth-child(2)', function ($row) {
                    $row->assertSee("Test Book");
                });
         });
    }
    
    /**
     * It sorts all books in alphabetical order by title descending
     */
    public function test_sortbooks_titleDescending_titleAlphabeticalOrderDescending() 
    {  
        $this->browse(function ($browser) {
            $browser->visit('http://localhost')
                ->type("title", "Test Book")
                ->type("author", "An Author")
                ->press('Add Book')
                ->waitForText("Fetching books...")
                ->waitUntilMissingText("Fetching books...")
                ->type("title", "Another Book")
                ->type("author", "Yet Another Author")
                ->press('Add Book')
                ->waitForText("Fetching books...")
                ->waitUntilMissingText("Fetching books...")
                ->waitFor(".row-item:nth-child(2)")
                ->select("sortBy", "title-desc")
                ->waitForText("Fetching books...")
                ->waitUntilMissingText("Fetching books...")
                ->whenAvailable('.row-item:nth-child(1)', function ($row) {
                    $row->assertSee("Test Book");
                })
                ->whenAvailable('.row-item:nth-child(2)', function ($row) {
                    $row->assertSee("Another Book");
                });
         });
    }
    
    /**
     * It sorts all books in alphabetical order by author ascending
     */
    public function test_sortbooks_authorAscending_authorAlphabeticalOrderAscending() 
    {  
        $this->browse(function ($browser) {
            $browser->visit('http://localhost')
                ->type("title", "Test Book")
                ->type("author", "An Author")
                ->press('Add Book')
                ->waitForText("Fetching books...")
                ->waitUntilMissingText("Fetching books...")
                ->type("title", "Another Book")
                ->type("author", "Yet Another Author")
                ->press('Add Book')
                ->waitForText("Fetching books...")
                ->waitUntilMissingText("Fetching books...")
                ->waitFor(".row-item:nth-child(2)")
                ->select("sortBy", "author-asc")
                ->waitForText("Fetching books...")
                ->waitUntilMissingText("Fetching books...")
                ->whenAvailable('.row-item:nth-child(1)', function ($row) {
                    $row->assertSee("Test Book");
                })
                ->whenAvailable('.row-item:nth-child(2)', function ($row) {
                    $row->assertSee("Another Book");
                });
         });
    } 

    /**
     * It sorts all books in alphabetical order by author descending
     */
    public function test_sortbooks_authorDescending_authorAlphabeticalOrderDescending() 
    {  
        $this->browse(function ($browser) {
            $browser->visit('http://localhost')
                ->type("title", "Test Book")
                ->type("author", "An Author")
                ->press('Add Book')
                ->waitForText("Fetching books...")
                ->waitUntilMissingText("Fetching books...")
                ->type("title", "Another Book")
                ->type("author", "Yet Another Author")
                ->press('Add Book')
                ->waitForText("Fetching books...")
                ->waitUntilMissingText("Fetching books...")
                ->waitFor(".row-item:nth-child(2)")
                ->select("sortBy", "author-desc")
                ->waitForText("Fetching books...")
                ->waitUntilMissingText("Fetching books...")
                ->whenAvailable('.row-item:nth-child(1)', function ($row) {
                    $row->assertSee("Another Book");
                })
                ->whenAvailable('.row-item:nth-child(2)', function ($row) {
                    $row->assertSee("Test Book");
                });
         });
    } 

}
