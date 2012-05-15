<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<?php	
	if(isset($_POST['submit']))
	{
		$name = $_POST['name'];
		$email = $_POST['email'];
		$website = $_POST['website'];
		$comments = $_POST['comments'];
					
		if(!empty($name) && !empty($comments))
		{
			//$link = mysql_connect('localhost', 'root', '');	
			$link = mysql_connect('marina.db', 'm2samuel', 'MKVoNc4');	
			if (!$link) die(mysql_error());
			mysql_select_db('marina');
												
			$sql = "INSERT INTO feedback VALUES ('$name', '$email', '$website', '$comments')";
			mysql_query($sql);
			mysql_close($link);
			
			$to = 'marina.samuel25@gmail.com';
			$subject = 'Comment From: ' . $name;
			$body = $comments . "\n\n" . 'Website: ' . $website;
			$header = 'From: ' . $name . "\r\n" . 'Reply-To: '.$email;
			
			mail($to, $subject, $body, $header);
			
			$success = true;
		}
		else
			$success = false;
	}			
?>

<html>

	<head>
		<title>Feedback | Marina Samuel</title>
		<link rel="stylesheet" type="text/css" href="web.css" />
	</head>

	<body>

		<div id="container">
		
			<?php require("layout.php"); ?>
			
			<div id="content">
				<h2>Feedback</h2>
				<h3>I'd love to hear from you!</h3>
				<p>
					This is my first ever <em>published</em> personal website.  Your feedback would be greatly appreciated!
				</p>
				
				<?php if(isset($success) && !$success): ?>
					<span class="dynamic_text"><p id="warning">Please fill in all mandatory fields marked by an * before submitting!</p></span>
				<?php elseif(isset($success) && $success): ?>
					<span class="dynamic_text"><p>Thank you! Your comments were successfully submitted!</p></span>
				<?php endif; ?>

				<div id="form-format">
					<form method="post" action="">

						<p>*Full Name: </p>
						<input type="text" name="name"/>
						
						<p>Email: </p>
						<input type="text" name="email"/> (if you'd like a reply!)
						
						<p>Website</p>
						<input type="text" name="website"/> 

						<p>*Comment: </p>
						<textarea name="comments" rows="10" cols="77"></textarea>

						<p>
							<input type="submit" name="submit"/>
							<input type="reset" />
						</p>

					</form>
				</div>

			</div>
			
			<div class="clearfix"></div>
			
		</div>
		
	</body>
	
</html>
