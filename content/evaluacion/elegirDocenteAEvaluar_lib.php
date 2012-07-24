<?php
	require_once("../../lib/librerias.php");
	
	function consultaDocentesAEvaluar()
	{

		$sqlDocentes = "SELECT a.idempleado as idempleado, concat(b.nombre ,' ',  b.paterno, ' ',  b.materno) as nombre, b.rfc ";
		$sqlDocentes .= "FROM siin_generales.gral_usuarios_adscripcion a, siin_generales.gral_usuarios b ";
		$sqlDocentes .= "WHERE a.idperiodo LIKE '48' "; // periodo actual?
		$sqlDocentes .= "AND a.idempleado = b.idempleado ";
		$sqlDocentes .= "AND a.idnivel IN ( 6, 7, 8, 9, 10 )";

		/* conexion a base de datos */
		$conexion = getConnection();

		/* ejecucion del query en el manejador de base datos */
		$resultSetGetDocentes = mysql_query($sqlDocentes, $conexion);			
		
		$plantillaElegirDocente = "";
		while($row = mysql_fetch_array($resultSetGetDocentes)){

			$nombre = $row['nombre'];			
			
			$plantillaElegirDocente .= "<div class='span1 seccion1-3-1'> ";
			$plantillaElegirDocente .= 		"<span class='label label-important' 'seleccion-documento'> ";
			$plantillaElegirDocente .= 			"No evaluado";
			$plantillaElegirDocente .= 		"</span> "; 
			$plantillaElegirDocente .= 		"<div class='usuario'> ";
			$plantillaElegirDocente .= 			"<a href='ventanaEvaluacion.php?rfc=".$row['rfc']."' class='usuario'> ";
			$plantillaElegirDocente .=			"</a> ";
			$plantillaElegirDocente .= 		"</div> ";
			$plantillaElegirDocente .= 		"<div class='spand1 seccion3-3 '> ";
			$plantillaElegirDocente .= 			"<a href='ventanaEvaluacion.php?rfc=".$row['rfc']."' rel='tooltip' title='".$nombre."'> ";			
			$plantillaElegirDocente .=				$nombre;
			$plantillaElegirDocente .= 			"</a> ";
			$plantillaElegirDocente .= 		"</div> ";
			$plantillaElegirDocente .= "</div> ";
		}

		// cerrando conexion a base de datos
		close($conexion);

		return $plantillaElegirDocente;
	}	
?>
	
