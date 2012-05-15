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
		$blog_name = $_POST['blog_name'];
		$username = $_POST['username'];
		$password = sha1($_POST['password']);
		$email = $_POST['email'];
					
		if(!empty($blog_name) && !empty($username) && !empty($_POST['password']) && !empty($email)) {
		
			Connect();
			mysql_select_db('blog');
			
			$sql = "SELECT * FROM people WHERE username = '$username'";
			$result = mysql_query($sql);
			
			if ($person = mysql_fetch_assoc($result)) {
				$error_msg = "Username already in use.  Please try another username.";
				$success = false;
			} else {
				$sql = "INSERT INTO people (blog_name, username, password, email) VALUES ('$blog_name', '$username', '$password', '$email')";
				mysql_query($sql);
				Disconnect();
				
				/*
				$subject = 'Welcome to SamBlogger!';
				$body = "Dear " . $username . ",\n\n On behalf of Simple SamSoft Solutions, I'd like to thank you for joining SamBlogger!";
				$header = 'From: ' . "Marina Samuel" . "\r\n" . 'Reply-To: ' . "marina.samuel25@gmail.com";
				
				mail($email, $subject, $body, $header);
				*/
				
				$success = true;
			}										
		}
		else {
			$error_msg = "Please fill in all fields before continuing";
			$success = false;
		}
	}			
?>

<html>

	<head>
		<title>Join SamBlogger | Marina Samuel</title>
		<link rel="stylesheet" type="text/css" href="web.css" />
	</head>

	<body>

		<div id="container">
				
			<div id="main">
				<div id="topNavigator">
					<ul>
						<li><a href='index.php'>Home</a></li>
						<li><a href='login.php'>Login</a></li>
					</ul>
				</div>
				<hr color='grey'>
			</div>
			
			
			<div id="center">
				
				<h2>Join SamBlogger Free!</h2>
				
				<?php 
					if(isset($success) && !$success) {
						echo "<span class='dynamic_text'><p id='warning'>" . $error_msg . "</p></span>";
					} elseif(isset($success) && $success) { 
						echo "<span class='dynamic_text'><p>Thank you! You are now an official member of SamBlogger!</p></span>";
					}
				?>
				
				<form method="post" action="">
					<div id="form-format">
						<label for="username">Blog Name: </label>
						<input type="text" name="blog_name"/>
						<br/>
						<label for="username">Username: </label>
						<input type="text" name="username"/>
						<br/>
						<label for="password">Password: </label>
						<input type="password" name="password"/> 
						<br/>
						<label for="email">Email: </label>
						<input type="text" name="email"/> 
						<br/>
					</div>
					<input type="submit" name="submit" value="Join Now!"/>
				</form>
					
			</div>
			<div class="clearfix"></div>
		</div>
		
	</body>
	
</html>