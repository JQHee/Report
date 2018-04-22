# 一、AJAX
#### 1.AJAX缓存
避免使用缓存的方法
- 1.在URL地址中添加随机数，这样使得URL是唯一的（常见Math.random()）。
- 2.设置header头(PHP文件中加),禁止浏览器缓存
```
header("Cache-Control:no-cache");
header(Pragma:no-cache);
header("Expires:-1");
```

#### 2.判断用户是否已经存在
通过调用后台的接口判断

#### 3.js操作json
将字符串转成object
eval('var info=' + str); // str为服务器返回的json数据
info 就转为一个对象(object)

// 分页拼接数据
str 为拼接好html标签内容
$('id').innerHTML=str;

# 二、bootstrap
#### 1.手机头部固定样式：

```
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <h1>你好，世界！</h1>

    <!-- jQuery (Bootstrap 的所有 JavaScript 插件都依赖 jQuery，所以必须放在前边) -->
    <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <!-- 加载 Bootstrap 的所有 JavaScript 插件。你也可以根据需要只加载单个插件。 -->
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </body>
</html>
```

#### 2.布局容器
2.1 固定宽度 1170px
```
<div class="container">
  ...
</div>
```

2.2  百分比宽度

```
<div class="container-fluid">
  ...
</div>
```

#### 3.导航栏头部
```
// 对齐方式： text-right
<h1 class='page-header'>产品展示</h1>
<h1 class='page-header text-right'>产品展示</h1>

// 英文字母大小写
<p class='text-uppercase'>英文字母都大写</p>
<p class='text-lowercase'>英文字母都小写</p>
<p class='text-capitalize'>首字母都大写</p>
```

### 4.列表
分为有序和无序列表

- list-unstyled - 去除自带的黑点
- list-inline - 纵向变横向（行内）
```
<ul class="list-unstyled"> 
  <li></li>
</ul>
```

自定义列表
- dl-horizontal - 横向排列
```
<dl class="dl-horizontal">
<dt>标题</dt>
<dd>标题解释</dd>
</dl>
```

#### 5.表格
// 表格加样式
- table - 表格的一个基类，如果加其他的样式，都在.table的基础上
- table-bordered - 添加外边框
- table-hover - 鼠标悬停效果，鼠标移动到单元格上，变色
- table-strped - 斑马线效果，隔行换色
- table-condensed - 表格变紧凑些。padding比原来减半
// 表格响应式
给表格父div 加 `table-responsive` - 变成响应的的表格（通俗就是用标签（div）把再包一层）
```
<table class="table"> 
  <tr> 
    <td> </td>
    <td> </td>
  </tr>
</table>
```
`状态类`设置的是行tr或td 的颜色

#### 6.图片响应式
- img-responsive - 图片变成响应式
- img-circle - 图片形状：椭圆形
- img-rounded - 图片设置圆角
- img-thumbnail - 常见：添加带圆角的边框
```
<img src="img/icon.png" class="img-responsive"/>
```

#### 7.栅格系统
栅格系统一定放入容器中
```
<div class="container">
  ...
</div>

<div class="container-fluid">
  ...
</div>
```
栅格系统，把浏览器窗口自动分配最多12列
由行row和列col组成

1.偏移： 只能向右偏移
如： col-md-offset-3  向右偏移三个单元格

2.排列（了解）
- col-md-push-8 - 右移动
- col-md-pull-4 - 左移动

#### 8.辅助样式
1.情境文本颜色： 
  - text.muted(柔和) 
  - text-success 
  - text-info 
  - text-warning
  - text-danger
  
2.背景文本颜色：
  - bg-success
  - bg-info
  - bg-primary
  - bg-warning
  
3.下拉三角 <span class="caret"></span>

4.快速浮动
  - pull-left
  - pull-right

#### 9.复选框
```
<form> 
  <div class="form-group"> 
    <label for="cemail">邮箱</label>
    <input type="email" name="cemail" id="cemail" class="form-control">
  </div>
  
  <div class="form-group"> 
    <label for="pwd">密码</label>
    <input type="password" name="pwd" id="pwd" class="form-control">
  </div>
  
  <div class="form-group"> 
    <label class="checkbox-inline"><input type="checkbox" name="habby"/>密码</label>
    <label class="checkbox-inline"><input type="checkbox" name="habby"/>密码</label>
    <label class="checkbox-inline disable"><input type="checkbox" name="habby"/>密码</label>
  </div>
</form>
```

