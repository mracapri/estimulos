<?php

	include "../../lib/librerias.php";
	function consultaDetalleIndicador($idIndicador){
		//echo "este valor:".$idIndicador;
		$sqlConsultas = "";
		$sqlConsultas.= "SELECT ";
		$sqlConsultas.= 		"c.id_categoria, "; 
		$sqlConsultas.= 		"c.descripcion, ";
		$sqlConsultas.= 		"i.id_indicador, ";
		$sqlConsultas.= 		"i.descripcion, ";
		$sqlConsultas.= 		"pi.porcentaje ";
		$sqlConsultas.= "FROM ";
		$sqlConsultas.= 		"categoria As c, indicador As i, categoria_indicador As ci, porcentaje_indicador As pi ";
		$sqlConsultas.= "WHERE ";
		$sqlConsultas.=		"c.id_categoria = ci.id_categoria and ";
		$sqlConsultas.=		"ci.id_indicador = ".$idIndicador." and ";
		$sqlConsultas.=		"i.id_indicador = ci.id_indicador and ";
		$sqlConsultas.=		"pi.id_categoriaindicador = ci.id_categoriaindicador ";	
	
		log_($sqlConsultas);
		/* conexion a base de datos */
		$conexion = getConnection();
		
		/* ejecucion del query en el manejador de base datos */
		
		$resultSetConsulta = mysql_query($sqlConsultas);
		$rowIndicador = mysql_fetch_array($resultSetConsulta);
		//echo $rowIndicador;		
		
		if(count($rowIndicador) > 0){
			
			return $rowIndicador;
		}
		

	}
?>