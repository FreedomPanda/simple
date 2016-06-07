<?php

namespace App\Controllers;

use Simple\Controller;
use Simple\View;

class Welcome extends Controller
{
	public function action_index()
	{
		View::bind([
			'content'	=> 'Hello',
			'title'		=> 'Simple.PHP',
		]);
		View::display('test');
	}
}