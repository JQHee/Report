<?php

namespace Admin\Controller;
use Think\Controller;

// 职员管理
class UserController extends CommonController {
    
    // 添加职员
    function add() {
        
        if (IS_POST) {
            
            $model = M('User');
            // 默认是接收I('post.')数据
            $data =  $model ->create();
            // 添加当前的时间戳
            $data['addtime'] = time();
            $result = $model ->add($data);
            if ($result) {
                $this ->success('职员添加成功', U('showList'), 3);
            } else {
                $this ->error('职员添加失败');
            }
            
        } else {
            
            // 查询部门数据,填充到下拉框中
            $model = M('Dept');
            $data = $model ->select();
            $this ->assign('data', $data);
            $this ->display(); 
        }
    }
    
    
    // 展示职员列表
    function showList() {
       
        $User = M('User'); // 实例化User对象
        $count      = $User->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,1);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        
        $Page -> lastSuffix = FALSE;
        $Page -> rollPage = 5;
        // 可选参数位置
        $Page ->setConfig('prev', '上一页');
        $Page ->setConfig('next', '下一页');
        $Page ->setConfig('first', '首页页');
        $Page ->setConfig('last', '末页');
        
        $show       = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $data = $User->order('addtime')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('data',$data);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出
        $this->display(); // 输出模板
    }
    
    
    // 报表统计
    function charts() {
      // select t2.name as deptname, count(*) as count from sp_user as t1, sp_dept as t2 where t1.deptid = t2.id group by deptname;  
       $model = M();
       $data = $model ->field('t2.name as deptname, count(*) as count') 
               ->table('sp_user as t1, sp_dept as t2') 
               ->where('t1.deptid = t2.id') 
               ->group('deptname') 
               ->select();
       //dump ($data); exit();
       // 将查询到的数据拼接成一个二维数组
       // 拼接好格式给hightcharts显示
       $str = '[';
       foreach ($data as $key => $value) {
           $str .= "['" . $value['deptname'] . "'," . $value['count'].'],';
       }
       // 去掉右边的逗号
       $resultStr = rtrim($str,',') . ']';
       
       $this ->assign('result', $resultStr);
       $this ->display();
 
    }
    
}

