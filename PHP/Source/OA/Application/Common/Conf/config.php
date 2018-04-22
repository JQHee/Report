<?php
return array(
    //'配置项'=>'配置值'
        /* 数据库设置 */
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  'localhost', // 服务器地址
    'DB_NAME'               =>  'zjwdb_6224898',          // 数据库名
    'DB_USER'               =>  'zjwdb_6224898',      // 用户名
    'DB_PWD'                =>  'Hjq562011',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'sp_',    // 数据库表前缀
    'DB_PARAMS'          	=>  array(), // 数据库连接参数    
    'DB_DEBUG'  			=>  TRUE, // 数据库调试模式 开启后可以记录SQL日志
    'DB_FIELDS_CACHE'       =>  true,        // 启用字段缓存
    'DB_CHARSET'            =>  'utf8',      // 数据库编码默认采用utf8
    'DB_DEPLOY_TYPE'        =>  0, // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    'DB_RW_SEPARATE'        =>  false,       // 数据库读写是否分离 主从式有效
    'DB_MASTER_NUM'         =>  1, // 读写分离后 主服务器数量
    'DB_SLAVE_NO'           =>  '', // 指定从服务器序号
    
    // 模板常量
    'TMPL_PARSE_STRING' => array (
        '__ADMIN__' => __ROOT__.'/Application/Public/Admin'
    ),
    // 显示页面跟踪信息
    'SHOW_PAGE_TRACE' => true,
    
    //动态加载文件
    //'LOAD_EXT_FILE'         =>  '', //包含文件名的字符串，多个文件名之间使用英文半角逗号分割
    
     // 设置一个对比的分组列表
    'MODULE_ALLOW_LIST' => array('Home','Admin','Api'),
    
    // 角色组
    'RBAC_ROLES' => array(
        1 => '高层管理',
        2 => '中层领导',
        3 => '普通职员'
    ),

    // 权限组
    'RBAC_ROLE_AUTHS' => array (
        1 => '*/*',
        2 => array('index/*','email/*', 'doc/*', 'knowledge/*'),
        3 => array('index/*','doc/*', 'knowledge/*'),
    ),
);