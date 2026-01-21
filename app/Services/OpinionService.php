<?php

namespace App\Services;

use App\Models\Opinion;
use App\Models\Record;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class OpinionService
{
    protected string $cacheTag = 'opinions';

    public function getOpinions()
    {
        $page = request('page', 1);

        return Cache::tags([$this->cacheTag])
            ->remember($this->cacheKey("index_page_{$page}"), 600, fn () => Opinion::orderByDesc('id')->paginate(3));
    }

    public function getOpinionById(int $id)
    {
        return Cache::tags([$this->cacheTag])
            ->remember($this->cacheKey("show_{$id}"), 600, fn () => Opinion::findOrFail($id));
    }

    public function createOpinion(array $data)
    {
        $data['content'] = nl2br($data['content']);
        $data['user_id'] = Auth::id();

        $opinion = Opinion::create($data);
        $this->clearCache();

        return $this->success($opinion->fresh());
    }

    public function deleteOpinion(Opinion $opinion)
    {
        $opinion->delete();
        $this->clearCache();

        return $this->success();
    }

    public function vote(Opinion $opinion, string $voteType)
    {
        $userId = Auth::id();

        if ($this->userVoted($userId, $opinion->id)) {
            return $this->fail('您已經對這個投票進行過投票！');
        }

        if ($voteType === 'agree') {
            $opinion->increment('agree');
        } elseif ($voteType === 'disagree') {
            $opinion->increment('disagree');
        }

        $opinion->increment('count');
        Record::create(['user_id' => $userId, 'opinion_id' => $opinion->id]);
        $this->clearCache($opinion->id);

        return $this->success($opinion->fresh());
    }

    protected function userVoted(int $userId, int $opinionId): bool
    {
        return Record::where('user_id', $userId)->where('opinion_id', $opinionId)->exists();
    }

    protected function cacheKey(string $key): string
    {
        return "{$this->cacheTag}_{$key}";
    }

    protected function clearCache(?int $id = null): void
    {
        Cache::tags([$this->cacheTag])->flush();
        if ($id) {
            Cache::tags([$this->cacheTag])->forget($this->cacheKey("show_{$id}"));
        }
    }

    protected function success($data = null, ?string $message = null): array
    {
        return ['success' => true, 'message' => $message, 'data' => $data];
    }

    protected function fail(string $message): array
    {
        return ['success' => false, 'message' => $message, 'data' => null];
    }
}
