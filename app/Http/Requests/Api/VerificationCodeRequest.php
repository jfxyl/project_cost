<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class VerificationCodeRequest extends FormRequest
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
        $rules = [];
        switch($this->type)
        {
            case 'register':
                $rules = [
                    'phone' => ['bail','required','regex:/^1\d{10}$/','unique:users'],
                ];
                break;
            case 'modifyPassword':
                $rules = [
                    'phone' => ['bail','required','regex:/^1\d{10}$/','exists:users'],
                ];
                break;
            default:
                die(json_encode(formError('系统错误！')));
                break;
        }
        return $rules;
    }

    public function attributes()
    {
        return [
            'phone' => '手机号'
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute 不能为空！',
            'regex' => ':attribute 格式不正确！',
            'unique' => ':attribute 已存在！',
            'exists' => ':attribute 尚未注册！',
        ];
    }
}
