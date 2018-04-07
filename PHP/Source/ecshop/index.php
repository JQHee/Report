<?php 
// 版本ThinkPHP3.2.3
// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

// 避免汉字出现乱码
header ("content-type:text/html;charset=utf-8;");

// 打开开发调试模式,另一种是生产模式
define('APP_DEBUG',true);

//给系统静态资源文件请求路径设置常量
define('SITE_URL','http://localhost/ecshop/');

// 在模板文件需要绝对路径引用静态资源文件（css/js/image），路径常量
// Home前台
define('CSS_URL','/ecshop/Home/Public/css/');
define('IMAGE_URL','/ecshop/Home/Public/images/');
define('JS_URL','/ecshop/Home/Public/js/');

// Admin后台
define('ADMIN_CSS_URL','/ecshop/Admin/Public/css/');
define('ADMIN_IMAGE_URL','/ecshop/Admin/Public/img/');
define('ADMIN_JS_URL','/ecshop/Admin/Public/js/');
// 引用tp框架接口文件
require '../ThinkPHP/ThinkPHP.php';;
// include ("../ThinkPHP/ThinkPHP.php");
