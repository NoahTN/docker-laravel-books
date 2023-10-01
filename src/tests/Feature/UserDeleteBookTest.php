<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserDeleteBookTest extends TestCase
{
    public function test_delete_book()
    {
        $response = $this->get('/');

        $response->assertStatus(400);
    }
}
