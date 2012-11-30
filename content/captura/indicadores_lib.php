<?php
	include "../../lib/librerias.php";

	function obtenerEstadoDeLaCaptura(){
		$result = 0;
		/* conexion a base de datos */
		$conexion = getConnection();

		$sql = "SELECT COALESCE(estado,0) as estado FROM participantes where rfc = '".$_SESSION['rfcDocente']."' and anio = ".$_SESSION['anioEvaluacion'];

		$resultSet = mysql_query($sql,$conexion);

		if(mysql_num_rows($resultSet) > 0){
			$row = mysql_fetch_array($resultSet);
			if($row['estado'] == 1){
				$result = 1;
			}
		}

		// cerrando conexion a base de datos
		close($conexion);

		return $result;
	}

	function enviarCaptura(){		
		$sql = "UPDATE participantes SET ESTADO = '1', FECHA = NOW() WHERE rfc = '".$_SESSION['rfcDocente']."' and anio = ".$_SESSION['anioEvaluacion'];
		/* conexion a base de datos */
		$conexion = getConnection();

		/* ejecucion del query en el manejador de base datos */
		if (!mysql_query($sql,$conexion)){
			$errorCode = mysql_errno();
			// Error al actualizar
			if(!empty($errorCode)){				
				echo "Error: ".$errorCode;
				/* TODO: Incluir mensaje para la vista */
			}
		}

		// cerrando conexion a base de datos
		close($conexion);
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
	
	function generaIndicadoresHtml(){		
		
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
			$sql.= 		"i.id_indicador as id_indicador, "; 
			$sql.= 		"i.descripcion as descripcion_indicador, ";
			$sql.= 		"ci.id_categoriaindicador as categoria_indicador, "; 
			$sql.= 		"(select max(porcentaje) from porcentaje_indicador where id_categoriaindicador = ci.id_categoriaindicador) as porcentaje, ";
			$sql.= 		"(select COALESCE(max(id_categoriaindicador),0)  from asignacion_indicador where id_categoriaindicador = ci.id_categoriaindicador and rfc_docente = '".$_SESSION['rfcDocente']."') as estatus ";
			$sql.= 	"FROM "; 
			$sql.= 		"categoria As c, indicador As i, categoria_indicador As ci ";
			$sql.= 	"WHERE "; 
			$sql.= 		"ci.id_categoria = ".$idCategoria." ";
			$sql.= 		"and c.id_categoria = ci.id_categoria ";
			$sql.= 		"and i.id_indicador = ci.id_indicador ";

			$resultSet = mysql_query($sql);	

			/* separador de plantilla */
			$separador = "<div class='navbar-separador'></div>";
			
			/* barre consulta para generar html */

			$contador = 1;
			$sumaPorcentaje = 0;
			while($row = mysql_fetch_array($resultSet)){			

				$plantillaElemento .="<div class='row-fluid'>";
				$plantillaElemento .=	"<div class='span3 categorias'>";
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
				$plantillaElemento .=	"<div class='span4 categorias'>";
				$plantillaElemento .=		$row['descripcion_indicador'];
				$plantillaElemento .=	"</div>";
				$plantillaElemento .=	"<div  class='span1 categorias'>";
				$plantillaElemento .=		$row['porcentaje'];
				$plantillaElemento .=	"</div>";
				$plantillaElemento .=	"<div  class='span2 categorias'>";

				if($row['estatus'] > 0){
					$plantillaElemento .=		"CAPTURADO";
				}else{
					$plantillaElemento .=		".........";
				}

				$plantillaElemento .=	"</div>";
				$plantillaElemento .=	"<div class='span1 categorias'>";
				$plantillaElemento .=		"<a href='asignaciondocumentos.php?id_indicador=".$row[id_indicador]."&categoria_indicador=".$row['categoria_indicador']."' class='ver'></a>";
				$plantillaElemento .=	"</div>";
				$plantillaElemento .="</div>";
			
				$contador++;
				
			}	
			$plantillaElemento = $plantillaElemento."".$separador;
			$plantillaElemento = str_replace("[PORCENTAJE_CATEGORIA]", $sumaPorcentaje, $plantillaElemento);
		}
		
		// cerrando conexion a base de datos
		close($conexion);
		
		return $plantillaElemento;
	}

?>