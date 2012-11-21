<?php 
	/*
		variable para prender la seguridad del sistema

		1 - ACTIVADA
		0 - DESACTIVADA

		Produccion: siempre en ACTIVADA
	*/
	define("SEGURIDAD", "0"); 

	function verificarSesionDelUsuario(){
		if(SEGURIDAD == 1){
		$alertaHtml = "";
		$alertaHtml .= "<span id=\"alerta-sesion\" style=\"margin-left:20px;\" class=\"label label-important\">";
			$alertaHtml .= 		"<a href=\"content/login/login.php\" style=\"color:white; \">";
		$alertaHtml .= 			"Vuelva a iniciar sesion";
		$alertaHtml .= 		"</a>";
		$alertaHtml .= "</span>";

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
?>