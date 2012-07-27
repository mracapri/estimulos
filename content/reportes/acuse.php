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
		//Cabecera de p�gina
		function Header()
			{
				//Logo
				$this->Image('../../img/logo.jpg',10,8,33);
				//Arial bold 15
				$this->SetFont('Arial','B',15);
				//Movernos a la derecha
				$this->Cell(85);
				//T�tulo
				$this->Cell(35,10,'Universidad Tecnol�gica del Valle del Mezquital.-'.$rfcDocente,0,0,'C');
				$this->Ln(8);
				$this->SetFont('Arial','B',12);
				$this->Cell(80);
				$this->Cell(35,10,'Acuse de envio.',0,0,'C');
				$this->Ln(15);
				//Fecha de impresion del reporte
				$this->SetX(10);
				$this->SetFont('Arial','',9);
				$mesnum = date('m') + 0;
				$mes = array('','Enero','Febrero','Marzo','Aril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
				$this->Cell(32,3,'Fecha de Impresi�n:',0,0,'LR',0,'L');
				
				mysql_query("SET NAMES UTF8");
				$datos = mysql_fetch_array(mysql_query("SELECT `folio`,`nombre`,`RFC`,`idempleado`,`programa_educativo` FROM `acuse` WHERE `idempleado` LIKE 'E999'"));
				

				$this->Cell(40,3,utf8_decode(date('d')." de ".$mes[$mesnum]." del ".date('Y')),0,0,'L');
				$this->Ln(4);
				$this->Cell(32,3,'Folio:',0,0,'l');
				$this->Cell(32,3,utf8_decode($datos[0]),0,0,'l');
				$this->Ln(4);
				$this->Cell(32,3,'Docente:',0,0,'l');
				$this->Cell(120,3,utf8_decode($datos[1]),0,0,'l');
				$this->Ln(4);
				$this->Cell(32,3,'RFC:',0,0,'l');
				$this->Cell(32,3,utf8_decode($datos[2]),0,0,'l');
				$this->Ln(4);
				$this->Cell(32,3,'No. Empleado:',0,0,'l');
				$this->Cell(32,3,utf8_decode($datos[3]),0,0,'l');
				$this->Ln(4);
				$this->Cell(32,3,'Programa E.:',0,0,'l');
				$this->Cell(150,3,utf8_decode($datos[4]),0,0,'l');
				
				//Salto de l�nea
				$this->Ln(8);
				
			}
		function tabla()
			{
				$this->SetX(5);
				//Arial 12
				$this->SetFont('Helvetica','B',12);
				//Color de fondo
				$this->SetFillColor(200,220,220);
				//T�tulo
				$this->Cell(205,5,'A C U S E',0,0,'C',true);
				//Salto de l�nea
				$this->Ln(10);
				
			}
		function body($rfcDocente)
			{
			mysql_query("SET NAMES UTF8");
			$datos = mysql_fetch_array(mysql_query("SELECT `nombre`FROM `acuse` WHERE `idempleado` LIKE 'E999'"));
				
				
					$this->SetX(10);
					$this->SetFont('Arial','',10);
					$this->MultiCell(195,5,'Este m�todo permite imprimir texto con saltos de l�nea. Estos pueden ser autom�ticos (tan pronto como el texto alcanza 
el borde derecho de la celda) o expl�cito (via el car�cter \n). Tantas celdas como sean necesarias son creadas,
uno debajo de otra. 
El texto puede ser alineado, centrado o justificado. El bloque de celda puede ser enmarcado y el fondo impreso.',0,'J',false);
											
					$this->Ln(140);
					
					$this->Cell(205,5,'______________________',0,0,'C',false);
					$this->SetFont('Arial','B',10);
					$this->Ln(5);
					$this->Cell(205,5,'Firma del docente',0,0,'C',false);
					$this->Ln(5);
					$this->SetFont('Arial','',10);
					$this->Cell(205,5,utf8_decode($datos[0]),0,0,'C',false);
					$this->Ln(5);
												
			}
			

		//Pie de p�gina
		function Footer()
			{
				//Leyenda de derechos reservados
				$this->SetY(-13);
				$this->SetFont('Arial','',8);
				$this->Cell(205,10,'UTVM Derechos Reservados.',0,0,'C');
				//Posici�n: a 1,5 cm del final
				$this->SetY(-10);
				//Arial italic 8
				$this->SetFont('Arial','I',8);
				//N�mero de p�gina
				$this->Cell(205,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
			}
	}
}

//Creaci�n del objeto de la clase heredada
$pdf=new PDF('P','mm','letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
$pdf->tabla();
$pdf->body($rfcDocente);
$pdf->Output();
?>