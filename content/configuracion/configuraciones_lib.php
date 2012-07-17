<?php
	include "../../lib/librerias.php";
	
	/*

	*/
	function consultaEvaluaciones(){

		$htmlPlantilla = "";

		$sql = "select ";
		$sql .= 	"anio, "; 
		$sql .= 	"descripcion, "; 
		$sql .= 	"fecha_captura, "; 
		$sql .= 	"fecha_limite_captura, "; 
		$sql .= 	"fecha_evaluacion, "; 
		$sql .= 	"fecha_limite_evaluacion "; 
		$sql .= "from ";
		$sql .= 	"evaluacion";
		

		// Abriendo conexion
		$conection = getConnection();

		// ejecutando el sql
		$iteraRegistros = 1;
		$resultSet = mysql_query($sql);
		while($row = mysql_fetch_array($resultSet)){
			// plantilla de la fila de la tabla		
			$htmlPlantilla .= "<tr>";
			$htmlPlantilla .= 	"<td>".$iteraRegistros."</td>";
			$htmlPlantilla .= 	"<td>".$row['anio']."</td>";
			$htmlPlantilla .= "<tr>";

			$iteraRegistros++;
		}

		// Cerrando conexion
		close($conection);

		// regresando resultados
		return $htmlPlantilla;
	}

	function consultaPermisosEspeciales(){
		$htmlPlantilla = "";
		// abriendo conexion a base de datos del siin
		$conection = getConnection();

		$sql = "select ";
		$sql .= 	"rfc, "; 
		$sql .= 	"anio "; 
		$sql .= "from ";
		$sql .= 	"permisos_especiales";

		$iteraRegistros = 1;
		$resultSet = mysql_query($sql);
		while($row = mysql_fetch_array($resultSet)){
			// plantilla de la fila de la tabla		
			$htmlPlantilla .= "<tr>";
			$htmlPlantilla .= 	"<td>".$iteraRegistros."</td>";
			$htmlPlantilla .= 	"<td>".$row['rfc']."</td>";
			$htmlPlantilla .= "<tr>";

			$iteraRegistros++;
		}

		// Cerrando conexion
		close($conection);
		return $htmlPlantilla;
	}

	function consultaEvaluadores(){
		$htmlPlantilla = "";
		return $htmlPlantilla;
	}

	function consultaReportes(){
		$htmlPlantilla = "";
		return $htmlPlantilla;
	}

	function registraEvaluacion($descripcion, $anio, $fechaCaptura, $fechaLimiteCaptura, $fechaEvaluacion, $fechaLimiteEvaluacion){

		$resultado = 0;

		return $resultado;
	}
?>