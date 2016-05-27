# simple

	Simple PHP
		简单、干净的php框架

	author		gavinczhang
	email		gavin6487@gmail.com
	version		0.4
	changed		2016年5月27日 16:03:46
	Explanation
			* 重新定义目录结构
			* 使用namespace

## namespace规则

	首字母大写
	App
	App\Controller
	Simple

## 目录结构

	app							项目目录
		controller					controller
		classes						项目特殊定义的class文件是目录
		model						模型文件 一个表对应一个model
		view						模板文件
		config						配置文件

	classes						全局class文件

	tools						工具目录
		curl.php					curl封装
		curl_options.php			curl所需的option封装
		email.php					发送邮件
		orm.php						ORM操作
		rdb.php						redis封装

	simple						框架
		core.php					框架核心文件
		arr.php
		config.php
		db.php
		cookie.php
		session.php
		controller.php
		controller_template.php
		view.php
		route.php

	logs						日志 未设置其他目录则输出至此

	index.php					入口文件

## 常用操作

	[写日志]
		//日志文件在logs下，按日期存放
		Core::log($title, $subtitle, $content);

	[数组操作]
		$row = Arr::get($array, 'test', false);   =>   $row = isset($array['test']) ? $array['test'] : false;

	[COOKIE操作]
		增/改	Cookie::set('abc', 'hahaha');
		查	$a = Cookie::get('abc');
		删	Cookie::delete('abc');
		清空	Cookie::clear();

	[SESSION操作]
		Session::instance()->get('abc');
		Session::instance()->set('abc', 'edf');
		Session::instance()->delete('abc');
		Session::instance()->clear();

	[DB操作]
		$query = DB::instance()->query($sql);
		$row = DB::instance()->fetch($query);
		$value = DB::instance()->check($value);	过滤函数

	[ORM操作]
		ORM::factory('cloud.depts')->where(array('rtx' => array('LIKE', '%gavin%')))->find_all();
		ORM::factory('depts')->add(array('rtx' => 'gavinczhang', 'name' => '张超'));
		ORM::factory('depts')->where(array('rtx' => 'gavinczhang', 'name' => '张超'))->delete();
		ORM::factory('depts')->where(array('rtx' => 'gavinczhang', 'name' => '张超'))->save(array('rtx' => 'gavin', 'name' => '张超'));

	[VIEW操作]
		View::bind('test', $abc);
		View::bind(array('test' => $abc, 'a' => $b));
		View::display('index');

	[Route操作]
		Route::set('list/hello', array('controller' => 'temp', 'action' => 'list'));	表示***.***.***/list/hello的网址，由Controller_Temp类下的action_list方法执行
		Route::set('404', array('controller' => 'error', 'action' => '404'));	表示定义404页面
		//TODO 未来将支持正则表达式
		Route::set('list/<controller>/<action>', array('controller' => 'temp', 'action' => 'list'));	表示所有/list/controller_name/action_name下的网址，均由对应的controller和action执行

## nginx配置

	server {
			listen 80;
			server_name simple.com;

			root /data/www/vhost/simple/;
			index index.php index.html;
			access_log /data/logs/nginx/simple.log main;

			location ~ \.php$ {
				client_max_body_size 128m;

				proxy_set_header X-Real-IP $remote_addr;
				fastcgi_pass   127.0.0.1:9000;
				fastcgi_index  index.php;
				fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
				include        fastcgi_params;
			}
	}

## 更新记录

	2016年6月27日
	· Bug fixed