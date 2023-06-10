<?php

namespace Tests\Feature;

use Tests\TestCase;

class FallbackTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function application_returns_a_successful_response()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function application_returns_a_successful_response_when_fallback()
    {
        $response = $this->get('/asdasdasdasdasd');

        $response->assertStatus(200);
    }
}
