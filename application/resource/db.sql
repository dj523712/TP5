drop database if exists darkcastle;
create database darkcastle default character set utf8 collate utf8_general_ci;
use darkcastle;
set names utf8;

-- 创建用户表
drop table if exists visitors;
create table visitors(
    id int not null auto_increment primary key comment '访客id',
    user_agent varchar(255) not null default '' comment  'user agent',
    client_device varchar(255) not null default '' comment  'pc|phone|tablet',
    client_os varchar(255) not null default '' comment  'ios|android|win',
    browser varchar(255) not null default '' comment  '浏览器',
    browser_version varchar(255) not null default '' comment  '浏览器版本',
    user_id int not null default 0 comment '用户id',
    ip varchar(50) not null default '' comment 'IP',
    visit_time int(10) unsigned not null default 0 comment '访问时间'
)engine innodb character set utf8 collate utf8_general_ci comment '访客表';

-- 创建用户表
drop table if exists visitors;
create table visitors(
    id int not null auto_increment primary key comment 'id',
    pwd char(60) not null default '' comment '密码',
    gender tinyint(1) not null default 0 comment '性别',
    avatar char(100) not null default '' comment '用户头像地址',
    email varchar(50) not null default '' comment '邮箱',
    points int not null default 0 comment '积分',
    description varchar(255) not null default '' comment '自我描述',
    last_login_ip varchar(20) not null default '' comment '上次登录ip',
    create_time int(10) not null default 0 comment '注册时间',
    modify_time int(10) not null default 0 comment '修改时间',
    timezone varchar(50) not null default '' comment '用户所在时区',
    last_login_time char(10) not null default '' comment '上次登录时间',
    answer_status tinyint(1) not null default 0 comment '状态未回答，已回答',
    status tinyint(1) not null default 0 comment '状态',
)engine innodb character set utf8 collate utf8_general_ci comment '用户表';
alter table users add index idx_email (email);
alter table users add index idx_username (username);

-- 创建知乎话题表
drop table if exists zhihu_topics;
create table zhihu_topics(
    id int not null auto_increment primary key comment 'id',
    raw_id int(10) not null default 0 comment '原id',
    parent_id int(10) not null default 0 comment '父级id',
    name char(60) not null default '' comment '话题名',
    create_time int(10) not null default 0 comment '注册时间',
    status tinyint(1) not null default 0 comment '状态'
)engine innodb character set utf8 collate utf8_general_ci comment '知乎话题表';

-- 创建引用文章表
drop table if exists mirror_articles;
create table mirror_articles(
    id int not null auto_increment primary key comment 'id',
    article_src varchar(50) not null default '' comment '文章来源',
    title varchar(500) not null default '' comment '标题',
    image_src varchar(255) not null default '' comment '首图来源',
    description varchar(500) not null default '' comment '描述',
    author varchar(100) not null default '' comment '作者',
    link varchar(500) not null default '' comment '链接',
    click int(10) not null default 0 comment '点击量',
    hot varchar(50) not null default '' comment '热度，点赞数',
    create_time int(10) not null default 0 comment '创建时间',
    status tinyint(1) not null default 0 comment '状态'
)engine innodb character set utf8 collate utf8_general_ci comment '知乎话题表';

-- 创建文章标签表
drop table if exists tags;
create table tags(
    id int not null auto_increment primary key comment 'id',
    title varchar(500) not null default '' comment '标题',
    create_time int(10) not null default 0 comment '创建时间',
    status tinyint(1) not null default 0 comment '状态'
)engine innodb character set utf8 collate utf8_general_ci comment '知乎话题表';

-- 创建文章标签关联表
drop table if exists articles_tags;
create table articles_tags(
    id int not null auto_increment primary key comment 'id',
    article_id int(10) not null default 0 comment '文章id',
    tag_id int(10) not null default 0 comment '文章id',
    create_time int(10) not null default 0 comment '创建时间',
    status tinyint(1) not null default 0 comment '状态'
)engine innodb character set utf8 collate utf8_general_ci comment '文章标签关联表';

