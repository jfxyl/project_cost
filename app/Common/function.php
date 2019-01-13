<?php

function formSuccess($msg = '修改成功！',$data = null)
{
    return $data?['status' => 0,'msg' => $msg,'data'=>$data]:['status' => 0,'msg' => $msg];
}

function authError($msg = '认证失败，请先登录！'){
    return ['status' => 1,'msg' => $msg];
}

function formError($msg = '未知错误！')
{
    return ['status' => 2,'msg' => $msg];
}

function array2xml($data,$tag = '')
{
    $xml = '<xml>';
    foreach($data as $key => $value)
    {
        if(is_numeric($key))
        {
            if(is_array($value))
            {
                $xml .= "<$tag>";
                $xml .= array2xml($value);
                $xml .="</$tag>";
            }
            else
            {
                $xml .= "<$tag>$value</$tag>";
            }    
        }
        else
        {
            if(is_array($value))
            {
                $keys = array_keys($value);
                if(is_numeric($keys[0]))
                {
                    $xml .=array2xml($value,$key);
                }
                else
                {
                    $xml .= "<$key>";
                    $xml .=array2xml($value);
                    $xml .= "</$key>";
                }
            }
            else
            {
                $xml .= "<$key>$value</$key>";
            }
        }
    }
    $xml .= '</xml>';
    return $xml;
}

function xml2array($xmlString = '')
{
    $targetArray = array();
    $xmlObject = simplexml_load_string($xmlString);
    $mixArray = (array)$xmlObject;
    foreach($mixArray as $key => $value)
    {
        if(is_string($value))
        {
            $targetArray[$key] = $value;
        }
        if(is_object($value))
        {
            $targetArray[$key] = xml2array($value->asXML());
        }
        if(is_array($value))
        {
            foreach($value as $zkey => $zvalue)
            {
                if(is_numeric($zkey))
                {
                    $targetArray[$key][] = xml2array($zvalue->asXML());
                }
                if(is_string($zkey))
                {
                    $targetArray[$key][$zkey] = xml2array($zvalue->asXML());
                }
            }
        }
    }
    return $targetArray;
}
