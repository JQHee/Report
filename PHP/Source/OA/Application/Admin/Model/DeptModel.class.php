<?php

namespace Admin\Model;
use Think\Model;

// 部门数据库模型
class DeptModel extends  Model {
    
    // 批量验证
    //protected $patchValidate = true;
    
    // 自定义数据库表
    // protected $tableName        =   '';
    
//    protected $_map             =   array(
//        // 键是表单中的name值 = 值是数据表中的字段名
//        
//    );  // 字段映射定义
    
    // 单个验证
    // 自动验证定义
    protected $_validate        =   array(
        
        array('name', 'require', '不能名称不能为空!'), // 不能为空验证
        array('name', '', '该部门名称已存在', '', 'unique'),  // 唯一验证
        array('sort', 'number', '排序必须是数字'),
        
    );  
    
}

