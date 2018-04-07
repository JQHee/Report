# 一、www（why + what + how）
1.项目的意义（why？）
- 1.1 oop和mvc掌握得怎么样

2.项目的定位(what？)
- 2.1 web开发（b/s模式软件开发）

3.项目的规划(how？)

# 二、编程思想
##### 1. oop思想

  oop: 面向对象程序设计
  核心思想： 使用人类思考问题、解决问题的方式来编写程序
  oop三大特征：
  - 1.封装
  - 2.继承
  - 3.多态
  
  oop好处：可重用、可拓展、可维护、灵活性高

##### 2. mvc模式【思想】

# 三、项目的搭建
1.良好的项目结构
2.统一的命名规范
3.单一的入口

##### 1.项目结构
- application - 应用程序目录
  - controllers - 控制器目录
    - admin - 后台目录
    - home - 前台目录
    
  - models - 数据库模式目录
  
  - views - 视图目录
    - admin - 后台目录
    - home - 前台目录
    
  - config - 配置文件目录
  
- framework - 框架目录
  - core - 框架核心类
  - databases - 数据库驱动类
  - libraries - 类库目录
  - helpers - 辅助函数目录
  
- public - 前台资源目录
  - css
  - js
  - images
  - uploads
  
- index.php - 入口文件

# 四、编码规范
1. 一定要有注释
2. 一定要有统一的命名规范
  - 类文件 类名.class.php 
  (类名首字母大写，大驼峰命名法,如：GoodsController  方法名：小驼峰， 如：addAction 
  属性：小驼峰/或者下划线开头)
  函数名：下划线式：var_dump、is_array 连写式：imagecreatetruecolor
  常量名：大写
  
3. 严格区分大小写
4. 主要缩进，代码对齐

# 五、TP框架
IDE: NetBeans
ctr + H 替换 
ctr + Shift+ H 全局替换
ctr + G 定位行号 
```
// 使用常量来替换
<?php echo IMAGE_URL; ?>
```
1.下载地址：http://www.thinkphp.cn/down.html
2.搭建应用
- 2.1 创建index.php入口文件
```
<?php
// 避免汉字出现乱码
header ("content-type:text/html;charset=utf-8;");
// 打开开发调试模式,另一种是生产模式
#define('APP_DEBUG',true);
// 在模板文件需要绝对路径引用静态资源文件（css/js/image），路径常量
// Home前台
define('CSS_URL','/ecshop/Home/Public/css/');
define('IMAGE_URL','/ecshop/Home/Public/images/');
define('JS_URL','/ecshop/Home/Public/js/');

// Admin后台
define('ADMIN_CSS_URL','/ecshop/Admin/Public/css/');
define('ADMIN_IMAGE_URL','/ecshop/Admin/Public/img/');
define('ADMIN_JS_URL','/ecshop/Admin/Public/js/');
// 引用tp框架接口文件
include ("../ThinkPHP/ThinkPHP.php");
```
- 2.2 创建虚拟主机(apache 目录：apache2/conf/extra/httpd-vhosts.conf)

- 2.3 重启apache, 增加域名解析 (hosts)

- 2.4 第一次运行会自动生成目录：
  - Common - 项目的函数库和配置文件
  - Home - 分组目录
    - Public - 静态资源文件（js、css、image）
  - Admin - (自己创建后台文件夹)
  - Model - 数据库模型文件
  - Runtime - 产生的临时文件（如日志）
  - Tools - 工具类

3.路由形式(四种路由形式)
- 3.1 基本get
  - http://网址/index.php?g=分组&c=控制器&a=操作方法 （如：index.php?m=Home&c=Index&a=index）
  
- 3.2 pathInfo 路径形式【默认】
  - index.php/Home/Index/index.html
  
- 3.3 伪静态形式
  - 省略index.php入口文件
  
- 3.4 兼容形式
  - index.php?s=/Home/Index/index.html
  
4.创建控制器
  - 1.tp命名空间
  - 2.名称 UserController.class.php 、GoodsController.class.php
  
5.模板加载
```
// 1.没有参数，表示模板与当前方法名称一致
$this->display();
// 2.调用当前控制器下的其它模板
$this->display(‘register’);
// 3.调用其它控制器的具体模板
$this->display(‘Goods/showList’);
```

