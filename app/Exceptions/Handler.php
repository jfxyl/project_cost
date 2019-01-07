<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;

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
        return parent::render($request, $exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if($request->expectsJson()){
            $response=response()->json([
                    'status'=>1,
                    'msg' => $exception->getMessage(),
                    'errors'=>[],
                ], 200);
        }else{
            $response=redirect()->guest(route('login'));
        }
        return $response;
    }

    public function convertValidationExceptionToResponse(ValidationException $exception, $request)
    {
        $data = $exception->validator->getMessageBag();
        $msg = collect($data)->first();
        if(is_array($msg)){
            $msg = $msg[0];
        }
        if($request->expectsJson()){
            $response=response()->json([
                    'status'=>2,
                    'msg' => $msg,
                ], 200);
        }else{
            return redirect()->back()->withErrors(['msg' => $msg]);
        }
        return $response;
    }
}
