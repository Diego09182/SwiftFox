<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'account' => 'required|string|min:5|max:8|unique:users,account',
            'password' => 'required|string|min:8|max:15',
            'name' => 'required|string|max:8',
            'email' => 'required|email|unique:users,email',
            'cellphone' => 'required|digits:10|unique:users,cellphone',
            'birthday' => 'required|date_format:Y-m-d',
        ];
    }

    public function messages(): array
    {
        return [
            'account.required' => '請填寫帳號',
            'account.string' => '帳號必須是字串',
            'account.min' => '帳號長度不能少於5個字',
            'account.max' => '帳號長度不能超過8個字',
            'account.unique' => '該帳號已經被使用',

            'password.required' => '請填寫密碼',
            'password.string' => '密碼必須是字串',
            'password.min' => '密碼長度不能少於8個字',
            'password.max' => '密碼長度不能超過15個字',

            'name.required' => '請填寫姓名',
            'name.max' => '姓名長度不能超過8個字',

            'email.required' => '請填寫信箱',
            'email.email' => '請填寫有效的信箱地址',
            'email.unique' => '該信箱已經被使用',

            'cellphone.required' => '請填寫手機號碼',
            'cellphone.digits' => '手機號碼必須是10位數字',
            'cellphone.unique' => '該手機號碼已經被使用',

            'birthday.required' => '請填寫生日',
        ];
    }
}
