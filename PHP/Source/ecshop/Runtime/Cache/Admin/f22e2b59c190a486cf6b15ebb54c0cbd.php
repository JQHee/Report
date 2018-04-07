<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />

        <title>会员列表</title>

        <link href="<?php echo ADMIN_CSS_URL?>mine.css" type="text/css" rel="stylesheet" />
    </head>
    <body>
        <style>
            .tr_color{background-color: #9F88FF}
        </style>
        <div class="div_head">
            <span>
                <span style="float: left;">当前位置是：商品管理-》商品列表</span>
                <span style="float: right; margin-right: 8px; font-weight: bold;">
                    <a style="text-decoration: none;" href="/ecshop/index.php/Admin/Goods/add">【添加商品】</a>
                </span>
            </span>
        </div>
        <div></div>
        <div class="div_search">
            <span>
                <form action="/ecshop/index.php/Admin/Goods/searchGoods" method="get">
                    品牌<select name="product_search" style="width: 100px;">
                        <option selected="selected" value="0">请选择</option>
                        <?php foreach($arr['brand'] as $key => $val) { ?>
                            <option value="<?php echo ($val["id"]); ?>" <?php if($val['id'] == $arr['brand_id']) echo ' selected="selected"'; ?>><?php echo ($val["name"]); ?>  </option>
                        <?php } ?>
                    </select>
                    <input value="查询" type="submit" />
                </form>
            </span>
        </div>
        <div style="font-size: 13px; margin: 10px 5px;">
            <table class="table_a" border="1" width="100%">
                <tbody><tr style="font-weight: bold;">
                        <td>序号</td>
                        <td>商品名称</td>
                        <td>库存</td>
                        <td>价格</td>
                        <td>图片</td>
                        <td>缩略图</td>
                        <td>品牌</td>
                        <td>创建时间</td>
                        <td align="center">操作</td>
                    </tr>
                    <?php foreach($arr['goods'] as $key => $val) { ?>
                    <tr id="product1">
                        <td><?php echo ($val["id"]); ?></td>
                        <td><a href="#"><?php echo ($val["goods_name"]); ?></a></td>
                        <td>100</td>
                        <td><?php echo ($val["goods_price"]); ?></td>
                        <td><img src="<?php echo SITE_URL; echo ($val["goods_img"]); ?>" height="60" width="60"></td>
                        <td><img src="<?php echo SITE_URL; echo ($val["goods_small_img"]); ?>" height="40" width="40"></td>
                        <td><?php echo ($val["brand_name"]); ?></td>
<!--                        只适用为时间戳的使用-->
<!--                        <td><?php echo (date('Y-m-d H:i:s',$val["goods_create_time"])); ?></td>-->
                        <td><?php echo (substr($val["goods_create_time"],0,10)); ?></td>
                        <td><a href="/ecshop/index.php/Admin/Goods/update/goods_id/<?php echo ($val["id"]); ?>">修改</a></td>
                        <td><a onclick="if (confirm('确定要删除吗？')) return true; else return false;" href="/ecshop/index.php/Admin/Goods/deleteGoods/id/<?php echo ($val["id"]); ?>" >删除</a></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="20" style="text-align: center;">
                            <?php echo ($arr['pagelist']); ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>