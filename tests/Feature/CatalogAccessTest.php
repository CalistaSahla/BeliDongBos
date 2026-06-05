<?php

namespace Tests\Feature;

use Tests\TestCase;

class CatalogAccessTest extends TestCase
{
    public function test_home_redirects_to_catalog()
    {
        $response = $this->get('/');

        $response->assertRedirect(route('catalog.index'));
    }
}