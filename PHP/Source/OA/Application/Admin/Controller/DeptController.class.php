<?php

namespace Admin\Controller;
use Think\Controller;

// 部门
class DeptController extends CommonController {
    
    // 部门列表
    function  showList() {
        $model = M();
        // 联表查询 (自联查询)
        $sql = 'select t1.*, t2.name as deptname from sp_dept as t1 left join sp_dept as t2 on t1.pid = t2.id;';
        $data = $model ->query($sql);
        
        $model = M('Dept');
        $data = $model -> field('t1.*, t2.name as deptname') 
                -> alias('t1') 
                -> join('left join sp_dept as t2 on t1.pid = t2.id') 
                -> select();
        
        $model = M();
        $data = $model -> field('t1.*, t2.name as deptname') 
                ->table('sp_dept as t1') 
                -> join('left join sp_dept as t2 on t1.pid = t2.id') 
                -> select();
  
        //$model = D('Dept');
        //$data = $model -> order('sort asc') -> select();
//        // 二次查询
//        foreach ($data as $key => $value) {
//            if ($value['pid'] > 0) {
//               $info = $model ->find($value['pid']);
//               $data[$key]['deptname'] = $info['name'];
//            }
//        }
        // 获取到树形结构
        $data = getTree($data);
        $this ->assign('data', $data);
        $this -> display();
    }
    
    // 添加部门
    function  add() {
        // 查询顶级部门数据
        $model = D('Dept');
        
        // 使用I方法接收整个数组 => I('post.')
        // I 有自动过滤 和 sql防注入(htmlspecialchars)的功能
        if (IS_POST) {
            // 处理表单提交的信息
            //$post = I('post.');
            $data = $model ->create(); // create() 默认接收$_POST的数据
            // 判断验证结果
            if (!$data) {
                dump($model ->getError()); // 批量验证返回数组
                $this ->error($model ->getError()); 
                exit(); // 获取die;
            }
            $result = $model ->add();
            if ($result){
                // 添加成功
                $this ->success('添加成功', U('showList'),3);
            } else {
                $this ->error("添加失败");
            }

        } else {      
            $data = $model ->where('pid = 0') ->select();
            $this ->assign('data', $data);
            $this -> display();
        }

    }
    
    // 编辑部门信息
    function edit() {
        $model = D('Dept');
        if (IS_POST) {
            $post = I('post.');
            $data = $model ->create();
            $result = $model ->save();
            if ($result) {
                $this ->success('编辑成功', U('showList'), 3);
            }else {
                $this ->error('编辑失败');
            }
            
        } else {
            
          $id = I('get.id');
          // 查询部门信息
          $data = $model ->where() ->find($id);
          // 查询所有部门信息
          $info = $model ->  where("id != $id")->select();
          $this ->assign('data', $data);
          $this ->assign('info', $info);
          $this ->display();  
        }

    }
    
    // 部门删除
    function del() {
        $id = I('get.id');
        // 去除最后的双引号
        //$id = $id.rtrim(',');
        $model = D('Dept');
        $result = $model ->delete($id);
        
        if ($result) {
            $this->success('部门删除成功', U('showList'), 3);
        } else { // 删除失败
            $this->error('部门删除失败', U('showList'), 3);
        }
    }
}

