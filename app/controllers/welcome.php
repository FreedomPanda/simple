<?php

namespace App\Controllers;

use Simple\ORM;
use Simple\Controller;
use Simple\View;

class Welcome extends Controller
{
	public function action_index()
	{
		View::bind([
			'content'	=> ORM::factory('articles')->count(),
			'title'		=> 'Simple.PHP',
		]);
		View::display('test');
	}
}