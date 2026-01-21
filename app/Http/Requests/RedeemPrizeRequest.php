<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RedeemPrizeRequest extends FormRequest
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
            'quantity' => 'required|integer|min:1',
            'shipping_address' => 'required|string|max:255',
            'note' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'quantity.required' => '請輸入兌換數量。',
            'quantity.integer' => '兌換數量必須是整數。',
            'quantity.min' => '兌換數量至少為 :min。',
            'shipping_address.required' => '請輸入收件地址。',
            'shipping_address.string' => '收件地址格式錯誤。',
            'shipping_address.max' => '收件地址不能超過 :max 個字。',
            'note.string' => '備註內容格式錯誤。',
            'note.max' => '備註內容不能超過 :max 個字。',
        ];
    }
}
