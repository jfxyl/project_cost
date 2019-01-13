<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Project;
use Auth;

class ProjectItemsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $project = Project::find($this->project_id);
        return Auth::user()->id == $project->user_id;
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
            'items' => 'bail|required|array',
            'items.*' => 'bail|required|exists:items,id'
        ];
    }

    public function attributes()
    {
        return [
            'project_id' => '项目id',
            'items' => '分项',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute 不能为空！',
            'array' => ':attribute 至少选一个！',
            'project_id.exists' => '系统错误！',
            'items.*.exists' => '分项 不存在！'
        ];
    }
}
