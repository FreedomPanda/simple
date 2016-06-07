<?php

namespace Simple;

class Error extends \Exception
{
	public $title = NULL;
	public $content = NULL;


	public function __construct($content, $title = 'Simple Error')
	{
		$this->title = $title;
		$this->content = $content;
		parent::__construct($content);
	}

	public function info()
	{

		if (DEBUG)
		{
			$data = [
				'message'	=> $this->title,
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
