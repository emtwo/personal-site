<?php
	include 'includes.php';

	session_start();
	if($_SESSION['isAdmin']) {
		//is logged in and is admin
		if(!isset($_POST['submit'])) {
			//Get variables from POST method
			$postId = $_SESSION['post_id'] = $_GET['post_id'];
			
			//Get access to blog that's getting edited
			Connect();
			mysql_select_db('blog');
												
			$sql = "SELECT * FROM blog_posts WHERE id = '$postId'";
			$result = mysql_query($sql);
			
			$row = mysql_fetch_assoc($result);
			
			Disconnect();
			
			//Setting session variables
			$_SESSION['blogpost_editor'] = "edit.php";
			$_SESSION['title'] = "Edit a";
			$_SESSION['blog_entry'] = $row;
			
			header("Location: blogpost_editor.php");
		} else {
			$title = addslashes($_POST['title']);
			$blog = addslashes($_POST['blog']);
			
			if(!empty($title) && !empty($blog)) {
				//Saving the post to SQL
				Connect();
				mysql_select_db('blog');
				$author_id = $_SESSION['author_id'];
				$postId = $_SESSION['post_id'];
				$sql = "UPDATE blog_posts SET title='$title', post='$blog' WHERE id='$postId'";
				
				mysql_query($sql);
				Disconnect();
				
				//Success
				$success = true;
				header("Location: view.php");
			} else {
				$error_msg = "Please fill in all fields before continuing";
				$success = false;
			}
			
			//unset session vars
		}
	} elseif($_SESSION['isClient']) {
		//logged in as a client => go back to public_view
	} else {
		header("Location: login.php");
	}
?>