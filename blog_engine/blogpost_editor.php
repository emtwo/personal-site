<?php
	//setup variables for create vs edit blog entries
	session_start();
	if($_SESSION['isAdmin']) {
		$action_file = $_SESSION['blogpost_editor'];
		$title = $_SESSION['title'];
	} elseif($_SESSION['isClient']) {
		//logged in as a client => go back to public_view
	} else {
		header("Location: login.php");
	}
?>

<html>

	<head>
		<title>Create SamBlog | Marina Samuel</title>
		<link rel="stylesheet" type="text/css" href="web.css" />
	</head>

	<body>

		<div id="container">
			<div id="main">
				<?php 
					require("layout.php");
					echo "<h2>" . $title . " Blog Post</h2>";
				
					if(isset($success) && !$success) {
						echo "<span class='dynamic_text'><p id='warning'>" . $error_msg . "</p></span>";
					} 
					
					echo "<form method='post' action='" . $action_file . "'>";
				
					echo "<p>Blog Title: </p>";
					
					// Blog entry exists (we are doing an edit)
					if(isset($_SESSION['blog_entry'])){
						$entry = $_SESSION['blog_entry'];
						$blog_title = stripslashes($entry['title']);
						$post = stripslashes($entry['post']);
					}
					
					if($action_file == "edit.php"){
					?>
						<!-- Getto haxxors - If I didn't do this thing, the title in the input field got cut off! -->
						<input type='text' name='title' size='70' value="<?php echo $blog_title; ?>"/>
						
					<?php
						$_SESSION['doit'] = true;
					} elseif($action_file == "create.php") {
						echo "<input type='text' name='title' size='70'/>";
					}
				
					echo "<p>Blog: </p>";
					if($action_file == "edit.php"){ 
						echo "<textarea name='blog' rows='20' cols='116'>$post</textarea>";
					} elseif($action_file == "create.php") {
						echo "<textarea name='blog' rows='20' cols='116'></textarea>";
					}
				
					echo "<p> <input type='submit' name='submit'/> <input type='reset' /> </p>";	
					echo "</form>";
				?>
				
				<hr>
				<p>&copy Simple SamSoft Solutions</p>
			</div>
			<div class="clearfix"></div>
		</div>
		
	</body>
	
</html>