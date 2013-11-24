<?php
	include ('function.php');
	
	top();
	
	connect_db();
	
	display_db();
?>
	<a href="index.php">Go and insert new record!</a><br/>
<?php
	delete();
	
	edit();
	
	bottom();
?>