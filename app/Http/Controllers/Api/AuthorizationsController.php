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
        $user = Auth::user();
        dump($user->isAdmin());
        dd($token);
    }
}
