<?php
	require_once("../../lib/librerias.php");
	
	function elegirDocenteEvaluar()
	{
		$plantillaElegirDocente = "";
		$plantillaElegirDocente .= "<div class='span1 seccion1-3-1'> ";
		$plantillaElegirDocente .= 		"<span class='label label-info' 'seleccion-documento'> ";
		$plantillaElegirDocente .= 			"Evaluado ";
		$plantillaElegirDocente .= 		"</span> "; 
		$plantillaElegirDocente .= 		"<div class='usuario'> ";
		$plantillaElegirDocente .= 			"<a href='http://localhost/estimulos/content/evaluacion/VentanaEvaluacion.php' class='usuario'> ";
		$plantillaElegirDocente .=			"</a> ";
		$plantillaElegirDocente .= 		"</div> ";
		$plantillaElegirDocente .= 		"<div class='spand1 seccion3-3 '> ";
		$plantillaElegirDocente .= 			"<a href='#' rel='tooltip' title='Mtra Maria de Lourdes Santiago Zaragoza'> ";
		$nombre = 'Mtra Maria de Lourdes Santiago Zaragoza';
		
		if(strlen($nombre)>10){
			//$plantillaElegirDocente .= substr ($nombre, 0, 10)."...";
			$plantillaElegirDocente .= $nombre;
		}else{
			$plantillaElegirDocente .=$nombre;
		}
		
		$plantillaElegirDocente .= 			"</a> ";
		$plantillaElegirDocente .= 		"</div> ";
		$plantillaElegirDocente .= "</div> ";
		return $plantillaElegirDocente;
	}	
?>
	
