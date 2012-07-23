<?php
	require_once("lib/librerias.php");


	$usuario = $_POST['usuario'];
	$clave = $_POST['clave'];


	logIn("SAZL700719");
	
	/* login dummy */
	if(!empty($usuario) && !empty($clave)){
		// login con LDAP -- Preguntar con Emma
		//$result = ...
		//if(true){
			//logIn("SAZL700719");
		//}
	}else{
		enviaMensajeAPantalla("Credenciales vacias", "form-section");
	}


	/* Iniciar sesion */
	function logIn($usuario){
		// iniciando sesion
		//session_start();

		// abriendo conexion a base de datos del siin
		$conection = getConnection();

		// obteniendo el perfil del usuario
		$sqlPerfilUsuario = "";
		$sqlPerfilUsuario .= "SELECT ";
		$sqlPerfilUsuario .= 	"a.idempleado as idempleado, ";
		$sqlPerfilUsuario .= 	"concat(a.profesion,' ',a.nombre,' ',a.paterno,' ',a.materno)as nombreEmpleado, ";
		$sqlPerfilUsuario .= 	"c.adscripcion ";
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
			$_SESSION['idEmpleado'] = $row['idempleado'];	
			$_SESSION['nombreUsuario'] = $row['nombreEmpleado'];
			$_SESSION['rfcDocente'] = $usuario;
			$_SESSION['anioEvaluacion'] = 2012 - 1;
			$_SESSION['usuarioFirmado'] = "1";

			/* obteniendo el anio de evaluacion */			

			// obtenieno los periodos de evaluacion
			$periodos = "";
			$sqlPeriodos = "SELECT idperiodo FROM siin_generales.gral_periodos where periodo like '%".$_SESSION['anioEvaluacion']."%'";	
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
		session_destroy();
	}
?>