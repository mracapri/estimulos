<?php
	require_once("../../lib/librerias.php");

	function guardaCalificacion($jsonEvaluacion, $categoriaIndicador){
		$resultado = json_decode(stripslashes($jsonEvaluacion));		
		if(!empty($resultado)){
			$idPorcentajeIndicador = $resultado->{'idPorcentajeindicador'};
			$calificacion = $resultado->{'calificacion'};
			$comentario = $resultado->{'comentario'};
			$estado = $resultado->{'false'};
			$rfcEvaluador = $_SESSION['rfcEvaluador'];
			$rfcDocente = $_SESSION['rfcDocente'];
			$anioEvaluacion = $_SESSION['anioEvaluacion'];

			/* conexion a base de datos */
			$conexion = getConnection();

			$sqlGetRegistroCalificado = "select * from evaluacion_indicador where id_categoriaindicador = ".$categoriaIndicador ;

			/* ejecucion del query en el manejador de base datos */
			$resultSetGetFolio = mysql_query($sqlGetRegistroCalificado, $conexion);

			if(mysql_num_rows($resultSetGetFolio) > 0){
				$rowRegistroCalificado = mysql_fetch_array($resultSetGetFolio);
				$sqlUpdateRegistro = "UPDATE evaluacion_indicador set cal_porcentaje = ".$calificacion." and estado = ".$estado." and motivo = '".$comentario."' ";
				$sqlUpdateRegistro = "where RFC_evaluador = '".$rfcEvaluador."' and RFC_docente = '".$rfcDocente."' and anio = ".$anioEvaluacion;
			}else{
				$sqlGetFolio = "select COALESCE(max(id_evaluacionindicador),0)+1 as folio from evaluacion_indicador";

				/* ejecucion del query en el manejador de base datos */
				$resultSetGetFolio = mysql_query($sqlGetFolio, $conexion);			

				if(mysql_num_rows($resultSetGetFolio) > 0	){
					$row = mysql_fetch_array($resultSetGetFolio);
					$folioNuevo = $row['folio'];
					
					$sqlInsertEvaluacion = "";
					$sqlInsertEvaluacion .= "insert into evaluacion_indicador ";
					$sqlInsertEvaluacion .= "(id_evaluacionindicador, id_categoriaindicador, RFC_docente, id_porcentajeindicador, cal_porcentaje, RFC_evaluador, estado, motivo, anio) ";
					$sqlInsertEvaluacion .= "values ";
					$sqlInsertEvaluacion .= "(";
					$sqlInsertEvaluacion .= 	$folioNuevo.", ";
					$sqlInsertEvaluacion .= 	$categoriaIndicador.", ";
					$sqlInsertEvaluacion .= 	"'".$rfcDocente."', ";				
					$sqlInsertEvaluacion .= 	$idPorcentajeIndicador.", ";
					$sqlInsertEvaluacion .= 	$calificacion.", ";
					$sqlInsertEvaluacion .= 	"'".$rfcEvaluador."', ";
					$sqlInsertEvaluacion .= 	"1 , ";
					$sqlInsertEvaluacion .= 	"'".$comentario."', ";
					$sqlInsertEvaluacion .= 	$anioEvaluacion;					
					$sqlInsertEvaluacion .= ") ";
					
					mysql_query($sqlInsertEvaluacion);

				}
			}



			// cerrando conexion a base de datos
			close($conexion);
		}
	}
	
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