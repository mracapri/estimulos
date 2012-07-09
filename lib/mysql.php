<?php
	include 'mysql_properties.php';

	/*******************************************
	Obtiene la conexion a la base de datos
	********************************************/

	function getConnection(){
		$conection = mysql_connect(HOST_NAME, MYSQL_USER, MYSQL_PASSWORD);
		if (!$conection)
		{
			die("No se puede conectar a la base de datos: " 
				. mysql_error());
		}
		mysql_select_db(MYSQL_DATABASE_NAME, $conection);
		return $conection;
	}


	/*******************************************
	Cierra la conexión a la base de datos
	********************************************/
	function close($conection){
		mysql_close($conection);
	}
?>
