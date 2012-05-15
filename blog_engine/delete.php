<?php
	include 'includes.php';

	session_start();
	if($_SESSION['isAdmin']) {
		//is logged in and is admin
		$postId = $_GET['post_id'];
		
		//Deleting a post from the DB
		
		Connect();
		mysql_select_db('blog');
											
		$del_post = "DELETE FROM blog_posts WHERE id = '$postId'";
		$del_comments = "DELETE FROM comments WHERE post_id = '$postId'";
		$result = mysql_query($del_post);
		$result = mysql_query($del_comments);
		
		header("Location: view.php");
	} elseif($_SESSION['isClient']) {
		//logged in as a client => go back to public_view
	} else {
		header("Location: login.php");
	}
?>	