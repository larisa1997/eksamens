<?php

	$db_loc = 'localhost';
	$db_user = 'root';
	$db_pass = '';
	$db_name = 'kases_aparati';

	$connect = mysql_connect($db_loc, $db_user, $db_pass) or die(mysql_error());

	mysql_select_db($db_name, $connect) or die(mysql_error());

	mysql_query("set character_set_client='utf8'");
	mysql_query("set character_set_results='utf8'");
	mysql_query("set collation_connection='utf8_general_ci'");
	
?>