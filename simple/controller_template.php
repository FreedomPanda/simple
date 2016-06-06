<?php

namespace Simple;

class Controller_Template extends Controller
{
	public $template = '';

	public function before()
	{
		// Nothing by default
		$this->template = Route::$view;
	}

	public function after()
	{
		// Nothing by default
		$this->display();
	}

	public function bind($key, $value = NULL)
	{
		View::bind($key, $value);
	}

	public function display()
	{
		View::display($this->template);
	}

} // End Controller
