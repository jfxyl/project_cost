<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\Api\VerificationCodeRequest;

class VerificationCodeController extends Controller
{
    protected $types = [
        'register' => 'register_code_',
        'modifyPassword' => 'modify_password_code_',
    ];

    public function verificationCode(VerificationCodeRequest $request)
    {
		if (!app()->environment('production')) {
			$code = '1234';
		} else {
			// 生成4位随机数，左侧补0
			$code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);
			try {
				$result = $easySms->send($request->phone, [
					'template' => '200437',
					'data' => [
						$code,
						2
					],
				]);
			} catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception) {
				$message = $exception->getException('yunpian')->getMessage();
				return $this->response->errorInternal($message ?? '短信发送异常');
			}
        }
        
        $key = $this->types[$request->type].$request->phone;
        $expiredAt = now()->addMinutes(2);
        // 缓存验证码 2分钟过期。
        \Cache::put($key, $code, $expiredAt);
        return formSuccess('短信发送成功！');
    }
}
