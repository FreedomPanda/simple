<?php

class Core
{
	//系统核心类库一览表
	public static $_system_class = array('core', 'arr', 'config', 'controller', 'cookie', 'db', 'orm', 'route', 'session', 'view', 'valid', 'redisdb', 'controller_template', 'curl', 'curl_options', 'email');
	public static $_path = array();
	public static $mvc = array();

	//查找文件
	public static function find_file($dir, $filename, $ext = '.php')
	{
		$path = DOCROOT . $dir . DIRECTORY_SEPARATOR . $filename . $ext;
		if (is_file($path))
		{
			return $path;
		}
		return false;
	}

	//加载文件
	public static function load($file)
	{
		return include $file;
	}

	//自动加载 *model和系统class不得重名
	public static function auto_load($class)
	{
		$class = strtolower($class);
		//$dir = 'class';
		if (in_array($class, Core::$_system_class))
		{
			//系统核心
			$path = Core::find_file('class', $class);
			//$dir = 'class';
		}
		else
		{
			//用户自定义
			if (substr($class, 0, 11) == 'controller_')
			{
				//controller相关
				$path = Core::find_file('controller', substr($class, 11));
				//$dir = 'controller';
			}
			else
			{
				//model
				$path = Core::find_file('model', $class);
				//$dir = 'model';
			}
		}

		if (!$path)
		{
			//die("[Wrong Type 1]: ".ucfirst($dir)." File Not Found! " . $class);
			return false;
		}
		else
		{
			require_once $path;
			return true;
		}
	}

	//打log
	public static function log($title, $subtitle, $data)
	{
		$time = time();
		$log_file_name = date('Ymd', $time).'.log';
		if (empty(Config::get('log.path')))
		{
			//本目录
			$fp = fopen(DOCROOT.'logs/'.$log_file_name, 'a+');
		}
		else
		{
			//path指定目录
			$fp = fopen(Config::get('log.path').$log_file_name, 'a+');
		}

		$date = date('Y-m-d H:i:s', $time);
		if (is_array($data))
		{
			$data = json_encode($data);
		}

		$str = ''.$date.' ['.$title.']'.$subtitle.' : '.$data."\n";
		fwrite($fp, $str);
		fclose($fp);
	}

	/**
	 * 取客户端IP
	 * @return string
	 */
	public static function get_client_ip()
	{
		$ip = '127.0.0.1';
		if ( !empty($_SERVER["HTTP_X_FORWARDED_FOR"]) )
		{
			$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		}
		else if ( !empty($_SERVER["HTTP_CLIENT_IP"]) )
		{
			$ip = $_SERVER["HTTP_CLIENT_IP"];
		}
		else if ( !empty($_SERVER["REMOTE_ADDR"]) )
		{
			$ip = $_SERVER["REMOTE_ADDR"];
		}

		return $ip;
	}

	public static function quit($str)
	{
		if (DEBUG)
		{
			die($str);
		}
		else
		{
			die;
		}
	}
}