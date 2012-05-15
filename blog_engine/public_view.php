<?php
	if(!isset($_SESSION['username'])) {
		//display message if not logged in to log in for clients
		echo "Please Login.";
	}
	//otherwise logged in as either admin or client and allowed to view client page
?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="blog.css" />
	</head>
	<body>
		<div id="main">
			<?php 
				echo "<h2>" . $_SESSION['blog_name'] . "</h2>";
				echo "<h4>By: " . $_SESSION['username'] . "</h4>"; 
			?>
			<hr>
			<div id="blog_posts">
				<?php
					$blogPosts = GetBlogsGivenPerson($_SESSION['author_id']);
					
					foreach ($blogPosts as $post) {		
						$post_id = $post->id;
						$num_comments = count(GetCommentsGivenPostId($post_id));
						echo "<div class='post'>";
						echo "<h3><a href='public_dynamic_pg.php?post_id=" . $post_id . "'>" . $post->title . "</a></h3>";
						echo $post->datePosted;
						echo "<p>" . stripslashes($post->post) . "</p>";
						echo "<p><a href='public_dynamic_pg.php?post_id="	. $post_id ."'>" . $num_comments . " Comment(s)</a></p>";
						//echo "<span class='footer'>Posted By: " . $post->author . " Posted On: " . $post->datePosted . " Tags: " . $post->tags . "</span>";
						echo "<hr>";
						echo "</div>";
					}
				?>
			</div>
			<p>&copy Simple SamSoft Solutions</p>
			<div class="clearfix"></div>
		</div>
	</body>
</html>