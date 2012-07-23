<?php
	/*******************************************
	Funcion para mandar mensajes via log
	********************************************/
	function log_($mensaje){
		error_log("\n".$mensaje."\n", 3, "/errors-estimulos.log");
	}

	/*******************************************
	Funcion para mandar mensajes a la pantalla del usuario

	ejemplo:

	@param mensaje
	@param id del elemento donde se anexara el mensaje
	enviaMensajeAPantalla("Datos invalidos", "div1");

	********************************************/
	function enviaMensajeAPantalla($mensaje,  $idElementoHtml){
		$mensajeHtml = "";
		$mensajeHtml .= "<div class=\"alert\" id=\"alerta-general\">";
		$mensajeHtml .= 	"<button class=\"close\" data-dismiss=\"alert\">x</button>";
		$mensajeHtml .= 	"<strong>Atencion!</strong> ";
		$mensajeHtml .= 	$mensaje;
		$mensajeHtml .= "</div>";

		/* definiendo script para agregar alerta */
		$scriptJQuery = "";
		$scriptJQuery .= "<script language=\"javascript\">";
		$scriptJQuery .= 	"$(document).ready(function(){";
		$scriptJQuery .= 		"$('".$mensajeHtml."').appendTo('#".$idElementoHtml."');";
		$scriptJQuery .= 	"});";
		$scriptJQuery .= "</script>";

		echo $scriptJQuery;
	}
?>
