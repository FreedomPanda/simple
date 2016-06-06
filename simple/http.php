<?php
namespace Simple;

class HTTP
{
	static $HTTP_HEADERS = [
		100 => "100 Continue",
		101 => "101 Switching Protocols",
		200 => "200 OK",
		201 => "201 Created",
		204 => "204 No Content",
		206 => "206 Partial Content",
		300 => "300 Multiple Choices",
		301 => "301 Moved Permanently",
		302 => "302 Found",
		303 => "303 See Other",
		304 => "304 Not Modified",
		307 => "307 Temporary Redirect",
		400 => "400 Bad Request",
		401 => "401 Unauthorized",
		403 => "403 Forbidden",
		404 => "404 Not Found",
		405 => "405 Method Not Allowed",
		406 => "406 Not Acceptable",
		408 => "408 Request Timeout",
		410 => "410 Gone",
		413 => "413 Request Entity Too Large",
		414 => "414 Request URI Too Long",
		415 => "415 Unsupported Media Type",
		416 => "416 Requested Range Not Satisfiable",
		417 => "417 Expectation Failed",
		500 => "500 Internal Server Error",
		501 => "501 Method Not Implemented",
		503 => "503 Service Unavailable",
		506 => "506 Variant Also Negotiates",
	];

	public static $_instance = NULL;

	/**
	 * @return HTTP
	 */
	public static function instance()
	{
		if (empty(self::$_instance))
		{
			self::$_instance = new HTTP();
		}
		return self::$_instance;
	}

	public function header($array, $value = NULL)
	{
		if (is_array($array))
		{
			foreach ($array as $key=>$item)
			{
				header($key.': '.$item);
			}
		}
		elseif (is_null($value))
		{
			header($array);
		}
		else
		{
			header($array.': '.$value);
		}
	}

	public function status($code)
	{
		$this->header('HTTP/1.1 '.self::$HTTP_HEADERS[$code]);
	}

	public function response($content)
	{
		exit($content);
	}

	public function redirect($url, $mode = 301)
	{
		$this->status($mode);
		$this->header('Location', $url);
		$this->finish();
	}

	public function finish($content = null)
	{
		$this->response($content);
	}
}