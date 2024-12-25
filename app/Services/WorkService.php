<?php

namespace App\Services;

use App\Models\Work;
use Illuminate\Support\Facades\Auth;

class WorkService
{
    public function checkWorkLimit()
    {
        $workCount = Work::where('user_id', Auth::id())->count();

        if ($workCount >= 10) {
            throw new \Exception('您已達到作品數量限制');
        }
    }

    public function createWork($validatedData)
    {
        $work = new Work($validatedData);
        $work->user_id = Auth::id();
        $work->save();

        return $work;
    }

    public function getWorksByPage($page = 1)
    {
        return Work::orderBy('id', 'desc')->paginate(6);
    }

    public function getWorkById($id)
    {
        return Work::with('photos')->findOrFail($id);
    }

    public function deleteWork($id)
    {
        $work = Work::findOrFail($id);
        $work->delete();
    }
}
