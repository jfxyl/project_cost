<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ProjectItem;
use App\Models\ProjectUserCatalog;
use App\Http\Requests\Api\ProjectRequest;
use App\Http\Requests\Api\ProjectItemsRequest;
use App\Http\Requests\Api\ProjectUserCatalogsRequest;
use Auth;
use Illuminate\Support\Facades\Storage;
use DB;

class ProjectsController extends Controller
{
    public function store(ProjectRequest $request)
    {
        if($request->area != $request->above_area + $request->below_area){
            return formError('建筑总面积应等于正负零上下面积之和！');
        }
        if($request->attachment){
            $realpath = $request->attachment->store('public/uploads');
        }
        $data = array_merge($request->except('attachment'),['user_id' => Auth::user()->id],isset($realpath)?['attachment'=>$realpath]:[]);
        if($project = Project::create($data)){
            return formSuccess('新建项目成功！',$project);
        }else{
            Storage::delete($project->attachment);
            return formError('新建项目失败！');
        }
    }

    public function projects()
    {
        return Project::orderBy('created_at','desc')->paginate(10);
    }

    public function projectItemsStore(ProjectItemsRequest $request)
    {
        ProjectItem::where('project_id',$request->project_id)->whereNotIn('item_id',$request->items)->update(['status' => 0]);  // 删除没选择的供应类别
        foreach($request->items as $item_id)
        {
            ProjectItem::updateOrCreate(['project_id'=>$request->project_id,'item_id'=>$item_id],['status'=>1]);
        }
        return formSuccess('保存成功！');
    }

    public function project(Request $request)
    {
        return Project::find($request->project_id);
    }

    public function projectItems(Request $request)
    {
        if(!$project = Project::find($request->project_id)){
            return formError('项目不存在！');
        }
        return $project->itemIds;
    }

    public function projectUserCatalogsStore(ProjectUserCatalogsRequest $request)
    {
        $user = Auth::user();
//        DB::beginTransaction();
//        try{
            foreach($request->catalogs as $catalog)
            {
                ProjectUserCatalog::firstOrCreate([
                    'project_id'=>$request->project_id,
                    'user_id'=>$user->id,
                    'catalog_id'=>$catalog['catalog_id']
                ],['amount'=>$catalog['amount']]);
            }
            if(!$request->remark){
                $request->remark = '';
            }
            ProjectItem::where('project_id',$request->project_id)->where('item_id',$request->item_id)->update(['remark'=>$request->remark]);
//            DB::commit();
//            return formSuccess('保存成功！');
//        }catch (\Exception $e){
//            DB::rollBack();
//            return formError('保存失败！');
//        }
    }
}
