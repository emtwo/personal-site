<?php	
	if(isset($_POST['submit'])) {
		$title = $_POST['title'];
		$blog = $_POST['blog'];
		$date = date_create();
		$dateFormatted = date_format($date, 'Y-m-d H:i:s');
		
		if(!empty($title) && !empty($blog)) {
			$link = mysql_connect('localhost', 'root', '');
			mysql_select_db('marina');
			$sql = "INSERT INTO blog (Title, Blog, Date) VALUES ('$title', '$blog', '$dateFormatted')";
			
			mysql_query($sql);
			mysql_close($link);
			
			$success = true;
		} else {
			$success = false;
		}
	}
?>


<html>

	<head>
		<title>Create Blog | Marina Samuel</title>
		<link rel="stylesheet" type="text/css" href="web.css" />
		<script type="text/javascript" src="analytics.js"></script>
	</head>

	<body>

		<div id="container">
			<div id="admin_create">
				<h2>Create Blog</h2>
				<div id="form-format">
					<form method="post" action="">

						<p>Blog Title: </p>
						<input type="text" name="title" size="70"/>

						<p>Blog: </p>
						<textarea name="blog" rows="10" cols="116"></textarea>

						<p>
							<input type="submit" name="submit"/>
							<input type="reset" />
						</p>

					</form>
				</div>
			</div>
			
			<div class="clearfix"></div>
		</div>
		
	</body>
	
</html>