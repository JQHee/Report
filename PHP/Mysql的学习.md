# 一、阶段
分三个阶段
1.基础阶段：基本操作（增删改查）
2.优化阶段：高级用法、索引、分表
3.部署阶段：搭建服务器，如服务器集群、负载均衡

# 二、数据库

1.数据库：高效存储和处理数据的介质（介质：磁盘和内存）

2.数据库的分类： 
数据库基于存储介质的不同：进行了分类：关系型数据库（SQL）和非关系型数据库（NoSql: Not Only SQL）

3.关系型数据库：
  - 大型： Oracle,DB2
  - 中型： SQL-SERVER,Mysql等
  - 小型： access等

关系型数据库：memcached, mongodb, redis(同步到磁盘)

4.两种数据库阵营的区别？
关系型数据库：安全（保存磁盘基本不可能丢失），容易理解，比较浪费空间（二维表）
非关系型数据库： 效率高（运行在内存中）、不安全（断电丢失）

# 三、关系型数据库
1.什么是关系型数据库？
关系型数据库：是一种建立在关系模式（数学模型）上的数据库。
关系模式： 一种所谓建立在关系上的模型。
关系模型包含三个方面：
  - 数据结构： 数据存储的问题，二维表（有行有列）
  - 操作指令集合：所有SQL语句
  - 完整性约束： 表内数据约束（字段与字段），表与表之间约束（外键）
  
2.关系型数据库的设计？
关系型数据库：从需要存储的数据需求中分析，如果是一类数据（*实体*）应该设计成一张二维表：
表由表头（字段名：用来规定数据名字）和数据部分组成（实际存储的数据单元）。

以实际案例来处理：分析一个教学系统，讲师负责教学，教学生，在教室教学生
a.找出系统中存在的实体：讲师表、学生表、班级表
b.找出实体中应存在的数据信息：
  - 讲师：姓名，性别，年龄，工资
  - 学生：姓名，性别，学号，学科
  - 班级：班级名字，教室编号
  
关系型数据库：维护实体内部，实体与实体之间的联系
实体内部联系：每个学生都有姓名，性别，学号，学科信息

**学生表**
| 姓名 | 性别 | 学号 | 学科 | 年龄|
| - | - | - | - | - |
| 陈明 | 男 |it-0001 | php | 20 |
| 陈一 | 男 |it-0002 | php | 20 |
| 陈二 |  |it-0003 | php |  |

第二行的所有字段，都是在描述陈明这个学生（内部联系）；第二列只能放性别（内部约束）

关系型数据库特点之一： 如果表中对应的某个字段没有值（数据），但是系统依然要分配空间：关系型数据库比较浪费
实体与实体之间的联系：每个学生肯定属于某个班级，每一个班一定有多个学生（一对多）

**学生表**
| 姓名 | 性别 | 学号 | 学科 | 年龄|
| - | - | - | - | - |
| 陈明 | 男 |it-0001 | php | 20 |
| 陈一 | 男 |it-0002 | php | 20 |
| 陈二 |  |it-0003 | php |  |

**班级表**
| 班级名称 | 班级编号 |
| - | - |
| php一班 | 001 |
| php二班 | 002 |
| php三班 | 003 |

解决方案：在学生表中增加一个班级字段来指向班级（必须能够唯一的找到一个班级的信息）
| 姓名 | 性别 | 学号 | 学科 | 年龄| 班级名称 |
| - | - | - | - | - | - |
| 陈明 | 男 |it-0001 | php | 20 | php一班 |
| 陈一 | 男 |it-0002 | php | 20 | php二班 |
| 陈二 |  |it-0003 | php |  | php三班 |
学生实体与班级实体的关联关系：实体与实体之间的关系

# 四、关键字说明
数据库：database
数据库系统：DBS(Database System),是一种虚拟系统，将多种内容关联起来的称呼
DBS = DBMS + DB
DBMS: Database Management System,数据库管理系统，专门管理数据库
DBA: Database Administrator,数据库管理员

行/记录：row/record 本质是一个东西：都是指表中的一行（一条记录），行是结构角度出发，记录是从数据角度出发
列/字段：column/field 本质是一个东西

# 五、操作指令集合SQL
SQL: structured Query Language,结构化查询语言（数据以查询为主）
SQL分为三个部分：
  - DDL: Data Definition Language,数据定义语言，用来维护存储数据的结构（数据库、表），代表指令create，drop，alter等
  - DML: Data manipulation Language,数据库操作语言，用来对数据进行操作（数据表中的内容），代表指令：insert,delete,update等，其中DML内部又单独进行了一个分类 *DQL*（Data Query Language: 数据查询语言，如：select）
  - DCL: Data Control Language,数据控制语言，主要是负责权限管理（用户），代表指令：grant,revoke等
  
SQL是关系型数据库的操作指令，SQL是一种约束，但不强制（类似W3C）不同的数据库产品（如：Oracle,Mysql）可能内部会有一些细微的区别。
  

# 六、Mysql数据库
Mysql数据库是一种c/s结构软件：客户端/服务端，若想访问服务器必须通过客户端（服务器一直运行，客户端在需要使用的时候运行）

交换方式：
  - 1.客户端
  - 2.客户端发送SQ指令
  - 3.服务端接收SQL指令，处理SQL指令，返回操作结果
  ```
  mysql.exe -hlocalhost -P3306 -uroot  -p
  ```
  - 4.客户端接收结果：显示结果
   
  ```
  show databases; -- 查看所有数据库
  ```
  - 5.断开连接（释放资源，服务器并发限制）exit/quit/\q
  
