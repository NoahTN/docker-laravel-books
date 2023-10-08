<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserChangeAuthorTest extends DuskTestCase 
{
    public function test_changeAuthor_noChange_succeed() 
    {
        $response = $this->get('/');

        $response->assertStatus(400);
    }

    public function test_changeAuthor_newAuthor_succeed() 
    {
        $response = $this->get('/');

        $response->assertStatus(400);
    }

    public function test_changeAuthor_existingTitleAndAuthor_reject() 
    {
        $response = $this->get('/');

        $response->assertStatus(400);
    }

}
