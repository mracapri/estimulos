<?php
	require_once("../../lib/librerias.php");
	
	function presentaCalificacion($idCategoriaindicador){

		$elementoHtmlCalificacion = "";

		/* conexion a base de datos */
		$conexion = getConnection();
		
		$sql = "select id_porcentajeindicador, porcentaje, descripcion from porcentaje_indicador where id_categoriaindicador = ".$idCategoriaindicador;

		/* ejecucion del query en el manejador de base datos */
		$resultSetCalificacion = mysql_query($sql);
		echo mysql_error();

		if(mysql_num_rows($resultSetCalificacion) > 1){
			$elementoHtmlCalificacion = "<select id='input-calificacion' name='input-calificacion'>";
			while($row = mysql_fetch_array($resultSetCalificacion)){
				$elementoHtmlCalificacion .= "<option value='".$row['porcentaje']."' data-id-porcentajeindicador='".$row['id_porcentajeindicador']."'>";
				$elementoHtmlCalificacion .= 	$row['porcentaje']."  -- ".$row['descripcion'];
				$elementoHtmlCalificacion .= "</option>";
			}
			$elementoHtmlCalificacion .= "</select>";
		}else{
			$row = mysql_fetch_array($resultSetCalificacion);
			$elementoHtmlCalificacion = "<input class='span4' type='text' placeholder='Calificación' id='input-calificacion' name='input-calificacion' value='".$row['porcentaje']."' title='".$row['porcentaje']."' data-id-porcentajeindicador='".$row['id_porcentajeindicador']."'/>";
		}

		// cerrando conexion a base de datos
		close($conexion);

		return $elementoHtmlCalificacion;
	}
?>