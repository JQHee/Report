<?php

namespace Admin\Controller;
use Think\Controller;
use Think\Verify;
use Tools\Captcha;

// 功能: 后台管理页面
// create by: hjq
// time: 2018-04-05

class ManagerController extends Controller {
    
    // 后台登录页面
    function login() {
        
        if (!empty($_POST)) {            
//            $verify = new Verify();
//            if ($verify ->check($_POST['captcha'])) { // 验证码验证成功
//                
//            }
            $ctcha = new Captcha();
            if ($ctcha -> checkCaptcha($_POST['captcha'])) { // 验证码验证成功
                $user = D('user');
                dump($_POST);
                $datas = array (
                    'name' => $_POST['admin_user'],
                    'password' => $_POST['admin_psd'],
                );
                // 匹配使用有用户名和密码相等
                // SELECT * from `ec_user` WHERE `name` == $datas['name'] AND `password` == $datas['password'] LIMIT 1;
                $sql =  "SELECT * FROM `ec_user` WHERE `name` = '".$datas['name']."' AND `password` = '".$datas['password']."' LIMIT 1";
                // 查出来的是一个二维数组
                //$info = $user -> query($sql);
                // 查出来的是一个一维数组
                $info = $user -> where($datas) -> find();
                if ($info) {
                    // 保存信息到session中
                    // dump($info);
                    session('admin_name', $info["name"]);
                    session('addmin_id', $info['id']);
                    $this -> redirect('Index/index');
                    
                } else {
                    echo '用户名或者密码错误';
                }
                
            }
            
        } else {
            echo '验证码错误';
        }
        $this -> display();
    }
    
    // 退出登录
    function logout() {
        session(null);
        $this ->redirect('Manager/login');
    }
    
    // 获取短信验证码
    function verifyImg() {
        
        // tp自带的验证码类
//        $cfg = array(
//            'fontttf' => '4.ttf',
//            'imageH' => 40,
//            'imageW' => 100,
//            'length' => 4,
//            'fontSize' => 15,
//        );
//        $verify = new Verify($cfg);
//        $verify -> entry();
        
        
        $captchaCfg = array (
            'width' => 80,
            'height' => 30,
            'fontsize' => 15,
            'str_len' => 4,
            
        );
        $ctcha = new Captcha($captchaCfg);
        $z = $ctcha -> generate();
        
        
        /********************
        // 1、写入内容到文件,追加内容到文件
        2、打开并读取文件内容
        ********************/
        //要写入文件的文件名（可以是任意文件名），如果文件不存在，将会创建一个
        $file  = 'log.txt';
        $content = $z;

       if($f  = file_put_contents($file, $content,FILE_APPEND)){// 这个函数支持版本(PHP 5) 
            echo "写入成功。<br />";
       }
       if($data = file_get_contents($file)){; // 这个函数支持版本(PHP 4 >= 4.3.0, PHP 5) 
            echo "写入文件的内容是：$data";
       }

    }
    

}


