<?php
	$link = mysql_connect('localhost', 'root', '');
	mysql_select_db('marina');
	$result = mysql_query("SELECT * FROM blog ORDER BY UUID");
	
	while($row = mysql_fetch_assoc($result)) {
		echo $row['Title'];
		echo "<br>";
	}
	
	mysql_close($link);