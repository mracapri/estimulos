<?php
session_start();							
require('../../ext-lib/fpdfp/fpdf.php');   //libreria fpdf
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
				$this->Cell(90,3,utf8_decode(date('d')." de ".$mes[$mesnum]." del ".date('Y')),0,0,'L');
				$this->Ln(4);
				$this->SetFont('Arial','',8);
				$this->Cell(32,3,'Evaluador:',0,0,'l');
				$this->Cell(32,3,utf8_decode($_SESSION['nombreUsuario']),0,0,'l');  // nombre del usuario
				$this->Ln(4);
				$this->SetFont('Arial','',8);
				$this->Cell(32,3,'RFC:',0,0,'l');
				$this->Cell(120,3,utf8_decode($_SESSION['rfcEvaluador']),0,0,'l');	//RFC del usuario
				$this->Ln(8);
				$this->SetFont('Arial','',8);
				$this->Cell(32,3,'Evalua al Docente:',0,0,'l');
				$this->Cell(32,3,utf8_decode($_SESSION['rfcDocente']),0,0,'l');		// Docente al que se esta evaluando
				$this->Ln(4);
				$this->SetFont('Arial','',8);
				$this->Cell(32,3,'RFC:',0,0,'l');
				$this->Cell(32,3,utf8_decode($_SESSION['Usuario']),0,0,'l');		// RFC del docente
				
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
				$this->Cell(50,5,'Categoria',1,0,'C',true);
				$this->Cell(20,5,'Porcentaje',1,0,'C',true);
				$this->Cell(90,5,'Indicador',1,0,'C',true);
				$this->Cell(20,5,'Porcentaje',1,0,'C',true);
				$this->Cell(25,5,'Estado',1,0,'C',true);
				//Salto de línea
				$this->Ln(5);
				$this->SetX(5);
				$this->SetFillColor(204,204,204);
				$this->Cell(205,3,'',0,1,'C',true);
				
				
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
						
						$this->SetLineWidth(.2);
						$this->SetX(5);
						$this->SetFont('Helvetica','',8);
						$this->SetTextColor(0,0,0);
						$this->Cell(50,5,utf8_decode($indica[1]),0,0,'l');         //trae el nombre de la categoria
						
						
						$sumaPorcentaje = $sumaPorcentaje + $indica['porcentaje']; //procedimiento para la suma de los valores de una categoria
						
	
						$this->Cell(20,5,utf8_decode($sumaPorcentaje),0,0,'C'); //trae el porcentaje de la categoria				
						$this->MultiCell(90,5,utf8_decode($indica[3]),0,'J');	   //trae la descripcion del indicador					
						$y = $this->GetY();										   //regresa el salto de linea que Multicell realiza
						$this->SetY($y-5);
						$this->SetX(165);
						$this->Cell(20,5,utf8_decode($indica[5]),0,0,'C');			//trae el porcentaje del indicador
						if($indica['estatus'] > 0){									//Estado de captura de un indicador
						$resul =		"EVALUADO";
						}
						else{
						$resul=		".........";
						}
						$this->Cell(25,5,($resul),0,0,'C');							//trae el estado del indicador
						
						$this->Ln(5);
						
						$contador++;
					}
					
					//salto de linea y separador
					$this->SetX(5);
					$this->SetFillColor(204,204,204);
					$this->Cell(205,3,'',0,1,'C',true);
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
$pdf->body($rfcDocente);
$pdf->Output();
?>