6.加载静态资源文件
- 要用(虚拟主机下)绝对路径（/shop/Home/Public/css/style.css）
- 注意：使用相对路径，get形式访问时成功，pathinfo路径形式访问是失败的（原因：把当前方法名当成目录，找不到资源）


7.tb框架提供的常量
```
1. __MODULE__: - 路由地址分组信息 （/shop/index.php/分组）

2.__CONTROLLER__: - 路由地址控制器信息 （/shop/index.php/分组/控制器）

3.__ACTION__: - 路由地址操作方法信息 （/shop/index.php/分组/控制器/操作方法）

4.__SELF__: - 路由地址全部信息 （/shop/index.php/分组/控制器/操作方法/名称1/值）

5.MODULE_NAME: - 分组名称

6.CONTROLLER_NAME: - 控制器名称

7.ACTION_NAME: - 操作方法名称
```

8.配置文件
- 1.ThinkPHP/Conf/convertion.php 系统主要的配置文件
- 2.shop/Common/Conf/config.php 当前shop项目的配置文件，针对各个分组起作用
- 3.shop/Home/Conf/config.php  当前shop项目Home分组 
- **备注： 以上三个配置文件，如果存在同名的配置变量，后者覆盖前者**

```
// shop/Common/Conf/config.php
<? php
return array {
  // 显示页面底部的跟踪信息
  'SHOW_PAGE_TRACE' => true,
  // 默认分组
  ‘DEFAULT_MODULE’ => 'Home',
  // 设置一个对比的分组列表
  ‘MODULE_ALLOW_LIST’ => array('Home','Admin'),
  // 开启Smarty模板引擎
  ‘TMPL_ENGING_TYPE’ => 'Smarty',
  // 变换smarty标记符号
  'TMPL_ENGING_CONFIG' => array (
    'left_delimiter' => '<%%%',
    'right_delimiter' => '%%%>',
  ),
  
    /* 数据库设置 */
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  'localhost', // 服务器地址
    'DB_NAME'               =>  '',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  '123456',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'sw_',    // 数据库表前缀
    'DB_PARAMS'          	=>  array(), // 数据库连接参数    
    'DB_DEBUG'  			=>  TRUE, // 数据库调试模式 开启后可以记录SQL日志
    'DB_FIELDS_CACHE'       =>  true,        // 启用字段缓存
    'DB_CHARSET'            =>  'utf8',      // 数据库编码默认采用utf8
    'DB_DEPLOY_TYPE'        =>  0, // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    'DB_RW_SEPARATE'        =>  false,       // 数据库读写是否分离 主从式有效
    'DB_MASTER_NUM'         =>  1, // 读写分离后 主服务器数量
    'DB_SLAVE_NO'           =>  '', // 指定从服务器序号
}
```

# 六、开启Smarty模板引擎
注意：如果不开启Smarty模板引擎，默认使用tp框架的Think模板引擎
1.{}与css/js有冲突
  - {}中间加空格 如：{ 内容 }
  - {} 左右标记不在同一行
  - 设置{literal}{\literal}
  - 外部引用js/css文件
  - 变换smarty标记符号
  
2.访问静态变量
  - 访问常量 {$smarty.const.CSS_URL}

# 七、数据库操作Model模型文件
备份数据库：终端命令->mysqldump -u root -p 数据库名>备份的名称（xx.sql）
1.连接和配置数据库
2.创建model模型类
```
// GoodsModel.class.php
<? php
// 命名空间 php5.3以后的版本
namespace Model;
user Think\Model;

// 表名：sw_goods
class  GoodsModel extends Model {
}

// 表名：englist ，特殊表没有sw_前缀开头
class  EnglistModel extends Model {
  //自定义当前model操作的真实数据表名字
  // 实际数据表（包含表前缀）
  protected $trueTableName = 'englist';
}
```

3.操作Model
```
// 1.实例化model对象
$goods = new \Model\GoodsModel();
dump($goods)

// 2.实例化父类model对象,操作sw_goods数据表
$obj = D('Goods');
dump($obj)
```

4.数据库的基本操作
- 增
```
$model -> add();
// 1.数组的方式
$数组 = {
  元素 => 值,
};
$model -> add($数组);

// 2.AR(Active Record活跃记录)方式
$model -> 属性 = 值;
$model -> add()
```
- 删
```
$z = $model -> where("password='123456'") -> delete();

或者
$model -> user_id=8;
$z = $model -> delete();

或者
$model -> delete(10);
$z = $model -> delete("11,21");
```