#### 10.单选框
```
<form> 

  <div class="form-group"> 
    <label class="radio-inline"><input type="radio" name="sex" value="男"/>男</label>
    <label class="radio-inline"><input type="radio" name="sex"/>女</label>
    <label class="radio-inline disable"><input type="radio" name="habby"/>保密</label>
  </div>
</form>
```

#### 11.输入框组
```
<form> 

  <div class="form-group">
    <div class="input-group"> 
      <span class="input-group-addon">搜索</span>
      <input type='search' name="sc" id="sc" class="form-control"/>
    </div>
  </div>
  
  <div class="form-group">
    <div class="form-group">
      <input type='search' name="sc" id="sc" class="form-control"/>
      <div class="input-group-addon">搜索内容</div>
    </div>
  </div>
 
</form>
```

#### 12.响应表单
表单加： form-horizontal - 变成响应式
```
<form class="form-horizontal"> 

  <div class="form-group">
    <div class="input-group"> 
      <span class="input-group-addon">搜索</span>
      <input type='search' name="sc" id="sc" class="form-control"/>
    </div>
  </div>
  
  <div class="form-group">
    <div class="input-group">
      <div class="col-md-10 col-sm-2 col-sm-2">
        <input type='search' name="sc" id="sc" class="form-control"/>
      </div>
      <div class="input-group-addon">搜索内容</div>
    </div>
  </div>
 
</form>
```

#### 13.按钮
- btn - 按钮样式的基类
- btn-primary
- btn-default
- btn-success
- btn-info
- btn-warning
- btn-danger
- active - 激活状态

按钮大小
- btn-lg
- btn-sm
- btn-xl
```
<input type="button">
<button>按钮</button>
<a href="#">内容</a>
```

按钮组
```
<div class="btn-group"> 
  <button class="btn btn-success"> 按钮内容</button>
  <button class="btn btn-success"> 修改查询容</button>
  <button class="btn btn-success"> 按钮内容</button>
</div>
```

#### 14.缩略图
```
<div class="container">
  <div class="row">
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6"> 
      <!--圆角的边框--
      <div class="thumbnail">
        <img src="" class="img-responsive">
        <!--caption--
        <div class="caption">
          <h3>标题</h4>
          <p>文本内容</p>
        </div>
      </div>
    </div>
  </div>
</div>
```

#### 15.标签页
1.下拉菜单
- dropdown-menu - 给下拉列表中的内容给ul加样式
- dropdown - 给包含触发按钮和下拉列表加样式 - 父元素
- data-toggle - 按钮的触发器
- dropdown-menu-left - 下拉列表的左对齐
- dropdown-menu-right - 下拉列表的右对齐
- divider - ul中加分割线

```
<h2 class="page-header">下拉列表</h2>
<div class="dropdown">
  <button class="btn btn-default" data-toggle="dropdown"> 登录<span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li> <a href="#">qq登录</a></li>
    <li> <a href="#">qq登录</a></li>
    <li class="divider"></li>
    <li> <a href="#">qq登录</a></li>
  </ul>
</div>
```

2.标签页
- nav-tabs
- nav-pills - 胶囊式
- nav-stacked - 垂直排列
- active - li加： 默认显示

```
<ul nav nav-tabs>
  <li class="active"><a href="#"></a></li>
  <li><a href="#"></a></li>
  <li><a href="#"></a></li>
</ul>
```

#### 16.导航
- navbar - 基类
- navbar-default - 默认样式
- navbar-fixed-top - 锁定在顶部
- navbar-inverse - 取反
```
<nav class="navbar">
  <div class="container">
    <div class="navbar-header"> 
      <a href=""><img src=""/></a>
    </div>
    // 标签页
  </div>
</nav>

<div class="container">
  <p>内容</p>
</div>
```

#### 17.默认分页