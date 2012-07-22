<?php 
	

	/*
		variable para prender la seguridad del sistema

		1 - ACTIVADA
		0 - DESACTIVADA

		Produccion: siempre en ACTIVADA
	*/
	define("SEGURIDAD", "0"); 

	/* login provisional */
	logIn();

	function verificarSesionDelUsuario(){
		if(SEGURIDAD == 1){
			$alertaHtml = "";
			$alertaHtml .= "<span id=\"alerta-sesion\" style=\"margin-left:20px;\" class=\"label label-important\">Vuelva a iniciar sesion</span>";

			/* definiendo script para agregar alerta */
			$scriptJQuery = "";
			$scriptJQuery .= "<script language='javascript'>";
			$scriptJQuery .= 	"$(document).ready(function(){";
			$scriptJQuery .= 		"if($('#alerta-sesion').size() == 0){";
			$scriptJQuery .= 			"$('".$alertaHtml."').appendTo(\"#nombre-persona\");";
			$scriptJQuery .= 		"}";
			$scriptJQuery .= 	"});";
			$scriptJQuery .= "</script>";

			/* comprobando la seguridad de la app */
			if(!isset($_SESSION['usuarioFirmado'])){
				echo $scriptJQuery;
				return false;
			}else{
				return true;
			}			
		}else{
			return true;
		}
	}

	/* Iniciar sesion */
	function logIn(){
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
		$sqlPerfilUsuario .= 	"a.rfc = 'SAZL700719' and ";
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
			$_SESSION['rfcDocente'] = 'SAZL700719';
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
	}

	/* Terminar sesion */
	function logOut(){
		
	}
?>