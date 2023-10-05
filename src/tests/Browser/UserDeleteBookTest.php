<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserDeleteBookTest extends TDuskestCase
{
    public function test_deleteBook_existing_succeed()
    {
        $response = $this->get('/');

        $response->assertStatus(400);
    }
}
