# 一、配置虚拟主机
#### 1.给整个文件夹权限
```
sudo  chmod  -R 777 Documents 
```

#### 2.设置虚拟主机

- 0. `vim /etc/hosts`

- 1.在终端运行 `sudo vi /etc/apache2/httpd.conf`，打开Apche的配置文件 

- 2.在`httpd.conf`中找到`Include /private/etc/apache2/extra/httpd-vhosts.conf`，去掉前面的“＃”，保存并退出。 

- 3.运行`sudo apachectl restart`，重启Apache后就开启了虚拟主机配置功能。 

- 4.运行`sudo vi /etc/apache2/extra/httpd-vhosts.conf`，就打开了配置虚拟主机文件`httpd-vhost.conf`，配置虚拟主机了。需要注意的是该文件默认开启了两个作为例子的虚拟主机

```
 <VirtualHost *:80>
       DocumentRoot "/Library/WebServer/Documents/"
       ServerName www.hjq.com
       ErrorLog "/private/var/log/apache2/dummy-host2.example.com-error_log"
       CustomLog "/private/var/log/apache2/dummy-host2.example.com-access_log"         common
   <Directory />
  Options Indexes FollowSymLinks MultiViews
  AllowOverride None
  Order deny,allow 
  Allow from all 
  </Directory>
  </VirtualHost>
```
保存，退出，重启Apache。

6.运行`sudo vi /etc/hosts`，打开hosts配置文件，加入`127.0.0.1 www.hjq.com`，这样就可以配置完成test虚拟主机了。

# 二、Apache
- 开启Apache：
`sudo apachectl start`

- 关闭Apache：
`sudo apachectl stop`

- 重启Apache：
`sudo apachectl  -k restart`
`sudo apachectl restart`

- 查看Apache版本：
`sudo apachectl  -v`

在浏览器中输入`localhost`，如果出现如下默认的“It works!”界面，则表示Apache开启成功

# 三、开启PHP环境
**1. 开启PHP**
 
需要修改Apache配置文件，方法如下：
打开终端，输入命令：
`sudo vim /etc/apache2/httpd.conf`

找到
`#LoadModule php5_module libexec/apache2/libphp5.so`，去掉注释（删除前面的**井**号）。

mac下Apache的默认文件夹为
`/Library/WebServer/Documents`，
在该目录下创建一个名为`test.php`文件，在文件中添加如下内容：`<?php phpInfo(); ?>`。然后在浏览器中输入`localhost/test.php`，如果出现如下PHP的info页，则表示PHP开启成功，如果不成功，用前面的命令重启Apache再试.
![14948978758847.jpg](http://upload-images.jianshu.io/upload_images/678898-c2eee4c00aa60b2d.jpg?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)


解决问题 - 修改Apache目录
上面说到了mac下Apache的默认文件夹为
`/Library/WebServer/Documents`，
该目录默认是隐藏的，操作不是很方便，我们可以将其修改成自定义的目录。

打开终端，输入命令：
`sudo vim /etc/apache2/httpd.conf`

找到如下两处
`DocumentRoot "/Library/WebServer/Documents"`

将两处中引号中的目录替换为自定义的目录

完成以上三步后，重启Apache，将之前创建的`test.php`文件拷贝到自定义目录中，然后在浏览器中输入`localhost/test.php`，如果出现PHP的info页，则表示目录修改成功,如下图效果。
![14948978758847.jpg](http://upload-images.jianshu.io/upload_images/678898-9ee71d3090d54bef.jpg?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

# 四、phpMyAdmin
下载地址：https://www.phpmyadmin.net
安装步骤：

- 1.去“下载”找到`phpMyAdmin-4.6.4-all-languages`文件夹，更改文件夹为`phpmyadmin`，放在`/Library/WebServer/Document/`目录下（Apache的根目录）

- 2.终端进入 `cd /etc/apache2`文件夹目录下，

![14948989778235.jpg](http://upload-images.jianshu.io/upload_images/678898-1d5c367e1281966e.jpg?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

用 vim 打开`httpd.conf`,修改成以下内容并保存
![14948990869810.jpg](http://upload-images.jianshu.io/upload_images/678898-c073f14e85ae3ac4.jpg?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

在浏览器打开`http://localhost/phpmyadmin/`网址，则会出现下图的效果
![14948992320385.jpg](http://upload-images.jianshu.io/upload_images/678898-efa33ea1523ab2dc.jpg?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

安装过程遇到的错误：

![14948993662587.jpg](http://upload-images.jianshu.io/upload_images/678898-68fa9230fd709f62.jpg?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

解决办法：

```
sudo mkdir /var/mysql
sudo ln -s /tmp/mysql.sock /var/mysql/mysql.sock
```
然后重启Apache生效

# 四、Mysql
#### 关于mac终端连接安装mysql
1.提示信息
`ERROR 1045: Access denied for user: 'root@localhost' (Using 
password: NO)`

或者

`ERROR 1045: Access denied for user: 'root@localhost' (Using 
password: YES)`

2.解决办法
通过命令关掉mysql服务
`/usr/local/mysql/bin/mysqladmin -u root -p shutdown`

2.进入mysql的bin目录执行如下命令

```
$ cd /usr/local/mysql/bin
$ sudo su  
```

之后输入管理员密码会看到

`sh-3.2# `

之后我们输入下面命令以安全模式运行mysql

```
sh-3.2# ./mysqld_safe --skip-grant-tables &
```

执行完以上命令，mysql的服务会重新开启
回到终端点击`Command ＋ N` 重新打开一个终端 
输入
```
mysql -u -root
mysql -u root -p
```

![14948242065176.jpg](http://upload-images.jianshu.io/upload_images/678898-003ed0870dc3ba73.jpg?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

#### 修改root密码 
首先执行下面命令为了能够修改任意的密码
mysql> `FLUSH PRIVILEGES`;
之后执行修改密码的SQL语句,这里的qsd19001008可以替换你自己想要修改的密码
mysql> `SET PASSWORD FOR root@'localhost' = PASSWORD('newpassword');`
最后刷新
mysql>`FLUSH PRIVILEGES;`

# 五、配置php.ini
可以通过以下的代码查看php.ini文件目录
```
<? php
echo phpinfo();
```
#### 1.配置完成文件大小限制和超时时间
```
post_max_size
max_execution_time
upload_max_filesize
```
#### 2.开启gd拓展
```
extension=php_gd2.dll
```