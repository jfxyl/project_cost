<?php

function formSuccess($msg = '修改成功！')
{
    return ['status' => 0,'msg' => $msg];
}

function authError($msg = '认证失败，请先登录！'){
    return ['status' => 1,'msg' => $msg];
}

function formError($msg = '未知错误！')
{
    return ['status' => 2,'msg' => $msg];
}