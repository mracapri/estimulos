<?php 
	require_once("../../ext-lib/phpexcel/Classes/PHPExcel.php");
	require_once("../../ext-lib/phpexcel/Classes/PHPExcel/Writer/Excel2007.php");
	require_once("../../lib/mysql.php");	
	
	/* conexion a base de datos */
		$conection = getConnection();
		
	//Abrir plantilla
	$objPHPExcel = PHPExcel_IOFactory::load('plantilla.xlsx');
	
	//Llenar plantilla	
	$objWorksheet = $objPHPExcel->getActiveSheet();		
	
	$queryObtieneEvaluadores = "select RFC_evaluador as rfcEvaluador, nombre as nombreEva from evaluador where anio = 2012";
	$resultSetObtieneEvaluadores = mysql_query($queryObtieneEvaluadores, $conection) or die(mysql_error());
	$totalObtieneEvaluadores = mysql_num_rows($resultSetObtieneEvaluadores);
	
	
	$queryObtieneDocente = "SELECT b.rfc as rfcDocente, concat( a.nombre, ' ', a.paterno, ' ', a.materno ) as nombreDoc ";
	$queryObtieneDocente .= "FROM siin_generales.gral_usuarios a, estimulos.participantes b ";
	$queryObtieneDocente .= "WHERE b.estado = '2' AND b.anio = 2012 AND a.rfc = b.rfc";
	
	$resultSetObtieneDocentes = mysql_query($queryObtieneDocente, $conection) or die(mysql_error());	
	$totalObtieneDocente = mysql_num_rows($resultSetObtieneDocentes);	

	/* Inserta columnas de evaluadores */
	$columnaEvaluador =1;
	while($rowEvaluadores = mysql_fetch_array($resultSetObtieneEvaluadores))
	{
		$nombre= utf8_encode($rowEvaluadores["nombreEva"]);		
		$objWorksheet->getCell('B4')->setValue($nombre);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($columnaEvaluador, 4, $nombre);
		$objPHPExcel->getActiveSheet()->insertNewColumnBefore('B', 1);
		$columnaEvaluador++;
	}
	
	$objPHPExcel->getActiveSheet()->removeColumn('B',1); 
	
	/* Inserta participantes */
	$filaDocente = 5;
	while($rowDocentes = mysql_fetch_array($resultSetObtieneDocentes))
	{
		$nombreDoc= utf8_encode($rowDocentes["nombreDoc"]);		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $filaDocente, $nombreDoc);
		$filaDocente++;
		
		
	}
	
	/* inserta calificaciones */

	$resultSetObtieneDocentes = mysql_query($queryObtieneDocente, $conection) or die(mysql_error());
	$filas = 5;
	while($rowDocentes = mysql_fetch_array($resultSetObtieneDocentes))
	{
		$columnas = 1;
		$rfcDoc= $rowDocentes["rfc"]; 
		$resultSetObtieneEvaluadores = mysql_query($queryObtieneEvaluadores, $conection) or die(mysql_error());
		$sumatoria = 0;
		while($row = mysql_fetch_array($resultSetObtieneEvaluadores))
		{
			$rfcEvaluador= $row["rfcEvaluador"];
			$rfcDocente = $rowDocentes["rfcDocente"];
			
			$queryObtieneCalificacion = "select coalesce(sum(cal_porcentaje),0) as calificacion, RFC_docente as rfc from evaluacion_indicador where anio = 2012 and RFC_evaluador = '".$rfcEvaluador."' and  RFC_docente = '".$rfcDocente."'";			
			$resultSetObtieneCalificacion = mysql_query($queryObtieneCalificacion, $conection) or die(mysql_error());
			$rowCalificaciones = mysql_fetch_array($resultSetObtieneCalificacion);						
						
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($columnas, $filas, $rowCalificaciones['calificacion']);
			
			$sumatoria = $sumatoria + $rowCalificaciones['calificacion'];
			
			$columnas++;
		}	

		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($columnas, $filas, ($sumatoria/$totalObtieneEvaluadores));
		
		$filas++;
	}	
	
	//Formato de hoja
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);	
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);	
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);	
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);	
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);	
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);	
	//$objWorksheet->getCell('B3')->setValue("Evaluadores");
	//$objPHPExcel->getActiveSheet()->mergeCells('B3:C3');//Combinar celdas
	//$objPHPExcel->getActiveSheet()->getStyle('A1:G4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);//alineacion 
	
 	// Renombrando la hoja
	$objPHPExcel->getActiveSheet()->setTitle('Reporte final');
	
	//Guardar doc xls
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('reporte_final.xls');	
	echo "<div>Por favor para descargar el reporte de Excel dar clic en la siguiente liga:</div>";
	echo "<a href='reporte_final.xls'>Reporte Excel</a>";
	//$enlace = $_GET['reporte_final.xls'];
	//exec('reporte_final.xls');
?>