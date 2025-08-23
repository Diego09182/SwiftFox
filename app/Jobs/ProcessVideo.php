<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\VideoService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $videoData;

    public $userId;

    public function __construct(array $videoData, int $userId)
    {
        $this->videoData = $videoData;
        $this->userId = $userId;
    }

    public function handle(VideoService $videoService)
    {
        $this->videoData['user_id'] = $this->userId;

        $videoService->createVideo($this->videoData);

        $videoService->clearCache();

        $user = User::find($this->userId);

        if ($user) {
            $user->increment('points', 10);
        }
    }
}