#### 1.新增数据库
基本语法：
```
create database 数据库名字[库选项]
库选项：用来约束数据库，分为两个选项
字符集设定：charset/character set 具体字符集（数据存储的编码方式）常见的字符集 GBK 和UTF8
校对集设定：collate 具体校对集（数据的比较规则）
```
```
-- 创建一个数据库 数据库名称不能用关键字或者保留字，如果非要使用则需添加反引号

-- 双中划线 + 空格：注释（单行注释），也可以使用#号
-- 创建数据库
create database mydatabase charset utf8;

-- 创建数据库，使用反引号
create database `database` charset utf8;
```

#### 2.查看数据库
```
-- 查看所有数据库
show databases;

-- 模糊查询
-- %:表示匹配多个字符
-- _:表示匹配单个字符
show database like 'pattern\_%';

-- 查看数据库的创建语句
show create database mydatabase;
```

#### 3.更新数据库
```
-- 数据库名字不可以修改
-- 数据库的修改仅限库选项：字符集和校对集
alter database 数据库名字 [库选项]
```

#### 4.删除数据库
```
drop database 数据库名字;
```

# 七、表操作
#### 1.新增数据表next -> 13
-- 先进入数据环境
*use 数据库名字;*
```
create table [if not exists] 表名（
  字段名 数据类型,
  字段名 数据类型 -- 最后一行不需要逗号
)[表选项]
表选项： 控制表的表现
  - 字符集：charset/character set具体字符集 -- 保证表中数据存储的字符集
  - 校对集：collate 具体校对集
  - 存储引擎：engine具体的存储引擎（innodb 和myisam）
```
```
-- 创建一个表
create table if not exists student (
name varchar(10),
gender varchar(10),
number varchar(10),
age int,
) charset uft8;
```
主键
```
-- 增加主键
create table my_pril(
name varchar(20) not null comment '姓名',
number varchar(10) primary key comment '学号：number + 0000'
)charset utf8;

-- 复合主键
create table my_pril2(
number varchar(10) comment '学号：number + 0000',
courese char(10) comment '课程代码：',
score tinyint unsigned default 60 comment '成绩'
primary key(number, courese)
)charset utf8;

-- 当前已经创建之后，在额外追加主键
Alter table 表名 modify course char(10) primary key comment '';
Alter table 表名 add primary key(course);

-- 删除主键
alter table 表名 drop primary key;

```

自动增长
```

-- 自增长特点： auto_increment
1.任何一个字段要做自增长必须前提是本身的一个索引（key一栏有值）
2.自增长字段必须是数字（整型）
3.一张表最大只有一个
create table my_auto (
id  int primary key auto_increment comment '自动增长',
name varchar(10) comment '名称'
);
```
唯一键(unique)：约束内容唯一
```
CREATE TABLE Persons(
Id_P int NOT NULL,
LastName varchar(255) NOT NULL,
FirstName varchar(255),
Address varchar(255),
City varchar(255),
UNIQUE (Id_P)
);
```

# 八、事务
#### 1.手动开启事务
```
start transaction;
commit;
rollback;
```

#### 2.自动事务处理
```
show variables like 'autocommit';
-- 关闭自动事务
set autocommit = 0;
```

# 九、连接查询
连接查询：join 使用方式：左表 join 右表
#### 1.交叉连接(应该避免使用)
交叉连接： cross join 从一张表中循环取出每一条记录，每条记录都去另外一张表匹配：匹配一定保留（没有条件匹配），而连接本身字段就会增加（保留），最终形成的结果叫做：迪卡尔积（没有实际意义，实际上用不到）。
基本语法：左表 cross join 右表; ===== from 左表，右表；
```
select * from my_student cross join my_class;
```
#### 2.内连接（常用)
内连接：[inner] join, 从左表中取出一条记录，去右表中与所有记录进行匹配；
匹配是某个条件在左表中与右表中相同才会保留结果，否则不保留。
基本语法：[inenr] join 右表 on 左表.字段 = 右表.字段；on 表示连接条件：条件字段就是代表相同的业务含义（如：my_student.c_id 和 my_class.id）
内连接可以没有连接条件：没有on之后的内容，这个时候系统会保留所有结果（迪卡尔积）
内连接还可以使用where 代替 on关键字（where 没有 on效率高）
```
select * from my_student inner join my_class on my_student.c_id = my_class.id;
-- 字段别名以及表别名的使用：在查询数据的时候，不同表有同名字段，这个时候需要加上表名才能区分，而表名太长，通常可以使用别名。
-- 字段和表别名
select s.*, c.name as c_name, c.room from my_student as s inner join my_class as c on s.c_id = c.id;


```
#### 3.外连接（常用)）
外连接：outer join ,以某张表为主，取出里面的所有记录，然后每条与另外一张表进行连接：不管内不能匹配上条件，最终都会保留，能匹配，正确保留；不能匹配，其它表的字段都置空NULL

外连接分为两种：是以某张表为主： 有主表
  - Left join: 左外连接（左连接），以左表为主表
  - Right join: 右外连接（右连接），以右表为主表
  
基本语法：左表 left/right 右表 on 左表.字段 = 右表.字段；
```
-- 左连接
select s.*, c.name as c_name, c.room from my_student as s left join my_class as c on s.c_id = c.id;

-- 右连接
select s.*, c.name as c_name, c.room from my_student as s right join my_class as c on s.c_id = c.id;
```
#### 4.自然连接（不常用)
自然连接： natural join, 自然连接，就是自动匹配连接条件，系统以字段名字作为匹配模式（同名字段就作为条件，多个同名字都作为条件）。
自然连接：可以分为自然内连接和自然外连接。
  - 自然内连接： 左表 natural join 右表；
  - 自然外连接： 左表 natural left/right join 右表；
```
-- 自然内连接
select * from my_student natural join my_class;
```