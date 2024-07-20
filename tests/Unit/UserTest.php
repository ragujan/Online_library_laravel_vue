<?php

namespace Tests\Unit;
use Log;
use Tests\TestCase;


class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        Log::info("hey");
    }
}