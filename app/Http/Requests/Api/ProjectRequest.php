<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Auth;
use Illuminate\Auth\AuthenticationException;

class ProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->isAdmin();
    }

    protected function failedAuthorization()
    {
        throw new AuthenticationException('此功能需要管理员权限！');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'bail|required|between:2,20|unique:projects',
            'area' => 'bail|required|numeric',
            'above_area' => 'bail|required|numeric',
            'above_open_ratio' => 'bail|required|numeric',
            'below_area' => 'bail|required|numeric',
            'below_open_ratio' => 'bail|required|numeric',
            'reference_price' => 'bail|required|numeric',
            'intro' => 'bail|required',
            'attachment' => 'bail|file'
        ];
    }

    public function attributes()
    {
        return [
            'name' => '项目名',
            'area' => '总建筑面积',
            'above_area' => '正负零以上建筑面积',
            'above_open_ratio' => '展开系数',
            'below_area' => '正负零以下建筑面积',
            'below_open_ratio' => '展开系数',
            'reference_price' => '对比价',
            'intro' => '项目介绍',
            'attachment' => '附件',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute 不能为空！',
            'between' => ':attribute 长度应在:min - :max之间！',
            'numeric' => ':attribute 应该为数字！',
            'unique' => ':attribute 已存在！',
            'file' => ':attribute 必须是文件！',
        ];
    }
}
