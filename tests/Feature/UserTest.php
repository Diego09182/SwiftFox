<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function user_can_be_created()
    {
        $response = $this->post('/register', [
            'account' => 'testuser',
            'password' => 'password123',
            'email' => 'testuser@example.com',
            'name' => 'Test',
            'cellphone' => '0912345678',
            'birthday' => '2000-01-01',
        ]);

        $response->assertRedirect(route('main'));

        $this->assertDatabaseHas('users', ['account' => 'testuser']);
    }
}
