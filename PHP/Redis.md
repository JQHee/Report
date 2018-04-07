redis网址：http://redis.io/
国内社区：http://www.redis.cn/

# 一、nosql简介
nosql产品有两个非常显著的特点：
  - 1.nosql产品一般不使用严格的表结构（行和列组成形成一个表）
  - 2.nosql产品的数据的查询一般都不在使用sql查询
  

# 二、Linux下安装redis
#### 1. 安装材料：
phpredis: https://github.com/owlient/phpredis
redis: https://redis.io/
  - phpredis.tar.gz - php操作redis的拓展包
  - redis.tar.gz - redis的源码包
  
#### 2.上传安装材料到linux服务器
```
// 查看ftp是否已经在运行
service vsftpd status 
// ftp工具
flashxp
```
#### 3.在linux服务上查看源码包信息
```
// 将安装材料复制复制到 /usr/local/src/
cp phpredis.tar.gz redis.tar.gz /usr/local/src/
ls /usr/local/src/
```

#### 4.进入/usr/local/src/目录，进行解压和安装
```
cd /usr/local/src/
tar -zxvf redis.tar.gz
```

#### 5.进入到解压后源码包的目录redis+版本
```
cd redis
make
// 指定安装的目录
make PREFIX=/usr/local/redis install
// 创建配置文件
mkdir /etc/redis
cp redis.conf /etc/redis/
```

#### 6.启动redis

```
cd /usr/local/redis
ls
cd bin/
./redis-server
```
启动redis服务之后，默认是占据终端窗口的，可以使用ctr+c关闭这个服务：
保持redis在后台运行的方法：
  - 修改redis的配置文件
  ```
  vim /etc/redis/redis.conf
  编辑内容：
  daemonize no 改成 daemonize yes
  ./redis-server /etc/redis/redis.conf
  ```
如何查看redis服务是否正常的启动
使用`ps`或`netstat`
```
ps axu | grep redis-server
netstat -tunple | grep 6379
```
关闭Linux下后台运行的redis服务
使用`pkill`
```
pkill -9 redis-server
```

使用客户端命令去连接redis服务
```
cls 
./redis-cli -h 192.168.1.108 -p 6379
// 测试
set name text
get name 
```

# 三、redis的数据类型
String 
```
set age 21
get age
incr age - 增加1
decr age - 自减1
incrby age 23 - 指定自增的数字
decrby age 23 - 指定自减的数字
keys * - 获取所有的key
```

hash
```
hset userInfo name asion
// userInfo => key
// 类似 $userInfo = array('name' => 'asion');
// 获取值
hget userInfo name
// 设置多个值
hmset userInfo name asion age 12
hgetall userInfo
```
list
```
lpush 向链表的头部放入数据 - 理解：left push
lpush link A
lpush link B
lpush link C

rpush  向链表的尾部部放入数据 - 理解：right push

lrange link 0 -1 获取链表的值 -1为最后一个单元
lpop 在链表的左侧弹出数据
rpop 在链表的右侧弹出最后一个数据

```

set
```
sadd set1 1
sadd set1 2
sadd set1 3
// 获取
smembers set1
// 移除
srem set1 1
// 随机弹出一个元素
spop set1

// 交集
sinter 
// 并集
sunion
// 差集
sdiff
```
zset
```
// 1 为排序的权重
zadd class:phpRank 1 aa
zadd class:phpRank 5 mark
zadd class:phpRank 15 ruby
zadd class:phpRank 45 lily

// 获取集合元素
zrange class:phpRank 0 -1

// 获取集合内容的时候，显示权重信息
zrange class:phpRank 0 -1 withscores

```

基本的数据类型：
  - 1.String 
  - 2.hash
  - 3.list - 链表 实际应用场景：后台统计最近最近的10个用户
  ```
  mysql的解决方式：
  select * from user order by logintime desc limit 10;
  redis:
  创建一个list类型，从链表左侧加入最近登录用户主键的id,当里面的单元超过十个，
  只需要把最右侧的那个单元弹出即可。
  ```
   - 4.set - 无序集合类型（实际应用：社交类的网站做好友关系的展示，如好友推荐、共同好友）
      - a.无序性
      - b.唯一性 - 无重复
      - c.确定性 - 个数确定
      
   - 5.zset - 有序集合
  
