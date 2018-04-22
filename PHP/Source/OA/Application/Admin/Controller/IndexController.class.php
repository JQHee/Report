<?php

namespace Admin\Controller;
use Think\Controller;

// 后台管理首页
class IndexController extends CommonController {
    
    function index() {
        
        $this -> display();
    }
    
    function  home() {
        $this -> display();
    }
}

