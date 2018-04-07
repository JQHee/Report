<?php

namespace Admin\Controller;
use Think\Controller;
use Tools\JPush;

// 功能: 极光推送
// create by: hjq
// time: 2018-04-05

class JpushController extends Controller {
    
    // 发推送
    function push() {

        $client = new JPush();
        //$client -> aa();
        $result = $client -> sendMessage('all', '推送内容', 'all', '', '', '86400');

        var_dump($result);
    }
    
}