- 改
```
// 1.数组
$model -> where('goods_id =167');
$model -> save($数组);

// 2.AR
$model -> where('goods_id =167');
$model -> save();

```

- 查
```
// select返回的是一个二维数组
$model -> select(); // 查询并返回数据表中的全部信息
$model -> select(主键id值); // 查询主键信息等于条件id值的一条记录
$model -> select('id1,id2...');

// 1.where()条件限制
$model -> where('goods_price > 1000 and goods_name like "12%"');
$model -> select();

// 2.limit() 记录数目限制
$model -> limit(5);
$model -> select();

// 3.field() 限制查询字段
$model -> field('goods_name, goods_id');
$model -> select();

// 4.oder()排序
$model -> order('goods_price ase');
$model -> select();

// 5.group() 分组查询 ,不推荐使用，推荐使用原生的sql语句查询
// 查询每个品牌的商品总数量
$model -> group('goods_branch_id');
$model -> field('goods_id,count(*)');
$model -> select();

// 6.find() 返回一维数组的一条信息
$info = $model -> find($goods_id);
dump($info);
```
```
having() 设置sql语句查询条件
group by 就使用 having
where 和 having 都可以设置查询条件，两种在某些场合可以通用
where: 条件必须是‘数据表’存在的字段
having: 条件必须是‘结果集’中的字段

// 1.两种可以通用
select * from sw_goods where goods_price > 1000;
select * from sw_goods having goods_price > 1000;

// 2.不能使用having
select goods_name, goods_id from sw_goods where goods_price > 1000;
select goods_name, goods_id from sw_goods having goods_price > 1000; // 错误

// 3.只能使用having
select goods_branch_id,count(*) as cnt from sw_goods having cnt > 3;
select goods_branch_id,count(*) as cnt from sw_goods where cnt > 3; // 错误
```
4.1 连贯操作

5.数据填充到模板
```
$this -> assign('info',$info);

// html文件 smarty
{foreach $info as $k => $v}
  <tr>
    <td> {*$v@iteration*} {$v.goods_id} </td>
  </tr>
{/foreach}

```

# 八、数据上录处理
1.数据添加
```
function tianjia() {
  $goods = D('Goods');
  if (!empty($_POST)) {
    $data = $goods -> create();
    $res = $goods -> add($data);
    if $res { // 添加成功
      //$this -> redirect(地址, 参数
      , 间隔时间, 提示信息)
      $this -> redirect('showlist', array()
      , 2, 添加商品成功);
    }
  } else {
        $this -> redirect('tianjia', array()
      , 2, 添加商品失败);
  }
}
```

2.数据的修改
传递参数给编辑窗口
通过get参数传递和接收
**传递：index.php/分组/控制器/操作方法/名称/值/名称/值**
**接收： function 方法名称($名称, $名称) {}**
```
// 隐藏域
<input type='hidden' name='goods_id' value={$info.goods_id}/>
```

3.数据删除操作delete
生产环境：逻辑删除,只是修改一个状态,留作跟踪记录

# 九、执行原生sql语句
1.查询语句：$model -> query($sql);
2.添加、修改、删除 $model -> execute($sql);

# 十、注册页面，表单验证
```
function register() {

  $user = new \Model\UserModel();
  if (!empty($_POST)) {
  
    // 把爱好的数组变为字符串
    // $_POST['user_hobby'] = implode(',', $_POST['user_hobby']);
    // $z = $user -> add($_POST);
    
    $data = $user -> create();
    if ($data) {
       // 把爱好的数组变为字符串
      $data['user_hobby'] = implode(',', $data['user_hobby']);
      $z = $user -> add($data);
      echo $z;
    }
    else {
      // 验证失败，输出错误信息
      dump($user -> getError());
    }
    
  } else {
  
  }
}
```
2.具体验证实现
2.1 通过Model->create()方法实现表单信息收集处理工作
create()方法的作用：收集表单信息、非法字段过滤、表单自动验证、信息过滤处理
```
<? php 

namepace Model;
user Think\Model;

class UserModel extends Model {

  // 设置验证规则
  // 自定验证定义
  protected $_validate = array (
    // 1.验证用户名，非空
    // array(字段名称(表单域name名称),验证规则,错误提示,验证条件,附加规则,验证时间)
    array('username','require','用户名不能为空'),
    array('username','require','用户名被占用', 'unique'),
    // 2.密码
    array('password','require','密码不能为空'),
    // 3.重复密码
    array('password2','require','密码不能为空'),
    array('password2','password','与密码保持一致', 0, 'confirm'),
    // 4.邮箱验证
    array('user_email','email','邮箱格式不正确'),
    // 5.qq,纯数字 5-12
    array('user_qq','number','qq号码为数字信息'),
    array('user_qq','5,12','qq号码长度不正确', 0, 'length'),
    // 6.学历
    array('user_xueli','2,3,4,5','学历必须选择一个', 0, 'in'),
    // 6.爱好
    array('user_hobby','check_hobby','爱好至少选择两个至以上', 1, 'callback'),
    // 7.手机号码验证
    array('user_phone','/^1[3|4|5|7|8|9][0-9]\d{4,8}$/','手机号码错误！','0','regex',1),
  );
  
  // $arg参数 代表被收集到的表单信息
  function check_hobby($arg) {
    if (count($arg) < 2) {
      return false;
    } else {
      return true;
    }
  }
}
```

