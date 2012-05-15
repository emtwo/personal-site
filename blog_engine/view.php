<?php
	session_start();	
	if(!isset($_SESSION['username']) && !$_SESSION['isClient']) {
		header("Location: login.php");
	}
?>

<html>

	<head>
		<?php
			echo "<title>" . $_SESSION['blog_name'] . " | SSSS</title>";
		?>
		<link rel="stylesheet" type="text/css" href="web.css" />
	</head>

	<body>

		<div id="container">
			<div id="main">
				<?php 
					require("layout.php");
					echo "<h1>" . $_SESSION['blog_name'] . "</h1>";
					echo "<h3>By: " . $_SESSION['username'] . "</h3>"; 
				?>
		
				<div id="blog_posts">
					<?php
						include 'includes.php';
						$blogPosts = GetBlogsGivenPerson($_SESSION['author_id']);
						
						foreach ($blogPosts as $post) {		
							$post_id = $post->id;
							echo "<div class='post'>";
							echo "<h2><a href='dynamic_pg.php?post_id=" . $post_id . "'>" . $post->title . "</a></h2>";
							echo $post->datePosted;
							echo "<p>" . stripslashes($post->post) . "</p>";
							echo " <a href='edit.php?post_id=$post_id'>Edit</a> | <a href='delete.php?post_id=$post_id'>Delete</a>";
							//echo "<span class='footer'>Posted By: " . $post->author . " Posted On: " . $post->datePosted . " Tags: " . $post->tags . "</span>";
							echo "<hr>";
							echo "</div>";
						}
					?>
				</div>
				<p>&copy Simple SamSoft Solutions</p>
			</div>
			<div class="clearfix"></div>
		</div>
		
	</body>
	
</html>