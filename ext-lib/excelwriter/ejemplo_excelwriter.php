<?php
	// Autor de este ejemplo:
	//   Oscar Hernandez Caballero
	//   Descargate este código desde http://www.parentesys.es/informatica
	
	include("excelwriter.inc.php");

	$excel=new ExcelWriter("prueba_excelwriter.xls");
	
	if($excel==false) {	
		echo $excel->error;
	}

	// linea de cabecera
	$myArr=array("nombre","apellido","edad","telefono");
	$excel->writeLine($myArr);

	// lineas de datos
	for ($ind=0; $ind<1000; $ind++) {
		$myArr=array("nombre".$ind,"apellido".$ind,"edad".$ind,"telefono".$ind);
		$excel->writeLine($myArr);
	}
	
	
	// otra forma de insertar una linea
	//$excel->writeRow();
	//$excel->writeCol("columna1");
	//$excel->writeCol("columna2");
	//$excel->writeCol("columna3");
	//$excel->writeCol("columna4");
	 
	$excel->close();
	echo "fin de la exportacion";
?>