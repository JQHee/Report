<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="/oa/Application/Public/Admin/css/base.css" />
<link rel="stylesheet" href="/oa/Application/Public/Admin/css/info-mgt.css" />
<link rel="stylesheet" href="/oa/Application/Public/Admin/css/WdatePicker.css" />
<title>移动办公自动化系统</title>
</head>

<body>
<div class="title"><h2>信息管理</h2></div>
<div class="table-operate ue-clear">
	<a href="javascript:;" class="add">添加</a>
    <a href="javascript:;" class="del">删除</a>
    <a href="javascript:;" class="edit">编辑</a>
    <a href="javascript:;" class="count">统计</a>
    <a href="javascript:;" class="check">审核</a>
</div>
<div class="table-box">
	<table>
    	<thead>
        	<tr>
            	<th class="num">序号</th>
                <th class="name">部门</th>
                <th class="process">所属部门</th>
                <th class="node">排序</th>
                <th class="time">备注</th>
                <th class="operate">操作</th>
            </tr>
        </thead>
        <tbody>
        <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><tr>
            	<td class="num"><?php echo ($vol["id"]); ?></td>
                <td class="name"><?php echo (str_repeat('&emsp;',$vol["level"]*2)); echo ($vol["name"]); ?></td>
                <td class="process"><?php if($vol["pid"] == 0 ): ?>顶级部门<?php else: echo ($vol["deptname"]); endif; ?></td>
                <td class="node"><?php echo ($vol["sort"]); ?></td>
                <td class="time"><?php echo ($vol["remark"]); ?></td>
                <td class="operate">
                    <input type="checkbox" value="<?php echo ($vol["id"]); ?>" class="checkbox"/>
                    <a href="/oa/index.php/Admin/Dept/edit/id/<?php echo ($vol["id"]); ?>">编辑</a>
                </td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
</div>
<div class="pagination ue-clear"></div>
</body>
<script type="text/javascript" src="/oa/Application/Public/Admin/js/jquery.js"></script>
<script type="text/javascript" src="/oa/Application/Public/Admin/js/common.js"></script>
<script type="text/javascript" src="/oa/Application/Public/Admin/js/WdatePicker.js"></script>
<script type="text/javascript" src="/oa/Application/Public/Admin/js/jquery.pagination.js"></script>
<script type="text/javascript">
$(".select-title").on("click",function(){
	$(".select-list").hide();
	$(this).siblings($(".select-list")).show();
	return false;
})
$(".select-list").on("click","li",function(){
	var txt = $(this).text();
	$(this).parent($(".select-list")).siblings($(".select-title")).find("span").text(txt);
})

$('.pagination').pagination(100,{
	callback: function(page){
		alert(page);	
	},
	display_msg: true,
	setPageNo: true
});

$("tbody").find("tr:odd").css("backgroundColor","#eff6fa");

showRemind('input[type=text], textarea','placeholder');

// 通过JQ获取复选框所选的的内容
$(function() {
    $('.del').on('click', function() {
        // 获取表单中 class 是checkbox 并且是选中的
        var idObj = $(':checkbox:checked');
        var id = '';
        for(var i = 0; i < idObj.length; i++) {
            // idObj[i] 为获取dom对象
            id += idObj[i].value + ',';
        }
        // 去除最后一个, , 也可以用php rtrim方法处理
        id = id.substring(0, id.length - 1);
        //console.log(id);
        window.location.href = '/oa/index.php/Admin/Dept/del/id/' + id;
        
    })
    
});

</script>
</html>