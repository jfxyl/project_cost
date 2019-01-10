<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        // 参数验证错误的异常，我们需要返回 400 的 http code 和一句错误信息
        if ($exception instanceof ValidationException) {
            return response(['status' => 2,'msg' => array_first(array_collapse($exception->errors()))]);
        }
        // 用户认证的异常，我们需要返回 401 的 http code 和错误信息
        if ($exception instanceof UnauthorizedHttpException) {
            return response(['status' => 1,'msg' => $exception->getMessage()]);
        }
        return parent::render($request, $exception);
    }
    // public function render($request, Exception $exception)
    // {
    //     return parent::render($request, $exception);
    // }

    // protected function unauthenticated($request, AuthenticationException $exception)
    // {
    //     if($request->expectsJson()){
    //         $response=response()->json([
    //                 'status'=>1,
    //                 'msg' => $exception->getMessage(),
    //                 'errors'=>[],
    //             ], 200);
    //     }else{
    //         $response=redirect()->guest(route('login'));
    //     }
    //     return $response;
    // }

    // public function convertValidationExceptionToResponse(ValidationException $exception, $request)
    // {
    //     $data = $exception->validator->getMessageBag();
    //     $msg = collect($data)->first();
    //     if(is_array($msg)){
    //         $msg = $msg[0];
    //     }
    //     if($request->expectsJson()){
    //         $response=response()->json([
    //                 'status'=>2,
    //                 'msg' => $msg,
    //             ], 200);
    //     }else{
    //         return redirect()->back()->withErrors(['msg' => $msg]);
    //     }
    //     return $response;
    // }
}
