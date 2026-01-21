<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePrizeRedemptionStatusRequest extends FormRequest
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
            'status' => 'required|string|in:pending,approved,shipped,canceled',
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => '請選擇兌換狀態。',
            'status.in' => '狀態必須為待處理、已審核、已出貨或已取消之一。',
        ];
    }
}
