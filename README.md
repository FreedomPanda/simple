# simple

	Simple PHP
		简单、干净的php框架

	author		gavinczhang
	email		gavin6487@gmail.com
	copyright	GPL
	version		0.4
	changed		2016年06月06日 00:35:46
	Explanation
			* 重新定义目录结构
			* 使用namespace
			* 支持多种自定义路由

## 感谢
	感谢kohana框架,参考借鉴了许多代码及思路
	感谢email类库的不知名作者

## namespace规则

	首字母大写
	App
	App\Controller
	Simple

## 目录结构

	app							项目目录
		controllers					controller
		classes						项目特殊定义的class文件是目录
		models						模型文件 一个表对应一个model
		views						模板文件
		configs						配置文件
		logs						日志 未设置其他目录则输出至此
		init.php					项目Route自定义

	classes						全局class文件
		curl.php					curl封装
		curl_options.php			curl所需的option封装
		email.php					发送邮件
		orm.php						ORM操作
		rdb.php						redis封装
		session.php					DB session封装 TODO db&redis

	tools						工具目录
		aliyun						阿里云SDK

	simple						框架
		simple.php					框架核心文件
		arr.php						常用数组操作
		config.php					配置文件读取
		db.php						数据库类
		cookie.php					cookie封装
		controller.php				基类
		controller_template.php		需要使用模板的controller基类
		view.php					模板
		route.php					路由
		http.php					response

	index.php					入口文件

## 常用操作

	[写日志]
		//日志文件在logs下，按日期存放
		Core::log($title, $subtitle, $content);

	[数组操作]
		//$row = isset($array['test']) ? $array['test'] : false;
		$row = Arr::get($array, 'test', false);

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
		$value = DB::instance()->check($value);

	[ORM操作]
		ORM::factory('cloud.depts')->where(array('rtx' => array('LIKE', '%gavin%')))->find_all();
		ORM::factory('depts')->add(array('rtx' => 'gavinczhang', 'name' => 'gavinczhang'));
		ORM::factory('depts')->where(array('rtx' => 'gavinczhang', 'name' => 'gavinczhang'))->delete();
		ORM::factory('depts')->where(array('rtx' => 'gavinczhang', 'name' => 'gavinczhang'))->save(array('rtx' => 'gavin', 'name' => 'gavin'));

	[VIEW操作]
		View::bind('test', $abc);
		View::bind(array('test' => $abc, 'a' => $b));
		View::display('index');

	[Route操作]
		//表示***.***.***/list/hello的网址，由Controller_Temp类下的action_list方法执行
		Route::set('list/hello', array('controller' => 'temp', 'action' => 'list'));
		//表示定义404页面
		Route::set('404', array('controller' => 'error', 'action' => '404'));
		//表示所有/list/controller_name/action_name下的网址，均由对应的controller和action执行
		Route::set('list/<controller>/<action>', array('controller' => 'temp', 'action' => 'list'));

## nginx配置

	server {
			listen 80;
			server_name simple.com;

			root /data/www/vhost/simple/;
			index index.php index.html;
			access_log /data/logs/nginx/simple.log main;

			location ^~/app/logs {
				deny all;
			}

			location / {
				if (!-e $request_filename) {
						rewrite ^/(.*)$ /index.php;
				}
			}

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

	2016年05月27日
	· 调整目录结构
	· 定义框架基本功能接口

	2016年06月02日
	· 增加500及DEBUG模式下输出相关信息
	· 增加HTTP类,处理response相关

	2016年06月06日
	· 支持多种路由规则