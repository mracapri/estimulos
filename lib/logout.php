<?php	
	session_start();
	define("PATH", "/estimulos");
	if($_GET['killsession'] == 1){
		logOut();
		echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.PATH.'/index.php">';
	}

	/* Terminar sesion */
	function logOut(){
	    session_destroy();   // destruye la session
	    session_unset();     // remueve la $_SESSION 
	}

?>