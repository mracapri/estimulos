<?php
	require_once("../../lib/librerias.php");
	
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
			$sql.= 		"pi.id_porcentajeindicador, "; 
			$sql.= 		"pi.porcentaje, ";
			$sql.= 		"(select COALESCE(max(id_categoriaindicador),0)  from evaluacion_indicador where id_categoriaindicador = ci.id_categoriaindicador) as estatus, ";
			$sql.= 		"(select motivo  from evaluacion_indicador where id_categoriaindicador = ci.id_categoriaindicador) as observacion ";
			$sql.= 	"FROM "; 
			$sql.= 		"categoria As c, indicador As i, categoria_indicador As ci, porcentaje_indicador As pi ";
			$sql.= 	"WHERE "; 
			$sql.= 		"ci.id_categoria = ".$idCategoria." and ";
			$sql.= 		"c.id_categoria = ci.id_categoria and ";
			$sql.= 		"i.id_indicador = ci.id_indicador and ";
			$sql.= 		"pi.id_categoriaindicador = ci.id_categoriaindicador ";		


			
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
				$plantillaElemento .=		"<a href='calificaciondocumetosindicador.php?id_indicador=".$row[id_indicador]."&categoria_indicador=".$row['categoria_indicador']."' class='ver'></a>";
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