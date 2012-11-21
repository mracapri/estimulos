<?php	
	session_start();
	require_once("constants.php"); // constantes del sistema
	define("PATH", CONTEXTO."/estimulos");
	if($_GET['killsession'] == 1){
		logOut();
		echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.CONTEXTO.'/estimulos/index.php">';
	}

	/* Terminar sesion */
	function logOut(){
	    session_destroy();   // destruye la session
	    session_unset();     // remueve la $_SESSION 
	}

?>