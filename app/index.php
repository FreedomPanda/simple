<?php

//框架公用,项目独立时可用此文件作为入口
define('DEBUG', TRUE);

$host = 'http://www.simple.com/';
if (DEBUG)
{
	$host = 'http://debug.simple.com/';
}
define('HOST', $host);

//预定义
date_default_timezone_set('Asia/Shanghai');
set_time_limit(0);

//定义框架路径,请修改为你本机框架所在实际路径
define('ROOT', '/Users/gavinczhang/webroot/public/framework/');
define('APP_ROOT', __DIR__.'/');

//自动挂载
require_once ROOT.'simple/simple.php';
spl_autoload_register(array('\\Simple\\Simple', 'autoload'));

//路由
require_once APP_ROOT.'init.php';

\Simple\Simple::add_namespace('App', APP_ROOT);
\Simple\Simple::instance()->run();