<?php
return array(
    //'配置项'=>'配置值'
    
        //数据库设置
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => 'localhost', // 服务器地址
    'DB_NAME'   =>  'zjwdb_6224898',          // 数据库名
    'DB_USER'   =>  'zjwdb_6224898',      // 用户名
    'DB_PWD'    =>  'Hjq562011',          // 密码
    'DB_PORT'   => '3306', // 端口
    'DB_PREFIX' => 'sp_', // 数据库表前缀

    /* SESSION设置 */
    'SESSION_AUTO_START' => false, // 是否自动开启Session
    'SESSION_OPTIONS'    => array(), // session 配置数组 支持type name id path expire domain 等参数
    'SESSION_TYPE'       => '', // session hander类型 默认无需设置 除非扩展了session hander驱动
    'SESSION_PREFIX'     => 'OA', // session 前缀

    'DEFAULT_MODULE'     => 'V1', // 默认模块
    'DEFAULT_CONTROLLER' =>  'Index', // 默认控制器名称
    'DEFAULT_ACTION'      =>  'index', // 默认操作名称

    /*URL_MODEL*/
    'URL_MODEL'          => 2,
    'URL_HTML_SUFFIX'   => '',
    'URL_PATHINFO_DEPR' => '/',

    /*加密方式*/
    //'DATA_CRYPT_TYPE'  => 'DES',
    
    /*加密KEY*/
    'PASS_KEY'    => 'PASSWORDKEY',
    

    /*接口域名*/
    'API_SITE_PREFIX'  => 'http://www/hjq.com/OA',

    /*默认头像文件路径*/
    'HAND_IMG_PATH'   =>  '/Public/pic_hand_img.png',


         //开启路由支持
    'URL_ROUTER_ON' => true,
    //API接口路由
    'URL_ROUTE_RULES' => array(
        'login' => 'Index/login',
        'register' => 'Index/register',
        'modifyPassword' => 'Public/modifyPassword',
        'dept' => 'Public/dept',
        'modifyAvatar' => 'Public/modifyAvatar',
        'uploadFiles' => 'Public/uploadFiles',
    ),

    /*支付方式*/
    'PAY_STATUS'   => array(
        'CYH_WAIT_PAY'  => 'CYH_WAIT_PAY', //等待支付
        'CYH_PAY_W_UP'  => 'CYH_PAY_W_UP', //APP端回调支付成功，等待支付宝回调响应
        'CYH_PAY_OK'    => 'CYH_PAY_OK', //支付完成
    ),
    'PAY_TYPE'   => array(
        'ALIPAY' => '支付宝',
        'SELF'    => '余额支付',
        'WEIXIN'  => '微信支付',
    ),
    
);