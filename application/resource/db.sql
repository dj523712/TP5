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
    id int not null auto_increment primary key comment '访客id',
    pwd char(60) not null default '' comment '密码',
    gender tinyint(1) not null default 0 comment '性别',
    avatar char(100) not null default '' comment '用户头像地址',
    email varchar(50) not null default '' comment '邮箱',
    points int not null default 0 comment '积分',
    description varchar(255) not null default '' comment '自我描述',
    last_login_ip varchar(20) not null default '' comment '上次登录ip',
    create_time char(10) not null default '' comment '注册时间',
    modify_time char(10) not null default '' comment '修改时间',
    timezone varchar(50) not null default '' comment '用户所在时区',
    last_login_time char(10) not null default '' comment '上次登录时间',
    answer_status tinyint(1) not null default 0 comment '状态未回答，已回答',
    status tinyint(1) not null default 0 comment '状态',
)engine innodb character set utf8 collate utf8_general_ci comment '用户表';
alter table users add index idx_email (email);
alter table users add index idx_username (username);