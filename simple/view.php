<?php

namespace Simple;

class View
{
	//参数
	public static $_params = array();

	//绑定参数
	public static function bind($key, $value = null)
	{
		if (is_array($key))
		{
			//数组，则合并
			self::$_params = array_merge(self::$_params, $key);
		}
		else
		{
			//参数则覆盖
			self::$_params[$key] = $value;
		}
	}

	//输出页面
	public static function display($filename, $find = true)
	{
		if ($find)
		{
			$path = Simple::find_file('views', $filename);
		}
		else
		{
			$path = $filename;
		}

		if (!$path)
		{
			throw new Error('View File['.$filename.'] Not Found!');
		}
		else
		{
			//正常
			ob_start();
			ob_implicit_flush(0);
			extract(self::$_params, EXTR_OVERWRITE);
			include $path;
			$content = ob_get_clean();
			HTTP::instance()->header('Content-Type:text/html; charset=utf-8');
			HTTP::instance()->finish($content);
		}
	}

	public static function path($filename)
	{
		$path = Simple::find_file('views', $filename);
		if (!$path)
		{
			throw new Error('View File['.$filename.'] Not Found!');
		}
		else
		{
			return $path;
		}
	}
}