<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\OpinionController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\WorkController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProfileController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Laravel版本
Route::get('/', function () {
    return view('welcome');
});

// 登入首頁
Route::get('/swiftfox/welcome', function () {
    return view('swiftfox.welcome');
});

// 登入
Route::post('/swiftfox/login', [AuthController::class, 'login'])->name('login');

// 註冊
Route::post('/swiftfox/register', [AuthController::class, 'register'])->name('register');

// 身分驗證
Route::middleware(['auth'])->group(function () {

    //首頁
    Route::get('/swiftfox/main', function () {
        return view('swiftfox.main');
    })->name('main');

    //登出
    Route::get('/swiftfox/logout', [AuthController::class, 'logout'])->name('logout');

    // 論壇系統
    // 認同貼文
    Route::post('/swiftfox/forum/post/{post}/like', [PostController::class, 'like'])->name('forum.like');
    // 不認同貼文
    Route::post('/swiftfox/forum/post/{post}/dislike', [PostController::class, 'dislike'])->name('forum.dislike');
    // 顯示所有貼文
    Route::get('/swiftfox/forum', [PostController::class, 'index'])->name('forum.index');
    // 顯示單個貼文
    Route::get('/swiftfox/forum/{post}/comment', [PostController::class, 'show'])->name('forum.show');
    // 發布貼文
    Route::post('/swiftfox/forum/post', [PostController::class, 'store'])->name('forum.store');
    // 刪除貼文
    Route::delete('/swiftfox/forum/post/{post}', [PostController::class, 'destroy'])->name('forum.destroy');
    // 發布評論
    Route::post('/swiftfox/forum/post/{post}/comment', [CommentController::class, 'store'])->name('comment.store');
    // 刪除評論
    Route::delete('/swiftfox/forum/post/{post}/comment/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy');

    // 個人系統
    // 個人資訊
    Route::get('/swiftfox/profile', [ProfileController::class, 'index'])->name('profile.index');
    // 個人資訊更新
    Route::put('/swiftfox/profile', [ProfileController::class, 'update'])->name('profile.update');

    // 顯示所有日記
    Route::get('/swiftfox/home', [NoteController::class, 'index'])->name('home.index');
    // 顯示單個日記
    Route::get('/swiftfox/home/note/{note}', [NoteController::class, 'show'])->name('note.show');
    // 發布日記
    Route::post('/swiftfox/home/note', [NoteController::class, 'store'])->name('note.store');
    // 刪除日記
    Route::delete('/swiftfox/home/note/{note}', [NoteController::class, 'destroy'])->name('note.destroy');

    // 投票系統
    // 認同投票
    Route::post('/swiftfox/opinion/{opinion}/agree', [OpinionController::class, 'agree'])->name('opinion.agree');
    // 不認同投票
    Route::post('/swiftfox/opinion/{opinion}/disagree', [OpinionController::class, 'disagree'])->name('opinion.disagree');
    // 顯示所有投票
    Route::get('/swiftfox/opinions', [OpinionController::class, 'index'])->name('opinion.index');
    // 顯示單個投票
    Route::get('/swiftfox/opinion/{opinion}', [OpinionController::class, 'show'])->name('opinion.show');
    // 發布投票
    Route::post('/swiftfox/opinion', [OpinionController::class, 'store'])->name('opinion.store');
    // 刪除投票
    Route::delete('/swiftfox/opinion/{opinion}', [OpinionController::class, 'destroy'])->name('opinion.destroy');

    // 文章系統
    // 顯示所有文章
    Route::get('/swiftfox/articles', [ArticleController::class, 'index'])->name('article.index');
    // 顯示單個文章
    Route::get('/swiftfox/article/{article}', [ArticleController::class, 'show'])->name('article.show');
    // 發布文章頁面
    Route::get('/swiftfox/article', [ArticleController::class, 'create'])->name('article.create');
    // 發布文章
    Route::post('/swiftfox/article', [ArticleController::class, 'store'])->name('article.store');
    // 刪除文章
    Route::delete('/swiftfox/article/{article}', [ArticleController::class, 'destroy'])->name('article.destroy');

    // 檔案系統
    // 顯示所有作品
    Route::get('/swiftfox/works', [WorkController::class, 'index'])->name('work.index');
    // 顯示單個作品
    Route::get('/swiftfox/work/{work}/photo', [WorkController::class, 'show'])->name('work.show');
    // 發布作品
    Route::post('/swiftfox/work', [WorkController::class, 'store'])->name('work.store');
    // 刪除作品
    Route::delete('/swiftfox/work/{work}', [WorkController::class, 'destroy'])->name('work.destroy');
    // 發布相片
    Route::post('/swiftfox/work/{work}/photo', [PhotoController::class, 'store'])->name('photo.store');
    // 顯示單個照片
    Route::get('/swiftfox/work/{work}/photo/{photo}', [PhotoController::class, 'show'])->name('photo.show');
    // 刪除相片
    Route::delete('/swiftfox/work/{work}/photo/{photo}', [PhotoController::class, 'destroy'])->name('photo.destroy');
});