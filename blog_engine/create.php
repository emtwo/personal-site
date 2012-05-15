<?php
	include 'includes.php';
	
	session_start();
	if($_SESSION['isAdmin']) {
		//is logged in and is admin	
		if(isset($_POST['submit'])) {
			$title = addslashes($_POST['title']);
			$blog = addslashes($_POST['blog']);
			$date = date_create();
			$date_formatted = date_format($date, 'Y-m-d H:i:s');
			
			if(!empty($title) && !empty($blog)) {
				//Saving the post to SQL
				Connect();
				mysql_select_db('blog');
				$author_id = $_SESSION['author_id'];
				$sql = "INSERT INTO blog_posts (title, post, author_id, date_posted) VALUES ('$title', '$blog', '$author_id', '$date_formatted')";
				
				mysql_query($sql);
				$postId = mysql_insert_id();
				$_SESSION['post_id'] = $postId;
				Disconnect();
				
				//Success
				$success = true;
				
				header("Location: view.php");
			} else {
				$error_msg = "Please fill in all fields before continuing";
				$success = false;
			}
			
			//unset session vars
		} else {
			$_SESSION['blogpost_editor'] = "create.php";
			$_SESSION['title'] = "Create a New";
			header("Location: blogpost_editor.php");
		}
	} elseif($_SESSION['isClient']) {
		//logged in as a client => go back to public_view
	} else {
		header("Location: login.php");
	}
?>