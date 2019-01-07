<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\Api\UserRequest;
use App\Http\Requests\Api\ModifyPasswordRequest;
use App\Http\Requests\Api\ModifyUserInfoRequest;
use App\Models\User;
use App\Models\UserSupplyCate;
use App\Http\Resources\User as UserResource;
use Auth;
use DB;

class UsersController extends Controller
{
    public function store(UserRequest $request)
    {
        $verifyData = \Cache::get('register_code_'.$request->phone);
        if (!$verifyData) {
            return formError('验证码已失效！');
        }
        if (!hash_equals($request->verification_code, $verifyData)) {
            // 返回401
            return formError('验证码错误！');
        }
        $user = User::create([
            'name' => $request->name,
            'company_name' => $request->company_name,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
        ]);
        // 清除验证码缓存
        \Cache::forget('register_code_'.$request->phone);
        return $this->response->array(formSuccess('注册成功！'))->withHeader('Authorization','Bearer '.Auth::fromUser($user));
    }

    public function modifyPassword(ModifyPasswordRequest $request)
    {
        // $verifyData = \Cache::get('modify_password_code_'.$request->phone);
        $verifyData = '1234';
        if (!$verifyData) {
            return formError('验证码已失效！');
        }
        if (!hash_equals($request->verification_code, $verifyData)) {
            return formError('验证码错误！');
        }
        $user = User::where('phone',$request->phone)->first();
        $user->password = bcrypt($request->password);
        $user->save();
        // 清除验证码缓存
        \Cache::forget('modify_password_code_'.$request->phone);
        return formSuccess('修改密码成功！');
    }

    public function me()
    {
        return new UserResource(Auth::user());
    }

    public function modifyUserInfo(ModifyUserInfoRequest $request)
    {
        DB::beginTransaction();
        try{
            $user = Auth::user();
            $user->company_name = $request->company_name;
            $user->wechat = $request->wechat;
            $user->save();
            UserSupplyCate::where('user_id',$user->id)->whereNotIn('supply_cate_id',$request->supply_cates)->delete();  // 删除没选择的供应类别
            foreach($request->supply_cates as $supply_cate_id)
            {
                UserSupplyCate::firstOrCreate(['user_id'=>$user->id,'supply_cate_id'=>$supply_cate_id]);
            }
            DB::commit();
            return formSuccess('修改个人资料成功！');
        }catch (\Exception $e){
            DB::rollBack();
            return formError('修改个人资料失败！');
        }
    }
}
