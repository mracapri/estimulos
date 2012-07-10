<?php
	/*******************************************
	Funcion para mandar mensajes via log
	********************************************/
	function log_($mensaje){
		error_log("\n".$mensaje."\n", 3, "/errors-estimulos.log");
	 }
?>
