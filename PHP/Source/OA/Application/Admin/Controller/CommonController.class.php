<?php

namespace Admin\Controller;
use Think\Controller;

// 基类控制器
class CommonController extends Controller {
    
//    // 构造方法
//    public function __construct() {
//        // 构造父类
//        parent::__construct();
//    }
    
    // tp中的方法
    public function _initialize() {
        //parent::_initialize();
        
        $id = session('id');
        
        if (empty($id)) { // 没有登录
            // iframe会有问题
            //$this ->error('你还未登录...',U('Public/login'),3);exit();
            // 顶级页面跳转
            $url = U('Public/login');
            echo "<script>top.location.href='$url'</script>"; exit();
        }
        
        // 角色组
        // config文件的组
        
        // RBAC部分
        // 获取当前用户角色id
        $role_id = session('role_id');
        // 2.获取全部用户组的权限
        $rbac_role_auths = C('RBAC_ROLE_AUTHS');
        // 当前用户的权限
        $currentRoleAuths = $rbac_role_auths[$role_id];
        
        // 3.使用常量获取当前控制器名和方法名
        $controller = strtolower(CONTROLLER_NAME);
        $action = strtolower(ACTION_NAME);
        
        // 4.判断权限是否具有
        if ($role_id > 1) {
            // 当用户不是超级管理员,进行权限判断
            if (!in_array($controller . '/' . $action, $currentRoleAuths) && !in_array($controller . '/*', $currentRoleAuths)) {
                $this ->error('您没有权限',U('Index/home',3));exit();
            }
        }
    }
    
}

