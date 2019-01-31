<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'current_password' => 'required',
            'password' => 'required|string|min:6',
            'password_confirmation' => 'required|same:password',
        ];
    }

    public function attributes()
    {
        return [
            'password_confirmation' => '確認密碼',
        ];
    }

    public function messages()
    {
        return [
            'current_password.required' => '請輸入帳號現在密碼',
            'password.required' => '請輸入密碼',
        ];
    }
}
