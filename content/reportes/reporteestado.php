<?php
require('../../ext-lib/fpdfp/fpdf.php');
include "../../lib/mysql.php";

$rfcDocente = 'E195';
reporteRegulares($rfcDocente);
function reporteRegulares($rfcDocente)
{
	$conexion = getConnection();
	class PDF extends FPDF
	{
		//Cabecera de página
		function Header()
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
				$this->SetFont('Arial','B',12);
				$this->Cell(80);
				$this->Cell(35,10,'Reporte de estado de captura del docente.',0,0,'C');
				$this->Ln(15);
				//Fecha de impresion del reporte
				$this->SetX(5);
				$this->SetFont('Arial','',9);
				$mesnum = date('m') + 0;
				$mes = array('','Enero','Febrero','Marzo','Aril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
				$this->Cell(35,3,'Fecha de Impresión:',0,0,'LR',0,'L');
				$this->Cell(90,3,utf8_decode(date('d')." de ".$mes[$mesnum]." del ".date('Y')),0,0,'L');
				
				//Salto de línea
				$this->Ln(15);
				
			}
		function tabla()
			{
				$this->SetX(5);
				//Arial 12
				$this->SetFont('Helvetica','',9);
				//Color de fondo
				$this->SetFillColor(200,220,220);
				//Título
				$this->Cell(50,5,'Categoria',1,0,'C',true);
				$this->Cell(20,5,'Porcentaje',1,0,'C',true);
				$this->Cell(90,5,'Indicador',1,0,'C',true);
				$this->Cell(20,5,'Porcentaje',1,0,'C',true);
				$this->Cell(25,5,'Estado',1,0,'C',true);
				//Salto de línea
				$this->Ln(10);
				
			}
		function body($rfcDocente)
			{
				$idCategoria = 7;
				
				
				//Consulta
				mysql_query("SET NAMES UTF8");
					$indicador = mysql_query("SELECT c.id_categoria as id_categoria, c.descripcion  as descripcion_categoria,i.descripcion as descripcion_indicador,(select max(porcentaje) from porcentaje_indicador where id_categoriaindicador = ci.id_categoriaindicador) as porcentaje, (select COALESCE(max(id_categoriaindicador),0) from asignacion_indicador where id_categoriaindicador = ci.id_categoriaindicador) as estatus FROM 	categoria As c, indicador As i, categoria_indicador As ci WHERE ci.id_categoria = ".$idCategoria." and c.id_categoria = ci.id_categoria and i.id_indicador = ci.id_indicador") or die('error');
				
				while($indica = mysql_fetch_array($indicador)){
					$this->SetLineWidth(.2);
					$this->SetX(5);
					
					$this->SetFont('Helvetica','',8);
					$this->Cell(50,5,utf8_decode($indica[1]),1,0,'l');
					$this->Cell(20,5,'No calculado',1,0,'C');
					$this->Cell(90,5,utf8_decode($indica[2]),1,'T');
					$this->Cell(20,5,utf8_decode($indica[3]),1,0,'C');
					$this->Cell(25,5,'Capturado',1,0,'C');
					$this->Ln(5);
					
				}
								
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
				$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
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