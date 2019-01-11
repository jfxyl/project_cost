<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Auth;
class ModifyUserInfoRequest extends FormRequest
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
            'company_name' => 'bail|required|between:2,20',
            'wechat' => ['bail','regex:/^[a-zA-Z][\w\d-]{5,19}$/','nullable',Rule::unique('users')->ignore(Auth::user()->id)],
            'items' => 'bail|required|array',
            'items.*' => 'bail|required|exists:items,id'
        ];
    }

    public function attributes()
    {
        return [
            'company_name' => '公司名称',
            'wechat' => '微信号',
            'items' => '供应类别',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute 不能为空！',
            'between' => ':attribute 长度应在:min - :max之间！',
            'regex' => ':attribute 格式不正确！',
            'unique' => ':attribute 已被使用！',
            'array' => ':attribute 至少选一个！',
            'items.*.exists' => '供应类别 不存在！'
        ];
    }
}
