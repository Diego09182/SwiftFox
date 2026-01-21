<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVideoRequest extends FormRequest
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
            'video' => 'required|mimes:mp4,mov,ogg,qt|max:51200',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => '影片標題為必填',
            'title.min' => '影片標題至少需要2個字',
            'title.max' => '影片標題不能超過20個字',
            'content.required' => '影片內容為必填',
            'content.min' => '影片內容至少需要2個字',
            'content.max' => '影片內容不能超過50個字',
            'video.required' => '影片檔案必須上傳',
            'video.mimes' => '影片格式僅限 mp4, mov, ogg, qt',
            'video.max' => '影片大小不可超過50MB',
        ];
    }
}
