<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchBooksTest extends TestCase
{
    // consider whitespace and trim accordingly
    // consider pagination after initial functionality built

    public function test_return_all_books_from_DB_when_no_search_query() 
    {
        $this->assertTrue(false);
    }

    public function test_return_no_books_from_DB_when_no_titles_or_authors_contain_word_with_beginning_characters_matching_search_query() 
    {
        $this->assertTrue(false);
    }

    public function test_return_books_with_title_or_author_containing_a_word_with_beginning_charcters_matching_search_query() 
    {
        $this->assertTrue(false);
    }

}
