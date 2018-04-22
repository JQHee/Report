<?php

namespace Admin\Controller;
use Think\Controller;

// 公文管理
class DocController extends CommonController {
    
    
    // 公文添加
    function add() {
        
        if (IS_POST) {
            $post = I('post.');
            
            $model = D('Doc');
            $result = $model -> saveData($post, $_FILES['file']);
            if ($result) {
                $this ->error('保存成功',U('showList'),3);
            }   else {
                $this ->error('保存失败');
            }
            
        } else {
            $this ->display();
        }
        
        
    }
    
    // 公文列表
    function showList() {
        
        $model = D('Doc');
        $data = $model ->select();
        $this ->assign('data', $data);
        $this ->display();
    }
    
    // 查看内容
    function lookcontent() {
        $id = I('get.id');
        $model = D('Doc');
        $data =  $model ->find($id);
        echo htmlspecialchars_decode($data['content']);
    }
    
    // 文件下载
    function download() {
        $id = I('get.id');
        $model = D('Doc');
        $data =  $model ->find($id);
        //WORKING_PATH 为带盘符的格式D:\WWW
        $file = WORKING_PATH. $data[filepath];
        header("Content-type:application/octet-stream");
        header("Accept-Length:". filesize($file));
        header('Content-Disposition: attachment; filename="'. basename($file).'"');
        readfile($file);
       
    }
}

