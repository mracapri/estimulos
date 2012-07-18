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

		// abriendo conexion a base de datos
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

	function registraPermisoEspecial(){
		/* Variables de entrada despues de enviar los datos de registro de permisos especiales*/
		$inputRfcPermisos = $_POST['input-rfc-permisos'];

	}

	function registraEvaluador(){
		/* Variables de entrada despues de enviar los datos de registro de evaluadores*/
		$inputRfcPermisos = $_POST['input-rfc-evaluador'];
		$inputRfcPermisos = $_POST['input-nombre-evaluador'];
		$inputRfcPermisos = $_POST['input-tipo-evaluador'];
		
	}	

	function registraEvaluacion(){

		/* Variables de entrada despues de enviar los datos de registro de evaluacion*/
		$descripcion = $_POST['input-descripcion'];
		$anio = $_POST['input-anio'];
		$fechaCaptura = $_POST['input-fecha-captura'];
		$fechaLimiteCaptura = $_POST['input-fecha-limite-captura'];
		$fechaEvaluacion = $_POST['input-fecha-evaluacion'];
		$fechaLimiteEvaluacion = $_POST['input-fecha-limite-evaluacion'];

		$resultado = "";

		$alertaHtml = "";	
		$alertaHtml .= "<div class='alert alert-error'>";	
		$alertaHtml .= 		"_mensaje_";
		$alertaHtml .= "</div>";	

		if(empty($descripcion)){
			$resultado = "Por favor, introduzca la descripcion";
		}else if(empty($anio)){
			$resultado = "Por favor, introduzca el anio";
			/*
			if (preg_match("/\bweb\b/i", $anio)) {
			    $resultado "Anio incorrecto";
			}
			*/
		}else if(empty($fechaCaptura)){
			$resultado = "Por favor, introduzca la fecha de captura";
		}else if(empty($fechaLimiteCaptura)){
			$resultado = "Por favor introduzca la fecha limite de captura";
		}else if(empty($fechaEvaluacion)){
			$resultado = "Por favor introduzca la fecha de evaluacion";
		}else if (empty($fechaLimiteEvaluacion)) {
			$resultado = "Por favor introduzca la fecha limite de evaluacion";
		}

		// si todos los campos vienen llenos, ejeutamos el insert
		if(empty($resultado)){
			// abriendo conexion a base de datos
			$conection = getConnection();

			// insert para salvar registros en la tabla evaluacion
			$queryInsert = "";
			$queryInsert .="insert into ";
			$queryInsert .="evaluacion(anio, descripcion, fecha_captura, fecha_limite_captura, fecha_evaluacion, fecha_limite_evaluacion) ";
			$queryInsert .="values (";
			$queryInsert .=		"".$anio.", ";
			$queryInsert .=		"'".$descripcion."', ";
			$queryInsert .=		"DATE('".$fechaCaptura."'), ";
			$queryInsert .=		"DATE('".$fechaLimiteCaptura."'), ";
			$queryInsert .=		"DATE('".$fechaEvaluacion."'), ";
			$queryInsert .=		"DATE('".$fechaLimiteEvaluacion."') ";
			$queryInsert .=")";

			// ejecutano insert sql
			if (!mysql_query($queryInsert,$conection)){
				$errorCode = mysql_errno();
				if(!empty($errorCode)){
					if($errorCode == 1062){ // registro duplicado
						$resultado = "Ya existe una evulacion con el mismo anio";
					}
				}
			}

			// cerrando conexion
			close($conection);	
		}

		// volvemos a preguntar para asegurar que no existen erores sql
		if (!empty($resultado)) {
			$alertaHtml = str_replace("_mensaje_", $resultado, $alertaHtml);
			return $alertaHtml;
		}else{
			// limpiando variables
			$inputDescripcion = "";
			$inputAnio = "";
			$inputFechaCaptura = "";
			$inputFechaLimiteCaptura = "";
			$inputFechaEvaluacion = "";
			$inputFechaLimiteEvaluacion = "";
			return "";
		}

	}

?>