<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserExportTest extends DuskTestCase
{
    // test for each: Include Titles and Authors, Include Only Titles, Include only Authors
    
    public function test_exportCSV_noData_reject() 
    {
      $this->assertTrue(false);
    }

    public function test_exportCSV_data_succeed() 
    {
      $this->assertTrue(false);
    }

    public function test_exportXML_noData_reject() 
    {
      $this->assertTrue(false);
    }

    public function test_exportXML_data_succeed() 
    {
      $this->assertTrue(false);
    }
}
