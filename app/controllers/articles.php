<?php

namespace App\Controllers;

use Simple\Controller_Template;
use Simple\View;

class Articles extends Controller_Template
{
	public function action_index()
	{
		View::bind([
			'content'	=> 'Hello',
		]);
	}

	public function action_detail($id = NULL)
	{
		View::bind([
			'id'	=> $id,
			'title'	=> 'detail',
		]);
	}
}