<?php

namespace Admin\Controller;
use Think\Controller;

// 报错优化的控制
class EmptyController extends Controller {
    
    function  _empty() {
        $this ->display();
    }
    
}

