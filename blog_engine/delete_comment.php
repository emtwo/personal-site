<?php
	include 'includes.php';

	session_start();
	if($_SESSION['isAdmin']) {
		//is logged in and is admin
		$commentId = $_GET['comment_id'];
		$post_id = $_GET['post_id'];
		
		//Deleting a comment from the DB
		Connect();
		mysql_select_db('blog');
											
		$sql = "DELETE FROM comments WHERE id = '$commentId'";
		$result = mysql_query($sql);
		
		header("Location: dynamic_pg.php?post_id=$post_id");
	} elseif($_SESSION['isClient']) {
		//logged in as a client => go back to public_view
	} else {
		header("Location: login.php");
	}
?>