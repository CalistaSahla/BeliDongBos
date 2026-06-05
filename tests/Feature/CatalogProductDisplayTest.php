<?php

namespace Tests\Feature;

use Tests\TestCase;

class CatalogProductDisplayTest extends TestCase
{
    public function test_catalog_route_exists()
    {
        $response = $this->get('/');

        $response->assertRedirect(route('catalog.index'));
    }
}