<?php
	include 'includes.php';
	session_start();
	if($_SESSION['isAdmin'] || $_SESSION['isClient']) {
		//otherwise logged in as either admin or client and allowed to view client page
		global $post_id;
		$post_id = $_GET['post_id'];
		$post = GetPostGivenPostId($post_id);	
							
		if(isset($_POST['submit'])) {
			$name = $_POST['name'];
			$email = $_POST['email'];
			$website = $_POST['website'];
			$comments = $_POST['comments'];
			$date = date_create();
			$date_formatted = date_format($date, 'Y-m-d H:i:s');
			
			if(!empty($name) && !empty($comments)) {
				Connect();
				mysql_select_db('blog');
				$sql = "INSERT INTO comments (name, email, website, comment, date_posted, post_id) VALUES ('$name', '$email', '$website', '$comments', '$date_formatted', '$post_id')";
					
				mysql_query($sql);
				Disconnect();
					
				//Success
				$success = true;
			} else {
				$error_msg = "Please fill in all fields before continuing";
				$success = false;
			}		
		}
	} else {
		header("Location: login.php");
	}
?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="blog.css" />
	</head>
	<div id='main'> 
		<?php
			global  $post_id;
			
			echo "<div class='post'>";
			echo "<h2>" . $post->title . "</h2>";
			echo $post->datePosted;
			echo "<p>" . stripslashes($post->post) . "</p>";
			echo "<hr>";
			echo "</div>";
						
			$comments = GetCommentsGivenPostId($post_id);
			foreach ($comments as $comment) {	
				echo "<div class='comment'>";
				echo "<h3>$comment->name says:</h3>";
				echo "<p>" . $comment->comment . "</p>";
				echo "<p>" . $comment->datePosted . "</p>";
				echo "</div>";
				echo "<hr>";
			}
		?>
		<div id='form-format'>	
			<h5>Join the Discussion!</h5>
			<form method='post' action=''>
		
				<p>*Full Name: </p>
				<input type='text' name='name'/>
				
				<p>Email: </p>
				<input type='text' name='email'/> (if you'd like a reply!)
				
				<p>Website</p>
				<input type='text' name='website'/> 

				<p>*Comment: </p>
				<textarea name='comments' rows='10' cols='77'></textarea>
				<p>
					<input type='submit' name='submit'/>
					<input type='reset' />
				</p>
			</form>
		</div>
	</div>
	<div class="clearfix"></div>
</html>