1. zend Framework
2. YII 外企用得挺多的
3. Symfony
4. Laravel
5. CodeIgniter 简称CI
6. ThinkPHP

# 一、fetch模板内容获取
```
display() ==> 展示模板
fetch()   ==> 获取模板（有返回值）==> echo 将结果输出;
打印输出：
echo '<pre>';
var_dump($);
dump($内容);
```

# 二、模板的注释
普通HTML的注释会被输出 <!--普通的注释-->
ThinkPHP中的注释不会被输出：
  - 行注释: {// 注释的内容}
  - 块注释: {/* 块注释内容*/}

# 三、模板输出对象的属性值 (不推荐用点形式{$val.id})
```
{$val : id}
{$val -> id}
```

# 四、系统变量
```
$Think.server = $_SEVER
$Think.get = $_GET
$Think.post = $_POST
$Think.request
$Think.cookie
$Think.session = $_SESSION
$Think.config
```

# 五、视图中的函数
语法:
```
{$变量|函数名1|函数名2=参数1,参数2...}
```
参数说明：
|:变量修饰名
例子：
```
时间戳的格式化 {$time|date='Y-m-d H:i:s',###}
// 第一个参数是自己，可以省略=###
截取字符串，再转成大写 {$val|substr=###,0,5|strtoupper}
```

# 六、默认值
```
{$val|default='默认值'}
```

# 七、文件的包含
把网站的公共部分 如头部、尾部、等部分，单独的存放到一个文件中
```
// 路径相对于入口文件
<inclue file='Application/Public/Admin/Html/需要引入的模板文件'>
// 简写，不需要后缀名
<inclue file='需要引入的模板文件'/>
<inclue file='Test/head'/>

// 可以用来传值给模板
<inclue file='Test/head' 参数名=参数值/>
```

# 八、循环遍历
- Volist
- foreach
```
// 视图中遍历
<volist name='需要遍历的模板遍历名', id='当前遍历到的值'> 

</volist>

<foreach name='需要遍历的模板遍历名', item='当前遍历到的值'> 

</foreach>

// php中的循环体
foreach ($variable as $key => $value) {
}

```
```
// 一维数组的遍历
// 二维数组的遍历
```

# 九、if 标签
```
// if 标签的语法格式：
<if condition='表达式一'>
<elseif condition='表达式二'/>
<else/>
</if>

```

# 十、php标签
```
<?php echo=''?>
<php>echo '输出';</php>
```

# 十一、模型的实例化
1. D方法实例化
```
$obj = D(['模型名']);
表达的含义：实例化我们自己创建的模型（分组/Model目录中）如果传递了模型名。则实例化指定的模型，如果没有指定或者模型名不存在，则直接实例化父类模型（Model.class.php）
```
2. M方法实例化
```
$obj = M(['不带前缀的表名']);
表达的含义：实例化父类的模型（Thinkphp目录中的Model.class）,如果指定了表名，则实例化父类模型的时候关联指定的表，如果指定的表名（没传递参数）则不关联表，一般用于执行原生的sql语句。
```

# 十二、第三天

#### 1.跟踪信息

借助开发工具： 如浏览器自带的`审查元素`

Sql调试： $model -> getLastSql(); => thinkphp 3.2之后 $model -> _sql();

性能调试（了解）：快速方法`G`方法

```

// 开始标志
G('start');

// 耗时代码 如：大循环

// 结束标志
G('stop');
// 统计的时间 默认是4
echo G('start','stop', 4);

```

#### 2.AR模式
AR: Active Record ,是一个对象-关系映射（ORM）技术，每个AR类代表一张数据表（或视图），数据表（或视图）的字段在AR类中体现为类的属性，一个AR实例则表示表中的一行。
  - AR类 ===> 表
  - AR类属性 ===> 表的字段
  - AR类的实例 ===> 表的记录
  ```
  AR模式在ThinkPHP中的典型应用，CURD操作
  // 实例化模型
  $model = M('关联的表')； => AR类
  $model -> 属性/表中字段 = 字段值
  
  // AR实例（操作）映射到表中的记录
  $model -> CURD操作，没有参数

  ```
  
  举例
  ```
  // 第一个映射： 类映射表（类关联表）
  $model = M('Dept');
  // 第二个映射： 属性映射字段
  $model -> name = '技术部';
  $model -> pid = '0';
  ...
  // 第三个映射：实例映射记录
   $model -> add(); // add()不需要参数
  ```
  
  补充说明：`在AR模式中U、D操作必须指定主键信息，但是有一种情况可以不指定主键执行U、D操作，在之前有做过查询语句，则后面没有指定主键，会操作当前查到的记录`

#### 3.辅助方法
- limit
- order
...

#### 4.统计查询
- count() - 表示查询表中总的记录数
- max('id')   - 表示查询某个字段的最大值
- min('id')   - 表示查询某个字段的最小值
- avg('id')   - 表示查询某个字段的平均值
- sum('id')   - 表示查询某个字段的总和

#### 5.fetchSql拓展
getLastSql() 只能调试逻辑错误
fetchSql(true) 调试语法错误 注意只能在ThinkPHP3.2.3之后的版本使用
```
$model -> where -> limit()..-> order() -> fetchSql(true) -> CURD操作
```

#### 6.部门的管理（组织结构）
1.设计二级导航效果
在ThinkPHP可以使用I(快速方法)接收任何的参数，并且系统自动sql防注入的方法（使用php内置方法htmlspecialchars）

#### 7.文件自动载入
```
// 第一种
load('@/tree');

// 第二种
function.php会自动载入

// 第三种
//动态加载文件，配置文件中配置
'LOAD_EXT_FILE'         =>  'tree', 
//包含文件名的字符串，多个文件名之间使用英文半角逗号分割
```

# 十三、第四天
#### 1.数据对象的创建
$model -> create(); 如果不传值，默认取$_POST中的数据

# 十四、第五天
主要内容：分页类、联表查询、hightCharts(国外)，echarts(百度开源)

#### 1.分页类的基本用法(可以参考手册)
```
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
```

#### 2.联表查询

```
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
```

#### 3.报表的使用(hightcharts)
官网地址：https://www.highcharts.com

# 十五、第六天
百度： UEeditor/UMeditor 
http://ueditor.baidu.com/website/

国外：CKedit

layer(jq的插件美化弹窗): 
http://layer.layui.com

因为存储到数据表中的html标签被编码了，字符还原：`htmlspecicalchars_decode`方法

关于使用UE的几个方法
  - 1.方式sql注入和xss：光通过I方法解决不了，在后面我们会使用一个插件`htmlpurifier`来指定标签进行过滤；
  - 2.关于UE表情的使用，这个功能需要联网
  - 3.关于图片上传，该功能需要配置，配置文件中在ue/php/config.json指定上传的路径

# 十五、第七天
邮件：站内信
分为以下几个组成部分：
  - 邮件发送
  - 邮件收件箱
  - 邮件发件箱
  
#### 1.拓展 -> 空操作
空操作指系统在找不到指定操作方法的时候，会定位到空操作方法来执行（针对控制器也是如此）利用这个机制，我们可以实现错误页面和一些URL的优化

关于空操作的说明：
1.空操作方法：控制器中可以定义一个操作方法的名字_empty();
2.空操作控制器，在tp中可以定义一个空的控制器，当指定的控制器找不到，则会去访问空的控制器，空的控制器名字EmptyController.class.php


#### 2.jquery 中ajax回顾
常见的方法 ：`get post ajax getJson(解决跨域的时候使用）`

1.$.get(url,[callback],[type])
参数说明：
  - url: 必须的参数，表示请求的地址
  - callback: 可选参数，回调方法
  - type: 希望请求成功返回数据的类型： json 、xml 、text 、html
  
2.$.post(url,[data],[callback],[type])
参数说明：
  - url: 必须的参数，表示请求的地址
  - data: 请求参数
  - callback: 可选参数，回调方法
  - type: 希望请求成功返回数据的类型： json 、xml 、text 、html
  
3.$.ajax(json)
参数说明：
- json: 参数只有一个json

# 十六、第八天
#### 1.翻墙：
用户没有登录，通过指定的路径就能查看后台的页面

#### 2.RBCA
一般有两种权限管理方式：
  - 1.传统权限分配方式 ： 将权限和用户挂钩
  
  - 2.RBCA(基于用户组)
    - 2.1 基于表结构RBCA
    - 2.2 基于文件结构RBCA
    说明：两者的差异就在数据的存储位置，前者是存储在数据表中（3表、5表）,
    后者是将数据存储在文件中。不管是前者还是后者原理都是一样的。
    基于数据表形式：优点是在后期数据维护上方便，有界面操作数据表，但不易理解。
    基于文件结构的形式：优点在于简单容易理解，但缺点是不易维护，没有维护界面。

用户 角色组 权限

3. 实现OA系统实现RBAC权限管理
1.写在配置文件中config.php文件中
```
// 角色组
'RBAC_ROLES' = array (
    1 => '高层管理',
    2 => '中层领导',
    3 => '普通职员'
),

// 权限组
'RBAC_ROLE_AUTHS' = array (
    1 => '*/*',
    2 => array('index/*','email/*', 'doc/*', 'knowledge/*'),
    3 => array('index/*','doc/*', 'knowledge/*'),
),

```
第二步：在指定的地方去根据用户当前的role_id获取当前用户应该拥有的权限。
第三步：通过`常量`的方式获取当前用户访问的路由中的控制器和方法名
第四步：判断组成的权限形式是否在权限数组中

# 十七、项目上线
  - 1.申请空间
  - 2.购买域名
  - 3.将数据库转移到服务器
  - 4.将项目上传到服务器（注意更改数据库配置）
  - 5.线上浏览测试

#### 1.申请空间
主机屋：http://www.zhujiwu.com/product/freeSpace.html

#### 2.购买域名
http://ftp6224898.host709.zhujiwu.me

#### 3.数据库转移到服务器
本地导入 -> 导出到远程服务器
数据库账号：zjwdb_6224898
密码： Hjq562011

#### 4.将项目上传

ssh