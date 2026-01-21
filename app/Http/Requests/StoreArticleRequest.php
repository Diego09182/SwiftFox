<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
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
            'title' => 'required|min:2|max:40',
            'content' => 'required|min:50|max:2000',
            'tag' => 'required|in:大學面試,競賽經驗,學習歷程,活動分享',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => '標題為必填項目',
            'title.min' => '標題至少需要2個字',
            'title.max' => '標題不能超過40個字',
            'content.required' => '內容為必填項目',
            'content.min' => '內容至少需要50個字',
            'content.max' => '內容不能超過2000個字',
            'tag.required' => '標籤為必填項目',
            'tag.in' => '標籤必須符合選項',
        ];
    }
}
