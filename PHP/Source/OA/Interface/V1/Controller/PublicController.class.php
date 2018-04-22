<?php

namespace V1\Controller;
use Common\Controller\ApiController;
use Think\Upload;

class PublicController extends ApiController {
    
    
    // 修改用户密码
    function modifyPassword() {
        
        $data['code'] = http_response_code();//php5.4版本以上
        $data['result'] = false;
        $data['msg'] = '';
        
        if (IS_POST) {
           $post = I('post.'); 
           $oldPwd = md5($post['oldPwd']);
           $newPwd = md5($post['newPwd']);
           $userId = $post['userId'];
           if (empty($oldPwd)) {
                $data['msg']='请输入原密码';
                echo json_encode($data);exit;
           }
           
           if (empty($newPwd)) {
                $data['msg']='请输入新密码';
                echo json_encode($data);exit;
           }
           
           $model = D('User'); 
           $result = $model ->where("id= '" . $userId ."' and password='" . $oldPwd."'") ->find();
           if ($result) {
               $userInfo = array (
                   $password => $newPwd,
               );
               // 更新旧密码
               $model ->where($userId)->save($userInfo);
               $data['msg']='密码修改成功';
               echo json_encode($data);exit;
  
           } else {
                $data['msg']='原密码错误';
                echo json_encode($data);exit;
           }
              
        } else {
            $data['msg']='请求错误';
            echo json_encode($data);exit;
        }
    }
    
    // 获取部门列表
    function dept() {
        $data['code'] = http_response_code();//php5.4版本以上
        $data['result'] = false;
        $data['msg'] = '';
        if (IS_POST) {
            
            $post = I('post.');
            $userId = $post['userId'];
            $pageIndex = $post['pageIndex'];
            $pageSize = $post['pageSize'];
            
            $model = D('Dept');
            // 获取到总条数
            $num = $model ->field('t1.*, t2.name as departname') 
                    -> alias('t1') ->join('left join sp_dept as t2 on t1.pid=t2.id') 
                    -> count();
            // 获取总的分页数
            $totalpage = ceil($num / $pageSize);
           
            // 自联查询
            $result = $model ->field('t1.*, t2.name as departname') 
                    -> alias('t1') ->join('left join sp_dept as t2 on t1.pid=t2.id') 
                    -> page($pageIndex, $pageSize)
                    ->select();
            

            $data['totalpage'] = $totalpage;
            $data['nowpage'] = $pageIndex;
            $data['num'] = $num;
            
            if ($result) {
                $data['msg'] = '请求成功';
            } else {
                $data['msg'] = '暂无数据';
            }
            $data['data'] =  $result;
            echo json_encode($data);exit;
            
            
        }else {
            $data['msg']='请求错误';
            echo json_encode($data);exit;  
        }
    }
    
    
    // 修改用户头像
    function modifyAvatar() {
        $data['code'] = http_response_code();//php5.4版本以上
        $data['result'] = false;
        $data['msg'] = '请求错误';
        if(!IS_POST) {
            echo json_ecode($data);exit;
        }
        
        $userId = I('post.userId');
        // 上传的图片
        $file = $_FILES['file'];
        if ($file['error'] == '0') { // 上传的图片
            $cfg = array (
                'rootPath' => './Interface/Public/Upload/'
            );
            $upLoad = new Upload($cfg);
            $uploadInfo = $upLoad ->uploadOne($file);
            
            $avatarPath =  $upLoad -> rootPath . $uploadInfo['savepath'].$uploadInfo['savename'];
            
            $avatarPath = ltrim($avatarPath, '.');
            $userInfo['avatar'] = $avatarPath;  
            
            $model = D('User');
            $model -> where($userId) ->save($userInfo);
            $data['msg'] = '图片上传成功';
            $data['path'] = $userInfo['avatar'];
            echo json_encode($data);exit; 
        } else {
           $data['msg'] = '请求错误';
           echo json_ecode($data);exit; 
        }
    }
    
    
    // 多图上传
    function  uploadFiles() {
        
        $data['code'] = http_response_code();//php5.4版本以上
        $data['result'] = false;
        $data['msg'] = '请求错误';
        if(!IS_POST) {
            echo json_ecode($data);exit;
        }
        
        $files = $_FILES;
        
        $cfg = array (
            'rootPath' => './Interface/Public/Upload/',
            'saveName'   =>    array('uniqid', ''),
        );
        $upLoad = new Upload($cfg);
        $uploadInfo = $upLoad ->upload($files);
        
        $path = null;
        foreach ($uploadInfo as $key => $value) {
            $tempPath = $upLoad -> rootPath . $value['savepath'].$value['savename'] . ",";
            $tempPath = ltrim($tempPath, '.');
            $path .= $tempPath;
        }
        $path = rtrim($path, ',');
        $data['path'] = $path;
        echo json_encode($data);exit;
        
    }
    
}

