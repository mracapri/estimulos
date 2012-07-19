<?php
	include "../../lib/librerias.php";
	
	function asignacionEvidenciaHtml()
	{
		/* 
			hardcode
			
			NOTA: Borrar			
		*/
		$idEmpleado = "E704"; // sesion
		$idPeriodos = "44, 45, 46"; // sesion
		$anioEvaluacion = 2012 - 1; // sesion
		
		
		$sqlAsignacion = "SELECT evidencia, nombre FROM traydoc_datos_logros WHERE fecha like '%".$anioEvaluacion."%' and idempleado = '".$idEmpleado."' AND evidencia != ''";
		$sqlAsignacion.= "UNION ";
		$sqlAsignacion.= "SELECT evidencia, nombre FROM traydoc_datos_premios WHERE fecha like '%".$anioEvaluacion."%' and idempleado = '".$idEmpleado."'  AND evidencia != ''";
		$sqlAsignacion.= "UNION ";
		$sqlAsignacion.= "SELECT evidencia, '' as nombre FROM  traydoc_formacion_academica WHERE evidencia LIKE '%".$anioEvaluacion."%' AND idempleado = '".$idEmpleado."' AND evidencia != ''";
		$sqlAsignacion.= "UNION ";
		$sqlAsignacion.= "SELECT evidencia, '' as nombre FROM traydoc_portafolio WHERE idperiodo IN ( ".$idPeriodos." ) AND idempleado = '".$idEmpleado."' AND evidencia != ''";
		$sqlAsignacion.= "UNION ";
		$sqlAsignacion.= "SELECT urlTitulo, 'TITULO' as nombre FROM traydoc_formacion_profesional WHERE  idempleado = '".$idEmpleado."' AND urlTitulo != ''";
		$sqlAsignacion.= "UNION ";
		$sqlAsignacion.= "SELECT urlCedula, 'CEDULA' as nombre FROM traydoc_formacion_profesional WHERE  idempleado = '".$idEmpleado."' AND urlCedula != ''";
		$sqlAsignacion.= "UNION ";
		$sqlAsignacion.= "SELECT urlCertificado, 'CERTIFICADO' as nombre FROM traydoc_formacion_profesional WHERE  idempleado = '".$idEmpleado."' AND urlCertificado != ''";
		$sqlAsignacion.= "UNION ";
		$sqlAsignacion.= "SELECT documentoPromep, 'PROMEP' as nombre FROM  traydoc_datos_complementarios WHERE idperiodo in (".$idPeriodos.") and idempleado = '".$idEmpleado."' AND documentoPromep != '' ";
	
	
		log_($sqlAsignacion);
	
		/* conexion a base de datos */
		$conexion = getConnection();
		
		/* ejecucion del query en el manejador de base datos */
		$resultSetAsignacion = mysql_query($sqlAsignacion);
		/* plantilla html para indicadores */
		$plantillaElementoAsignacion = "";
	
		while($rowAsigna = mysql_fetch_array($resultSetAsignacion)){
			$id_empleado = $rowAsigna['idempleado'];
			
			$sql = "";
			$sql.= "SELECT ";
			$sql.=	 "evidencia as evidencia1 ";
			$sql.= "FROM ";
			$sql.=	 "traydoc_datos_logros ";
			$sql.= "WHERE";
			$sql.=	 "fecha like '%2011%' and idempleado = 'E437' ";
			$sql.= "UNION ";
			$sql.= "SELECT ";
			$sql.=	"evidencia as evidencia2 ";
			$sql.= "FROM ";
			$sql.=  "traydoc_datos_premios " ;
			$sql.= "WHERE " ;
			$sql.=  "fecha like '%2011%' and idempleado = 'E437' ";
			$sql.= "UNION ";
			$sql.= "SELECT ";
			$sql.= 	 "evidencia as evidencia3 ";
			$sql.= "FROM ";
			$sql.= 	"traydoc_formacion_academica ";
			$sql.= "WHERE ";
			$sql.= 	" evidencia LIKE '%2011%' AND idempleado = 'E437' ";
			$sql.= "UNION ";
			$sql.= "SELECT ";
			$sql.= 	"evidencia as evidencia4 ";
			$sql.= "FROM ";
			$sql.= 	"traydoc_portafolio ";
			$sql.= "WHERE ";
			$sql.= 	"idperiodo IN ( 44, 45, 46 ) AND idempleado = 'E437' ";
			$sql.= "UNION ";
			$sql.= "SELECT ";
			$sql.= 	"urlTitulo as evidencia5 ";
			$sql.= "FROM ";
			$sql.= 	"traydoc_formacion_profesional ";
			$sql.= "WHERE ";
			$sql.= 	"idempleado = 'E437' ";
			$sql.= "UNION ";
			$sql.= "SELECT ";
			$sql.= 	"urlCedula as evidencia6 ";
			$sql.= "FROM ";
			$sql.= 	"traydoc_formacion_profesional ";
			$sql.= "WHERE ";
			$sql.= 	"idempleado = 'E437' ";
			$sql.= "UNION ";
			$sql.= "SELECT ";
			$sql.= 	"urlCertificado as evidencia7 ";
			$sql.= "FROM ";
			$sql.= 	"traydoc_formacion_profesional ";
			$sql.= "WHERE ";
			$sql.= 	"idempleado = 'E437' ";
			$sql.= "UNION ";
			$sql.= "SELECT ";
			$sql.= 	"documentoPromep as evidencia8 ";
			$sql.= "FROM ";
			$sql.= 	"traydoc_datos_complementarios ";
			$sql.= "WHERE ";
			$sql.= "idperiodo between '44' and '46' and idempleado = 'E437' ";
		
		$resultSet = mysql_query($sql);		
			
			/* barre consulta para generar html */
			log_($indicadorHtml);
			$contador = 1;
			while($row = mysql_fetch_array($resultSet)){			
				$plantillaElementoAsignacion .="<div class='span1 seccion1-3'>";
				$plantillaElementoAsignacion .=		"<span class='seleccion-documento'>";
				$plantillaElementoAsignacion .= 		"<input type='checkbox'/>";
				$plantillaElementoAsignacion .= 	"</span>";
				$plantillaElementoAsignacion .= 	"<div class='pdf2'>";
				$plantillaElementoAsignacion .= 		"<a href='#' class='pdf'></a>";
				$plantillaElementoAsignacion .= 	"</div>";
				$plantillaElementoAsignacion .= 	"<div class='span2 seccion3-2'>";
				$plantillaElementoAsignacion .=			"<a href='#' rel='tooltip' title='first tooltip'>";
				if($contador == 1){
					$plantillaElementoAsignacion .=				$row['evidencia1'];	
				}
				$plantillaElementoAsignacion .=			"</a>";
				$plantillaElementoAsignacion .=		"</div>";
				$plantillaElementoAsignacion .= "</div>";

				$contador++;
				
			}	
			
			$plantillaElementoAsignacion = str_replace($plantillaElementoAsignacion);
		}
		// cerrando conexion a base de datos
		close($conexion);
		
		return $plantillaElementoAsignacion;
	
	}


?>
