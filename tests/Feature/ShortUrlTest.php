<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShortUrlTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_short_url_creation(): void
    {
        $response = $this->post('/shorten', [
            'original_url' => 'Google.com',
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'short_url',
        ]);
    }

    
}
