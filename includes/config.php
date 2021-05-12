<?php
/*Details to the database*/
	$config['db_host'] = 'mysqlsrv.dcs.bbk.ac.uk';
	$config['db_name'] = 'jlee49';
	$config['db_pass'] = 'bbkmysql';
	$config['db_user'] = 'jlee49db';

	date_default_timezone_set('Europe/London');

	$config['language'] = 'en';
	//$config['language'] = 'esp';
	
	$config['app_dir'] = dirname(dirname(__FILE__));
	$config['upload_dir'] = $config['app_dir'] . '/uploads/';
?>