# 十一、验证码
gd库画图
生成4位随机字符
字符画到图片上、字符保存到session中
```
// Verify.class.php
// 生成验证码
function verifyImg() {
  $cfg = array (
    'imageH' => 40,
    'imageW' => 100,
    'fontSize' => 15,
    'length' => 4,
    'fontttf' => '4.ttf', // 字体
  );
  $very = new \Think\Verify($cfg);
  $very -> entry();
}
```
校验验证码
```
function login() {
  if (!empty($_POST)) {
    // 检验验证码
    // $_SESSION[名称]
    $vry = new \Think\Verify();
    if ($vry -> check($_POST['captcha'])) {
      // 验证验证成功
    }
  }
}
```

# 十二、附件上传
```
// html
<form enctype="multipart/form-data"> 
  <input type="file"/>
</form>

// php接收附件信息
$_FILES 接收附件信息
name size tmp_name type error( error: 0 没有问题 1/2 大小限制 3只上传部分附件 4没有上传)

// 功能类 Upload.class.php
func upload() {
  $goods = D('Goods');
  if (!empty($_POST)) {
    // 图片处理
    if ($_FILES['goods_pic']['error']===0) {
      // 设置附件存储位置
      $cfg = array (
        'rootPath' => './Public/Upload/', 保存根路径
      );
      $up = new \Think\Upload($cfg);
      // 上传附件
      $z = $up -> uploadOne($_FILES['goods_pic']);
      //dump($z);
      // 附件保存到数据库中
      $bigPicName = $up -> rootPath.$z['saveath'].$z['savename'];
      $_POST['goods_big_img'] = substr($bigPicName,2); // 去掉./
      
      // 给上传好的图片制作缩略图
      $im = \Think\Image();
      // 打开源图片
      $im -> open($bigPicName);
      // 为原图制作缩略图
      $im -> thumb(125, 125); // 等比例缩放
      // 把制作好的缩略图把存到服务器上
      $smalpicname = $up -> rootPath.$z['saveath']."small_".$z['savename'];
      $im -> save($smalpicname)
      // 把缩略图保存到数据库中
      $_POST['goods_small_img'] = substr($bigPicName,2);
    }
    
    $data = $goods -> create();
    $res = $goods -> add($data);
    
  }
}
```

制作缩略图
原理： 把一个已有图片打开，裁剪已有图片某个部分，该部分经过放大、缩小处理
```
// 功能类： Image.class.php
```

# 十三、数据分页
limit 偏移量，长度
偏移量=（当前页码-1）*每页条数
功能类： Page.class.php
```
// 自定义工具类
// Page.class.php
```

# 十四、登录功能
用户名信息给session持久化

```
function login() {
  if (!empty($_POST)) {
    $userpwd = array (
      'mg_name' = $_POST['admin_user'],
      'mg_pwd' =  $_POST['admin_pwd']
    );
    $info = D('Manager') -> where($userpwd) -> find();
    if ($info) {
      // session持久化用户信息
      session('admin_name', $info['mg_name']);
      session('admin_id', $info['mg_id']);
    }
  }
}
```

# 十五、RBAC
role base access control 基于角色的用户访问权限控制

# 十六、路由设置伪静态
```
// 路由伪静态
// 打开开关
'URL_ROUTE_RULES' => true,

// 规则
'URL_ROUTE_RULES' => array (

),

```