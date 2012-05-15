<?php
	include 'includes.php';
	session_start();
	if($_SESSION['isAdmin']) {
		//is logged in and is admin
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
	} elseif($_SESSION['isClient']) {
		//logged in as a client => go back to public_view
	} else {
		header("Location: login.php");
	}
?>

<html>
	<head>
		<title><?php echo $post->title;?></title>
		<link rel='stylesheet' type='text/css' href='web.css' />
	</head>
	<body>
		<div id='container'> 
			<div id='main'> 
				<?php
					global  $post_id;
				
					require("layout.php");
					echo "<div class='post'>";
					echo "<h2>" . $post->title . "</h2>";
					echo "<p>" . $post->post . "</p>";
					echo $post->datePosted;
					echo "<hr>";
					echo "</div>";
					
					$comments = GetCommentsGivenPostId($post_id);
					foreach ($comments as $comment) {	
						echo "<div class='comment'>";
						echo "<h2>$comment->name says:</h2>";
						echo "<p>" . $comment->comment . "</p>";
						echo "<p>" . $comment->datePosted . "</p>";
						$comment_id = $comment->id;
						echo "<a href='delete_comment.php?comment_id=$comment_id&post_id=$post_id'>Delete</a>";
						echo "</div>";
						echo "<hr>";
					}
				?>
			</div>
			<div class='clearfix'></div>
		</div>
	</body>
</html>