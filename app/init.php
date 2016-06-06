<?php

\Simple\Route::add('', [
	'controller'	=> 'welcome',
	'action'		=> 'index',
]);

\Simple\Route::add('index', [
	'controller'	=> 'welcome',
	'action'		=> 'index',
]);

//设置路由
\Simple\Route::add('articles/(\d+)', [
	'controller'	=> 'articles',
	'action'		=> 'detail',
	'param'			=> ':1',
]);

\Simple\Route::add('(\w+)/(\w+)/(\d+)', [
	'controller'	=> ':1',
	'action'		=> ':2',
	'param'			=> ':3',
]);

\Simple\Route::add('login', [
	'controller'	=> 'user',
	'action'		=> 'login',
]);

\Simple\Route::add('/baidu', 'http://www.baidu.com/');