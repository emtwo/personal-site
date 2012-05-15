<?php
	session_start();
	if(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']) {
		header("Location: view.php");
	} elseif(isset($_SESSION['isClient']) && $_SESSION['isClient']) {
		//logged in as a client => go back to public_view
	} else {
		//otherwise this page is for not logged in
	}
?>

<html>

	<head>
		<title>SamBlogger | Marina Samuel</title>
		<link rel="stylesheet" type="text/css" href="web.css" />
	</head>

	<body>

		<div id="container">
			<div id="center">
				<h2>SamBlogger</h2>
				<h3>
					Create and edit a blog in seconds! Join for free today!
				</h3>
				<div id="home_navigator">
					<ul>
						<li><a href="join.php">Join</a></li>
						<li><a href="login.php">Login</a></li>
					</ul>
				</div>
				&copy Simple SamSoft Solutions
			</div>
			<div class="clearfix"></div>
		</div>
		
	</body>
	
</html>
