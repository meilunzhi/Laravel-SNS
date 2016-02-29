<?php
namespace App\Utils;

/**
 * 工具类
 * User: USER
 * Date: 2016/1/11
 * Time: 9:36
 */
class Utils{
    /**
     * 请求不合法
     * @param string $status
     * @param string $msg
     * @return string
     */
    public static function error($result='',$status = 'error',$msg = '请求失败'){
        return json_encode([
            'status' => $status,
            'msg'    => $msg,
            'result' => $result
        ]);
    }

    /**
     * 请求成功
     * @param $result
     * @return string
     */
    public static function success($result='',$status = 'success',$msg = '请求成功'){
        return json_encode([
            'status' => $status,
            'msg'    => $msg,
            'result' => $result
        ]);
    }
}