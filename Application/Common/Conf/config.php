<?php
return array(
	//'配置项'=>'配置值'
    // 显示页面Trace信息
    'SHOW_PAGE_TRACE' =>true,
    //数据库配置
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  '127.0.0.1', // 服务器地址
    'DB_NAME'               =>  'oa',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  '',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'oa_',    // 数据库表前缀


    'URL_CASE_INSENSITIVE'  =>  true,   // 默认false 表示URL区分大小写 true则表示不区分大小写
    'URL_MODEL'             =>  1,       // URL访问模式,可选参数0、1、2、3,代表以下四种模式：

    'DEFAULT_MODULE'        =>  'admin',  // 默认模块
    'DEFAULT_CONTROLLER'    =>  'Index', // 默认控制器名称
    'DEFAULT_ACTION'        =>  'index', // 默认操作名称

    'MODULE_DENY_LIST'      =>  array('Common','Runtime'), //禁止访问的模块
    'MODULE_ALLOW_LIST'      =>  array('Admin','Home'), //允许访问的模块

    //设置模板常量
    'TMPL_PARSE_STRING'  =>array(
        '__ADMIN__' => '/Public/Admin'
    ),

    //禁用php原生标签(一般不禁用)
    //"TMPL_DENY_PHP" => true,

    //盐
    'SALT' => 'asdadaadadadqwdsa1342321@##fdsfwqefwfw',

    //载入外部自定义的文件(多个用逗号隔开)
    'LOAD_EXT_FILE' => 'a,b',

);