<?php
	require_once("../../lib/librerias.php");

	$guardarEvaluacion = $_POST['guardar-evaluacion'];
	$guardarPermisoEspecial = $_POST['guardar-permiso'];
	$guardarEvaluador = $_POST['guardar-evaluador'];

	if (filter_has_var(INPUT_POST, "guardar-evaluacion")) {
		// Registrando evaluacion
		$resultado = registraEvaluacion();
	}else if (filter_has_var(INPUT_POST, "cargar-usuarios")) {
		// cargando participantes desde el procedimiento almacenado
		cargarParticipanes();
	}else if (filter_has_var(INPUT_POST, "eliminar-participantes")) {
		$participantes = json_decode(stripslashes($_POST['eliminar-participantes']));
		eliminarParticipantes($participantes);
	}else if (
		filter_has_var(INPUT_POST, "input-periodo-actual") && 
		filter_var($_POST['input-periodo-actual'], FILTER_VALIDATE_INT)) {
		cambiaPeriodoCuatrimestralEnParametros($_POST['input-periodo-actual']);
	}else if (filter_has_var(INPUT_GET, "eliminar-evaluador") && !empty($_GET['rfc'])) {
		eliminarEvaluador($_GET['rfc']);
	}else if(!empty($guardarPermisoEspecial)){
		// Registrando permiso especial
		registraPermisoEspecial();
	}

	function cambiaPeriodoCuatrimestralEnParametros($periodo){
		// Definiendo el procedimiento almacenado 
		// para esta tarea		
		$sqlDelete = "delete from parametros where clave = 'PERIODO_ACTUAL'";
		$sqlInsert = "insert into parametros values('PERIODO_ACTUAL', '".$periodo."')";

		// Abriendo conexion
		$conection = getConnection();
		// ejecutando el sql
		mysql_query($sqlDelete);
		mysql_query($sqlInsert);

		// Cerrando conexion
		close($conection);
	}

	function eliminarEvaluador($rfc){
		// Definiendo el procedimiento almacenado 
		// para esta tarea

		// Abriendo conexion
		$conection = getConnection();

		// construyendo el query para eliminar los registros
		$sql = "delete from evaluador ";				
		$sql .= "where RFC_evaluador = '".$rfc."' "; 
		$sql .= "and anio in (select max(anio) from evaluacion)";

		// ejecutando el sql
		mysql_query($sql);

		// Cerrando conexion
		close($conection);
	}

	function eliminarParticipantes($arregloParticipantes){
		// Abriendo conexion
		$conection = getConnection();

		for($iteraParticipante = 0; 
			$iteraParticipante < sizeof($arregloParticipantes);
			 $iteraParticipante++){
			// construyendo el query para eliminar los registros
			$sql = "delete from participantes ";				
			$sql .= "where rfc = '".$arregloParticipantes[$iteraParticipante]."' "; 
			$sql .= "and anio in (select max(anio) from evaluacion)";

			// ejecutando el sql
			mysql_query($sql);
		}

		// Cerrando conexion
		close($conection);
	}

	function cargarParticipanes(){
		// Definiendo el procedimiento almacenado 
		// para esta tarea
		$sql = "call cargaParticipantes()";	

		// Abriendo conexion
		$conection = getConnection();

		// ejecutando el sql
		mysql_query($sql);

		// Cerrando conexion
		close($conection);
	}


	function consultaParticipantes(){
		$htmlPlantilla = "";

		$sql = "select "; 
		$sql .= 	"p.rfc, "; 
		$sql .= 	"concat(a.profesion,' ',a.nombre,' ',a.paterno,' ',a.materno) as nombre_empleado "; 
		$sql .= "from ";
		$sql .= 	"participantes p, ";
		$sql .= 	"siin_generales.gral_usuarios a ";
		$sql .= "where ";
		$sql .= 	"p.anio in (select max(anio) from evaluacion) and a.rfc = p.rfc";

		// Abriendo conexion
		$conection = getConnection();

		// ejecutando el sql
		$iteraRegistros = 1;
		$resultSet = mysql_query($sql);
		while($row = mysql_fetch_array($resultSet)){
			// plantilla de la fila de la tabla		
			$htmlPlantilla .= "<tr>";
			$htmlPlantilla .= 	"<td>".$iteraRegistros."</td>";
			$htmlPlantilla .= 	"<td>".$row['nombre_empleado']."</td>";
			$htmlPlantilla .= 	"<td><input class='participante-selected' title='".$row['rfc']."'  type='checkbox' /></td>";
			$htmlPlantilla .= "<tr>";

			$iteraRegistros++;
		}

		// Cerrando conexion
		close($conection);

		// regresando resultados
		return $htmlPlantilla;
	}

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
		$sql .= 	"evaluador ";
		$sql .= "where ";
		$sql .= 	"anio in (select max(anio) from evaluacion)";

		$iteraRegistros = 1;
		$resultSet = mysql_query($sql);
		while($row = mysql_fetch_array($resultSet)){
			// plantilla de la fila de la tabla		
			$htmlPlantilla .= "<tr>";
			$htmlPlantilla .= 	"<td>".$iteraRegistros."</td>";
			$htmlPlantilla .= 	"<td>".$row['RFC_evaluador']."</td>";
			$htmlPlantilla .= 	"<td>".$row['nombre']."</td>";
			$htmlPlantilla .= 	"<td>".$row['tipo']."</td>";
			$htmlPlantilla .= 	"<td><a href='?eliminar-evaluador=1&rfc=".$row['RFC_evaluador']."'>Eliminar</a></td>";
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
		$inputRfcEvaluador = $_POST['input-rfc-evaluador'];
		$inputNombreEvaluador = $_POST['input-nombre-evaluador'];
		$inputTipoEvaluador = $_POST['input-tipo-evaluador'];

		if(empty($inputRfcEvaluador)){
			return construyeAlertaHtml("Por favor, introduzca el RFC del evaluador");
		}else if(empty($inputNombreEvaluador)){
			return construyeAlertaHtml("Por favor, introduzca el nombre del evaluador");
		}

		$sql = "insert into evaluador(RFC_evaluador, nombre, tipo, anio) ";	
		$sql .= "values('".$inputRfcEvaluador."', '".$inputNombreEvaluador."', '".$inputTipoEvaluador."', (select max(anio) from evaluacion))";	

		// Abriendo conexion
		$conection = getConnection();

		// ejecutando el sql
		mysql_query($sql);

		// Cerrando conexion
		close($conection);

	}	

	function construyeAlertaHtml($mensaje){
		$alertaHtml = "";	
		$alertaHtml .= "<div class='alert alert-error'>";	
		$alertaHtml .= 		"_mensaje_";
		$alertaHtml .= "</div>";	
		$alertaHtml = str_replace("_mensaje_", $mensaje, $alertaHtml);
		return $alertaHtml;
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
			return construyeAlertaHtml($resultado);
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