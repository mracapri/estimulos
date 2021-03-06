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
				$this->Cell(35,10,'Universidad Tecnol�gica del Valle del Mezquital.',0,0,'C');
				$this->Ln(5);
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
				$this->Cell(35,10,'Reporte de estado de captura del docente.',0,0,'C');
				$this->Ln(10);
				//Fecha de impresion del reporte
				$this->SetX(10);
				$this->SetFont('Arial','',9);
				$mesnum = date('m') + 0;
				$mes = array('','Enero','Febrero','Marzo','Aril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
				$this->Cell(32,3,'Fecha de Impresi�n:',0,0,'LR',0,'L');
				$this->Cell(90,3,utf8_decode(date('d')." de ".$mes[$mesnum]." del ".date('Y')),0,0,'L');
				
				$this->Ln(4);
				$this->SetFont('Arial','',8);
				$this->Cell(32,3,'Docente:',0,0,'l');
				$this->Cell(32,3,utf8_decode($_SESSION['nombreUsuario']),0,0,'l');  // nombre del usuario
				$this->Ln(4);
				$this->SetFont('Arial','',8);
				$this->Cell(32,3,'RFC:',0,0,'l');
				$this->Cell(120,3,utf8_decode($_SESSION['rfcDocente']),0,0,'l');	//RFC del usuario
				$this->Ln(4);
				$this->SetFont('Arial','',8);
				$this->Cell(32,3,'No. Empleado:',0,0,'l');
				$this->Cell(32,3,utf8_decode($_SESSION['idEmpleado']),0,0,'l');		// Numero de empleado
				$this->Ln(4);
				$this->SetFont('Arial','',8);
				$this->Cell(32,3,'Programa Educativo:',0,0,'l');
				$this->Cell(32,3,($_SESSION['adscripcion']),0,0,'l');	// Adscripcion al que esta registrado el usuario
				
				//Salto de l�nea
				$this->Ln(8);
				
				// encabezado de la tabla
				
				$this->SetX(5);
				//Arial 12
				$this->SetFont('Helvetica','',9);
				//Color de fondo
				$this->SetFillColor(51,51,51);
				$this->SetTextColor(255,255,255);
				//T�tulo
				$this->Cell(50,5,'Categoria',1,0,'C',true);
				$this->Cell(20,5,'% Categoria',1,0,'C',true);
				$this->Cell(90,5,'Indicador',1,0,'C',true);
				$this->Cell(20,5,'% Indicador',1,0,'C',true);
				$this->Cell(25,5,'Estado',1,0,'C',true);
				//Salto de l�nea
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
					$indicador = ("SELECT c.id_categoria as id_categoria, c.descripcion  as descripcion_categoria, i.descripcion as descripcion_indicador, ci.id_categoriaindicador as categoria_indicador, (select max(porcentaje) from porcentaje_indicador where id_categoriaindicador = ci.id_categoriaindicador) as porcentaje, (select COALESCE(max(id_categoriaindicador),0)  from asignacion_indicador where id_categoriaindicador = ci.id_categoriaindicador and rfc_docente = '".$_SESSION['rfcDocente']."') as estatus FROM categoria As c, indicador As i, categoria_indicador As ci WHERE ci.id_categoria = ".$idCategoria." and c.id_categoria = ci.id_categoria and i.id_indicador = ci.id_indicador ") or die('error');					
					$resultindicador = mysql_query($indicador);		
					
					$contador = 1;											//contador
					$sumaPorcentaje = 0;							
						
						
					while($indica = mysql_fetch_array($resultindicador)){
						
						$this->SetLineWidth(.2);
						$this->SetX(5);
						$this->SetFont('Helvetica','',8);
						$this->SetTextColor(0,0,0);
						if($contador == 1){
							$this->Cell(50,5,utf8_decode($indica[1]),0,0,'l');         //trae el nombre de la categoria
						}else{
							$this->Cell(50,5,utf8_decode(" "),0,0,'l');         //trae el nombre de la categoria
						}

						
						
						//hace la suma de los indicadores....
					
						$sumaPorcentaje = $sumaPorcentaje + $indica['porcentaje']; //procedimiento para la suma de los valores de una categoria
						


						if($contador == 1){

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
							$this->Cell(20,5,utf8_decode($suma),0,0,'C'); 			//trae el porcentaje de la categoria

						}else{
							$this->Cell(20,5,utf8_decode(" "),0,0,'C'); 			//espacio en blanco
						}

						$this->MultiCell(90,5,utf8_decode($indica[2]),0,'J');	   //trae la descripcion del indicador					
						$y = $this->GetY();										   //regresa el salto de linea que Multicell realiza
						$this->SetY($y-5);
						$this->SetX(165);
						$this->Cell(20,5,utf8_decode($indica[4]),0,0,'C');			//trae el porcentaje del indicador
						if($indica['estatus'] > 0){									//Estado de captura de un indicador
							$resul =		"CAPTURADO";
						}else{
							$resul=		".........";
						}
						$this->Cell(25,5,($resul),0,0,'C');							//trae el estado del indicador
						
						$this->Ln(5);

						$contador++;
					}
					// trae la suma toda de una categoria.
					$sumatotal = $sumaPorcentaje;
					//salto de linea y separador
					$this->SetX(5);
					$this->SetFillColor(204,204,204);
					$this->Cell(205,3,'',0,1,'C',true);
				}
								
			}
			

		//Pie de p�gina
		function Footer()
			{
				//Leyenda de derechos reservados
				$this->SetY(-13);
				$this->SetFont('Arial','',8);
				$this->Cell(0,10,'UTVM Derechos Reservados.',0,0,'C');
				//Posici�n: a 1,5 cm del final
				$this->SetY(-10);
				//Arial italic 8
				$this->SetFont('Arial','I',8);
				//N�mero de p�gina
				$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
			}
	}
}

//Creaci�n del objeto de la clase heredada
$pdf=new PDF('P','mm','letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
$pdf->body($rfcDocente);
$pdf->Output();
?>