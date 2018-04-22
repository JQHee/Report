<?php

// 版本3.2.3
// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

// 避免汉字出现乱码
header ("content-type:text/html;charset=utf-8;");

// 打开开发调试模式,另一种是生产模式
define('APP_DEBUG',true);

// 接口文件目录
define('APP_PATH', './Interface/');

// 应用api模式
define('APP_MODE', 'api');


// 引用tp框架接口文件
require '../ThinkPHP/ThinkPHP.php';

