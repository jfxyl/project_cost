<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class AuthorizationRequest extends FormRequest
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
            'phone' => ['bail','required','regex:/^1\d{10}$/','exists:users'],
            'password' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'phone' => '手机号',
            'password' => '密码',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute 不能为空！',
            'regex' => ':attribute 格式不正确！',
            'exists' => ':attribute 尚未注册！'
        ];
    }
}
