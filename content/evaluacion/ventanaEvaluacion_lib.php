<?php
	require_once("../../lib/librerias.php");
	require_once("elegirDocenteAEvaluar_lib.php");

	function terminarEvaluacion($rfcDocente, $comentarioFinal){
		/* conexion a base de datos */
		$conexion = getConnection();		

		$sql = "UPDATE participantes SET estado = '2' WHERE rfc = '".$rfcDocente."'";
		mysql_query($sql);

		$sqlFolioComentarios = "select COALESCE(max(idcomentario),0)+1 as folio from comentarios";
		$resultSetFolioComentarios = mysql_query($sqlFolioComentarios);
		if(mysql_num_rows($resultSetFolioComentarios) > 0){
			$row = mysql_fetch_array($resultSetFolioComentarios);
			$folio = $row['folio'];
		}

		$sqlInsertaComentarios = "insert into comentarios (idcomentario, rfcDocente, rfcEvaluador, comentario, anio) ";
		$sqlInsertaComentarios .= "values (".$folio.", '".$_SESSION['rfcDocente']."', '".$_SESSION['rfcEvaluador']."', '".$comentarioFinal."', ".$_SESSION['anioEvaluacion'].")";
		mysql_query($sqlInsertaComentarios);

		// cerrando conexion a base de datos
		close($conexion);
	}

	function obtieneIndicadoresNoEvaluados(){

		$htmlPlantilla = "";

		/* conexion a base de datos */
		$conexion = getConnection();

		$sql = "";
		$sql .= "SELECT i.descripcion as descripcion_indicador, c.descripcion as descripcion_categoria ";
		$sql .= "FROM categoria As c, indicador As i, categoria_indicador As ci ";
		$sql .= "WHERE c.id_categoria = ci.id_categoria and i.id_indicador = ci.id_indicador ";
		$sql .= "and not exists ( ";
		$sql .= 	"select null ";
		$sql .= 	"from asignacion_indicador ai ";
		$sql .= 	"where ai.id_categoriaindicador = ci.id_categoriaindicador and ai.rfc_docente = '".$_SESSION['rfcDocente']."' and ai.anio = ".$_SESSION['anioEvaluacion'];
		$sql .= ")";

		/* ejecucion del query en el manejador de base datos */
		$iteraRegistros = 1;
		$resultSetGetIndicadoresNoCapturados = mysql_query($sql);
		
		while($row = mysql_fetch_array($resultSetGetIndicadoresNoCapturados)){
			// plantilla de la fila de la tabla		
			$htmlPlantilla .= "<tr>";
			$htmlPlantilla .= 	"<td>".$iteraRegistros."</td>";
			$htmlPlantilla .= 	"<td>".$row[0]."</td>";
			$htmlPlantilla .= 	"<td>".$row[1]."</td>";
			$htmlPlantilla .= "<tr>";

			$iteraRegistros++;
		}

		// cerrando conexion a base de datos
		close($conexion);

		return $htmlPlantilla;
	}

	function obtenerPorcentajeDeCaptura($rfcDocente){

		$porcentaje = 0;

		/* conexion a base de datos */
		$conexion = getConnection();


		$sqlGetNumeroIndicadores = "";
		$sqlGetNumeroIndicadores .= "SELECT ";
		$sqlGetNumeroIndicadores .= 	"count(i.id_indicador) as numeroIndicadores ";
		$sqlGetNumeroIndicadores .= "FROM ";
		$sqlGetNumeroIndicadores .= 	"categoria As c, ";
		$sqlGetNumeroIndicadores .= 	"indicador As i, ";
		$sqlGetNumeroIndicadores .= 	"categoria_indicador As ci ";
		$sqlGetNumeroIndicadores .= "WHERE ";
		$sqlGetNumeroIndicadores .= 	"c.id_categoria = ci.id_categoria ";
		$sqlGetNumeroIndicadores .= 	"and i.id_indicador = ci.id_indicador ";

		/* ejecucion del query en el manejador de base datos */
		$resultSetGetNumeroIndicadores = mysql_query($sqlGetNumeroIndicadores);
		$row = mysql_fetch_array($resultSetGetNumeroIndicadores);

		if(mysql_num_rows($resultSetGetNumeroIndicadores) > 0){
			$sqlIndicadoresCapturados = "";
			$sqlIndicadoresCapturados .= "select ai.id_categoriaindicador ";
			$sqlIndicadoresCapturados .= "from asignacion_indicador ai, categoria_indicador ci ";
			$sqlIndicadoresCapturados .= "where ai.RFC_docente = '".$rfcDocente."' and ai.id_categoriaindicador = ci.id_categoriaindicador group by 1";

			/* ejecucion del query en el manejador de base datos */
			$resultSetIndicadoresCapturados = mysql_query($sqlIndicadoresCapturados);
			$indicadoresCapturados = mysql_num_rows($resultSetIndicadoresCapturados);

			$numeroIndicadores = $row['numeroIndicadores'];
			$porcentaje = round(($indicadoresCapturados / $numeroIndicadores)*100);
			
		}

		// cerrando conexion a base de datos
		close($conexion);

		return $porcentaje;
	}
	
	function obtenerPorcentajeDeEvaluacion($rfcDocente){

		$porcentaje = 0;

		/* conexion a base de datos */
		$conexion = getConnection();
		$sqlGetNumeroIndicadores = "select distinct id_categoriaindicador from asignacion_indicador where RFC_docente = '".$rfcDocente."' and anio = ".$_SESSION['anioEvaluacion'];
		/* ejecucion del query en el manejador de base datos */
		$resultSetGetNumeroIndicadores = mysql_query($sqlGetNumeroIndicadores);
		$row = mysql_fetch_array($resultSetGetNumeroIndicadores);

		if(mysql_num_rows($resultSetGetNumeroIndicadores) > 0){


			$sqlIndicadoresEvaluados = "";
			$sqlIndicadoresEvaluados .= "select ei.id_categoriaindicador  ";
			$sqlIndicadoresEvaluados .= "from evaluacion_indicador ei, categoria_indicador ci ";
			$sqlIndicadoresEvaluados .= "where ei.RFC_docente = '".$rfcDocente."' and ei.id_categoriaindicador = ci.id_categoriaindicador group by 1";

			/* ejecucion del query en el manejador de base datos */
			$resultSetIndicadoresEvaluados = mysql_query($sqlIndicadoresEvaluados);
			$indicadoresEvaluados = mysql_num_rows($resultSetIndicadoresEvaluados);
			$numeroIndicadores = mysql_num_rows($resultSetGetNumeroIndicadores);

			$porcentaje = round(($indicadoresEvaluados / $numeroIndicadores)*100);
		}

		// cerrando conexion a base de datos
		close($conexion);

		return $porcentaje;
	}

	function generaIndicadoresHtml(){
		if(!verificarSesionDelUsuario()){ return; }; //IMPORTANTE: verifica la sesion del usuario
		/* SQL */
		$sqlCategorias = "";
		$sqlCategorias.= "SELECT ";
		$sqlCategorias.= 	"id_categoria, ";
		$sqlCategorias.= 	"descripcion ";
		$sqlCategorias.= "FROM ";
		$sqlCategorias.= 	"categoria order by 1 asc";
		
		

		/* conexion a base de datos */
		$conexion = getConnection();
		
		
		/* ejecucion del query en el manejador de base datos */
		$resultSetCategoria = mysql_query($sqlCategorias);
		/* plantilla html para indicadores */
		$plantillaElemento = "";
			
		while($rowCategoria = mysql_fetch_array($resultSetCategoria)){
			$idCategoria = $rowCategoria['id_categoria'];
			
			$sql = "";
			$sql.= "SELECT ";
			$sql.= 		"c.id_categoria as id_categoria, ";
			$sql.= 		"c.descripcion  as descripcion_categoria, ";
			$sql.= 		"i.id_indicador, "; 
			$sql.= 		"i.descripcion as descripcion_indicador, ";
			$sql.= 		"ci.id_categoriaindicador as categoria_indicador, "; 
			$sql.= 		"(select max(porcentaje) from porcentaje_indicador where id_categoriaindicador = ci.id_categoriaindicador) as porcentaje, ";
			$sql.= 		"(select COALESCE(max(id_categoriaindicador),0)  from evaluacion_indicador where id_categoriaindicador = ci.id_categoriaindicador and rfc_docente = '".$_SESSION['rfcDocente']."' and rfc_evaluador = '".$_SESSION['rfcEvaluador']."') as estatus, ";
			$sql.= 		"(select motivo  from evaluacion_indicador where id_categoriaindicador = ci.id_categoriaindicador and rfc_docente = '".$_SESSION['rfcDocente']."' and rfc_evaluador = '".$_SESSION['rfcEvaluador']."') as observacion , ";
			$sql.= 		"(select estado  from evaluacion_indicador where id_categoriaindicador = ci.id_categoriaindicador and rfc_docente = '".$_SESSION['rfcDocente']."' and rfc_evaluador = '".$_SESSION['rfcEvaluador']."') as estado , ";
			$sql.= 		"(select cal_porcentaje  from evaluacion_indicador where id_categoriaindicador = ci.id_categoriaindicador and rfc_docente = '".$_SESSION['rfcDocente']."' and rfc_evaluador = '".$_SESSION['rfcEvaluador']."') as calificacion , ";
			$sql.= 		"(select COALESCE(max(id_categoriaindicador),0) from asignacion_indicador where id_categoriaindicador = ci.id_categoriaindicador and rfc_docente = '".$_SESSION['rfcDocente']."') as estatusCaptura ";
			$sql.= 	"FROM "; 
			$sql.= 		"categoria As c, indicador As i, categoria_indicador As ci ";
			$sql.= 	"WHERE "; 
			$sql.= 		"ci.id_categoria = ".$idCategoria." and ";
			$sql.= 		"c.id_categoria = ci.id_categoria and ";
			$sql.= 		"i.id_indicador = ci.id_indicador ";

			$resultSet = mysql_query($sql);		
			
			
			/* separador de plantilla */
			$separador = "<div class='navbar-separador'></div>";
			
			/* barre consulta para generar html */
			log_($indicadorHtml);
			$contador = 1;
			$sumaPorcentaje = 0;
			while($row = mysql_fetch_array($resultSet)){			
				$plantillaElemento .="<div class='row-fluid'>";
				$plantillaElemento .=	"<div class='span2 categorias'>";
				if($contador == 1){
					$plantillaElemento .=		$row['descripcion_categoria'];	
				}
				
				$plantillaElemento .=	"</div>";
				$plantillaElemento .=	"<div class='span1 categorias'>";
				
				$sumaPorcentaje = $sumaPorcentaje + $row['porcentaje'];
				if($contador == 1){
					$plantillaElemento .=		"[PORCENTAJE_CATEGORIA]";	
				}
				$plantillaElemento .=	"</div>";
				$plantillaElemento .=	"<div class='span3 categoria'>";
				$plantillaElemento .=		$row['descripcion_indicador'];
				$plantillaElemento .=	"</div>";
				$plantillaElemento .=	"<div  class='span1 categorias'>";
				$plantillaElemento .=		$row['porcentaje'];
				$plantillaElemento .=	"</div>";
				$plantillaElemento .=	"<div  class='span1 categorias'>";

				if($row['estatus'] > 0){
					$plantillaElemento .=		"EVALUADO";
				}else{
					$plantillaElemento .=		".........";
				}

				$plantillaElemento .=	"</div>";
				$plantillaElemento .=	"<div  class='span1 categorias'>";
				if($row['estado'] == 0){
					$plantillaElemento .=		$row['calificacion'];
				}else{
						if($row['estado'] == 1){
						$plantillaElemento .=		"0";
						}
				}

				$plantillaElemento .=	"</div>";
				$plantillaElemento .=	"<div  class='span2 categoria'>";
				$plantillaElemento .=		$row['observacion'];
				$plantillaElemento .=	"</div>";
				$plantillaElemento .=	"<div class='span1 categorias'>";

				if($row['estatusCaptura'] > 0){
					$plantillaElemento .=		"<a href='calificaciondocumetosindicador.php?id_indicador=".$row[id_indicador]."&categoria_indicador=".$row['categoria_indicador']."' class='ver'></a>";
				}else{
					$plantillaElemento .=		"<a href='#' class='no-ver'></a>";
				}

				$plantillaElemento .=	"</div>";
				$plantillaElemento .="</div>";
			
				$contador++;
				
			}	
			$plantillaElemento = $plantillaElemento."".$separador;
			$plantillaElemento = str_replace("[PORCENTAJE_CATEGORIA]", $sumaPorcentaje, $plantillaElemento);
		}
		
		
		return $plantillaElemento;
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
		$sqlPerfilUsuario .= 	"concat(a.profesion,' ',a.nombre,' ',a.paterno,' ',a.materno)as nombreEmpleado, a.idempleado as idempleado, c.idadscripcion as adscripcion ";
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
			$_SESSION['idEmpleadoAEvaluar'] = $row['idempleado'];
			$_SESSION['idEmpleadoAEvaluarAdscripcion'] = $row['adscripcion'];
			return $row['nombreEmpleado'];
			
		}

		// cerrando conexion a base de datos
		close($conection);
	}
		
?>