<?php

namespace App\Services;

use App\Models\Opinion;

class OpinionService
{
    public function checkOpinionLimit()
    {
        $opinionCount = Opinion::count();
        $maxOpinionCount = 500;

        if ($opinionCount >= $maxOpinionCount) {
            throw new \Exception('投票事項數量已達到系統限制');
        }
    }
}
