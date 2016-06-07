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

		table {
			text-align: left;
			margin-bottom: 40px;
		}
		tr {
			height: 20px;
		}
	</style>
</head>
<body>
<div id="content">
	<h1><?php echo $message; ?></h1>
	<p><?php echo $content; ?></p>
	<?php $trace = debug_backtrace(); ?>
	<table frame="hsides">
		<thead>
			<tr>
				<th width="50">No</th>
				<th width="600">文件</th>
				<th width="400">类名-方法</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($trace as $key=>$value) :?>
				<tr>
					<td><?php echo $key; ?></td>
					<td><?php echo 'file:'.\Simple\Arr::get($value, 'file', 'not_found'); ?>[<?php echo \Simple\Arr::get($value, 'line', 0); ?>]</td>
					<td><?php echo 'call:'.\Simple\Arr::get($value, 'class', '').\Simple\Arr::get($value, 'type', '').\Simple\Arr::get($value, 'function', ''); ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
</body>
</html>