<?php

namespace Simple;

/**
 * Class Route
 * 路由有几种规则
 * 1. 匹配对应的url,进入对应的controller和action中
 * 2. 匹配对应的url,直接跳转某个新的url
 * 3. 规则匹配不到,按/分隔,找对应的controller和action
 * 4.
 * @package Simple
 */
class Route
{
	public static $controller = '';
	public static $action = '';
	public static $view = '';
	public static $_matches = [];

	//简单路由规则
	public static $_routes = [];
	public static $_404 = [];
	public static $_default_controller = 'welcome';
	public static $_default_action = 'index';

	public static function set_default($controller, $action)
	{
		self::$_default_controller = $controller;
		self::$_default_action = $action;
	}

	//设置404页面
	public static function set_404($controller, $action)
	{
		Route::$_404 = [
			'controller'	=> $controller,
			'action'		=> $action,
		];
	}

	//设置路由规则
	public static function add($rule, $route)
	{
		Route::$_routes[] = [
			'rule'	=> $rule,
			'route'	=> $route,
		];
	}

	//获取对应的controller或action
	public static function router()
	{
		$url_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
		//小写 并 移除首末的/
		$url_path = strtolower($url_path);
		$url_path = trim($url_path, '/');

		foreach (self::$_routes as $route)
		{
			if (empty($route['rule']))
			{
				if (empty($url_path))
				{
					//空字符串
					if (is_array($route['route']))
					{
						Route::run(Arr::get($route['route'], 'controller', Route::$_default_controller), Arr::get($route['route'], 'action', Route::$_default_action));
					}
					else
					{
						//URL直接跳转
						HTTP::instance()->redirect($route['route']);
					}
				}
			}
			elseif (preg_match('@'.$route['rule'].'@', $url_path, $matches))
			{
				//正则匹配成功
				if (is_array($route['route']))
				{
					Route::$_matches = $matches;
					//替换route设置时的:1为正则匹配到的参数
					$controller = preg_replace_callback('@:(\d+)@', function($match) {
						return Route::$_matches[$match[1]];
					}, $route['route']['controller']);
					$action = preg_replace_callback('@:(\d+)@', function($match) {
						return Route::$_matches[$match[1]];
					}, $route['route']['action']);
					if (isset($route['route']['param']))
					{
						$param = preg_replace_callback('@:(\d+)@', function($match) {
							return Route::$_matches[$match[1]];
						}, $route['route']['param']);
					}
					else
					{
						$param = NULL;
					}
					Route::run($controller, $action, $param);
				}
				else
				{
					//URL直接跳转
					HTTP::instance()->redirect($route['route']);
				}
			}
		}

		//未匹配到,走默认情况
		$uri_array = [];
		if (!empty($url_path))
		{
			if (strpos($url_path, '/') !== false)
			{
				$uri_array = explode('/', $url_path);
			}
			else
			{
				$uri_array = [$url_path];
			}
		}

		Route::run(Arr::get($uri_array, 0, Route::$_default_controller), Arr::get($uri_array, 1, Route::$_default_action), Arr::get($uri_array, 2));
	}

	//执行
	public static function run($controller, $action, $param = NULL)
	{
		Route::$controller = $controller;
		Route::$action = 'action_'.$action;
		Route::$view = $controller . '/' . $action;

		//查找对应的class 可做404
		if (Simple::find_file('controllers', Route::$controller))
		{
			$controller_name = '\\App\\Controllers\\'.ucfirst(Route::$controller);
			//存在此controller文件
			if (method_exists($controller_name, Route::$action))
			{
				/**
				 * @var $controller Controller
				 */
				$controller = new $controller_name();
				$controller->before();
				if (!is_null($param))
				{
					$controller->{Route::$action}($param);
				}
				else
				{
					$controller->{Route::$action}();
				}
				$controller->after();
				return;
			}
		}

		if (DEBUG)
		{
			throw new Error('\\App\\Controllers\\'.Route::$controller.'->'.Route::$action. ' is not found');
		}

		Route::error_404();
	}

	//404
	public static function error_404()
	{
		HTTP::instance()->status(404);

		if (!empty(Route::$_404))
		{
			Route::$controller = Route::$_404['controller'];
			Route::$action = 'action_'.Route::$_404['action'];
			Route::$view = Route::$_404['controller'] . '/' . Route::$_404['action'];

			//查找对应的class 可做404
			if (Simple::find_file('controllers', Route::$controller))
			{
				$controller_name = '\\App\\Controllers\\'.ucfirst(Route::$controller);
				//存在此controller文件
				if (method_exists($controller_name, Route::$action))
				{
					/**
					 * @var $controller Controller
					 */
					$controller = new $controller_name();
					$controller->before();
					$controller->{Route::$action}();
					$controller->after();
					return;
				}
			}
		}

		//默认404页面
		$data = [
			'title'		=> '404 Page Not Found',
			'message'	=> '您要访问的页面被实习工删了....',
		];
		$file_path = ROOT.'simple/views/error.php';
		View::bind($data);
		View::display($file_path, FALSE);
	}
}