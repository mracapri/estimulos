<?php
	require_once("../../lib/librerias.php");

	function obtieneRegistroEvaluado($categoriaIndicador){

		$rfcEvaluador = $_SESSION['rfcEvaluador'];
		$rfcDocente = $_SESSION['rfcDocente'];
		$anioEvaluacion = $_SESSION['anioEvaluacion'];

		/* conexion a base de datos */
		$conexion = getConnection();

		$sqlGetRegistroCalificado = "select * from evaluacion_indicador where id_categoriaindicador = ".$categoriaIndicador." and rfc_evaluador = '".$rfcEvaluador."' " ;
		$sqlGetRegistroCalificado .= "and rfc_docente = '".$rfcDocente."' and anio = ".$anioEvaluacion ;

		/* ejecucion del query en el manejador de base datos */
		$resultSetGetRegistro = mysql_query($sqlGetRegistroCalificado, $conexion);
		if(mysql_num_rows($resultSetGetRegistro) > 0){
			$row = mysql_fetch_array($resultSetGetRegistro);
		}

		// cerrando conexion a base de datos
		close($conexion);

		return $row;
	}

	function guardaCalificacion($jsonEvaluacion, $categoriaIndicador){
		$resultado = json_decode(stripslashes($jsonEvaluacion));		
		if(!empty($resultado)){
			$idPorcentajeIndicador = $resultado->{'idPorcentajeindicador'};
			$calificacion = $resultado->{'calificacion'};
			$comentario = $resultado->{'comentario'};
			$estado = $resultado->{'estado'};
			$rfcEvaluador = $_SESSION['rfcEvaluador'];
			$rfcDocente = $_SESSION['rfcDocente'];
			$anioEvaluacion = $_SESSION['anioEvaluacion'];

			if ($estado == 'true' ) {
				$calificacion = 0;
			}

			/* ejecucion del query en el manejador de base datos */
			$registro = obtieneRegistroEvaluado($categoriaIndicador);


			/* conexion a base de datos */
			$conexion = getConnection();

			if(!empty($registro)){
				$sqlUpdateRegistro .= "UPDATE evaluacion_indicador set cal_porcentaje = ".$calificacion.", estado = ".$estado.", motivo = '".$comentario."' ";
				$sqlUpdateRegistro .= "where RFC_evaluador = '".$rfcEvaluador."' and RFC_docente = '".$rfcDocente."' and anio = ".$anioEvaluacion." and id_categoriaindicador = ".$categoriaIndicador;
				mysql_query($sqlUpdateRegistro);
			}else{
				$sqlGetFolio = "select COALESCE(max(id_evaluacionindicador),0)+1 as folio from evaluacion_indicador";

				/* ejecucion del query en el manejador de base datos */
				$resultSetGetFolio = mysql_query($sqlGetFolio, $conexion);

				if(mysql_num_rows($resultSetGetFolio) > 0){
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
					$sqlInsertEvaluacion .= 	"'".$estado."',";
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
	
	function presentaCalificacion($idCategoriaindicador, $registro){

		$elementoHtmlCalificacion = "";

		/* conexion a base de datos */
		$conexion = getConnection();
		
		$sql = "select id_porcentajeindicador, porcentaje, descripcion from porcentaje_indicador where id_categoriaindicador = ".$idCategoriaindicador;

		/* ejecucion del query en el manejador de base datos */
		$resultSetCalificacion = mysql_query($sql);
		echo mysql_error();

		if(mysql_num_rows($resultSetCalificacion) > 1){

			/*TODO: Presentar calificacion seleccionada por el usuario*/

			$elementoHtmlCalificacion = "<select id='input-calificacion' name='input-calificacion'>";
			while($row = mysql_fetch_array($resultSetCalificacion)){
				if(!empty($registro) && $registro[4] == $row['porcentaje']){
					$valorSeleccionado = $registro[4];

					$elementoHtmlCalificacion .= "<option value='".$row['porcentaje']."' data-id-porcentajeindicador='".$row['id_porcentajeindicador']."' selected='selected'>";
					$elementoHtmlCalificacion .= 	$row['porcentaje']."  -- ".$row['descripcion'];
					$elementoHtmlCalificacion .= "</option>";

				}else{
					$elementoHtmlCalificacion .= "<option value='".$row['porcentaje']."' data-id-porcentajeindicador='".$row['id_porcentajeindicador']."'>";
					$elementoHtmlCalificacion .= 	$row['porcentaje']."  -- ".$row['descripcion'];
					$elementoHtmlCalificacion .= "</option>";					
				}
			}
			$elementoHtmlCalificacion .= "</select>";
		}else{
			$row = mysql_fetch_array($resultSetCalificacion);
			$elementoHtmlCalificacion = "<input class='span4' type='text' placeholder='Calificaci&oacute;n' id='input-calificacion' name='input-calificacion' value='".$row['porcentaje']."' title='".$row['porcentaje']."' data-id-porcentajeindicador='".$row['id_porcentajeindicador']."'/>";
		}

		// cerrando conexion a base de datos
		close($conexion);

		return $elementoHtmlCalificacion;
	}
	function obtenerNombreUsuario($rfcDocente)
	{
		// abriendo conexion a base de datos del siin
		$conection = getConnection();
		
		$rfcDocente = $_SESSION['rfcDocente'];
		$idPeriodos = $_SESSION['idPeriodos'];
		$anioEvaluacion = $_SESSION['anioEvaluacion'];	
		
		// obteniendo el perfil del usuario
		
		$sqlPerfilUsuario = "";
		$sqlPerfilUsuario .= "SELECT ";
		$sqlPerfilUsuario .= 	"concat(a.profesion,' ',a.nombre,' ',a.paterno,' ',a.materno)as nombreEmpleado ";
		$sqlPerfilUsuario .= "FROM ";
		$sqlPerfilUsuario .= 	"siin_generales.gral_usuarios a, ";
		$sqlPerfilUsuario .= 	"siin_generales.gral_usuarios_adscripcion b, ";
		$sqlPerfilUsuario .= 	"siin_generales.gral_adscripcion c, siin_generales.gral_periodos d ";
		$sqlPerfilUsuario .= "WHERE ";
		$sqlPerfilUsuario .= 	"a.rfc = '".$rfcDocente."' and ";
		$sqlPerfilUsuario .= 	"b.idempleado = a.idempleado and ";
		$sqlPerfilUsuario .= 	"d.actual = 1 and ";
		$sqlPerfilUsuario .= 	"b.idperiodo = d.idperiodo and ";
		$sqlPerfilUsuario .= 	"c.idadscripcion = b.idadscripcion";
		
		$resultSet = mysql_query($sqlPerfilUsuario);	
		$resultSetPerfilUsuario = mysql_query($sqlPerfilUsuario, $conection);
		$row = mysql_fetch_array($resultSetPerfilUsuario);		

		if(mysql_num_rows($resultSetPerfilUsuario) > 0){

			return $row['nombreEmpleado'];
			
		}

		// cerrando conexion a base de datos
		close($conection);
	}
	
?>