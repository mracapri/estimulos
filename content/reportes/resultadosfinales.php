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
			
				// obtener el nuevo folio del acuse 
				mysql_query("SET NAMES UTF8");
				
				$conexion = getConnection();
				$NoFolio = ("SELECT(max(coalesce(folio, 0))+1) as folio FROM acuse");
				
				/* ejecucion del query en el manejador de base datos */
				$resultfolio = mysql_query($NoFolio);

				/* obteniendo Folio */
				$idfolio = 0;
				$row = mysql_fetch_array($resultfolio);
				if(count($row) > 0){
					$idfolio = $row['Folio']+1;
				}
				
				
				
				$sqlInsert .= "INSERT INTO acuse (folio, fecha , nombre , RFC, idempleado, programa_educativo, anio) VALUES (".$idfolio.", now(), '".$_SESSION['nombreUsuario']."', '".$_SESSION['rfcDocente']."', '".$_SESSION['idEmpleado']."',  '".$_SESSION['adscripcion']."', '".$_SESSION['anioEvaluacion']."')";
				$Insert = mysql_query($sqlInsert);
				
				// ejecutano insert sql
				if (!mysql_query($Insert,$conexion)){
					$errorCode = mysql_errno();
					if(!empty($errorCode)){
						if($errorCode == 1062){ // registro duplicado
							// mandar un error a la vista en html
							$resultado = "Ya existe una evulacion con el mismo anio";
						}
					}
				}
				
				
				
		
			
				//Logo
				$this->Image('../../img/logo.jpg',10,8,33);
				//Arial bold 15
				$this->SetFont('Arial','B',15);
				//Movernos a la derecha
				$this->Cell(85);
				//T�tulo
				$this->Cell(35,10,'Universidad Tecnol�gica del Valle del Mezquital.'.$rfcDocente,0,0,'C');
				$this->Ln(8);
				$this->Cell(85);
				$this->SetFont('Arial','B',8);
				$this->Cell(35,10,'Resultados del Programa de Reconocimiento y Est�mulo al Desempe�o del Personal Acad�mico ',0,0,'C');
				$this->Ln(5);
				$this->Cell(85);
				$this->SetFont('Arial','B',8);
				$this->Cell(35,10,'(PREDA).',0,0,'C');
				$this->Ln(5);
				$this->SetFont('Arial','B',12);
				$this->Cell(85);
				$this->Cell(35,10,'Reporte de resultados finales de la evaluaci�n.',0,0,'C');
				$this->Ln(15);
				//Fecha de impresion del reporte
				$this->SetX(10);
				$this->SetFont('Arial','',9);
				$mesnum = date('m') + 0;
				$mes = array('','Enero','Febrero','Marzo','Aril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
				$this->Cell(32,3,'Fecha de Impresi�n:',0,0,'LR',0,'L');
				
				
				//datos del que genera el reporte
				

				$this->Cell(40,3,utf8_decode(date('d')." de ".$mes[$mesnum]." del ".date('Y')),0,0,'L');
				$this->Ln(5);
				$this->SetX(10);
				$this->Cell(32,3,'Emitido por el Dto.:',0,0,'l');
				$this->Cell(100,3,'Direcci�n de desarrollo acad�mico y calidad educativa.',0,0,'l');
				
				//Salto de l�nea
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
				$this->Ln(5);
				$this->Sety(-60);
				$this->SetX(10);	
				
				// query de los participantes

				
				/****************************************************/
				
			}
		function body($rfcDocente)
			{
			
			
			
			

				
				$this->SetFont('Arial','',10);
				$this->SetTextColor(0,0,0);
				$this->MultiCell(195,5,'En apego al  art�culo 23 del CAPITULO IV. DEL PROCESO DE EVALUACI�N Y PAGO DE EST�MULOS del Programa de Reconocimiento y Est�mulo al desempe�o del Personal Acad�mico, la Direcci�n de Administraci�n y Finanzas les notificar� el d�a en que se realizar� el pago.',0,'J',false);
				$this->Ln(8);					
				$this->SetFont('Arial','B',10);
				$this->Ln(5);
				$this->Cell(205,5,'Atentamente.',0,0,'C',false);
				$this->Ln(5);
				$this->SetFont('Arial','I',10);
				$this->Cell(205,5,'�Aprender, Emprender, Transformar�',0,0,'C',false);
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