<?php
//Establishes a connection with the database. Values are taken from the config.php file
$link = mysqli_connect(
		$config['db_host'], 
		$config['db_name'], 
		$config['db_pass'], 
		$config['db_user']
	);
	if (mysqli_connect_errno()) {
		exit(mysqli_connect_error());
	}
?>