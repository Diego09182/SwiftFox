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
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);

        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/forum/post', [
            'title' => '測試文章標題',
            'content' => '這是一篇測試文章內容',
            'tag' => '學習問題',
        ]);

        $response->assertRedirect(route('forum.index'));

        $this->assertDatabaseCount('posts', 1);

        $this->assertDatabaseHas('posts', [
            'title' => '測試文章標題',
            'content' => '這是一篇測試文章內容',
            'tag' => '學習問題',
            'user_id' => $user->id,
            'view' => 0,
            'like' => 0,
            'dislike' => 0,
        ]);
    }

}
