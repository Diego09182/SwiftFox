<?php

namespace App\Services;

use App\Models\Work;

class WorkService
{
    public function checkWorkLimit()
    {
        $workCount = Work::count();
        $maxWorkCount = 100;

        if ($workCount >= $maxWorkCount) {
            throw new \Exception('作品集數量已達到系統限制');
        }
    }
}
