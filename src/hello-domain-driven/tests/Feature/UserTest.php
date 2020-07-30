<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

// TODO ほんとは、UserApplicationができたらそこを切り出したテストがいいかも

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_user()
    {
        $request = ['name' => 'tarou', 'email' => 'a@a.com'];

        $this->withoutExceptionHandling();
        $response = $this->postJson('/api/users', $request);

        $response->assertStatus(200);

        // あんまよくない
        //$this->assertDatabaseHas('users', $request);
    }
}
