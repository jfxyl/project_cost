<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ModifyPasswordRequest extends FormRequest
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
            'verification_code' => 'required',
            'password' => 'bail|required|between:6,16|alpha_num|confirmed'
        ];
    }

    public function attributes()
    {
        return [
            'phone' => '手机号',
            'verification_code' => '验证码',
            'password' => '密码',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute 不能为空！',
            'between' => ':attribute 长度应在:min - :max之间！',
            'regex' => ':attribute 格式不正确！',
            'exists' => ':attribute 尚未注册！',
            'password.between' => '密码 应为:min-:max位的数字字母组合!',
            'alpha_num' => ':attribute 应为数字与字母的组合！',
            'confirmed' => '两次密码不相同！'
        ];
    }
}
