<?php

namespace App\Services;

use App\Models\Opinion;
use App\Models\Record;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class OpinionService
{
    public function hasUserVoted($userId, $opinionId)
    {
        return Record::where('user_id', $userId)
            ->where('opinion_id', $opinionId)
            ->exists();
    }

    public function vote($userId, $opinion, $voteType)
    {
        if ($this->hasUserVoted($userId, $opinion->id)) {
            throw new \Exception('您已經對這個投票進行過投票！');
        }

        if ($voteType == 'agree') {
            $opinion->agree++;
        } elseif ($voteType == 'disagree') {
            $opinion->disagree++;
        }

        $opinion->count++;
        $opinion->save();

        Record::create([
            'user_id' => $userId,
            'opinion_id' => $opinion->id,
        ]);

        $this->clearCache($opinion);

        return $opinion;
    }

    public function incrementAgree(Opinion $opinion)
    {
        $opinion->agree++;
        $opinion->count++;
        $opinion->save();

        $this->clearCache($opinion);

        return $opinion;
    }

    public function incrementDisagree(Opinion $opinion)
    {
        $opinion->disagree++;
        $opinion->count++;
        $opinion->save();

        $this->clearCache($opinion);

        return $opinion;
    }

    public function getOpinionsByPage(int $page)
    {
        $cacheKey = 'opinions_index_page_'.$page;

        return Cache::tags(['opinions'])->remember($cacheKey, 600, function () {
            return Opinion::orderBy('id', 'desc')->paginate(3);
        });
    }

    public function createOpinion(array $data)
    {
        $data['content'] = nl2br($data['content']);
        $data['user_id'] = Auth::id();

        $opinion = Opinion::create($data);

        $this->clearCache();

        return $opinion;
    }

    public function getOpinionById(int $id)
    {
        $cacheKey = 'opinion_'.$id;

        return Cache::tags(['opinions'])->remember($cacheKey, 600, function () use ($id) {
            return Opinion::findOrFail($id);
        });
    }

    public function deleteOpinion(Opinion $opinion)
    {
        $opinion->delete();

        $this->clearCache($opinion);
    }

    private function clearCache(?Opinion $opinion = null)
    {
        Cache::tags(['opinions'])->flush();

        if ($opinion) {
            Cache::forget('opinion_'.$opinion->id);
        }
    }
}
