<?php

namespace Admin\Controller;
use Think\Controller;
use Think\Upload;
use Think\Image;
use Tools\Page;


// 功能: 商品相关
// create by: hjq
// time: 2018-04-05

class GoodsController extends Controller {
    
    // 商品添加
    function add() {
        
        if (!empty($_POST)) {
            if($_FILES['goods_image']['error']===0) { // 有图片上传
                
                $cfg = array (
                    'rootPath' => './Public/UploadImages/'
                );
                $up = new Upload($cfg);
                // 上传一张图片
                $z = $up -> uploadOne($_FILES['goods_image']);
                $goods_img = $up -> rootPath.$z['savepath'].$z['savename'];
                if($z) {
                    $_POST['goods_img'] = substr($goods_img, 2); // 去掉./
                }
                
                // 制作缩略图
                $img = new Image();
                $img ->open($goods_img);
                //③ 为源图片制作缩略图
                $img -> thumb(125,125);  //等比例缩放
                $goods_small_img = $up -> rootPath.$z['savepath'].'small_'.$z['savename'];
                $img -> save($goods_small_img);
                $_POST['goods_small_img'] = substr($goods_small_img, 2); // 去掉./
                
            }
            
            // 收集表单信息
            $goods = D('Goods');
            $info = $goods ->create();
            $z = $goods ->add($info);
            if($z){
                //$this ->redirect (地址分组/控制器/操作方法, 参数, 间隔时间, 提示信息)
                $this ->redirect('show', array(), 2, '添加商品成功！');
            } else {
                $this ->redirect('add', array(), 2, '添加商品失败！');
            }
            
        } else { 
            
            $brand = D('Goodsbrand');
            $brandInfo = $brand ->select();
            $category = D('Goodscategory');
            $categoryInfo = $category ->select();
            $arr = array (
                'category' =>  $categoryInfo,
                'brand' => $brandInfo,
            );
            $this -> assign('arr', $arr);            
        }
        $this -> display();
    }
    
    // 商品的修改
    function update($goods_id) {
         $goods = D('Goods');
        if (!empty($_POST)) {
           $data = $goods -> create();
           $z = $goods ->save($data);
            if($z){
                //$this ->redirect (地址分组/控制器/操作方法, 参数, 间隔时间, 提示信息)
                $this -> redirect('Goods/show', array(), 2, '商品更新成功！');
            } else {
                $this -> redirect('Goods/show', array(), 2, '商品更新失败！');
            }
            
        } else {
            $info = $goods -> find($goods_id);
            $brand = D('Goodsbrand') -> select();
            $category = D('Goodscategory') -> select();
            $this -> assign('info', $info);
            $this -> assign('brand', $brand);
            $this -> assign('category', $category);
            $this ->display();
        }
        
    }
    
    // 删除商品id
    function deleteGoods($id) {
        $goods = D('Goods');
        $z = $goods -> delete($id);
        //实现数据分页效果
        //① 获得总条数、每页显示条数设置
        $cnt = $goods -> count();  //获得总条数 sum() max() avg() min()
        //SELECT COUNT(*) AS tp_count FROM `sw_goods` LIMIT 1
        $per = 7;

        //② 实例化分页类对象
        $page_obj = new Page($cnt,$per);
        // 内连接连表查询
        $sql = "select g.*, c.name as brand_name "
               . "from `ec_goods` as g inner join `ec_goodsbrand` as c "
               . "on g.goods_brand_id = c.id ".$page_obj -> limit.';';
        
        $datas = $goods -> query($sql);
        $brand = D('Goodsbrand');
        $brandInfo = $brand ->select();

        //④ 制作页码列表
        $pagelist = $page_obj -> fpage(array(3,4,5,6,7,8));
        // 实现分页效果
        $arr = array (
            'goods' =>  $datas,
            'brand' => $brandInfo,
            'pagelist' => $pagelist
        );
 
        $this -> assign('arr', $arr);
        if($z){
            //$this ->redirect (地址分组/控制器/操作方法, 参数, 间隔时间, 提示信息)
            $this -> redirect('Goods/show', array(), 2, '商品删除成功！');
        } else {
            $this -> redirect('Goods/show', array(), 2, '商品删除失败！');
        }
    }
    
    // 商品的展示
    function  show() {
       
        $goods = D('Goods');
        //实现数据分页效果
        //① 获得总条数、每页显示条数设置
        $cnt = $goods -> count();  //获得总条数 sum() max() avg() min()
        //SELECT COUNT(*) AS tp_count FROM `sw_goods` LIMIT 1
        $per = 7;

        //② 实例化分页类对象
        $page_obj = new Page($cnt,$per);
        // 内连接连表查询
        $sql = "select g.*, c.name as brand_name "
               . "from `ec_goods` as g inner join `ec_goodsbrand` as c "
               . "on g.goods_brand_id = c.id ".$page_obj -> limit.';';
        
        $datas = $goods -> query($sql);
        $brand = D('Goodsbrand');
        $brandInfo = $brand ->select();

        //④ 制作页码列表
        $pagelist = $page_obj -> fpage(array(3,4,5,6,7,8));
        // 实现分页效果
        $arr = array (
            'goods' =>  $datas,
            'brand' => $brandInfo,
            'pagelist' => $pagelist
        );
 
        $this -> assign('arr', $arr);
        $this -> display();
    }
    
    // 筛选
    function  searchGoods() {
       
        $goods_brand_id = $_GET['product_search'];
        $goods = D('Goods');
        //实现数据分页效果
        //① 获得总条数、每页显示条数设置
        $cnt = $goods -> count();  //获得总条数 sum() max() avg() min()
        //SELECT COUNT(*) AS tp_count FROM `sw_goods` LIMIT 1
        $per = 7;

        //② 实例化分页类对象
        $page_obj = new Page($cnt,$per);
        // 内连接连表查询
        $sql = "select g.*, c.name as brand_name "
          . "from `ec_goods` as g inner join `ec_goodsbrand` as c "
          . "on g.goods_brand_id = c.id ";
        if ($goods_brand_id  == 0) { // 全部数据
            $sql = $sql.$page_obj -> limit.';';
        } else {
            $sql = $sql."where `goods_brand_id` = ".$goods_brand_id.' '.$page_obj -> limit.';';
        }
    
        $datas = $goods -> query($sql);
        $brand = D('Goodsbrand');
        $brandInfo = $brand -> select();
        //④ 制作页码列表
        $pagelist = $page_obj -> fpage(array(3,4,5,6,7,8));
        $arr = array (
            'goods' =>  $datas,
            'brand' => $brandInfo,
            'pagelist' => $pagelist,
            'brand_id' => $goods_brand_id,
        );
        $this -> assign('arr', $arr);
        $this -> display('Goods/show');
    }
}


