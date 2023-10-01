<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserChangeAuthorTest extends TestCase 
{
    public function test_allow_change_author_no_text_change() 
    {
        $response = $this->get('/');

        $response->assertStatus(400);
    }

    public function test_change_author() 
    {
        $response = $this->get('/');

        $response->assertStatus(400);
    }

    public function testRejectChangeAuthorWith0Characters() 
    {
        $response = $this->get('/');

        $response->assertStatus(400);
    }

    public function testRejectChangeAuthorGreaterThan100Characters() 
    {
        $response = $this->get('/');

        $response->assertStatus(400);
    }

    public function testRejectChangeAuthorToExistingAuthorWWhenSameTitle() 
    {
        $response = $this->get('/');

        $response->assertStatus(400);
    }

}
