<?php

namespace App\Services;

use App\Models\Video;

class VideoService
{
    public function checkVideoLimit()
    {
        $videoCount = Video::count();
        $maxVideoCount = 150;

        if ($videoCount >= $maxVideoCount) {
            throw new \Exception('影片數量已達到系統限制');
        }
    }
}
