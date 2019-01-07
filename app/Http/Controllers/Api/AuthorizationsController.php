<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\Api\AuthorizationRequest;
use App\Models\User;
use Auth;

class AuthorizationsController extends Controller
{
    public function login(AuthorizationRequest $request)
    {
        $phone = $request->phone;
        $password = $request->password;
        if (!$token = Auth::attempt(['phone' => $phone, 'password' => $password])) {
            return formError('密码错误！');
        }
        return $this->response->array(formSuccess('登陆成功！'))->withHeader('Authorization','Bearer '.Auth::fromUser(Auth::user()));
    }
}
