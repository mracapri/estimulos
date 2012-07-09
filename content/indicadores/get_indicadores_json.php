<?php
	include "../../lib/mysql.php";
	header('Content-type: application/json');
	
	$con = getConnection();
	mysql_query("SET NAMES UTF8");
	$query = "";
	$query = $query."select ";
	$query = $query.	"id_categoria, ";
	$query = $query.	"descripcion ";
	$query = $query."from ";
	$query = $query.	"categoria";
	$resultSet = mysql_query($query);		
	
	
	$categorias = array();
	$indicadores = array();
	$porcentaje = array();
	
	
	$iteraCategorias = 0;
	while($row = mysql_fetch_array($resultSet))
	{	
		
		$queryIndicador = "";
		$queryIndicador = $queryIndicador. "select ";
		$queryIndicador = $queryIndicador. 		"i.id_indicador, ";
		$queryIndicador = $queryIndicador. 		"i.descripcion As des, ";
		$queryIndicador = $queryIndicador. 		"ci.id_categoriaindicador ";
		$queryIndicador = $queryIndicador. "from ";
		$queryIndicador = $queryIndicador. 		"indicador As i, categoria_indicador As ci ";
		$queryIndicador = $queryIndicador. "where ";
		$queryIndicador = $queryIndicador. 		"ci.id_categoria  = ".$row['id_categoria']." and ";
		$queryIndicador = $queryIndicador. 		"i.id_indicador = ci.id_indicador ";
		
		$resultSetIndicador = mysql_query($queryIndicador);				
		$indicadores = array();
		$iteraIndicador = 0;
		
		
		while($rowIndicador = mysql_fetch_array($resultSetIndicador))
		{
		
			$idCategoriaIndicador = $rowIndicador['id_categoriaindicador'];
			

			$queryPorcentaje = "";
			$queryPorcentaje = $queryPorcentaje. "select ";
			$queryPorcentaje = $queryPorcentaje. 		"pi.porcentaje as porcentaje, ";
			$queryPorcentaje = $queryPorcentaje. 		"pi.descripcion as descrip ";
			$queryPorcentaje = $queryPorcentaje. "from ";
			$queryPorcentaje = $queryPorcentaje. 		"porcentaje_indicador As pi ";
			$queryPorcentaje = $queryPorcentaje. "where ";
			$queryPorcentaje = $queryPorcentaje. 		"pi.id_categoriaindicador = ". $idCategoriaIndicador;
			
			$porcentaje = array();
			$iteraPorcentaje = 0;
			$resultSetPorcentaje = mysql_query($queryPorcentaje);	
			while($rowPorcentaje = mysql_fetch_array($resultSetPorcentaje)){
				$porcentaje[$iteraPorcentaje] = array(
					"porcentaje" => $rowPorcentaje['porcentaje'],
					"descripcion" => $rowPorcentaje['descrip']
				);
				
				$iteraPorcentaje++;
				
			}			
		

			$indicadores[$iteraIndicador] = array(
				"id_indicador" => $rowIndicador['id_indicador'],
				"descripcion" => $rowIndicador['des'],
				"porcentajes" => $porcentaje
				
			);
			$iteraIndicador++;
		}
		
		$categorias[$iteraCategorias] = array(
			"id_categoria"=> $row['id_categoria'] , 
			"descripcion" => $row['descripcion'] ,
			"indicadores" => $indicadores
		);		
		$iteraCategorias++;
	}



	$jsonData = array("indicadores" => array(
		"categorias" => $categorias
	));
	
	echo json_encode($jsonData);
	
	close($con);
	
?>
