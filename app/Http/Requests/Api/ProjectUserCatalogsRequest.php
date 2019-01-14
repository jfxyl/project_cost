<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectUserCatalogsRequest extends FormRequest
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
            'project_id' => 'bail|required|exists:projects,id',
            'item_id' => ['bail','required',Rule::exists('project_items')->where(function ($query) {
                $query->where('project_id', $this->project_id)->where('status',1);
            })],
            'catalogs' => 'bail|required|array',
            'catalogs.*.catalog_id' => ['bail',Rule::exists('catalogs','id')->where(function ($query) {
                $query->where('item_id', $this->item_id);
            })],
            'catalogs.*.amount' => 'bail|required|numeric',
            //'remark' => 'bail',
        ];
    }

    public function attributes()
    {
        return [
            'project_id' => '项目id',
            'item_id' => '分项id',
            'remark' => '备注',
            'catalogs' => '条目',
            'catalogs.*.catalog_id' => '条目',
            'catalogs.*.amount' => '数量'
        ];
    }

    public function messages()
    {
        return [
            'required' => '系统错误！',
            'exists' => ':attribute 不存在！',
            'unique' => ':attribute 已存在！',
            'array' => '请填写类别！',
            'numeric' => ':attribute 应该为数字！',
        ];
    }
}
