<?php

	require_once("../../lib/librerias.php");
	require_once("indicadores_lib.php");

	function guardarAsignacion($jsonAsignacion, $categoriaIndicador){
		if(!verificarSesionDelUsuario()){ return; }; //IMPORTANTE: verifica la sesion del usuario
		if(obtenerEstadoDeLaCaptura() == 0){
			// variables de sesion
			$idEmpleado = $_SESSION['idEmpleado'];
			$rfcDocente = $_SESSION['rfcDocente'];

			/* Eliminando diagonales y decodificando el JSON */
			$resultado = json_decode(stripslashes($jsonAsignacion));
			
			/* conexion a base de datos */
			$conexion = getConnection();


			/* elimina asignaciones para agregar las nuevas */
			$sqlDelete = "delete from asignacion_indicador where rfc_docente = '".$rfcDocente."' and id_categoriaindicador = ".$categoriaIndicador;
			mysql_query($sqlDelete,$conexion);


			/* itera asignaciones */
			for ($iteraAsignacion=0; $iteraAsignacion < count($resultado); $iteraAsignacion++) { 
				$nombreEvidencia = $resultado[$iteraAsignacion]->{'nombre'};


				$sqlGetLlave = "SELECT coalesce(MAX(id_asignacionindicador),0)+1 as llave from asignacion_indicador";
				
				/* ejecucion del query en el manejador de base datos */
				$resultGetLlave = mysql_query($sqlGetLlave);

				/* obteniendo llave */
				$idLlave = 0;
				$row = mysql_fetch_array($resultGetLlave);
				if(count($row) > 0){
					$idLlave = $row['llave'];
				}


				$sqlInsert = "";
				$sqlInsert .= "INSERT INTO ";
				$sqlInsert .=		"asignacion_indicador (id_asignacionindicador, id_categoriaindicador, RFC_docente, fecha, anio, doc_evidencia) ";
				$sqlInsert .= "VALUES ";
				$sqlInsert .=	"(";
				$sqlInsert .=		"".$idLlave.", ";
				$sqlInsert .=		"".$categoriaIndicador.", ";
				$sqlInsert .=		"'".$_SESSION['rfcDocente']."', ";
				$sqlInsert .=		"now(), ";
				$sqlInsert .=		"".$_SESSION['anioEvaluacion'].", ";
				$sqlInsert .=		"'".$nombreEvidencia."'";
				$sqlInsert .=	")";

				// ejecutano insert sql
				if (!mysql_query($sqlInsert,$conexion)){
					$errorCode = mysql_errno();
					if(!empty($errorCode)){
						if($errorCode == 1062){ // registro duplicado
							// mandar un error a la vista en html
							$resultado = "Ya existe una evulacion con el mismo anio";
						}
					}
				}

			}
			
			// cerrando conexion a base de datos
			close($conexion);
		}

	}
	
	function consultaArchivosHtml(){
		if(!verificarSesionDelUsuario()){ return; }; //IMPORTANTE: verifica la sesion del usuario	

		/* datos desde la sesion */
		$idEmpleado = $_SESSION['idEmpleado'];
		$idPeriodos = $_SESSION['idPeriodos'];
		$anioEvaluacion = $_SESSION['anioEvaluacion'];
		
		/* sql para obtener las evidencias del usuario */ 
		/*-------------------------------Query trae las evidencias del portafolio-------------------------------------*/
		$sqlArchivos = "";
		$sqlArchivos.= "SELECT a.evidencia, a.competencia, a.idempleado, b.nombre ";
		$sqlArchivos.= "FROM siin_trayectorias_docentes.traydoc_portafolio a, siin_trayectorias_docentes.traydoc_portafolio_leyendas b ";
		$sqlArchivos.= "WHERE a.idperiodo IN ( ".$idPeriodos." ) AND a.idempleado = '".$idEmpleado."' AND a.competencia = b.id ";
		
		$sqlArchivos.= "UNION ";
		/*--------------------------Query trae los formatos de la tabla estimulos_preda------------------------------*/
		$sqlArchivos.= "SELECT evidencia, '', idempleado, nombre ";
		$sqlArchivos.= "FROM siin_trayectorias_docentes.traydoc_estimulos_preda ";
		$sqlArchivos.= "WHERE anyo = '".($anioEvaluacion-1)."' AND idempleado = '".$idEmpleado."' and tipo = 'preda' ";
		
		$sqlArchivos.= "UNION ";
		/*-------------------------------Query trae evidencias de la tabla estimulos_preda -------------------------------------*/
		$sqlArchivos.= "SELECT evidencia, '', idempleado, nombre ";
		$sqlArchivos.= "FROM siin_trayectorias_docentes.traydoc_estimulos_preda ";
		$sqlArchivos.= "WHERE anyo = '".($anioEvaluacion-1)."' AND idempleado = '".$idEmpleado."' and tipo = 'estimulo'";

		$sqlArchivos.= "UNION ";
		/*-------------------------------Query trae evidencias de Formación Profecional-------------------------------------*/
		
		$sqlArchivos.= "SELECT urlTitulo, 'TITULO' as nombre, '', 'TITULO' FROM siin_trayectorias_docentes.traydoc_formacion_profesional WHERE  idempleado = '".$idEmpleado."' AND urlTitulo != '' ";
		$sqlArchivos.= "UNION ";
		$sqlArchivos.= "SELECT urlCedula, 'CEDULA' as nombre, '',  'CEDULA' FROM siin_trayectorias_docentes.traydoc_formacion_profesional WHERE  idempleado = '".$idEmpleado."' AND urlCedula != '' ";
		$sqlArchivos.= "UNION ";
		$sqlArchivos.= "SELECT urlCertificado, 'CERTIFICADO' as nombre, '', 'CERTIFICADO' FROM siin_trayectorias_docentes.traydoc_formacion_profesional WHERE  idempleado = '".$idEmpleado."' AND urlCertificado != '' ";
		$sqlArchivos.= "UNION ";
		$sqlArchivos.= "SELECT documentoPromep, 'PROMEP' as nombre, '', 'DOCUMENTO PROMEP' FROM  siin_trayectorias_docentes.traydoc_datos_complementarios WHERE idperiodo in (".$idPeriodos.") and idempleado = '".$idEmpleado."' AND documentoPromep != '' ";
		
		$sqlArchivos.= "UNION ";
		/*-------------------------------Query trae evidencias de Logros-------------------------------------*/
		$sqlArchivos.= "SELECT evidencia, 'LOGROS', '',nombre FROM siin_trayectorias_docentes.traydoc_datos_logros WHERE fecha like '".($anioEvaluacion-1)."%' and idempleado = '".$idEmpleado."' AND evidencia != '' ";
		
		$sqlArchivos.= "UNION ";
		/*-------------------------------Query trae evidencias de Premios-------------------------------------*/
		
		$sqlArchivos.= "SELECT evidencia, 'PREMIO', '',nombre FROM siin_trayectorias_docentes.traydoc_datos_premios WHERE fecha like '".($anioEvaluacion-1)."%' and idempleado = '".$idEmpleado."'  AND evidencia != '' ";
	
		$sqlArchivos.= "UNION ";
		/*--------------------------Query trae evidencias de Formacion Academica---------------------------------*/

		$sqlArchivos.= "SELECT evidencia, 'FORMACION ACADEMICA' ,'' ,tituloArticulo FROM  siin_trayectorias_docentes.traydoc_formacion_academica WHERE fechaPublicacionArticulo LIKE '%".($anioEvaluacion-1)."%' AND idempleado = '".$idEmpleado."' AND evidencia != '' ";
		$sqlArchivos.= "UNION ";
		$sqlArchivos.= "SELECT evidencia, 'FORMACION ACADEMICA' , '', tituloArticulo FROM  siin_trayectorias_docentes.traydoc_formacion_academica WHERE fechaInicioAsesoria	 LIKE '%".($anioEvaluacion-1)."%' AND idempleado = '".$idEmpleado."' AND evidencia != '' ";
		
		//echo $sqlArchivos;
		/* conexion a base de datos */
		$conexion = getConnection();
		

		/* ejecucion del query en el manejador de base datos */
		$resultSetAsignacion = mysql_query($sqlArchivos);
		
		$idEmpleado = $_SESSION['idEmpleadoAEvaluar'];

		if(empty($idEmpleado)){
			$idEmpleado = $_SESSION['idEmpleado'];
		}

		$idAdscripcion = $_SESSION['idEmpleadoAEvaluarAdscripcion'];
		if(empty($idAdscripcion)){
			$idAdscripcion = $_SESSION['idAdscripcion'];
		}

		/* barre consulta para generar html */
		while($row = mysql_fetch_array($resultSetAsignacion)){
			$plantillaElementoAsignacion .="<div class='span1 seccion1-3'>";
			$plantillaElementoAsignacion .=		"<span class='seleccion-documento'>";
			$plantillaElementoAsignacion .= 		"<input type='checkbox' data-nombre-archivo='".$row[0]."' />";
			$plantillaElementoAsignacion .= 	"</span>";
			$plantillaElementoAsignacion .= 	"<div class='pdf2'>";
			$plantillaElementoAsignacion .= 		"<a target='_blank' href='http://10.100.96.7/siin/trayectoriasProfesionales/uploads/".$idAdscripcion."/".$row[0]."' class='pdf'>";
			$plantillaElementoAsignacion .= 		"</a>";
			$plantillaElementoAsignacion .= 	"</div>";
			$plantillaElementoAsignacion .= 	"<div class='span1 seccion3-2'>";
			$plantillaElementoAsignacion .=			"<a href='#' rel='tooltip' title='".$row[3]."'>";
			$nombreEvidencia = $row[3];
			if(strlen($row[3]) > 20){
				$plantillaElementoAsignacion .=	substr($nombreEvidencia, 0, 20)."...";
			}else{
				$plantillaElementoAsignacion .=	$nombreEvidencia;
			}
			$plantillaElementoAsignacion .=			"</a>";
			$plantillaElementoAsignacion .=		"</div>";
			$plantillaElementoAsignacion .= "</div>";
		}

		/* Resultado de las evaluaciones */
		$periodos = preg_split("/[\s,]+/", $idPeriodos);
		for($iteraPeriodo = 0; $iteraPeriodo < count($periodos); $iteraPeriodo++){
			$plantillaElementoAsignacion .="<div class='span1 seccion1-3'>";
			$plantillaElementoAsignacion .=		"<span class='seleccion-documento'>";
			$plantillaElementoAsignacion .= 		"<input type='checkbox' data-nombre-archivo='EBC-FILE-".$periodos[$iteraPeriodo]."-".obtieneNombrePeriodo($periodos[$iteraPeriodo])."' />";
			$plantillaElementoAsignacion .= 	"</span>";
			$plantillaElementoAsignacion .= 	"<div class='pdf2'>";
			$plantillaElementoAsignacion .= 		"<a target='_blank' href='http://10.100.96.7/sea-ebc/reportes/concentradoDocentes.php?carrera=".$idAdscripcion."&idprofesor=".$idEmpleado."&idperiodo=".$periodos[$iteraPeriodo]."' class='pdf'>";
			$plantillaElementoAsignacion .= 		"</a>";
			$plantillaElementoAsignacion .= 	"</div>";
			$plantillaElementoAsignacion .= 	"<div class='span1 seccion3-2'>";
			$plantillaElementoAsignacion .=			"<a href='#' rel='tooltip' title='Evaluacion EBC'>";
			$plantillaElementoAsignacion .=				"Evaluacion EBC ".obtieneNombrePeriodo($periodos[$iteraPeriodo]) ;
			$plantillaElementoAsignacion .=			"</a>";
			$plantillaElementoAsignacion .=		"</div>";
			$plantillaElementoAsignacion .= "</div>";
		}

		// cerrando conexion a base de datos
		close($conexion);
		
		// retorna el resultado
		return $plantillaElementoAsignacion;
	}

	function obtieneNombrePeriodo($idPeriodo){
		$nombrePeriodo = "";

		$sql = "select periodo from siin_generales.gral_periodos  where idperiodo = ".$idPeriodo;
		/* conexion a base de datos */
		$conexion = getConnection();
		

		/* ejecucion del query en el manejador de base datos */
		$resultSet = mysql_query($sql);
		echo mysql_error();

		if(mysql_num_rows($resultSet)){
			$row = mysql_fetch_array($resultSet);
			$nombrePeriodo = $row[0];
		}
		return $nombrePeriodo;
	}
	
	function consultaDetalleIndicador($idIndicador){
		if(!verificarSesionDelUsuario()){ return; }; //IMPORTANTE: verifica la sesion del usuario	

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
		
		if(count($rowIndicador) > 0){
			
			return $rowIndicador;
		}
	}


	function consultaArchivosAsignadosHtml($idCategoriaIndicador){
		if(!verificarSesionDelUsuario()){ return; }; //IMPORTANTE: verifica la sesion del usuario	

		/* datos desde la sesion */
		$rfcDocente = $_SESSION['rfcDocente'];
		$idPeriodos = $_SESSION['idPeriodos'];
		$anioEvaluacion = $_SESSION['anioEvaluacion'];
		
		/* sql para obtener las evidencias del usuario */ 
		$sqlArchivos = "";
		$sqlArchivos .= "select doc_evidencia, ";
		$sqlArchivos .= "(select coalesce((select nombre FROM siin_trayectorias_docentes.traydoc_portafolio_leyendas where id = competencia), 'SIN CLASIFICACION') from siin_trayectorias_docentes.traydoc_portafolio tp where tp.evidencia = doc_evidencia) as nombre ";
		$sqlArchivos .= "from asignacion_indicador ";
		$sqlArchivos .= "where id_categoriaindicador = ".$idCategoriaIndicador." and rfc_docente = '".$rfcDocente."'";

		/* conexion a base de datos */
		$conexion = getConnection();
		
		/* ejecucion del query en el manejador de base datos */
		$resultSetAsignados = mysql_query($sqlArchivos);
		


		$idEmpleado = $_SESSION['idEmpleadoAEvaluar'];

		if(empty($idEmpleado)){
			$idEmpleado = $_SESSION['idEmpleado'];
		}

		$idAdscripcion = $_SESSION['idEmpleadoAEvaluarAdscripcion'];
		if(empty($idAdscripcion)){
			$idAdscripcion = $_SESSION['idAdscripcion'];
		}


		/* barre consulta para generar html */
		while($row = mysql_fetch_array($resultSetAsignados)){
			$plantillaElementoAsignacion .="<div class='span1 seccion1-3'>";
			$plantillaElementoAsignacion .=		"<span class='seleccion-documento'>";
			$plantillaElementoAsignacion .= 		"<input type='checkbox' data-nombre-archivo='".$row[0]."' />";
			$plantillaElementoAsignacion .= 	"</span>";
			$plantillaElementoAsignacion .= 	"<div class='pdf2'>";
			if(substr_count($row['doc_evidencia'],"EBC-FILE") > 0){
				$valores = preg_split("/[\-,]+/", $row['doc_evidencia']);

				$plantillaElementoAsignacion .= 	"<a target='_blank' href='http://10.100.96.7/sea-ebc/reportes/concentradoDocentes.php?carrera=".$idAdscripcion."&idprofesor=".$idEmpleado."&idperiodo=".$valores[2]."' class='pdf'>";
			}else{
				$plantillaElementoAsignacion .= 	"<a target='_blank' href='http://10.100.96.7/siin/trayectoriasProfesionales/uploads/".$idAdscripcion."/".$row[0]."' class='pdf'>";
			}
			$plantillaElementoAsignacion .= 		"</a>";
			$plantillaElementoAsignacion .= 	"</div>";
			$plantillaElementoAsignacion .= 	"<div class='span1 seccion3-2'>";
			$plantillaElementoAsignacion .=			"<a href='#' rel='tooltip' title=''>";
			if(!empty($row['nombre'])){
				$nombre = $row['nombre'];	
				if(strlen($nombre) > 20){
					$plantillaElementoAsignacion .=	substr($nombre, 0, 20)."...";
				}else{
					$plantillaElementoAsignacion .=	$nombre;
				}
			}else{	
				$nombre = $row['doc_evidencia'];
				if(strlen($nombre) > 20){
					$plantillaElementoAsignacion .=	substr($nombre, 0, 20)."...";
				}else{
					$plantillaElementoAsignacion .=	$nombre;
				}
			}
			$plantillaElementoAsignacion .=			"</a>";
			$plantillaElementoAsignacion .=		"</div>";
			$plantillaElementoAsignacion .= "</div>";
		}	
		// cerrando conexion a base de datos
		close($conexion);
		
		// retorna el resultado
		return $plantillaElementoAsignacion;
	}	
?>