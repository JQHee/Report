<?php


    // 有选择性的过滤XSS --》 说明：性能非常低-》尽量少用
    // function: 过滤点html中标签
    function removeXSS($data) {

        //require_once './HtmlPurifier/HTMLPurifier.auto.php';
        // 引入HTMLPurifier 仿xss
        vendor('HTMLPurifier.HTMLPurifier#auto');
        $_clean_xss_config = HTMLPurifier_Config::createDefault();
        $_clean_xss_config->set('Core.Encoding', 'UTF-8');
        // 设置保留的标签
        $_clean_xss_config->set('HTML.Allowed','div,b,strong,i,em,a[href|title],ul,ol,li,p[style],br,span[style],img[width|height|alt|src]');
        $_clean_xss_config->set('CSS.AllowedProperties', 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align');
        $_clean_xss_config->set('HTML.TargetBlank', TRUE);
        $_clean_xss_obj = new HTMLPurifier($_clean_xss_config);
        // 执行过滤
        return $_clean_xss_obj->purify($data);
    }

    // 字符串截取,超过长度以省略号的形式显示
    /**
     * 字符串截取，支持中文和其他编码
     * @static
     * @access public
     * @param string $str 需要转换的字符串
     * @param string $start 开始位置
     * @param string $length 截取长度
     * @param string $charset 编码格式
     * @param string $suffix 截断显示字符
     * @return string
     */
    function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true) {
         if(function_exists("mb_substr"))
             $slice = mb_substr($str, $start, $length, $charset);
         elseif(function_exists('iconv_substr')) {
             $slice = iconv_substr($str,$start,$length,$charset);
         }else{
             $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
             $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
             $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
             $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
             preg_match_all($re[$charset], $str, $match);
             $slice = join("",array_slice($match[0], $start, $length));
         }
         return $suffix ? $slice.'...' : $slice;
     }

    # 递归方法实现无限极分类
    function getTree($list,$pid=0,$level=0) {
        static $tree = array();
        foreach($list as $row) {
                if($row['pid']==$pid) {
                        $row['level'] = $level;
                        $tree[] = $row;
                        getTree($list, $row['id'], $level + 1);
                }
        }
        return $tree;
    }
