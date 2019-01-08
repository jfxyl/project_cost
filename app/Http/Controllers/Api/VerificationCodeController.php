<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\Api\VerificationCodeRequest;
use GuzzleHttp\Client;

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
			$res = $this->sendSms(['Phones'=>$request->phone,'Content' => '您的示例验证码是：'.$code]);
			if(!$res['status']){
				return formError('短信发送失败（'.$res['msg'].'）！');
			}
        }
        
        $key = $this->types[$request->type].$request->phone;
        $expiredAt = now()->addMinutes(2);
        // 缓存验证码 2分钟过期。
        \Cache::put($key, $code, $expiredAt);
        return formSuccess('短信发送成功！');
	}
	
	private function sendSms($data)
	{
		$conf = [
			'UserName' => config('sms.UserName'),
			'Token' => config('sms.Token')
		];
		$data = array_merge($conf,$data);
		$xml = array2xml($data);
		$client = new Client();
		$response = $client->request('POST', 'https://api.bk.sh.cn:8081/sms_send.do', ['body' => $xml]);
		$body = $response->getBody();
		$arr = xml2array($body);
		if($arr['errcode'] == 0){
			return ['status' => true,'msg' => $arr['errmsg']];
		}else{
			return ['status' => false,'msg' => $arr['errmsg']];
		}
	}
}
