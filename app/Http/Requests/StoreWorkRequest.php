<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWorkRequest extends FormRequest
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
            'name' => 'required|min:2|max:20',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => '作品集名稱為必填項目',
            'name.min' => '作品集名稱至少需要2個字',
            'name.max' => '作品集名稱不能超過20個字',
        ];
    }
}
