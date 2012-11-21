<?php
session_start();							
require('../../ext-lib/fpdfp/fpdf.php');   //libreria fpdf
include "../../lib/mysql.php";

$rfcDocente = $_SESSION['rfcDocente'];
$fechaAnterior = $_GET['fa'];

reporteRegulares($rfcDocente, $fechaAnterior);
function reporteRegulares($rfcDocente, $fechaAnterior)
{
	$conexion = getConnection();
	class PDF extends FPDF
	{
		//Cabecera de página
		function cabecera($fechaAnterior)
			{
				//Logo
				$this->Image('../../img/logo.jpg',10,8,33);
				//Arial bold 15
				$this->SetFont('Arial','B',15);
				//Movernos a la derecha
				$this->Cell(85);
				//Título
				$this->Cell(35,10,'Universidad Tecnológica del Valle del Mezquital.',0,0,'C');
				$this->Ln(8);
				$this->Cell(85);
				$this->SetFont('Arial','B',8);
				$this->Cell(35,10,'Resultados del Programa de Reconocimiento y Estímulo al Desempeño del Personal Académico ',0,0,'C');
				$this->Ln(5);
				$this->Cell(85);
				$this->SetFont('Arial','B',8);
				$this->Cell(35,10,'(PREDA).',0,0,'C');
				$this->Ln(5);
				$this->SetFont('Arial','B',12);
				$this->Cell(85);
				$this->Cell(35,10,'Reporte de estado de Evaluación.',0,0,'C');
				$this->Ln(10);
				//Fecha de impresion del reporte
				$this->SetX(10);
				$this->SetFont('Arial','',9);
				$mesnum = date('m') + 0;
				$mes = array('','Enero','Febrero','Marzo','Aril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
				$this->Cell(32,3,'Fecha de Impresión:',0,0,'LR',0,'L');
						
				if( empty($fechaAnterior) ){
				$this->Cell(90,3,utf8_decode(date('d')." de ".$mes[$mesnum]." del ".date('Y')),0,0,'L');
				}else{
					$this->Cell(90,3,utf8_decode($fechaAnterior),0,0,'L');
				}
				
				$this->Ln(4);
				$this->SetFont('Arial','',8);
				$this->Cell(32,3,'Evaluador:',0,0,'l');
				$this->Cell(32,3,utf8_decode($_SESSION['nombreUsuario']),0,0,'l');  // nombre del usuario
				$this->Ln(4);
				$this->SetFont('Arial','',8);
				$this->Cell(32,3,'RFC:',0,0,'l');
				$this->Cell(120,3,utf8_decode($_SESSION['rfcEvaluador']),0,0,'l');	//RFC del usuario
				$this->Ln(8);
				
				
				
				
				$sqlPerfilUsuario = ("SELECT concat(a.nombre,' ',a.paterno,' ',a.materno)as nombreEmpleado FROM siin_generales.gral_usuarios a WHERE rfc = '".$_SESSION['rfcDocente']."'");
				mysql_query("SET NAMES UTF8");
				$sqlUsuario = mysql_query($sqlPerfilUsuario);
				//echo $sqlPerfilUsuario;
				while($DocenteNombre = mysql_fetch_array($sqlUsuario)){
				$this->SetFont('Arial','',8);
				$this->Cell(32,3,'Evalua al Docente:',0,0,'l');
				$this->Cell(32,3,utf8_decode($DocenteNombre[0]),0,0,'l');		// Docente al que se esta evaluando
				$this->Ln(4);
				$this->SetFont('Arial','',8);
				$this->Cell(32,3,'RFC:',0,0,'l');
				$this->Cell(32,3,utf8_decode($_SESSION['rfcDocente']),0,0,'l');		// RFC del docente
				
				//Salto de línea
				$this->Ln(8);
				// encabezado de la tabla
				
				$this->SetX(5);
				//Arial 12
				$this->SetFont('Helvetica','',9);
				//Color de fondo
				$this->SetFillColor(51,51,51);
				$this->SetTextColor(255,255,255);
				//Título
				$this->Cell(40,5,'Categoria',1,0,'C',true);
				//$this->Cell(20,5,'% Porcentaje',1,0,'C',true);
				$this->Cell(75,5,'Indicador',1,0,'C',true);
				$this->Cell(12,5,'% Max.',1,0,'C',true);
				$this->Cell(18,5,'% Obtenido',1,0,'C',true);
				$this->Cell(60,5,'Comentario',1,0,'C',true);
				//Salto de línea
				$this->Ln(5);
				$this->SetX(5);
				$this->SetFillColor(204,204,204);
				$this->Cell(205,3,'',0,1,'C',true);
				
				}
			}
		
		function body($rfcDocente)
			{
				
				for($idCategoria = 1; $idCategoria <= 8; $idCategoria++)   // iteracion para envocar a todas las categorias e indicadores
				{
					//Consulta
					mysql_query("SET NAMES UTF8");
						$indicador = "SELECT c.id_categoria as id_categoria, c.descripcion  as descripcion_categoria, i.id_indicador, i.descripcion as descripcion_indicador, ci.id_categoriaindicador as categoria_indicador, (select max(porcentaje) from porcentaje_indicador where id_categoriaindicador = ci.id_categoriaindicador) as porcentaje, (select COALESCE(max(id_categoriaindicador),0)  from evaluacion_indicador where id_categoriaindicador = ci.id_categoriaindicador and rfc_docente = '".$_SESSION['rfcDocente']."' and rfc_evaluador = '".$_SESSION['rfcEvaluador']."') as estatus, (select motivo  from evaluacion_indicador where id_categoriaindicador = ci.id_categoriaindicador and rfc_docente = '".$_SESSION['rfcDocente']."' and rfc_evaluador = '".$_SESSION['rfcEvaluador']."') as observacion , (select COALESCE(max(id_categoriaindicador),0) from asignacion_indicador where id_categoriaindicador = ci.id_categoriaindicador and rfc_docente = '".$_SESSION['rfcDocente']."') as estatusCaptura FROM categoria As c, indicador As i, categoria_indicador As ci WHERE ci.id_categoria = ".$idCategoria." and c.id_categoria = ci.id_categoria and i.id_indicador = ci.id_indicador ";
						$resultindicador = mysql_query($indicador);		
						//echo $indicador;
						$contador = 1;											//contador
						$sumaPorcentaje = 0;							
						
					while($indica = mysql_fetch_array($resultindicador)){
						
						//hace la suma de los indicadores....
						$sumaPorcentaje = $sumaPorcentaje + $indica['porcentaje']; //procedimiento para la suma de los valores de una categoria
							$sqlSumaPorcentajes = "";
							$sqlSumaPorcentajes .= "SELECT ";
							$sqlSumaPorcentajes .= 		"max(porcentaje) as porcentaje,  ";
							$sqlSumaPorcentajes .= 		"id_categoriaindicador  ";
							$sqlSumaPorcentajes .= "FROM ";
							$sqlSumaPorcentajes .= 		"porcentaje_indicador ";
							$sqlSumaPorcentajes .= "WHERE ";
							$sqlSumaPorcentajes .= 		"id_categoriaindicador in (";
							$sqlSumaPorcentajes .= 			"select id_categoriaindicador from categoria_indicador where id_categoria = ".$indica['id_categoria'];
							$sqlSumaPorcentajes .= 		") group by 2";

							$resultSetSumaPorcentajes = mysql_query($sqlSumaPorcentajes);

							$suma = 0;
							while($rowSuma = mysql_fetch_array($resultSetSumaPorcentajes)){
								$suma = $suma + $rowSuma['porcentaje'];
							}
							//la suma de los indicadores es para hacer la suma total de una categoria 
						
						$this->SetLineWidth(.2);
						$this->SetX(5);
						$this->SetFont('Helvetica','',8);
						$this->SetTextColor(0,0,0);
						if($contador == 1){
						$this->MultiCell(40,5,utf8_decode($indica[1]),0,'l');  
						$y = $this->GetY();										   //regresa el salto de linea que Multicell realiza
						$this->SetY($y-5);		
						$this->SetX(45);						//trae el nombre de la categoria
						}else{
							if($contador == 2){
							$this->Cell(40,5,utf8_decode($suma),0,0,'c');         //trae el nombre de la categoria
							}
							else{
							$this->Cell(40,5,utf8_decode(" "),0,0,'l');
							}
						}
		
		
						$this->MultiCell(75,5,utf8_decode($indica[3]),0,'J');	   //trae la descripcion del indicador					
						$y = $this->GetY();										   //regresa el salto de linea que Multicell realiza
						$this->SetY($y-5);
						$this->SetX(120);
						$this->Cell(12,5,utf8_decode($indica[5]),0,0,'C');			//trae el porcentaje del indicador
						/*if($indica['estatus'] > 0){									//Estado de captura de un indicador
						$resul =		"EVALUADO";
						}
						else{
						$resul=		".........";
						}*/
						//$this->Cell(17,5,($resul),0,0,'C');							//trae el estado del indicador
						$observacion = "SELECT cal_porcentaje as calificacion, motivo as observacion, estado as estado from evaluacion_indicador a, categoria_indicador b where a.rfc_docente = '".$_SESSION['rfcDocente']."' and a.rfc_evaluador = '".$_SESSION['rfcEvaluador']."' and b.id_categoria = ".$idCategoria." and b.id_indicador = ".$indica[2]." and a.id_categoriaindicador = b.id_categoriaindicador";
						//echo $observacion;
						$sqlobservacion = mysql_query($observacion);
						while($observa = mysql_fetch_array($sqlobservacion)){
						if($observa['estado'] == 0){
						$this->Cell(18,5,($observa[0]),0,0,'C');
						}else{
							if($observa['estado'] == 1){
								$this->Cell(18,5,"0",0,0,'C');
							}
						}
						
						$this->SetX(150);
						$this->MultiCell(60,5,utf8_decode($observa[1]),0,'J');
						$y = $this->GetY();							//regresa el salto de linea que Multicell realiza
						$this->SetY($y-5);
						$this->SetX(125);
						}
						$this->Ln(5);
						$contador++;
					}
					$sumatotalPorcentaje = $sumaPorcentaje;
					//salto de linea y separador
					$this->SetX(5);
					$this->SetFillColor(204,204,204);
					$this->Cell(205,3,'',0,1,'C',true);
				}
				//trae la suma total del porcentaje que tubo al ser evaluado
				//query que hace la suma de la puntuacion total que tubo un docente
				$querycalificacion = "SELECT (sum(cal_porcentaje)) as calificacion from evaluacion_indicador where rfc_docente = '".$_SESSION['rfcDocente']."' and rfc_evaluador = '".$_SESSION['rfcEvaluador']."' and anio = 2012";
				$calificacionfinal = mysql_query($querycalificacion);
				while($rowSuma = mysql_fetch_array($calificacionfinal)){
				$this->SetX(5);
				$this->SetFont('Helvetica','',9);
				$this->SetFillColor(0,0,0);
				$this->SetTextColor(255,255,255);
				$this->Cell(125,5,'Porcentaje total obtenido:',1,0,'R',true);
				$this->Cell(14,5,($rowSuma[0]),1,0,'R',true);
				$this->Cell(66,5,'%',1,0,'L',true);
				$this->SetTextColor(0,0,0);
				}
							
			}
			
		Function Comentario()
		{
				mysql_query("SET NAMES UTF8");
				$ComentarioEv = ("SELECT comentario FROM estimulos.comentarios WHERE rfcdocente = '".$_SESSION['rfcDocente']."' and rfcevaluador = '".$_SESSION['rfcEvaluador']."'");
				$sqlComent = mysql_query($ComentarioEv);
				//echo $ComentarioEv;
				while($Coment = mysql_fetch_array($sqlComent)){
					//echo $Coment;
				$this->ln(5);
				$this->SetX(5);
				//Arial 12
				$this->SetFont('Helvetica','',9);
				//Color de fondo
				$this->SetFillColor(51,51,51);
				$this->SetTextColor(255,255,255);
				//Título
				$this->Cell(205,5,'Comentario final del evaluador.',1,0,'C',true);

				//Salto de línea
				$this->Ln(5);
				$this->SetX(5);
				$this->SetFillColor(255,255,255);
				
				$this->SetTextColor(0,0,0);
				$this->Ln(5);
				$this->SetX(15);
				$this->MultiCell(185,5,utf8_decode($Coment[0]),0,'J',true);
				
				
				}
				$this->SetX(10);
				$this->SetFont('Arial','',12);
				$this->SetY(-38);
				$this->Cell(195,5,'______________________',0,0,'C',false);
				$this->SetFont('Arial','B',10);
				$this->Ln(5);
				$this->Cell(195,5,'Firma del evaluador.',0,0,'C',false);
				$this->Ln(5);
				$this->SetFont('Arial','',10);
				$this->Cell(195,5,utf8_decode($_SESSION['nombreUsuario']),0,0,'C',false);
				$this->Ln(5);
		}
		//Pie de página
		function Footer()
			{
				//Leyenda de derechos reservados
				$this->SetY(-13);
				$this->SetFont('Arial','',8);
				$this->Cell(0,10,'UTVM Derechos Reservados.',0,0,'C');
				//Posición: a 1,5 cm del final
				$this->SetY(-10);
				//Arial italic 8
				$this->SetFont('Arial','I',8);
				//Número de página
				$this->Cell(0,15,'Page '.$this->PageNo().'/{nb}',0,0,'C');
			}
	}
}

//Creación del objeto de la clase heredada
$pdf=new PDF('P','mm','letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
$pdf->cabecera($fechaAnterior);
$pdf->body($rfcDocente);
$pdf->Comentario();
$pdf->Output();
?>