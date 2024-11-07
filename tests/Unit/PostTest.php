<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 測試能否創建新文章
     */
    public function test_user_can_create_post()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/posts', [
            'title' => '測試文章標題',
            'content' => '這是一篇測試文章內容',
            'tag' => '測試',
            'view' => 0,
            'like' => 0,
            'dislike' => 0,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('posts', ['title' => '測試文章標題']);
    }
}
