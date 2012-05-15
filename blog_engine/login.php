<?php
	include 'includes.php';

	session_start();
	if(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']) {
		header("Location: view.php");
	} elseif(isset($_SESSION['isClient']) && $_SESSION['isClient']) {
		//logged in as a client => go back to public_view
	} else {
		//otherwise this page is for not logged in
	}

	//otherwise this page is for not logged in	
	if(isset($_POST['submit']))
	{
		$username = htmlspecialchars($_POST['username']);
		$password = sha1($_POST['password']);
	
		if(!empty($username) && !empty($_POST['password'])) {
		
			Connect();
			mysql_select_db('blog');
												
			$sql = "SELECT * FROM people WHERE username = '$username' AND password = '$password'";
			$result = mysql_query($sql);
			
			if ($person = mysql_fetch_assoc($result)) {
				session_start();
				$_SESSION['blog_name'] = $person['blog_name'];
				$_SESSION['author_id'] = $person['id'];
				$_SESSION['username'] = $username;
				$_SESSION['isAdmin'] = 1;
				$success = true;
				header("Location: view.php");
			} else {
				$error_msg = "Access Denied: invalid username or password";
				$success = false;
			}
						
			Disconnect();
		}
		else {
			$error_msg = "Please fill in all fields before continuing";
			$success = false;
		}
	}			
?>

<html>

	<head>
		<title>Login to SamBlogger | Marina Samuel</title>
		<link rel="stylesheet" type="text/css" href="web.css" />
	</head>

	<body>

		<div id="container">
			<div id="main">
				<div id="topNavigator">
					<ul>
						<li><a href='index.php'>Home</a></li>
						<li><a href='join.php'>Join</a></li>
					</ul>
				</div>
				<hr color='grey'>
			</div>
			<div id="center">
				<h2>Login to SamBlogger</h2>
				
				<?php 
					if(isset($success) && !$success) {
						echo "<span class='dynamic_text'><p id='warning'>" . $error_msg . "</p></span>";
					} 
				?>
				
				<form method="post" action="">
					<div id="form-format">
						<label for="username">Username: </label>
						<input type="text" name="username"/>
						<br/>
						<label for="password">Password: </label>
						<input type="password" name="password"/> 
						<br/>
					</div>
					<input type="submit" name="submit" value="Login"/>
				</form>	
			</div>
			<div class="clearfix"></div>
		</div>
		
	</body>
	
</html>