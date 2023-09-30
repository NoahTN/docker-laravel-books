<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddBookTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testRejectAddingBookWithNoTitleAndNoAuthor() {
        $response = $this->get('/');

        $response->assertStatus(400);
    }

    public function testRejectAddingBookWitAuthorButNoTitle() {
        $response = $this->get('/');

        $response->assertStatus(400);
    }

    public function testRejectAddingBookWithTitleButNoAuthor() {
        $response = $this->get('/');

        $response->assertStatus(400);
    }

    public function testRejectAddingBookWithExistingTitleAndExistingAuthor() {
        $response = $this->get('/');

        $response->assertStatus(400);
    }

    public function testAllowAddingBookWithExistingTitleButDifferentAuthor() {
        $response = $this->get('/');

        $response->assertStatus(400);
    }

    public function testAllowAddingBookWithExistingAUthorButDifferentTitle() {
        $response = $this->get('/');

        $response->assertStatus(400);
    }

    public function testRejectAddingBookWithTitleLongerThan100Characters() {
        $response = $this->get('/');

        $response->assertStatus(400);
    }

}
