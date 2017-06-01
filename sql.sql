--部门表
CREATE database oa;
use oa;
set names gbk;
DROP TABLE if EXISTS oa_dept;
CREATE TABLE oa_dept(
  id int NOT NULL auto_increment,
  NAME char(20) NOT NULL DEFAULT "",
  pid INT NOT NULL DEFAULT 0 comment '上级部门id',
  ADD_TIME INT NOT NULL DEFAULT 0 comment '部门创建时间',
  intro text comment '部门介绍',
  sort tinyint DEFAULT 50,
  PRIMARY key(id)
)engine=innodb charset=utf8;

--用户表
DROP TABLE if EXISTS oa_user;
CREATE TABLE oa_user(
  id INT NOT NULL auto_increment,
  username VARCHAR(30) NOT NULL DEFAULT '' comment'用户名称',
  password CHAR (32) NOT NULL DEFAULT ''comment'用户密码',
  sex tinyint NOT NULL DEFAULT 0 comment'0-男，1-女',
  truename VARCHAR(30) NOT NULL DEFAULT ''comment'职员的真名',
  dept_id tinyint unsigned NOT NULL DEFAULT 0 comment'所属部门id',
  role_id tinyint unsigned NOT NULL DEFAULT 0 comment'所属角色id',
  tel CHAR(11) NOT NULL DEFAULT '00000000000'comment '手机号码',
  email VARCHAR(40) NOT NULL DEFAULT '' comment '邮箱',
  birthday INT NOT NULL DEFAULT 0,
  add_time INT NOT NULL DEFAULT 0,
  PRIMARY KEY (id)

)engine=innodb charset=utf8;

--公文表
DROP TABLE if EXISTS oa_doc;
CREATE TABLE oa_doc(
id INT NOT NULL auto_increment,
title VARCHAR(60) NOT NULL DEFAULT '' comment'标题',
content text NOT NULL DEFAULT '' comment'正文',
add_time INT NOT NULL DEFAULT 0 comment'发布时间',
file VARCHAR(100) NOT NULL DEFAULT'' comment'文件名称',
author_id tinyint unsigned NOT NULL DEFAULT 0 comment'发布作者id',
PRIMARY KEY (id)
)engine=innodb charset=utf8;

--知识表
DROP TABLE if EXISTS oa_knowledge;
CREATE TABLE oa_knowledge(
id INT NOT NULL auto_increment,
title CHAR(50) NOT NULL DEFAULT '' comment'标题',
content text,
author_id tinyint NOT NULL DEFAULT 0 comment '用户id',
ori_img VARCHAR(60) NOT NULL DEFAULT '' comment '原图片',
thumb_img VARCHAR (60) NOT NULL DEFAULT '' comment '缩略图',
add_time INT NOT NULL DEFAULT 0 comment '添加时间',
PRIMARY key(id)
)engine=innodb charset=utf8;

--邮件表
DROP TABLE if EXISTS oa_email;
CREATE TABLE oa_email(
id INT NOT NULL auto_increment,
title VARCHAR(60) NOT NULL DEFAULT '' comment'邮件主题',
file VARCHAR(60) NOT NULL DEFAULT '' comment'附件',
content text,
send_id tinyint unsigned NOT NULL DEFAULT 0 comment'发送邮件人的id',
addressee_id tinyint unsigned NOT NULL DEFAULT 0 comment'收件人的id',
send_time INT NOT NULL DEFAULT 0 comment'发送时间',
is_read tinyint NOT NULL DEFAULT '0' comment'0->未读 ，1->已读',
PRIMARY key (id)
)engine=innodb charset=utf8;

--角色表
DROP TABLE if EXISTS oa_role;
CREATE TABLE oa_role(
id INT NOT NULL auto_increment,
role CHAR(30) NOT NULL DEFAULT '' comment'角色',
auth_ids VARCHAR(100) NOT NULL DEFAULT '' comment'权限',
PRIMARY key (id)
)engine=innodb charset=utf8;

--权限表
DROP TABLE if EXISTS oa_auth;
create table oa_auth(
    id int not null auto_increment,
    name varchar(50) not null default '' comment '权限的名称,如:公文管理,公文列表',
    pid int not null default 0 comment '权限的上级权限',
    m_name varchar(50) default '' comment '权限所属模块 如:Admin,Home',
    c_name varchar(50) default '' comment '权限所属控制器 如:Dept,Email',
    a_name varchar(50) default '' comment '权限所属操作方法 如:add,index',
    level tinyint not null default 0 comment '权限的级别:如:公文管理-0 发布列表-1 删除-2',
    sort smallint not null default 50 comment '排序字段',
    primary key(id)
)engine=innodb charset=utf8;


insert into oa_auth values(1,'日常办公',0,'Admin','Index','Home',1,1);

insert into oa_auth values(2,'公文管理',0,'','','',1,2);
insert into oa_auth values(3,'发布公文',2,'Admin','Doc','add',2,1);
insert into oa_auth values(4,'公文列表',2,'Admin','Doc','index',2,1);
insert into oa_auth values(5,'公文编辑',4,'Admin','Doc','edit',3,1);


insert into oa_auth values(6,'知识管理',0,'','','',1,3);
insert into oa_auth values(7,'添加知识',6,'Admin','Knowledge','add',2,1);
insert into oa_auth values(8,'知识列表',6,'Admin','Knowledge','index',2,1);
insert into oa_auth values(9,'知识编辑',8,'Admin','Knowledge','edit',3,1);


insert into oa_auth values(10,'职员管理',0,'','','',1,4);
insert into oa_auth values(11,'添加职员',10,'Admin','User','add',2,1);
insert into oa_auth values(12,'职员列表',10,'Admin','User','index',2,1);
insert into oa_auth values(13,'职员编辑',12,'Admin','User','edit',3,1);


insert into oa_auth values(14,'部门管理',0,'','','',1,5);
insert into oa_auth values(15,'添加部门',14,'Admin','Dept','add',2,1);
insert into oa_auth values(16,'部门列表',14,'Admin','Dept','index',2,1);
insert into oa_auth values(17,'部门编辑',16,'Admin','Dept','edit',3,1);


insert into oa_auth values(18,'邮件管理',0,'','','',1,6);
insert into oa_auth values(19,'发送邮件',18,'Admin','Email','send',2,1);
insert into oa_auth values(20,'收件箱',18,'Admin','Email','receiver',2,1);

insert into oa_auth values(21,'系统管理',0,'','','',1,7);
insert into oa_auth values(22,'角色管理',21,'Admin','Role','index',2,1);
insert into oa_auth values(23,'权限管理',21,'Admin','Auth','index',2,1);
