<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreActivityRequest extends FormRequest
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
            'title' => 'required|min:2|max:20',
            'content' => 'required|min:2|max:50',
            'location' => 'required',
            'date' => 'required|date',
            'url' => 'nullable|url',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:4096',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => '標題為必填項目',
            'title.min' => '標題至少需要2個字',
            'title.max' => '標題不能超過20個字',
            'content.required' => '內容為必填項目',
            'content.min' => '內容至少需要2個字',
            'content.max' => '內容不能超過50個字',
            'location.required' => '地點為必填項目',
            'date.required' => '日期為必填項目',
            'date.date' => '日期格式錯誤',
            'url.url' => '請輸入正確的網址格式',
            'file.image' => '上傳的檔案必須是圖片格式',
            'file.mimes' => '圖片格式僅限 jpeg, png, jpg, svg',
            'file.max' => '圖片大小不可超過 4MB',
        ];
    }
}
