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
					$idfolio = $row['Folio'];
				}
				
				
				
				$sqlInsert .= "INSERT INTO ";
				$sqlInsert .=		"acuse (folio, fecha , nombre , RFC, idempleado, programa_educativo, anio) ";
				$sqlInsert .= "VALUES ";
				$sqlInsert .=	"(";
				$sqlInsert .=		"".$idfolio.", ";
				$sqlInsert .=		"now(), ";
				$sqlInsert .=		"'".$_SESSION['nombreUsuario']."', ";
				$sqlInsert .=		"'".$_SESSION['rfcDocente']."', ";
				$sqlInsert .=		"'".$_SESSION['idEmpleado']."', ";
				$sqlInsert .=		"'".$_SESSION['adscripcion']."', ";
				$sqlInsert .=		"'".$_SESSION['anioEvaluacion']."', ";
				$sqlInsert .=	")";
				
				// ejecutano insert sql
				if (!mysql_query($sqlInsert,$conexion)){
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
				//Título
				$this->Cell(35,10,'Universidad Tecnológica del Valle del Mezquital.'.$rfcDocente,0,0,'C');
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
				$this->Cell(32,3,'Fecha de Impresión:',0,0,'LR',0,'L');
				
				
				//$datos = mysql_fetch_array(mysql_query("SELECT `folio`,`nombre`,`RFC`,`idempleado`,`programa_educativo` FROM `acuse` WHERE `idempleado` LIKE 'E999'"));
				

				$this->Cell(40,3,utf8_decode(date('d')." de ".$mes[$mesnum]." del ".date('Y')),0,0,'L');
				$this->Ln(4);
				$this->Cell(32,3,'Folio:',0,0,'l');
				$this->Cell(32,3,utf8_decode($sqlInsert[0]),0,0,'l');
				$this->Ln(4);
				$this->Cell(32,3,'Docente:',0,0,'l');
				$this->Cell(120,3,utf8_decode($sqlInsert[2]),0,0,'l');
				$this->Ln(4);
				$this->Cell(32,3,'RFC:',0,0,'l');
				$this->Cell(32,3,utf8_decode($sqlInsert[3]),0,0,'l');
				$this->Ln(4);
				$this->Cell(32,3,'No. Empleado:',0,0,'l');
				$this->Cell(32,3,utf8_decode($sqlInsert[4]),0,0,'l');
				$this->Ln(4);
				$this->Cell(32,3,'Programa E.:',0,0,'l');
				$this->Cell(150,3,utf8_decode($sqlInsert[5]),0,0,'l');
				
				//Salto de línea
				$this->Ln(8);
				
			}
		function tabla()
			{
				$this->SetX(5);
				//Arial 12
				$this->SetFont('Helvetica','B',12);
				//Color de fondo
				$this->SetFillColor(200,220,220);
				//Título
				$this->Cell(205,5,'A C U S E',0,0,'C',true);
				//Salto de línea
				$this->Ln(10);
				
			}
		function body($rfcDocente)
			{
			mysql_query("SET NAMES UTF8");
			//$datos = mysql_fetch_array(mysql_query("SELECT nombre FROM acuse WHERE rfc = ".$_SESSION['rfcDocente']));
				
				
					$this->SetX(10);
					$this->SetFont('Arial','',10);
					$this->MultiCell(195,5,'Este método permite imprimir texto con saltos de línea. Estos pueden ser automáticos (tan pronto como el texto alcanza 
el borde derecho de la celda) o explícito (via el carácter \n). Tantas celdas como sean necesarias son creadas,
uno debajo de otra. 
El texto puede ser alineado, centrado o justificado. El bloque de celda puede ser enmarcado y el fondo impreso.',0,'J',false);
											
					$this->Ln(140);
					
					$this->Cell(205,5,'______________________',0,0,'C',false);
					$this->SetFont('Arial','B',10);
					$this->Ln(5);
					$this->Cell(205,5,'Firma del docente',0,0,'C',false);
					$this->Ln(5);
					$this->SetFont('Arial','',10);
					$this->Cell(205,5,utf8_decode($datos[2]),0,0,'C',false);
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