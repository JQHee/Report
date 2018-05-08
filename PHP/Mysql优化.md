## 目录

### 1.Mysql优化

  * [1.1 表的设计要合理(满足3NF)3范式](#Mysql_3NF)
  * [1.2 创建适当索引[主键索引|唯一索引|普通索引|全文索引|空间索引]](#Mysql_index)
  * [1.3 对SQL语句优化 -> 定位慢查询(explain(工具))](#Mysql_explain)
  * [1.4 使用分表技术(重点【水平分表、垂直分表】), 分区技术（了解）](#Mysql_table)
  * [1.5 读写分离（只要配置即可）]()
  * [1.6 创建适当存储过程、函数、触发器]()
  * [1.7 对my.ini优化，优化配置](#Mysql_myini)
  * [1.8 软件硬件升级]()
    

#### <a id="Mysql_3NF"></a> 1.1 表的设计要合理(满足3NF)3范式
1.1.1 概述：目前我们表的设计，最高级别的范式是"6NF",对PHP程序员来说，我们的表满足3FN即可。

1.1.2 1NF

  - (1)指表的属性（列）有原子性，即表的列不能再分了。（列本身含义精准）
  - (2)不能有重复的列
  
特殊：

  - 只要是关系型数据库，就天然满足1NF
  
1.1.3 2NF

  - 所谓2NF是指在我们表中不能存在一条完全相同的记录，一般通过设置一个主键，而该主键是自增的。

1.1.4 3NF

  - 所谓3NF是指，如果列的内容可以推导（显式推导，隐式推导）出，那就不要单独一列存放。（例如外键即可以推导出信息）

1.1.5 反3NF

  - 在通常情况下，我们的表的设计要严格遵守3NF,但也有例外，反而提高查询的效率。

```
// 相册 (views浏览的总次数)
id name views

// 相册的流量图片 （当有人查看图片，通过触发器更新相册浏览的总次数+1）
id name views

```

#### <a id="Mysql_inde"></a> 1.2 创建适当索引[主键索引|唯一索引|普通索引|全文索引|空间索引]

1.2.0 构建海量表，定位慢查询

  - 为了讲解这个优化，我们需要构建一个海量表（800000），而且每条数据不一样。这时我们需要存储过程完成任务
    - 构建海量表
  
```
#创建表DEPT  
  
  
  
CREATE TABLE dept( /*部门表*/  
deptno MEDIUMINT   UNSIGNED  NOT NULL  DEFAULT 0,  
dname VARCHAR(20)  NOT NULL  DEFAULT "",  
loc VARCHAR(13) NOT NULL DEFAULT ""  
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;  
  
  
  
#创建表EMP雇员  
CREATE TABLE emp  
(empno  MEDIUMINT UNSIGNED  NOT NULL  DEFAULT 0,  
ename VARCHAR(20) NOT NULL DEFAULT "",  
job VARCHAR(9) NOT NULL DEFAULT "",  
mgr MEDIUMINT UNSIGNED NOT NULL DEFAULT 0,  
hiredate DATE NOT NULL,  
sal DECIMAL(7,2)  NOT NULL,  
comm DECIMAL(7,2) NOT NULL,  
deptno MEDIUMINT UNSIGNED NOT NULL DEFAULT 0  
)ENGINE=MyISAM DEFAULT CHARSET=utf8 ;  
  
#工资级别表  
CREATE TABLE salgrade  
(  
grade MEDIUMINT UNSIGNED NOT NULL DEFAULT 0,  
losal DECIMAL(17,2)  NOT NULL,  
hisal DECIMAL(17,2)  NOT NULL  
)ENGINE=MyISAM DEFAULT CHARSET=utf8;  
  
INSERT INTO salgrade VALUES (1,700,1200);  
INSERT INTO salgrade VALUES (2,1201,1400);  
INSERT INTO salgrade VALUES (3,1401,2000);  
INSERT INTO salgrade VALUES (4,2001,3000);  
INSERT INTO salgrade VALUES (5,3001,9999);  
  
# 随机产生字符串  
#定义一个新的命令结束符合  
delimiter $$  
#删除自定的函数  
drop  function rand_string $$  
  
#这里我创建了一个函数.  
  
create function rand_string(n INT)  
returns varchar(255)  
begin  
 declare chars_str varchar(100) default  
   'abcdefghijklmnopqrstuvwxyzABCDEFJHIJKLMNOPQRSTUVWXYZ';  
 declare return_str varchar(255) default '';  
 declare i int default 0;  
 while i < n do  
   set return_str =concat(return_str,substring(chars_str,floor(1+rand()*52),1));  
   set i = i + 1;  
   end while;  
  return return_str;  
  end $$  
  
  
delimiter ;  
select rand_string(6);  
  
# 随机产生部门编号  
delimiter $$  
drop  function rand_num $$  
  
#这里我们又自定了一个函数  
create function rand_num( )  
returns int(5)  
begin  
 declare i int default 0;  
 set i = floor(10+rand()*500);  
return i;  
  end $$  
  
  
delimiter ;  
select rand_num();  
  
#******************************************  
#向emp表中插入记录(海量的数据)  
  
  
delimiter $$  
drop procedure insert_emp $$  
  
  
  
create procedure insert_emp(in start int(10),in max_num int(10))  
begin  
declare i int default 0;  
 set autocommit = 0;    
 repeat  
 set i = i + 1;  
 insert into emp values ((start+i) ,rand_string(6),'SALESMAN',0001,curdate(),2000,400,rand_num());  
  until i = max_num  
 end repeat;  
   commit;  
 end $$  
  
  
delimiter ;  
#调用刚刚写好的函数, 1800000条记录,从100001号开始  
call insert_emp(100001,1800000);  
  
  
#**************************************************************  
#  向dept表中插入记录  
  
delimiter $$  
drop procedure insert_dept $$  
  
  
create procedure insert_dept(in start int(10),in max_num int(10))  
begin  
declare i int default 0;  
 set autocommit = 0;    
 repeat  
 set i = i + 1;  
 insert into dept values ((start+i) ,rand_string(10),rand_string(8));  
  until i = max_num  
 end repeat;  
   commit;  
 end $$  
  
  
delimiter ;  
call insert_dept(100,10);  
  
  
  
  
  
#------------------------------------------------  
#向salgrade 表插入数据  
delimiter $$  
drop procedure insert_salgrade $$  
create procedure insert_salgrade(in start int(10),in max_num int(10))  
begin  
declare i int default 0;  
 set autocommit = 0;  
 ALTER TABLE emp DISABLE KEYS;    
 repeat  
 set i = i + 1;  
 insert into salgrade values ((start+i) ,(start+i),(start+i));  
  until i = max_num  
 end repeat;  
   commit;  
 end $$  
delimiter ;  
#测试不需要了  
#call insert_salgrade(10000,1000000);  
  
  
#---------------------------------------------- 
```

- 1.2.1 索引的创建

```
// 主键索引的创建
主键索引的创建有两种形式：
1.在创建表的时候，直接指定某列或者某几列为主键，这时就有主键索引
2.添加表后，再指定主键索引
// 1.直接创建主键索引
create table aaa(id int primary key, name varchar(32) no null default '');
// 2.先创建表，再指定主键
create table bbb(id int, name varchar(32) no null default '');
// 增加主键
alert table 表名 add primarykey(列名1,列名2...);
// 列如
alert table bbb add primarykey(id);
主键索引的特点：
  - 一个表最多只能有一个主键
  - 一个主键可以指向多列（复合主键）
  - 主键索引的效率最高，因此我们应该id,一般id自增
  - 主键不能不能重复，也不能为null
```

```
// 唯一索引的创建
直接在创建表的时候，指定某一列或者某几列为唯一索引
把表创建好后，再指定某一列或者某几列为唯一索引
create unique index uni_email on ddd(email);
alter table ddd add unique (email);
```

```
// 普通索引的创建
create index ind_name on eee (name);
alter table eee add index (name);

```

```
// 全文索引的创建（主要针对文章、汉字、英文的检索，可以快速检索到文章的关键词，数据表引擎myisam）
FULLTEXT(title,body)
// 使用
select * from articles where match(title,body) against('database');

解决mysql全文索引不支持中文的问题：
1.使用mysql的一个中文全文插件mysqlcft  
2.可以使用专门的中文检索引擎sphinx中文版（coreseek）

特点：
- mysql全文索引，只支持引擎myisam
- mysql全文索引，默认只支持英文
- 停止词，对应特别普通的字母不会见索引
- 匹配度，按一定的概率来匹配

```

- 1.2.2 索引的的查询

```
desc 表名
show keys from 表名\G
show index from 表名\G
show indexes from 表名\G
```
- 1.2.3 索引的的修改

```
先删除，再添加
```
- 1.2.4 索引的的删除

```
drop index 索引名 on 表名;
alter table 表名 drop index 索引名;
```
- 1.2.5 索引的的原理

```
btree(b树)
```

- 1.2.6 索引的的注意事项

- 1.2.7 mysql优化

```
下列的几种情况有可能使用到索引：
1.对于创建的队列（复合）索引，只要查询条件使用了最左边的列（dname）,索引一般就会被使用
2.对于使用like查询，查询的结果是'%aaa'_不会使用索引 'aaa%'会使用到索引
// 复合索引
alter table dept add index (dname,loc);

// 下列的表将不使用索引
1.如果条件中有or,则要求or的所有字段都必须有索引，否则不能用索引。
2.队列多列索引，不是使用第一部分，则不会使用索引
3.like查询是以%开头
4.如果类型是字符串，那一定要在条件中将数据使用引号引用起来，否则不使用索引。（添加时，字符串必须"）
5.如果mysql估计使用全表扫描使用索引快，则不使用索引。
```

- 1.2.8 管理员大批量导入数据（了解）

```
对于MyISAM:
alter table table_name disable keys; // 禁用所有的键，不然导入会很慢，一个检测
loading data // insert语句
alter table table_name enable keys;

对于Innodb:
1.将要导入的数据按照主键排序
2.set unique_check=0; // 关闭唯一性校验
3.set autocommit=0; // 关闭自动提交

```

- 1.2.9 选择合适的存储引擎

  - MyISAM: 默认的Mysql存储引擎，如果应用是以读操作和插入为主，只有很少的更新和删除操作，并且对事务完整性不高，其优势访问速度快。（尤其适合论坛帖子/信息表/新闻/商品表）。
  - InnoDB: 提供了具有提交、回滚和崩溃恢复能力的事务安全，但是对于myisam,写的处理效率差一些并且占用更多的磁盘空间（如果对安全性要求高，则使用innodb）[账号、积分、余额]
  - Memory/heap [一些访问频繁，变化频繁，又没有必要入库的数据，比如用户的在线状态]，当mysql重启，表结构还在，数据已被清空

- 1.3.0 选择合适的类型

  - 在精度要求高的应用中，建议使用`定点数`来存储数值，以保证结果的准确性。decimal不要用float
  - 对于存储引擎是myisam的数据库，如果经常删除和修改记录的操作，要定时执行optimize table table_name;功能对表进行`碎片整理`。
  - 日期类型要根据实际需要选择能够满足应用的最小存储日期的类型(msql int 和 php int数据类型长度不一样) Datetime
  
  ```
  // 时间戳转
  $d = new DateTime('@21444444448');
  $d = setTimezone(new DateTimeZone('RPC'));
  echo $d->format('Y-m-d H:i:s');
  
  // 转成时间戳 或者使用strtoTime('2019-08-01 19:33:20');
  $d = new DateTime('2019-08-01 19:33:20');
  echo $d -> format('U');
  ```

#### <a id="Mysql_explain"></a> 1.3 对SQL语句优化 -> 定位慢查询(explain(工具))

```
// 方法一
mysql> show variables like "%long%";  // 查看一下默认为慢查询的时间10秒
mysql> set global long_query_time=2;  // 设置成2秒，加上global,下次进mysql已然生效
mysql> show variables like "%slow%";          //查看一下慢查询是不是已经开启 
mysql> set slow_query_log='ON';                        //加上global，不然会报错的。
mysql> set global slow_query_log='ON';            //启用慢查询 
mysql> show variables like "%slow%";              //查看是否已经开启  
```

```
// 方法2,修改mysql的配置文件my.cnfgeneral_log
long_query_time = 2  
log-slow-queries = /usr/local/mysql/mysql-slow.log  

// 重启一下mysql服务
/usr/local/mysql/libexec/mysqld restart
[root@BlackGhost mysql]# cat mysql-slow.log     //查看命令 
```

#### <a id="Mysql_table"> </a>1.4 使用分表技术(重点【水平分表、垂直分表】), 分区技术（了解）
当一个表很大时，我们可以考虑添加索引，当索引都解决不了这个问题时，我们使用分表或者分区技术搞定。

1.4.1 水平分割表(大表和小表的结构一样的)
如QQ登录 `表qq_number(假如10G)` id  id%3
子表 `qq_number0`  `qq_number1` `qq_number2`
`create table  qq_number1 like qq_number0`;

// 注册，后台通过算法生成一个唯一id或者uuid
定表`$table_name = "qq_number".$id%3`;

1.4.2 垂直分割表(了解)
所谓垂直分隔，就是把表中某个大字段（而且很少查询），单独取出放入另外一个表，并通过id关联
考试成绩表： id stuid questionid answer(大字段) grade (如：id=1)
学生表：stuid name
问题表：quetionid
answer(大字段)：id answer（如：id=1）

1.4.3 对表的分区（了解）

- 分区允许根据指定的规则，跨文件系统分配单个表的多个部分，表的不同部分在不同的位置被存储为单独的表。MySQL从5.1.3开始支持Partition.
- 分表和分区的区别:

<br/>

| 手动分表 | 分区 |
| :-: | :-: |
| 多张数据表 | 一张数据表 |
| 重复数据的风险 | 没有重复数据的风险 |
| 写入多张表 | 写入一张表 |
| 没有统一的约束限制 | 强制的约束限制 |

<br/>

实际案例：每年作为一个分区
  当某个表海量，而且我们的查询条件按照日期来检索。
  
分区的限制：

  - 只能对数据表的整型列进行分区，或者数据列可以通过分区函数转化成整型列。
  - 最大分区数目不能超过1024
  - 如果含有唯一索引或者主键，则分区列必须包含所有的唯一索引或者主键在内。
  - 不支持外键。
  - 不支持全文索引（fulltext）
  - 按日期进行分区非常适合，因为很多日期函数可以用。但是对于字符串来说，合适的分区函数不太多。

#### <a id="Mysql_myini"></a> 1.7 对my.ini优化，优化配置

  - 最主要的参数就是内存，我们主要用的innodb引擎，所以下面两个参数调得很大
    - `innodb_additional_mem_pool_size = 64M`
    - `innodb_buffer_pool_size = 1G`
  - 对于myisam,需要调整`key_buffer_size`,当然调参数还是主要看状态，用`show status`语句查看当前状态，以决定改哪些参数
  - 在`my.ini`修改端口3306，默认存储引擎和最大连接数 `max_connections 100 ==> 调到2500`
  - `query_cache_size 100m`