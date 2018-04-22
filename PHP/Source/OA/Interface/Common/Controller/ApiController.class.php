<?php

/**
 * Api公共类
 * Interface引用api模式，没有display等view的渲染和页面模版输出
 */
namespace Common\Controller;
use Think\Controller;

/* 状态码说明:
 * 401 => 登录过期
 */

class ApiController extends Controller {
    

    protected function _initialize() {
        
        // 验证token 
       $token = $_SERVER['HTTP_LOGINTOKEN'];
       $model = D('User');
       // 查询用户表中的token的最后期限是否大于当前时间
       $result = $model -> where("token='" . $token . "' and deadline>" . time())
               ->find();
       if (!$result) {// 登录过期
           $this ->jsonPrint('登录过期', 401, false);
       }
  
    }
    
        /**
     * 公共错误返回
     * @param $msg 需要打印的错误信息
     * @param $code 默认打印200信息
     */
    public function jsonPrint($msg='', $code=200, $result=false, $data=''){
        $result = array(
            'code' => $code,
            'msg' => $msg,
            'result' => $result,
            'data' => $data,    
        );
        $this->ajaxReturn($result);exit;
    }
   
    
}

