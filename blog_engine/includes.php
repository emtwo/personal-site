<?php
include 'blogpost.php';
include 'comment.php';

$link;
Connect();
mysql_select_db('blog');

function Connect() {
	global $link;	
	//$link = mysql_connect('localhost', 'root', '');	
	$link = mysql_connect('marina.db', 'm2samuel', 'MKVoNc4');
	if (!$link) die(mysql_error());
}

function Disconnect() {
	global $link;
	mysql_close($link);
}

function GetBlogPosts($inId=null, $inTagId=null) {
	if (!empty($inId)) {
		$query = mysql_query("SELECT * FROM blog_posts WHERE id = " . $inId . " ORDER BY id DESC");
	} else if (!empty($inTagId)) {
		$query = mysql_query("SELECT blog_posts.* FROM blog_post_tags LEFT JOIN (blog_posts) ON (blog_post_tags.postID = blog_posts.id) WHERE blog_post_tags.tagID =" . $tagID . " ORDER BY blog_posts.id DESC");
	} else {
		$query = mysql_query("SELECT * FROM blog_posts ORDER BY id DESC");
	}
	
	$postArray = array();
	while ($row = mysql_fetch_assoc($query)) {
		$myPost = new BlogPost($row["id"], $row['title'], $row['post'], $row['author_id'], $row['date_posted']);
		array_push($postArray, $myPost);
	}
	return $postArray;
}

function GetBlogsGivenPerson($inPersonId) {
	Connect();
	mysql_select_db('blog');

	if(!empty($inPersonId)){
		$query = mysql_query("SELECT * FROM blog_posts WHERE author_id = " . $inPersonId . " ORDER BY id DESC");
	}
	
	$postArray = array();
	while ($row = mysql_fetch_assoc($query)) {
		$myPost = new BlogPost($row["id"], $row['title'], $row['post'], $row['author_id'], $row['date_posted'], $row['file']);
		array_push($postArray, $myPost);
	}
	return $postArray;
}

function GetCommentsGivenPostId($postId) {
	Connect();
	mysql_select_db('blog');

	if(!empty($postId)){
		$query = mysql_query("SELECT * FROM comments WHERE post_id = " . $postId . " ORDER BY id ASC");
	}
	
	$commentArray = array();
	while ($row = mysql_fetch_assoc($query)) {
		$comment = new Comment($row["id"], $row['name'], $row['email'], $row['website'], $row['comment'], $row['date_posted'], $row['post_id']);
		array_push($commentArray, $comment);
	}
	return $commentArray;
}

function GetPostGivenPostId($postId) {
	Connect();
	mysql_select_db('blog');

	if(!empty($postId)){
		$query = mysql_query("SELECT * FROM blog_posts WHERE id = " . $postId);
	}
	
	$row = mysql_fetch_assoc($query);
	$myPost = new BlogPost($row["id"], $row['title'], $row['post'], $row['author_id'], $row['date_posted'], $row['file']);
	
	return $myPost;
}

function Login($username, $password) {
	Connect();
	mysql_select_db('blog');
								
	$password = sha1($password);
	$sql = "SELECT * FROM people WHERE username = '$username' AND password = '$password'";
	$result = mysql_query($sql);
	
	if ($person = mysql_fetch_assoc($result)) {
		session_start();
		$_SESSION['blog_name'] = $person['blog_name'];
		$_SESSION['author_id'] = $person['id'];
		$_SESSION['username'] = $username;
		$_SESSION['isClient'] = 1;
		$success = true;
	} else {
		$error_msg = "Access Denied: invalid username or password";
		$success = false;
	}
					
	Disconnect();
	return $success;
}
?>