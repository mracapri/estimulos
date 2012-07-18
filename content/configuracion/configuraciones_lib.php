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

		// abriendo conexion a base de datos del siin
		$conection = getConnection();

		$sql = "select ";
		$sql .= 	"RFC_evaluador, "; 
		$sql .= 	"nombre, "; 
		$sql .= 	"tipo "; 
		$sql .= "from ";
		$sql .= 	"evaluador";

		$iteraRegistros = 1;
		$resultSet = mysql_query($sql);
		while($row = mysql_fetch_array($resultSet)){
			// plantilla de la fila de la tabla		
			$htmlPlantilla .= "<tr>";
			$htmlPlantilla .= 	"<td>".$iteraRegistros."</td>";
			$htmlPlantilla .= 	"<td>".$row['RFC_evaluador']."</td>";
			$htmlPlantilla .= 	"<td>".$row['nombre']."</td>";
			$htmlPlantilla .= 	"<td>".$row['tipo']."</td>";
			$htmlPlantilla .= "<tr>";

			$iteraRegistros++;
		}

		// Cerrando conexion
		close($conection);
		return $htmlPlantilla;
	}

	function consultaReportes(){
		$htmlPlantilla = "";

		// abriendo conexion a base de datos del siin
		$conection = getConnection();

		$sql = "select ";
		$sql .= 	"id_reporte, "; 
		$sql .= 	"nombre, "; 
		$sql .= 	"path "; 
		$sql .= "from ";
		$sql .= 	"reportes";

		$iteraRegistros = 1;
		$resultSet = mysql_query($sql);
		while($row = mysql_fetch_array($resultSet)){
			// plantilla de la fila de la tabla		
			$htmlPlantilla .= "<option value='".$row['id_reporte']."' data-path='".$row['path']."'>".$row['nombre']."</option>";
			$iteraRegistros++;
		}

		// Cerrando conexion
		close($conection);
		return $htmlPlantilla;
	}

	function registraEvaluacion($descripcion, $anio, $fechaCaptura, $fechaLimiteCaptura, $fechaEvaluacion, $fechaLimiteEvaluacion){
		$resultado = "";

		$alertaHtml = "";	
		$alertaHtml .= "<div class='alert alert-error'>";	
		$alertaHtml .= 		"_mensaje_";
		$alertaHtml .= "</div>";	

		if(empty($descripcion)){
			$resultado = "Por favor, introduzca la descripcion";
		}else if(empty($anio)){
			$resultado = "Por favor, introduzca el anio";
		}else if(empty($fechaCaptura)){
			$resultado = "Por favor, introduzca la fecha de captura";
		}else if(empty($fechaLimiteCaptura)){
			$resultado = "Por favor introduzca la fecha limite de captura";
		}else if(empty($fechaEvaluacion)){
			$resultado = "Por favor introduzca la fecha de evaluacion";
		}else if (empty($fechaLimiteEvaluacion)) {
			$resultado = "Por favor introduzca la fecha limite de evaluacion";
		}

		$alertaHtml = str_replace("_mensaje_", $resultado, $alertaHtml);

		if(empty($resultado)){
			return "";
		}else{
			return $alertaHtml;
		}
	}

?>