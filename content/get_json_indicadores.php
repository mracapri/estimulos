<?php
	include "mysql.php";
	header('Content-type: application/json');
	$con = getConnection();
	$resultSet = mysql_query("SELECT user FROM user");		
	echo json_encode(mysql_fetch_array($resultSet));
	close($con);
?>
