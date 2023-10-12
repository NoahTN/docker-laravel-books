<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserSearchBooksTest extends DuskTestCase
{
   use DatabaseMigrations;


   /**
    * It notifies the user that no books matching the query were found
    */
    public function test_searchBooks_noMatchingTitlesOrAuthors_noBooks()
    {
      $this->browse(function ($browser) {
         $browser->visit('http://localhost')
               ->type("title", "Test Book")
               ->type("author", "An Author")
               ->press('Add Book')
               ->waitForText("Fetching books...")
               ->waitUntilMissingText("Fetching books...")
               ->waitFor(".row-item")
               ->type("query", "Movie")
               ->waitForText("Fetching books...")
               ->waitUntilMissingText("Fetching books...")
               ->assertSee("No books matching \"Movie\" found");
      });
    }

   /**
    * It gets all books with matching titles or authors 
    */
    public function test_searchBooks_matchingTitlesOrAuthors_matchedBooks()
    {
      $this->browse(function ($browser) {
         $browser->visit('http://localhost')
               ->type("title", "Test Book")
               ->type("author", "An Author")
               ->press('Add Book')
               ->waitForText("Fetching books...")
               ->waitUntilMissingText("Fetching books...")
               ->waitFor(".row-item")
               ->type("query", "An")
               ->waitForText("Fetching books...")
               ->waitUntilMissingText("Fetching books...")
               ->whenAvailable('.row-item', function ($row) {
                  $row->assertSee('An Author');
              });
      });
    }

}
