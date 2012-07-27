<?php
	require_once("../../lib/librerias.php");
	
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
				$plantillaElemento .=	"<div  class='span2 categorias'>";

				if($row['estatus'] > 0){
					$plantillaElemento .=		"EVALUADO";
				}else{
					$plantillaElemento .=		".........";
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
	
?>