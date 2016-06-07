<?php

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

//定义路径
define('ROOT', __DIR__.'/');
define('APP_ROOT', ROOT.'app/');

//自动挂载
require_once ROOT.'simple/simple.php';
spl_autoload_register(array('\\Simple\\Simple', 'autoload'));

//路由
require_once APP_ROOT.'init.php';

\Simple\Simple::instance()->run();