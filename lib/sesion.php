<?php 
	

	/*
		variable para prender la seguridad del sistema

		1 - ACTIVADA
		0 - DESACTIVADA

		Produccion: siempre en ACTIVADA
	*/
	define("SEGURIDAD", "0"); 

	/* login provisional */
	logIn();

	function verificarSesionDelUsuario(){
		if(SEGURIDAD == 1){
			$alertaHtml = "";
			$alertaHtml .= "<span id=\"alerta-sesion\" style=\"margin-left:20px;\" class=\"label label-important\">Vuelva a iniciar sesion</span>";

			/* definiendo script para agregar alerta */
			$scriptJQuery = "";
			$scriptJQuery .= "<script language='javascript'>";
			$scriptJQuery .= 	"$(document).ready(function(){";
			$scriptJQuery .= 		"if($('#alerta-sesion').size() == 0){";
			$scriptJQuery .= 			"$('".$alertaHtml."').appendTo(\"#nombre-persona\");";
			$scriptJQuery .= 		"}";
			$scriptJQuery .= 	"});";
			$scriptJQuery .= "</script>";

			/* comprobando la seguridad de la app */
			if(!isset($_SESSION['usuarioFirmado'])){
				echo $scriptJQuery;
				return false;
			}else{
				return true;
			}			
		}else{
			return true;
		}
	}

	/* Iniciar sesion */
	function logIn(){
		// iniciando sesion
		//session_start();

		// store session data
		$_SESSION['idEmpleado'] = "E704";
		$_SESSION['idPeriodos'] = "44, 45, 46";
		$_SESSION['anioEvaluacion'] = (2012-1);
		$_SESSION['usuarioFirmado'] = "1";
		$_SESSION['nombreUsuario'] = "Mario Rivera Angeles";
	}

	/* Terminar sesion */
	function logOut(){
		
	}
?>