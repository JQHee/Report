<?php

namespace Admin\Model;

use Think\Model;

// 公文模型
class DocModel extends Model {
    
    // 保存数据
    function saveData($post, $file) {
        
        if (!$file['error']) { // 上传用文件信息
            
            // Mac环境下要给权限
            $cfg = array (
                'rootPath' => './Application/Public/Upload/'
            );
            $upLoad = new \Think\Upload($cfg);
            $info = $upLoad ->uploadOne($file); 
            $filePath = $upLoad -> rootPath . $info['savepath'] . $info['savename'];
            $filePath = ltrim($filePath,'.');
            // 上传成功后得到文件名称和路径
            $post['filename'] = $info['name'];
            $post['filepath'] = $filePath;
            $post['hasfile'] = 1;
            
        }
        $post['addtime'] = time();
        return $this ->add($post);
    }
    
}

