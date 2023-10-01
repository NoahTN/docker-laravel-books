<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserExportTest extends TestCase
{
    // test for each: Include Titles and Authors, Include Only Titles, Include only Authors
    
    public function test_export_csv_no_data() 
    {
       $response = $this->get('/');

       $response->assertStatus(400);
    }

    public function test_export_XML_no_data() 
    {
       $response = $this->get('/');

       $response->assertStatus(400);
    }

    public function test_export_CSV_with_data() 
    {
       $response = $this->get('/');

       $response->assertStatus(400);
    }

    public function test_export_XML_with_data() 
    {
       $response = $this->get('/');

       $response->assertStatus(400);
    }
}
