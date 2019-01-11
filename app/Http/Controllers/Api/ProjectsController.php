<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Http\Requests\Api\ProjectRequest;
use Auth;

class ProjectsController extends Controller
{
    public function store(ProjectRequest $request)
    {
        if($request->area != $request->above_area + $request->below_area){
            return formError('建筑总面积应等于正负零上下面积之和！');
        }
        $data = array_merge($request->all(),['user_id' => Auth::user()->id]);
        if(Project::create($data)){
            return formSuccess('新建项目成功！');
        }else{
            return formError('新建项目失败！');
        }
    }

    public function projects()
    {
        return Project::orderBy('created_at','desc')->simplePaginate(10);
    }
}
