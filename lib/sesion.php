<?php 
	/*
		verifica si la seccion aun es activa y lo notifica al usuario
	*/

	function verificarSesionDelUsuario(){
		$alertaHtml = "";
		$alertaHtml .= "<span id=\"alerta-sesion\" style=\"margin-left:20px;\" class=\"label label-important\">";
		$alertaHtml .= 		"<a href=\"/estimulos/\" style=\"color:white; \">";
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
			exit;
			return false;
		}else{
			return true;
		}
	}
?>