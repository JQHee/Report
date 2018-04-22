<?php

namespace Api\Controller;
use Think\Controller;

// 公共接口
class AppPublicController extends Controller {
    
    // 登录
    function login() {
        // 客户端通过header头上传的token
        echo($_SERVER['HTTP_LOGINTOKEN']);
        exit;
        
        $data['code'] = http_response_code();//php5.4版本以上
        $data['result'] = false;
        $data['msg'] = '';
        $data['deadline']=time()+7*24*3600;//token过期时间
        $data['token']=createstring(16);
        //$data['last_login_ip']=get_client_ip($type = 0, $adv = true);//$type 0 返回IP地址 1 返回IPV4地址数字
        $data['data'] = array();
        // 判断token过期
        //$to = Db::name('user')->where("token= '" . $token . "' and deadline>" . time())->find();
        echo json_encode($data);
        exit;
        
//        else {
//            $data['msg']='请求错误';echo json_encode($data);exit;
//        }
        
    }
    
    // 注册
    function register() {
        
    }
    
    // 修改密码
    function modifyPassword() {
        
    }
    
    // 找回密码
    function findPassword() {
        
    }
    
    // 获取验证码
    function getCode() {
        
    }
}

