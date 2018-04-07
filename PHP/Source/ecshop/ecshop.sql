-- 创建用户表
-- 唯一键，表示约束没有重复值
create table if not exists `ec_user`(
`id` int auto_increment comment '自增id',
`name` varchar(20) COLLATE utf8_unicode_ci not null default '' comment '用户名',
`password` varchar(50) not null default '' comment '密码',
primary key(id),
CONSTRAINT UNQ_XXX UNIQUE(name) 
)engine InnoDB auto_increment = 1 default charset utf8;


-- 插入一条新数据
insert into `ec_user`(name, password) values ('hjq', '123456');

-- 创建商品表
create table if not exists `ec_goods`(
`id` int auto_increment comment '自增id',
`goods_name` varChar(50) COLLATE utf8_unicode_ci not null default '' comment '商品名称',
`goods_price` decimal(10,2) not null default 0.0 comment '商品价格',
`goods_img` varchar(100) COLLATE utf8_unicode_ci not null default '' comment '商品图片',
`goods_small_img` varchar(100) not null default '' comment '商品缩略图',
`goods_introduce` varchar(255) COLLATE utf8_unicode_ci not null default '' comment '商品简介',
`goods_category_id` int not null default 0 comment '商品分类id',
`goods_brand_id` int not null default 0 comment '商品的品牌id',
`goods_create_time` datetime not null default now() comment '添加时间',
primary key(id)
)engine InnoDB auto_increment = 1 default charset utf8;

-- 商品品牌表
create table if not exists `ec_goodsbrand`(
`id` int auto_increment comment '自增id',
`name` varChar(50) COLLATE utf8_unicode_ci not null default '' comment '品牌名称',
primary key(id)
)engine InnoDB auto_increment = 1 default charset utf8;

-- 插入品牌数据
insert into `ec_goodsbrand`(name) values ('品牌一');
insert into `ec_goodsbrand`(name) values ('品牌二');


-- 商品分类表
create table if not exists `ec_goodscategory`(
`id` int auto_increment comment '自增id',
`name` varChar(50) COLLATE utf8_unicode_ci not null default '' comment '商品分类名称',
primary key(id)
)engine InnoDB auto_increment = 1 default charset utf8;

-- 插入分类数据
insert into `ec_goodscategory`(name) values ('手机');
insert into `ec_goodscategory`(name) values ('电脑');