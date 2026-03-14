<?php

namespace App\Services;

use App\Models\Opinion;
use App\Models\Record;
use DomainException;
use Illuminate\Support\Facades\Auth;
use InvalidArgumentException;

class OpinionService extends AbstractService
{
    protected string $cacheTag = 'opinions';

    protected function getModelClass(): string
    {
        return Opinion::class;
    }

    public function getOpinions(int $perPage = 3)
    {
        $page = request('page', 1);
        $key = $this->cacheKey("index_page_{$page}_{$perPage}");

        return $this->rememberEmpty($key, 600, fn () => Opinion::orderByDesc('id')->paginate($perPage));
    }

    public function getOpinionById(int $id): Opinion
    {
        $key = $this->cacheKey("show_{$id}");

        return $this->rememberEmpty($key, 600, fn () => Opinion::findOrFail($id));
    }

    public function createOpinion(array $data): Opinion
    {
        $data['content'] = nl2br($data['content']);
        $data['user_id'] = Auth::id();
        $opinion = Opinion::create($data);
        $this->clearCache();

        return $opinion->fresh();
    }

    public function deleteOpinion(Opinion $opinion): void
    {
        $opinion->delete();
        $this->clearCache($opinion->id);
    }

    public function vote(Opinion $opinion, string $voteType): Opinion
    {
        $userId = Auth::id();

        if ($this->userVoted($userId, $opinion->id)) {
            throw new DomainException('您已經對這個議題投過票');
        }

        match ($voteType) {
            'agree' => $opinion->increment('agree'),
            'disagree' => $opinion->increment('disagree'),
            default => throw new InvalidArgumentException('不合法的投票類型'),
        };

        $opinion->increment('count');

        Record::create([
            'user_id' => $userId,
            'opinion_id' => $opinion->id,
        ]);

        $this->clearCache($opinion->id);

        return $opinion->fresh();
    }

    protected function userVoted(int $userId, int $opinionId): bool
    {
        return Record::where('user_id', $userId)
            ->where('opinion_id', $opinionId)
            ->exists();
    }

    public function clearCache(?int $id = null): void
    {
        if ($id) {
            $this->flushCache($this->cacheKey("show_{$id}"));
        }
        $this->flushCache();
    }
}
