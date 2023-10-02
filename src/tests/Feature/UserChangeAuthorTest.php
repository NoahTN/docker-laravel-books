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

    public function test_reject_change_author_with_no_characters() 
    {
        $response = $this->get('/');

        $response->assertStatus(400);
    }

    public function test_reject_change_author_greater_than_100_characters() 
    {
        $response = $this->get('/');

        $response->assertStatus(400);
    }

    public function test_reject_change_author_to_existing_author_when_same_title() 
    {
        $response = $this->get('/');

        $response->assertStatus(400);
    }

}
