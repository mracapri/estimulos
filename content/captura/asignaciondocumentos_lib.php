<?php

	require_once("../../lib/librerias.php");

	function guardarAsignacion($jsonAsignacion){
	if(!verificarSesionDelUsuario()){ return; }; //IMPORTANTE: verifica la sesion del usuario

		/* Eliminando diagonales y decodificando el JSON */
		$resultado = json_decode(stripslashes($jsonAsignacion));

		$idEmpleado = $_SESSION['idEmpleado'];

		/* itera asignaciones */
		for ($iteraAsignacion=0; $iteraAsignacion < count($resultado); $iteraAsignacion++) { 
			$nombreEvidencia = $resultado[$iteraAsignacion]->{'nombre'};

		}
	}
	
	function consultaArchivosHtml(){
	if(!verificarSesionDelUsuario()){ return; }; //IMPORTANTE: verifica la sesion del usuario	
		/* datos desde la sesion */
		$idEmpleado = $_SESSION['idEmpleado'];
		$idPeriodos = $_SESSION['idPeriodos'];
		$anioEvaluacion = $_SESSION['anioEvaluacion'];
		
		/* sql para obtener las evidencias del usuario */ 
		$sqlArchivos = "SELECT evidencia, nombre FROM siin_trayectorias_docentes.traydoc_datos_logros WHERE fecha like '%".$anioEvaluacion."%' and idempleado = '".$idEmpleado."' AND evidencia != ''";
		$sqlArchivos.= "UNION ";
		$sqlArchivos.= "SELECT evidencia, nombre FROM siin_trayectorias_docentes.traydoc_datos_premios WHERE fecha like '%".$anioEvaluacion."%' and idempleado = '".$idEmpleado."'  AND evidencia != ''";
		$sqlArchivos.= "UNION ";
		$sqlArchivos.= "SELECT evidencia, '' as nombre FROM  siin_trayectorias_docentes.traydoc_formacion_academica WHERE evidencia LIKE '%".$anioEvaluacion."%' AND idempleado = '".$idEmpleado."' AND evidencia != ''";
		$sqlArchivos.= "UNION ";
		$sqlArchivos.= "SELECT evidencia, '' as nombre FROM siin_trayectorias_docentes.traydoc_portafolio WHERE idperiodo IN ( ".$idPeriodos." ) AND idempleado = '".$idEmpleado."' AND evidencia != ''";
		$sqlArchivos.= "UNION ";
		$sqlArchivos.= "SELECT urlTitulo, 'TITULO' as nombre FROM siin_trayectorias_docentes.traydoc_formacion_profesional WHERE  idempleado = '".$idEmpleado."' AND urlTitulo != ''";
		$sqlArchivos.= "UNION ";
		$sqlArchivos.= "SELECT urlCedula, 'CEDULA' as nombre FROM siin_trayectorias_docentes.traydoc_formacion_profesional WHERE  idempleado = '".$idEmpleado."' AND urlCedula != ''";
		$sqlArchivos.= "UNION ";
		$sqlArchivos.= "SELECT urlCertificado, 'CERTIFICADO' as nombre FROM siin_trayectorias_docentes.traydoc_formacion_profesional WHERE  idempleado = '".$idEmpleado."' AND urlCertificado != ''";
		$sqlArchivos.= "UNION ";
		$sqlArchivos.= "SELECT documentoPromep, 'PROMEP' as nombre FROM  siin_trayectorias_docentes.traydoc_datos_complementarios WHERE idperiodo in (".$idPeriodos.") and idempleado = '".$idEmpleado."' AND documentoPromep != '' ";
	
		/* conexion a base de datos */
		$conexion = getConnection();
		
		/* ejecucion del query en el manejador de base datos */
		$resultSetAsignacion = mysql_query($sqlArchivos);
		echo mysql_error();
		
		/* barre consulta para generar html */
		while($row = mysql_fetch_array($resultSetAsignacion)){
			$plantillaElementoAsignacion .="<div class='span1 seccion1-3'>";
			$plantillaElementoAsignacion .=		"<span class='seleccion-documento'>";
			$plantillaElementoAsignacion .= 		"<input type='checkbox' data-nombre-archivo='".$row[0]."' />";
			$plantillaElementoAsignacion .= 	"</span>";
			$plantillaElementoAsignacion .= 	"<div class='pdf2'>";
			$plantillaElementoAsignacion .= 		"<a target='_blank' href='http://10.100.96.7/siin/trayectoriasProfesionales/uploads/7/".$row[0]."' class='pdf'>";
			//$plantillaElementoAsignacion .=				$row[1];
			$plantillaElementoAsignacion .= 		"</a>";
			$plantillaElementoAsignacion .= 	"</div>";
			$plantillaElementoAsignacion .= 	"<div class='span2 seccion3-2'>";
			$plantillaElementoAsignacion .=			"<a href='#' rel='tooltip' title='".$row[1]."'>";
			$nombreEvidencia = $row[1];
			if(strlen($row[1]) > 10){
				$plantillaElementoAsignacion .=	substr($nombreEvidencia, 0, 10)."...";
			}else{
				$plantillaElementoAsignacion .=	$nombreEvidencia;
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
?>