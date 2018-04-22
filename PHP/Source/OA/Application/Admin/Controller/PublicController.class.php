<?php

namespace Admin\Controller;
use Think\Controller;
use Think\Verify;

// 登录
class PublicController extends Controller {
    
    // 登录
    function login() {
        
//        $result = removeXSS("<html>122233</html>");
//        echo $result; 
  
       $this -> display();   
    }
    
    // 退出登录
    function logout() {
        session(null);
        $this ->success('退出成功', U('login'),3);
    }
    
    // 处理登录的数据
    function checkLogin() {
        
       // 
        $post = I('post.');
        $very = new Verify();
        $result = $very->check($post['captcha']);
        if ($result) {
            // 验证用户名和密码
            $model = M('User');
            // 删除验证码参数 // 移除数组中的某个参数
            unset($post['captcha']);
            $data = $model ->where($post) -> find();
            if ($data) {
                // 用户信息的持久化
                session('id', $data['id']);
                session('username', $data['username']);
                session('role_id', $data['role_id']);
                
                $this ->success('登录成功', U('Index/index'), 3);
                
            }else {
                $this ->error('用户名或者密码错误');
            }
        } else {
            // 
            $this ->error('您输入的验证码错误');
        }
    }
    
    // 获取图形验证码
    function captcha() {
        // 配置项
        $cfg = array (
          'imageH' => 40,
          'imageW' => 120,
          'fontSize' => 15,
          'length' => 4,
          'fontttf' => '4.ttf', // 字体
          'useCurve'  =>  false,            // 是否画混淆曲线
          'useNoise'  =>  false, 
        );
        $very = new Verify($cfg);
        $very -> entry();
    }
    
}



