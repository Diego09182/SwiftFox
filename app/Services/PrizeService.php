<?php

namespace App\Services;

use App\Models\Prize;
use Illuminate\Support\Facades\Storage;

class PrizeService
{
    public function createPrize(array $data)
    {
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            $data['image'] = $data['image']->store('prizes', 'public');
        }

        return Prize::create($data);
    }

    public function updatePrize(Prize $prize, array $data)
    {
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            if ($prize->image && Storage::disk('public')->exists($prize->image)) {
                Storage::disk('public')->delete($prize->image);
            }

            $data['image'] = $data['image']->store('prizes', 'public');
        }

        $prize->update($data);

        return $prize;
    }

    public function deletePrize(Prize $prize)
    {
        if ($prize->image && Storage::disk('public')->exists($prize->image)) {
            Storage::disk('public')->delete($prize->image);
        }

        $prize->delete();
    }
}
