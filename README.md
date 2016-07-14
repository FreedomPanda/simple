# simple

	Simple PHP
		简单、干净的php框架

	author		gavinczhang
	email		gavin6487@gmail.com
	version		0.4
	changed		2016年06月08日 20:18:46
	Explanation
			* 重新定义目录结构
			* 使用namespace
			* 支持自定义路由(简单路由/正则路由/匹配跳转)
			* 支持debug模式下Config类自动读取debug中的配置文件
			* 新增model基类

## 感谢
	感谢kohana/swoole/thinkphp框架,参考借鉴了许多代码及思路
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
		configs						配置文件目录
			debug						debug模式下配置文件目录
				database.php				debug模式下数据库配置文件
			database.php				正式环境数据库配置文件
			cookie.php					cookie配置文件
			redis.php					redis配置文件
			session.php					session配置文件
		logs						日志 未设置其他目录则输出至此
		init.php					项目Route自定义

	classes						全局class文件
		curl.php					curl封装
		curl_options.php			curl所需的option封装
		email.php					发送邮件
		redis.php					redis封装
		session.php					DB session封装 TODO db&redis

	tools						工具目录
		aliyun						阿里云SDK

	simple						框架
		simple.php					框架核心文件
		arr.php						常用数组操作
		config.php					配置文件读取
		db.php						数据库类
		cookie.php					cookie封装
		model.php					model基类
		controller.php				controller基类
		controller_template.php		需要使用模板的controller基类
		view.php					模板
		route.php					路由
		http.php					response
		orm.php						ORM操作

	index.php					入口文件

## 常用操作

	[写日志]
		//日志文件在logs下，按日期存放
		Simple::log($title, $subtitle, $content);

	[数组操作]
		//$row = isset($array['test']) ? $array['test'] : false;
		$row = Arr::get($array, 'test', false);

	[COOKIE操作]
		增/改	Cookie::set('abc', 'hahaha');
		查	$a = Cookie::get('abc');
		删	Cookie::delete('abc');
		清空	Cookie::clear();

	[SESSION操作]
		Classes\Session::instance()->get('abc');
		Classes\Session::instance()->set('abc', 'edf');
		Classes\Session::instance()->delete('abc');
		Classes\Session::instance()->clear();

	[DB操作]
		$query = DB::instance()->query($sql);
		$row = DB::instance()->fetch($query);
		$value = DB::instance()->check($value);

	[ORM操作]
		//查找articles表中,id=3的一条数据
		ORM::factory('articles')->where(3)->find();
		//查找articles表中,id!=3且type=1的一条数据
		ORM::factory('articles')->where(['id' => ['!=', 3], 'type' => 1])->find();
		//查找articles表中,id in (1, 2, 3)且type=1的所有数据,按id ASC排序,获取从第五条开始的10条数据  WHERE条件中的IN/NOT IN/BETWEEN必须为大写
		ORM::factory('articles')->where(['id' => ['IN', [1, 2, 3]], 'type' => 1])->order(['id' => 'ASC'])->limit(5, 10)->find_all();
		//修改articles表中,id=3的数据,修改title为new_title,content为new_content
		//SELF::INC自增 SELF::DEC自减  SELF::*2自乘2
		ORM::factory('articles')->where(3)->save(['title' => 'new_title', 'content' => 'new_content', 'read_count' => 'SELF::INC']);
		//新增
		$id = ORM::factory('articles')->add(['title' => 'new_title', 'content' => 'new_content']);
		//新增一批
		$first_id = ORM::factory('articles')->add([['title' => 'new_title1', 'content' => 'new_content1'], ['title' => 'new_title2', 'content' => 'new_content2']]);
		ORM::factory('articles')->where(3)->delete();

	[VIEW操作]
		View::bind('test', $abc);
		View::bind([
			'test'	=> $abc,
			'title'	=> $title,
		]);
		View::display('index');

	[Route操作]
		在app/init.php中配置路由
		//访问www.simple.com时进入welcome controller和action_index
		\Simple\Route::add('', [
			'controller'	=> 'welcome',
			'action'		=> 'index',
		]);
		//访问www.simple.com/index时,进入welcome controller中的action_index方法
		\Simple\Route::add('index', [
			'controller'	=> 'welcome',
			'action'		=> 'index',
		]);
		//访问www.simple.com/articles/1234类似的网址,进入articles controller的action_detail方法,并传入参数1234
		\Simple\Route::add('articles/(\d+)', [
			'controller'	=> 'articles',
			'action'		=> 'detail',
			'param'			=> ':1',
		]);
		//访问www.simple.com/qq时,直接跳转到www.qq.com
		\Simple\Route::add('qq', 'http://www.qq.com/');
		//自定义404 当404时,使用welcome controller中的action_404方法处理
		\Simple\Route::set_404('welcome', '404');

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
	· 支持正则等多种路由规则

	2016年06月08日
	· Config类增加自动读取debug模式的配置文件功能
	· 增加model基类
	· 更新文档
