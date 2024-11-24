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
        // 創建測試用戶
        $response = $this->post('/register', [
            'account' => 'testuser',
            'password' => 'password123',
            'email' => 'testuser@example.com',
            'name' => 'Test',
            'cellphone' => '0912345678',
            'birthday' => '2000-01-01',
        ]);

        $response->assertRedirect(route('main'));

        // 重新取得該用戶，並執行登入
        $user = User::where('account', 'testuser')->first();

        // 模擬用戶登入並發送發文請求
        $response = $this->actingAs($user)->post('/forum/posts', [
            'title' => '測試文章標題',
            'content' => '這是一篇測試文章內容',
            'tag' => '學科問題',
            'view' => 0,
            'like' => 0,
            'dislike' => 0,
            'user_id' => $user->id,
        ]);

        // 確保發文後重定向至論壇列表頁面
        $response->assertRedirect(route('forum.index'));

        // 確認資料是否正確儲存於資料庫
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