mysql it_user表
|id|username| email|
|-|-|-|
| 1 | mark | 12@163.com |
| 45 | m | 12@163.com |

如果把mysql表里面的数据存储到redis里，存储的key改如何设计？
步骤：
  - 1.把mysql里面的表名获取redis里面的key的前缀(`it_user`前缀)
  - 2.吧mysql表里面的主键名放在上面的前缀后面，一般使用冒号分隔（`it_user:id`)
  - 3.对应记录的主键值做key的第三步（`it_user:id:1`）
  - 4.把msql里面的其它的字段作为key的第四部分（`it_user:id:1:username`）
```
keys it_user:id:1*
```

# 三、php操作redis
```
<?php
// 1.实例化对象
$redis = new Redis();

// 2.定义主机和端口
$host = '192.168.1.101';
$port = 6379;

// 3. 连接redis服务器
$redis -> connect($host, $port);

// 4.设置值
$redis -> set('windows', 'windows test');

$data = $redis -> get('windows');

echo $data;

```

1.linux 安装 phpredis源码包
```
// 解压
tar -zxvf phpredis-4.0.0
cd  phpredis-4.0.0
// 使用`phpize`命令完成php环境检测
// 使用phpize命令收集php相关信息 
/usr/local/php5/bin/phpize
./configure --with-php-config=/usr/local/php5/bin/php-config
make && make install 
// 修改php.ini文件
修改
extension_dir="make install 得到拓展的路径"
extension="mongo.so"
extension="redis.so"
// 重启apache

```

# 四、redis的安全问题
在操作redis的时候，默认是不需要客户端提供认证信息，不需要密码即可对redis操作，
本身很危险，所有有必要开启redis的认证功能。
1.修改redis.conf文件
```
vim /etc/redis/redis.conf
# 注意是明文密码，所以要注意redis.conf权限问题解决
内容 requirepass admin88  
重启redis服务
pkill -9 redis-server
/usr/local/redis/bin/redis-server /etc/redis/redis.conf
cd /usr/local/redis/bin/
./redis-cli -h 192.168.108 -p 6039 -a admin88
auth admin88
```

# 五、redis的持久化功能
#### 1.简介
redis为了本身数据的安全和完整性，会把内存中的数据按照一定的方法同步到电脑的磁盘上面，这个过程被称为持久化操作，下次再次启动redis服务的时候，会把磁盘上面的保存的数据重新加载到内存中。

常见的持久化方式有两种：
  - 1.基于快照的方式：redis会按照一定的周期把内存的数据同步到磁盘
  - 2.基于文件的追加 redis会把对redis数据造成更改的命令记录到日志文件里面，然后再次重启的时候，执行一下日志文件里面对redis写的操作，达到数据的还原。
  
#### 2.基于快照的持久化方式
`bgsave` 手工的触发快照的持久化操作
1.修改配置文件，开始基于快照的选项
```
vim /etc/redis/redis.conf
修改内容： 
save 900 1 含义如果在900s内，对redis的key进行过一次操作，则会把内存中的数据同步到磁盘文件
save 300 10 含义如果在300s内，对redis的key进行过十次操作，则会把内存中的数据同步到磁盘文件
save 60 10000 含义如果在60s内，对redis的key进行过一万次操作，则会把内存中的数据同步到磁盘文件
```

#### 3.基于文件的追加的持久化方式
1.修改配置文件
```
vim /etc/redis/redis.conf
修改内容：
appendonly no 改为 appendonly yes
备份信息：
appendfsync everysec 代表的含义 每一秒进行一次 对redis数据造成更改的操作，都要记录到磁盘文件上
appendfsync always 代表的含义 只要存在对redis数据造成更改的操作，都要记录到磁盘文件上
appendfsync no 代表的含义 完全交给操作系统来完成，意思在操作系统不忙的时候 会把对redis数据造成更改的操作，都要记录到磁盘文件上
```