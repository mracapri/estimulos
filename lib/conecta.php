<?php
	require_once '../ext-lib/soap/nusoap.php';

	/* Parametros de entrada */
	$parametros=array();
	$parametros['usuario']=$_GET['usuario'];
	$parametros['clave']=$_GET['password'];
	
	/* Nombre del servicio */
	$servicio="http://10.100.96.11:8080/RegistroUnicoPersonalService/RegistroUnicoPersonal?wsdl";
	

	$client = new SoapClient($servicio, $parametros);
	$result = $client->autenticarse($parametros);
	$result = result($result);

	/* consume servicio web */
	if($result['return']['accesoPermitido'] == true){
		echo 1;
	}else{
		echo 2;
	}

	//Funcion para obtener el array selectivo
	function result($obj){
		$out = array();
		foreach ($obj as $key => $val) {
			switch(true) {
				case is_object($val):
					$out[$key] = result($val);
					break;
				case is_array($val):
					$out[$key] = result($val);
					break;
				default:
					$out[$key] = $val;
			}
		}
		echo $val;
		return $out;
	}
?>