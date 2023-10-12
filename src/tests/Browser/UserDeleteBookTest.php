<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserDeleteBookTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * It successfully deletes an existing book
     */
    public function test_deleteBook_existing_succeed()
    {
        $this->browse(function ($browser) {
            $browser->visit('http://localhost')
                ->type("title", "Test Book")
                ->type("author", "An Author")
                ->press('Add Book')
                ->whenAvailable('.row-item', function ($row) {
                    $row->press("Delete");
                })
                ->clear("title")
                ->assertDontSee("td", "Test Book");
                
        });
    }
}
