<?php
session_start();
require('../../ext-lib/fpdfp/fpdf.php');
include "../../lib/mysql.php";

$rfcDocente = $_SESSION['rfcDocente'];

reporteRegulares($rfcDocente);
function reporteRegulares($rfcDocente)
{
	$conexion = getConnection();
	class PDF extends FPDF
	{
		//Cabecera de página
		function Header()
			{
			
				/* obteniendo Folio 
				$idfolio = 0;
				$row = mysql_fetch_array($resultfolio);
				if(count($row) > 0){
					$idfolio = $row['Folio']+1;
				}
				
				*/
				
				
				
		
			
				//Logo
				$this->Image('../../img/logo.jpg',10,8,33);
				//Arial bold 15
				$this->SetFont('Arial','B',15);
				//Movernos a la derecha
				$this->Cell(85);
				//Título
				$this->Cell(35,10,'Universidad Tecnológica del Valle del Mezquital.'.$rfcDocente,0,0,'C');
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
				$this->Cell(35,10,'Reporte de resultados finales de la evaluación.',0,0,'C');
				$this->Ln(15);
				//Fecha de impresion del reporte
				$this->SetX(10);
				$this->SetFont('Arial','',9);
				$mesnum = date('m') + 0;
				$mes = array('','Enero','Febrero','Marzo','Aril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
				$this->Cell(32,3,'Fecha de Impresión:',0,0,'LR',0,'L');
				
				
				//datos del que genera el reporte
				

				$this->Cell(40,3,utf8_decode(date('d')." de ".$mes[$mesnum]." del ".date('Y')),0,0,'L');
				$this->Ln(5);
				$this->SetX(10);
				$this->Cell(32,3,'Emitido por el Dto.:',0,0,'l');
				$this->Cell(100,3,'Dirección de desarrollo académico y calidad educativa.',0,0,'l');
				
				//Salto de línea
				$this->Ln(8);
				
			}
		function tabla()
			{
				//Construccion de la tabla
				$this->SetX(10);
				$this->SetFont('Helvetica','B',10);
				$this->SetFillColor(204,204,204);
				$this->SetTextColor(0,0,0);
				$this->Cell(30,5,'No. Participante',0,0,'C',true);
				$this->Cell(110,5,'Nombre del Participante',0,0,'C',true);
				$this->Cell(50,5,'Porcentaje Obtenido (%)',0,0,'C',true);
				$this->Ln(10);
					
				
				// query de los participantes

				mysql_query("SET NAMES UTF8");
				$participantes = ("select b.rfc, concat(a.nombre, ' ', a.paterno, ' ' ,a.materno) from siin_generales.gral_usuarios a, participantes b where b.anio = 2012 and a.rfc = b.rfc") or die('error');
				$resultparticipantes = mysql_query($participantes);	
				
				
							
				while($Nombre = mysql_fetch_array($resultparticipantes))
				{
				 
				$CalfPorcentaje = ("SELECT cal_porcentaje FROM evaluacion_indicador WHERE ".($resultparticipantes[0])." = ".($resultparticipantes[0])." AND RFC_evaluador = RFC_evaluador ");
				$Calificaciones = mysql_query($CalfPorcentaje);	
				//echo $CalfPorcentaje;
					
					$this->SetLineWidth(.2);
					$this->SetX(10);
					$this->SetFont('Helvetica','',8);
					$this->SetTextColor(0,0,0);
					$this->Cell(30,5,($No),1,0,'C');
					$this->Cell(110,5,utf8_decode($Nombre[1]),1,0,'l');
					$this->Cell(50,5,utf8_decode($Calificaciones[0]),1,0,'C');					
					$this->ln(5);
				}
				$this->Sety(-60);
				$this->SetX(10);
			}
			
		function body($rfcDocente)
			{
				
				$this->SetFont('Arial','',10);
				$this->SetTextColor(0,0,0);
				$this->MultiCell(195,5,'En apego al  artículo 23 del CAPITULO IV. DEL PROCESO DE EVALUACIÓN Y PAGO DE ESTÍMULOS del Programa de Reconocimiento y Estímulo al desempeño del Personal Académico, la Dirección de Administración y Finanzas les notificará el día en que se realizará el pago.',0,'J',false);
				$this->Ln(8);					
				$this->SetFont('Arial','B',10);
				$this->Ln(5);
				$this->Cell(205,5,'Atentamente.',0,0,'C',false);
				$this->Ln(5);
				$this->SetFont('Arial','I',10);
				$this->Cell(205,5,'“Aprender, Emprender, Transformar”',0,0,'C',false);
				$this->Ln(5);
												
			}
			

		//Pie de página
		function Footer()
			{
				//Leyenda de derechos reservados
				$this->SetY(-13);
				$this->SetFont('Arial','',8);
				$this->Cell(205,10,'UTVM Derechos Reservados.',0,0,'C');
				//Posición: a 1,5 cm del final
				$this->SetY(-10);
				//Arial italic 8
				$this->SetFont('Arial','I',8);
				//Número de página
				$this->Cell(205,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
			}
	}
}

//Creación del objeto de la clase heredada
$pdf=new PDF('P','mm','letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
$pdf->tabla();
$pdf->body($rfcDocente);
$pdf->Output();
?>