<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_post()
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

        $user = User::where('account', 'testuser')->first();

        $response = $this->actingAs($user)->post('/forum/post', [
            'title' => '測試文章標題',
            'content' => '這是一篇測試文章內容',
            'tag' => '學科問題',
            'view' => 0,
            'like' => 0,
            'dislike' => 0,
            'user_id' => $user->id,
        ]);

        $response->assertRedirect(route('forum.index'));

        $this->assertDatabaseHas('posts', [
            'title' => '測試文章標題',
            'content' => '這是一篇測試文章內容',
            'tag' => '學科問題',
            'view' => 0,
            'like' => 0,
            'dislike' => 0,
            'user_id' => $user->id,
        ]);
    }
}
