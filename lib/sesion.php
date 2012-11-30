<?php 
	/*
		variable para prender la seguridad del sistema

		1 - ACTIVADA
		0 - DESACTIVADA

		Produccion: siempre en ACTIVADA
	*/
	define("SEGURIDAD", "0"); 

	function verificarSesionDelUsuario(){
		/* comprobando la seguridad de la app */
		if(!isset($_SESSION['usuarioFirmado'])){
			echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.PATH.'/index.php">';
			die();
		}else{
			return true;
		}
	}
?>