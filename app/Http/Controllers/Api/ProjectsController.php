<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ProjectItem;
use App\Http\Requests\Api\ProjectRequest;
use App\Http\Requests\Api\ProjectItemsRequest;
use Auth;

class ProjectsController extends Controller
{
    public function store(ProjectRequest $request)
    {
        if($request->area != $request->above_area + $request->below_area){
            return formError('建筑总面积应等于正负零上下面积之和！');
        }
        $data = array_merge($request->all(),['user_id' => Auth::user()->id]);
        if($project = Project::create($data)){
            return formSuccess('新建项目成功！',$project);
        }else{
            return formError('新建项目失败！');
        }
    }

    public function projects()
    {
        return Project::orderBy('created_at','desc')->simplePaginate(10);
    }

    public function project_items_store(ProjectItemsRequest $request)
    {
        ProjectItem::where('project_id',$request->project_id)->whereNotIn('item_id',$request->items)->update(['status' => 0]);  // 删除没选择的供应类别
        foreach($request->items as $item_id)
        {
            ProjectItem::firstOrCreate(['project_id'=>$request->project_id,'item_id'=>$item_id]);
        }
        return formSuccess('保存成功！');
    }

    public function project_items(Request $request)
    {
        if(!$project = Project::find($request->project_id)){
            return formError('项目不存在！');
        }
        return $project->itemIds;
    }
}
