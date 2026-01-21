<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClubRequest extends FormRequest
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
            'title' => 'required|min:2|max:10',
            'tag' => 'required',
            'content' => 'required|min:2|max:50',
            'teacher' => 'nullable',
            'director' => 'required',
            'vice_director' => 'nullable',
            'file' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => '標題為必填項目',
            'title.min' => '標題至少需要2個字',
            'title.max' => '標題不能超過10個字',

            'content.required' => '內容為必填項目',
            'content.min' => '內容至少需要2個字',
            'content.max' => '內容不能超過50個字',

            'tag.required' => '標籤為必填項目',
            'director.required' => '社長為必填項目',

            'file.image' => '檔案必須是圖片格式',
            'file.mimes' => '只接受 jpeg, png, jpg 格式圖片',
            'file.max' => '圖片大小不能超過2MB',
        ];
    }
}
