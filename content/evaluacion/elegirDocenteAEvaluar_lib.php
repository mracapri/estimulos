<?php
	require_once("../../lib/librerias.php");
	
	function consultaDocentesAEvaluar()
	{

		/* conexion a base de datos */
		$conexion = getConnection();

		$sqlPeriodoActual = "select idperiodo from siin_generales.gral_periodos where actual = 1";


		$resultSetPeriodoActual = mysql_query($sqlPeriodoActual);
		$periodoActual = 0;
		if(mysql_num_rows($resultSetPeriodoActual) > 0){
			$rowPeriodoActual = mysql_fetch_array($resultSetPeriodoActual);
			$periodoActual = $rowPeriodoActual[0];
		}

		$sqlDocentes = "SELECT a.idempleado as idempleado, concat(b.nombre ,' ',  b.paterno, ' ',  b.materno) as nombre, b.rfc, c.estado ";
		$sqlDocentes .= "FROM siin_generales.gral_usuarios_adscripcion a, siin_generales.gral_usuarios b, participantes c ";
		$sqlDocentes .= "WHERE a.idperiodo LIKE '".$periodoActual."' ";
		$sqlDocentes .= "AND a.idempleado = b.idempleado ";
		$sqlDocentes .= "AND a.idnivel IN ( 6, 7, 8, 9, 10 ) ";
		$sqlDocentes .= "AND b.rfc = c.rfc";

		/* ejecucion del query en el manejador de base datos */
		$resultSetGetDocentes = mysql_query($sqlDocentes, $conexion);			
		
		$plantillaElegirDocente = "";
		while($row = mysql_fetch_array($resultSetGetDocentes)){

			$nombre = $row['nombre'];			
			
			$plantillaElegirDocente .= "<div class='span1 seccion1-3-1'> ";
			if($row['estado'] == 0){
				$plantillaElegirDocente .= 		"<span class='label label-important' 'seleccion-documento'> ";
				$plantillaElegirDocente .= 			"No enviada";
				$plantillaElegirDocente .= 		"</span> "; 
			}else if($row['estado'] == 2){
				$plantillaElegirDocente .= 		"<span class='label label-info' 'seleccion-documento'> ";
				$plantillaElegirDocente .= 			"Evaluada";
				$plantillaElegirDocente .= 		"</span> "; 
			}else{
				$plantillaElegirDocente .= 		"<span class='label label-success' 'seleccion-documento'> ";
				$plantillaElegirDocente .= 			"Enviada";
				$plantillaElegirDocente .= 		"</span> "; 
			}

			$plantillaElegirDocente .= 		"<div class='usuario'> ";

			if($row['estado'] == 0){
				$plantillaElegirDocente .= 			"<a href='#' class='usuario'> ";			
				$plantillaElegirDocente .= 			"</a> ";
			}else if($row['estado'] == 2){
				$plantillaElegirDocente .= 			"<a href='#' class='usuario'> ";			
				$plantillaElegirDocente .= 			"</a> ";
			}else{
				$plantillaElegirDocente .= 			"<a href='ventanaEvaluacion.php?rfc=".$row['rfc']."' class='usuario'> ";
				$plantillaElegirDocente .= 			"</a> ";
			}

			$plantillaElegirDocente .= 		"</div> ";
			$plantillaElegirDocente .= 		"<div class='spand1 seccion3-3 '> ";
			if($row['estado'] == 0){
				$plantillaElegirDocente .= 			"<a href='#' rel='tooltip' title='".$nombre."'> ";			
				$plantillaElegirDocente .=				$nombre;
				$plantillaElegirDocente .= 			"</a> ";
			}else if($row['estado'] == 2){
				$plantillaElegirDocente .= 			"<a href='#' rel='tooltip' title='".$nombre."'> ";			
				$plantillaElegirDocente .=				$nombre;
				$plantillaElegirDocente .= 			"</a> ";
			}else{
				$plantillaElegirDocente .= 			"<a href='ventanaEvaluacion.php?rfc=".$row['rfc']."' rel='tooltip' title='".$nombre."'> ";
				$plantillaElegirDocente .=				$nombre;
				$plantillaElegirDocente .= 			"</a> ";
			}
			$plantillaElegirDocente .= 		"</div> ";
			$plantillaElegirDocente .= "</div> ";
		}

		// cerrando conexion a base de datos
		close($conexion);

		return $plantillaElegirDocente;
	}	
?>
	
