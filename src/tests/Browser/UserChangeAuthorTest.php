<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserChangeAuthorTest extends DuskTestCase 
{
    use DatabaseMigrations;

    /**
     * It accepts saving the author when no changes are made
     */
    public function test_changeAuthor_noChange_succeed() 
    {
        $this->browse(function ($browser) {
            $browser->visit('http://localhost')
                    ->type("title", "Test Book")
                    ->type("author", "An Author")
                    ->press('Add Book')
                    ->waitForText("Fetching books...")
                    ->waitUntilMissingText("Fetching books...")
                    ->waitFor(".row-item")
                    ->press("Edit")
                    ->press('Save')
                    ->waitForText("Updating author...")
                    ->waitForText("Fetching books...")
                    ->waitUntilMissingText("Fetching books...")
                    ->whenAvailable('.row-item', function ($row) {
                        $row->assertSee('An Author');
                    });
        });
    }

    /**
     * It accepts saving the author when changes are made
     */
    public function test_changeAuthor_newAuthor_succeed() 
    {
        $this->browse(function ($browser) {
            $browser->visit('http://localhost')
                    ->type("title", "Test Book")
                    ->type("author", "An Author")
                    ->press('Add Book')
                    ->waitForText("Fetching books...")
                    ->waitUntilMissingText("Fetching books...")
                    ->waitFor(".row-item")
                    ->press("Edit")
                    ->type("edit-Test Book_An Author", "Yet Another Author")
                    ->press('Save')
                    ->waitForText("Updating author...")
                    ->waitForText("Fetching books...")
                    ->waitUntilMissingText("Fetching books...")
                    ->whenAvailable('.row-item', function ($row) {
                        $row->assertSee('Yet Another Author');
                    });
        });
    }

    /**
     * It It warns the user that an existing book with the title and author exists
     */
    public function test_changeAuthor_existingTitleAndAuthor_reject() 
    {
        $this->browse(function ($browser) {
            $browser->visit('http://localhost')
                    ->type("title", "Test Book")
                    ->type("author", "An Author")
                    ->press('Add Book')
                    ->waitForText("Fetching books...")
                    ->waitUntilMissingText("Fetching books...")
                    ->waitFor(".row-item")
                    ->type("author", "Another Author")
                    ->press('Add Book')
                    ->waitForText("Fetching books...")
                    ->waitUntilMissingText("Fetching books...")
                    ->whenAvailable('tr:nth-child(2)', function ($row) {
                        $row->press("Edit")
                            ->type("edit-Test Book_Another Author", "An Author")
                            ->press('Save');
                    })
                    ->waitUntilMissingText("Updating author")
                    ->assertSee("duplicate entry found");
        });
    }

}
