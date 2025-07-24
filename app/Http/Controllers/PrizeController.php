<?php

namespace App\Http\Controllers;

use App\Models\Prize;
use App\Services\PrizeService;
use Illuminate\Http\Request;

class PrizeController extends Controller
{
    protected PrizeService $prizeService;

    public function __construct(PrizeService $prizeService)
    {
        $this->prizeService = $prizeService;
    }

    public function index()
    {
        $prizes = Prize::orderBy('created_at', 'desc')->paginate(8);

        return view('swiftfox.prize.index', compact('prizes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'prize' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'prize.required' => '請輸入獎品名稱。',
            'prize.string' => '獎品名稱必須是文字格式。',
            'prize.max' => '獎品名稱最多 :max 個字。',
            'price.required' => '請輸入獎品點數。',
            'price.integer' => '點數必須是整數。',
            'price.min' => '點數不能小於 :min。',
            'quantity.required' => '請輸入獎品數量。',
            'quantity.integer' => '數量必須是整數。',
            'quantity.min' => '數量不能小於 :min。',
            'image.image' => '圖片格式錯誤。',
            'image.mimes' => '圖片只允許 jpg、jpeg、png 格式。',
            'image.max' => '圖片大小不能超過 2MB。',
        ]);

        $this->prizeService->createPrize($validated + ['image' => $request->file('image')]);

        return redirect()->route('prize.index')->with('success', '獎品新增成功！');
    }

    public function update(Request $request, Prize $prize)
    {
        $validated = $request->validate([
            'prize' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'prize.required' => '請輸入獎品名稱。',
            'prize.string' => '獎品名稱必須是文字格式。',
            'prize.max' => '獎品名稱最多 :max 個字。',
            'price.required' => '請輸入獎品點數。',
            'price.integer' => '點數必須是整數。',
            'price.min' => '點數不能小於 :min。',
            'quantity.required' => '請輸入獎品數量。',
            'quantity.integer' => '數量必須是整數。',
            'quantity.min' => '數量不能小於 :min。',
            'image.image' => '圖片格式錯誤。',
            'image.mimes' => '圖片只允許 jpg、jpeg、png 格式。',
            'image.max' => '圖片大小不能超過 2MB。',
        ]);

        $this->prizeService->updatePrize($prize, $validated + ['image' => $request->file('image')]);

        return redirect()->route('prize.index')->with('success', '獎品更新成功！');
    }

    public function destroy(Prize $prize)
    {
        $this->prizeService->deletePrize($prize);

        return redirect()->route('prize.index')->with('success', '獎品已刪除。');
    }
}
