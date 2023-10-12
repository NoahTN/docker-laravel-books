<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserAddBookTest extends DuskTestCase
{
    use DatabaseMigrations;


    /**
     * It fails in adding a book to the database and notifies the user that duplicate title and author exists
     */
    public function test_addBook_existingTitleAndAuthor_reject() 
    {
        $this->browse(function ($browser) {
            $browser->visit('http://localhost')
                ->type("title", "Test Book")
                ->type("author", "An Author")
                ->press('Add Book')
                ->waitFor(".row-item")
                ->press('Add Book')
                ->waitFor("#warning-add")
                ->assertSeeIn("#warning-add", "Failed to add book, \"Test Book\" by \"An Author\" already exists");
        });
    }

    /**
     * It succeeds in adding a book with an existing title but different author
     */
    public function test_addBook_existingTitleDifferentAuthor_succeed() 
    {
        $this->browse(function ($browser) {
            $browser->visit('http://localhost')
                    ->type("title", "Test Book")
                    ->type("author", "An Author")
                    ->press('Add Book')
                    ->waitFor(".row-item")
                    ->type("author", "Another Author")
                    ->press('Add Book')
                    ->whenAvailable('tr:nth-child(2)', function ($row) {
                        $row->assertSee('Another Author');
                    });
        });
    }

    /**
     * It succeeds in adding a book with an existing author but different title
     */
    public function test_addBook_differentTitleExistingAuthor_succeed() 
    {
        $this->browse(function ($browser) {
            $browser->visit('http://localhost')
                    ->type("title", "Test Book")
                    ->type("author", "An Author")
                    ->press('Add Book')
                    ->waitFor(".row-item")
                    ->type("title", "Another Book")
                    ->press('Add Book')
                    ->whenAvailable('tr:nth-child(2)', function ($row) {
                        $row->assertSee('Another Book');
                    });
        });
    }

}
