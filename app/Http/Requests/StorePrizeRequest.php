<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePrizeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'prize' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
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
        ];
    }
}
