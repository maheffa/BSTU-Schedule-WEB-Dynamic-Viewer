<!DOCTYPE html>
<html>
	<head>
		<title>BSTU Super Schedule</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="css/global.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<link rel="icon" href="http://www.bstu.ru/favicon.ico" type="image/x-icon">
		<meta charset="UTF-8">
	</head>
	<body class="transp">
		<div id="body_wrap">
			<div id="header">
				<a href="index.php"><img src="image/logo.png"/></a>
				<div id="top_menu">
					<ul>
						<li class="tmenu_item box"><a href="index.php?page=home">Home</a></li>
						<li class="tmenu_item box"><a href="index.php?page=comparison">Comparison</a></li>
						<li class="tmenu_item box"><a href="index.php?page=statistic">Statistic</a></li>
					</ul>
				</div>

			</div>

			<div id="body">
				<?php
					$page = filter_input(INPUT_GET, 'page');
					if ($page == '' || $page == 'home') {
						include 'home.php';
					} elseif ($page == 'statistic') {
						include 'statistic.php';
					} elseif ($page == 'comparison') {
						include 'comparison.php';
					} else {
						header('HTTP/1.1 404 Not Found');
						include '404.php';
					}

				?>
			</div>

			<span id="footer">
				<p> by MANITRARIVO Adama Mahefa, Group PV-41</p>
			</span>
		</div>
	</body>
</html>
