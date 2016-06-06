<?php

namespace Simple;

class Error extends \Exception
{
	public $message = NULL;
	public $content = NULL;


	public function __construct($content, $message = 'Simple Error')
	{
		$this->message = $message;
		$this->content = $content;
		parent::__construct($content);
	}

	public function info()
	{

		if (DEBUG)
		{
			$data = [
				'message'	=> $this->message,
				'content'	=> $this->content,
			];
			$file_path = ROOT.'simple/views/debug.php';
		}
		else
		{
			HTTP::instance()->status(500);
			$data = [
				'title'		=> '500 Service Error',
				'message'	=> '服务器被临时工搬走了....',
			];
			$file_path = ROOT.'simple/views/error.php';
		}
		View::bind($data);
		View::display($file_path, FALSE);
	}
}
