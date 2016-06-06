<html>
<head>
	<title><?php echo $message; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style type="text/css">
		*{
			font-family:		Consolas, Courier New, Courier, monospace;
			font-size:			14px;
		}
		body {
			background-color:	#fff;
			margin:				40px;
			color:				#000;
		}

		#content  {
			border:				#999 1px solid;
			background-color:	#fff;
			padding:			20px 20px 12px 20px;
			line-height:160%;
		}

		h1 {
			font-weight:		normal;
			font-size:			14px;
			color:				#990000;
			margin: 			0 0 4px 0;
		}
	</style>
</head>
<body>
<div id="content">
	<h1><?php echo $message; ?></h1>
	<p><?php echo $content; ?></p>
	<pre>
		<?php $trace = debug_backtrace(); ?>
		<?php echo str_repeat('-', 100); ?>
		<?php echo str_repeat('-', 100); ?>
		<?php foreach ($trace as $key=>$value) :?>
			<?php $value['line'] = !isset($value['line']) || empty($value['line']) ? 0 : $value['line'];?>
			<?php $value['class'] = !isset($value['class']) || empty($value['class']) ? '' : $value['class'];?>
			<?php $value['type'] = !isset($value['type']) || empty($value['type']) ? '' : $value['type'];?>
			<?php $value['file'] = !isset($value['file']) || empty($value['file']) ? 'not_found' : $value['file'];?>
			<?php echo "#$key\t line:{$value['line']}\t call:{$value['class']}{$value['type']}{$value['function']}\t file:{$value['file']}\n"; ?>
		<?php endforeach; ?>
	</pre>
</div>
</body>
</html>