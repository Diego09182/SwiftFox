<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\FileService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $validatedData;

    public $userId;

    public function __construct(array $validatedData, $userId)
    {
        $this->validatedData = $validatedData;
        $this->userId = $userId;
    }

    public function handle(FileService $fileService)
    {
        $this->validatedData['user_id'] = $this->userId;

        $fileService->createFile($this->validatedData);

        $user = User::find($this->userId);

        if ($user) {
            $user->increment('points', 10);
        }
    }
}
