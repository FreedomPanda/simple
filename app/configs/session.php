<?php

return [
	'mode'		=> 'mysql',			//mysql or redis
	'mysql'		=> [
		'name'		=> '_session_id',
		'table'		=> 'sessions',
		'gc'		=> 500,
		'columns'	=> [
			'session_id'	=> 'session_id',
			'last_active'	=> 'last_active',
			'contents'		=> 'contents',
		],
		'expire'	=> 2592000,		//30 day
	],
	'redis'		=> [
		'name'		=> '_session_id',
		'prefix'	=> 'SESSION_',
		'expire'	=> 2592000,		//30 day
	],
];