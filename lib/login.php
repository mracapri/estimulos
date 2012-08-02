<?php

	/* valida el tiempo de la sesion */
	$periodoInactividadMinutos = 30; // periodo de inactividad de 30 minutos
	$seguridadActivada = false;

	if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > ($periodoInactividadMinutos * 60) )) {
	    logOut();
		echo '<META HTTP-EQUIV="Refresh" Content="0; URL=/estimulos/index.php">';
	}
	$_SESSION['LAST_ACTIVITY'] = time();

	function logIn(){
		
		$usuario = $_POST['usuario'];
		$clave = $_POST['clave'];

		if(!empty($usuario) && !empty($clave)){
			if(elUsuarioSeEncuentraEnActiveDirectorie()){

				/* establece el momento en segundos del login */
				$_SESSION['LAST_ACTIVITY'] = time(); 

				/* obteniendo el anio de evaluacion */			
				$_SESSION['anioEvaluacion'] = 2012;

				if(elUsuarioEsEvaluador($usuario)){
					$_SESSION['rfcEvaluador'] = $usuario;
					$_SESSION['usuarioFirmado'] = "1";					
					echo '<META HTTP-EQUIV="Refresh" Content="0; URL=/estimulos/content/evaluacion/elegirDocenteAEvaluar.php">';
				}else if(elUsuarioEsDocenteParticipante($usuario)){
					$_SESSION['rfcDocente'] = $usuario;
					$_SESSION['usuarioFirmado'] = "2";
					$_SESSION['mensajeLegal'] = "0";
					echo '<META HTTP-EQUIV="Refresh" Content="0; URL=/estimulos/content/captura/indicadores.php">';
				}
				obteniendoPerfil($usuario);
			}else{					
				$_SESSION['usuarioFirmado'] = "0";
				enviaMensajeAPantalla("Usuario o Clave incorrecta",  "form-section");
			}
		}else{ 
			// si el usuario ya esta logueado pues lo deja entrar
			if($_SESSION['usuarioFirmado'] == 1){
				echo '<META HTTP-EQUIV="Refresh" Content="0; URL=/estimulos/content/evaluacion/elegirDocenteAEvaluar.php">';
			}else if($_SESSION['usuarioFirmado'] == 2){
				echo '<META HTTP-EQUIV="Refresh" Content="0; URL=/estimulos/content/captura/indicadores.php">';
			}else{
				enviaMensajeAPantalla("Usuario o Clave incorrecta",  "form-section");
			}
		}		
	}


	function elUsuarioSeEncuentraEnActiveDirectorie(){		

		if($seguridadActivada){

			$fd = fopen( "http://10.100.96.7/siin/servicioConecta/conecta.php", "r");	
			if(empty($fd)){
				echo "Error en el servidor Web del Siin";
			}else{
			    while(!feof($fd)) {
			        $result .= $buffer = fgets($fd, 4096);
			    }
			    fclose( $fd );
			}
			$jsonObj = json_decode($result);
			$resultadoArray  = jsonToArray($jsonObj);
			$acceso = $resultadoArray['return']['acceso'];

			if(!empty($acceso)){
				if($acceso == "1"){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}else{
			return true;
		}
	}

	/* convierte la respuesta json a arreglo*/
	function jsonToArray($obj){
	  	$out = array();
	  	foreach ($obj as $key => $val) {
	   		switch(true) {
	    		case is_object($val):
	     		$out[$key] = jsonToArray($val);
	     		break;
	    	case is_array($val):
	     		$out[$key] = jsonToArray($val);
	     		break;
	    	default:
	     		$out[$key] = $val;
			}
		}
		return $out;
	}

	function elUsuarioEsEvaluador($rfc){
		$result = false;
		$sql = "select nombre from evaluador where RFC_evaluador = '".$rfc."'";

		// abriendo conexion a base de datos del siin
		$conection = getConnection();		

		$resultSet = mysql_query($sql, $conection);		

		if(mysql_num_rows($resultSet) > 0){
			$row = mysql_fetch_array($resultSet);
			$_SESSION['nombreUsuario'] = $row['nombre'];
			$result = true;
		}

		// cerrando conexion a base de datos
		close($conection);

		return $result;
	}

	function elUsuarioEsDocenteParticipante($rfc){
		$result = false;
		$sql = "select * from participantes where rfc = '".$rfc."'";

		// abriendo conexion a base de datos del siin
		$conection = getConnection();		

		$resultSet = mysql_query($sql, $conection);		

		if(mysql_num_rows($resultSet) > 0){			
			$result = true;
		}

		// cerrando conexion a base de datos
		close($conection);

		return $result;
	}

	/* Iniciar sesion */
	function obteniendoPerfil($usuario){
		// iniciando sesion
		//session_start();

		// abriendo conexion a base de datos del siin
		$conection = getConnection();
			
		// obteniendo el perfil del usuario
		$sqlPerfilUsuario = "";
		$sqlPerfilUsuario .= "SELECT ";
		$sqlPerfilUsuario .= 	"a.idempleado as idempleado, ";
		$sqlPerfilUsuario .= 	"concat(a.profesion,' ',a.nombre,' ',a.paterno,' ',a.materno)as nombreEmpleado, ";
		$sqlPerfilUsuario .= 	"c.adscripcion as adscripcion, ";
		$sqlPerfilUsuario .= 	"c.idadscripcion as idadscripcion ";
		$sqlPerfilUsuario .= "FROM ";
		$sqlPerfilUsuario .= 	"siin_generales.gral_usuarios a, ";
		$sqlPerfilUsuario .= 	"siin_generales.gral_usuarios_adscripcion b, ";
		$sqlPerfilUsuario .= 	"siin_generales.gral_adscripcion c, siin_generales.gral_periodos d ";
		$sqlPerfilUsuario .= "WHERE ";
		$sqlPerfilUsuario .= 	"a.rfc = '".$usuario."' and ";
		$sqlPerfilUsuario .= 	"b.idempleado = a.idempleado and ";
		$sqlPerfilUsuario .= 	"d.actual = 1 and ";
		$sqlPerfilUsuario .= 	"b.idperiodo = d.idperiodo and ";
		$sqlPerfilUsuario .= 	"c.idadscripcion = b.idadscripcion";

		$resultSetPerfilUsuario = mysql_query($sqlPerfilUsuario, $conection);
		$row = mysql_fetch_array($resultSetPerfilUsuario);		

		if(mysql_num_rows($resultSetPerfilUsuario) > 0){

			// store session data
			$_SESSION['nombreUsuario'] = $row['nombreEmpleado'];
			$_SESSION['idEmpleado'] = $row['idempleado'];
			$_SESSION['idAdscripcion'] = $row['idadscripcion'];
			$_SESSION['adscripcion'] = $row['adscripcion'];

			// obtenieno los periodos de evaluacion
			$periodos = "";
			$sqlPeriodos = "SELECT idperiodo FROM siin_generales.gral_periodos where periodo like '%".($_SESSION['anioEvaluacion']-1)."%'";	
			$resultSetPeriodos = mysql_query($sqlPeriodos, $conection);
			$ultimoRegistro = mysql_num_rows($resultSetPeriodos);

			// barre los registros
			$iteraRegistro = 1;
			while($rowPeriodos = mysql_fetch_array($resultSetPeriodos)){
				if($iteraRegistro == $ultimoRegistro){
					$periodos .= $rowPeriodos[0]. "";
				}else{
					$periodos .= $rowPeriodos[0]. ",";
				}
				$iteraRegistro++;
			}
			$_SESSION['idPeriodos'] = $periodos;
		}

		// cerrando conexion a base de datos
		close($conection);
	}

	/* Terminar sesion */
	function logOut(){
	    session_destroy();   // destruye la session
	    session_unset();     // remueve la $_SESSION 
	}
?>