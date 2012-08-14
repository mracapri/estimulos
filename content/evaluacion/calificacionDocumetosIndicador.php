<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>

	<!-- Meta -->
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<meta name="author" content="Noemi Mejia, David Perez, Mario Rivera" />
	<meta name="keywords" content="programa de estimulos utvm" />
	<meta name="description" content="Programa de estimulos para Universidad Tecnologica del Valle del Mezquital" />
	<meta name="robots" content="all" />	
	
	<!-- Titulo del documento -->		
	<title>Calificaci&oacute;n de documentos</title>

	<!-- css bootstrap framework -->
	<link rel="stylesheet" href="../../css/bootstrap.min.css" type="text/css">
	<link rel="stylesheet" href="../../css/bootstrap-responsive.min.css" type="text/css">

	<!-- css application -->
	<link rel="stylesheet" href="../../css/main.css" type="text/css">

   
   	<!-- js bootstrap framework -->
	<script type='text/javascript' src='../../js/jquery-1.7.2.min.js'></script> <!-- esta libreria siempre tiene que ir al inicio -->
	<script type='text/javascript' src='../../js/bootstrap.js'></script>
	<script type='text/javascript' src='../../js/bootstrap-modal.js'></script>
	<script type='text/javascript' src='../../js/bootstrap-dropdown.js'></script>	


	<!-- js application -->
	<script type='text/javascript' src='../../js/main.js'></script>

	<!-- YUI -->
	<script src="http://yui.yahooapis.com/3.5.1/build/yui/yui-min.js"></script>

	<?php
		require_once("calificacionDocumetosIndicador_lib.php");
		require_once("../captura/asignaciondocumentos_lib.php");
		require_once("elegirDocenteAEvaluar_lib.php");

		$categoriaIndicador = $_GET['categoria_indicador'];
		$jsonEvaluacion = $_POST['json-evaluacion'];		

		if(!empty($jsonEvaluacion)){
			guardaCalificacion($jsonEvaluacion, $categoriaIndicador);
		}		

		$registroEvaluado = obtieneRegistroEvaluado($categoriaIndicador);
	?>
</head>

<body>

	<!-- barra negro -->
	<div class="navbar">
	    <div class="navbar-inner">
		    <div class="container">
				<a class="brand" href="#">Programa de Estimulos</a>
				<ul class="nav">
				    <li>
				    	<a href="#">Evaluador</a>
				    </li>

					<li class="active2">
						<a id="nombre-persona" href="#"><?php echo $_SESSION['nombreUsuario']; ?></a>
					</li>
					<a class="brand-3" href="#">Evaluando a:  <?php echo obtenerNombreUsuario($_SESSION['rfcDocente']); ?></a>
					<div class="span2 position">
					<div class="btn-group pull-right">
						<a class="btn dropdown-toggle" href="#" data-toggle="dropdown">
							<i class="icon-user"></i>
								<?php echo $_SESSION['rfcEvaluador']; ?>
						</a>
						<ul class="dropdown-menu">
							<li><a href="ventanaEvaluacion.php?rfc=<?php echo $_SESSION['rfcDocente']; ?>">Inicio</a></li>
							<li><a href="elegirDocenteAEvaluar.php">Elegir docente</a></li>
							<li><a href="#" class="cerrar-sesion">Salir</a></li>
				</ul>
					</div>
					</div>
				</ul>
		    </div>
	    </div>
	</div>

	<!-- contenedor principal -->
	<div class="container">
		<div class="row-fluid">
			<div class="span3"> 
				<div class="btn-group">
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
					    Documentos
					<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
					    <li>
							<a href="../recursos/Guia_PREDA_2012.pdf" target="_blank">Guia</a>
						</li>
					</ul>
				</div>
			</div>
			

			<div class="span2">
				 
			</div>

			<div class="span5">

			</div>

			<div class="span2">
				
			</div>
		</div>

		<div id="captura-indicadores" class="container">
			<!-- diseno fluido con bootstrap -->
			<?php 
				$idIndicador = $_GET["id_indicador"];
				$detalle= consultaDetalleIndicador($idIndicador); 
				//echo $detalle;
			?>
			<div class="span6 seccion1">
				<div class="span2 seccion1-1" >
					<ul>
						<li>
						
							Categor&iacute;a:
							<a href="#"><?php echo $detalle[1]; ?></a>
	
						</li>
						<li>
							Indicador:
							<a href="#"><?php echo $detalle[2]; ?></a>
	
						</li>
						<li>
							Descripci&oacute;n:
							<a href="#"><?php echo $detalle[3]; ?></a>
	
						</li>
						<li>
							Puntuacion maxima a obtener:
							<a href="#"><?php echo $detalle[4]; ?></a>
	
						</li>
						
					</ul>
				
				</div>
				<div class="span2 seccion1-2">
					<?php 
						echo consultaArchivosAsignadosHtml($categoriaIndicador); 
					?>
				</div>
			</div>
			<div class="span6 seccion2">
				<div class="span2 seccion1-1" >
					<ul>
						<li>Evaluaci&oacute;n</li>
						<li><a href="#">Verifique las evidencias y asigne la calificaci&oacute;n</a></li>
					</ul>
				</div>
				<div class="span6 seccion1-2 " >
					<form class="well">
							<label>Elija la calificacion</label>
							<?php 							
								echo presentaCalificacion($categoriaIndicador, $registroEvaluado);
							?>
							<label class="checkbox">Incorrecto
								<input type="checkbox" id="incorrecto" name="incorrecto" <?php if(!empty($registroEvaluado)){ if($registroEvaluado[6] == 1){ echo "checked"; } } ?>/>
							</label>
							<textarea class="span4 text-area" placeholder="Comentario" id="input-comentario"><?php if(!empty($registroEvaluado)){ echo $registroEvaluado[7]; } ?></textarea>							
					</form>
				</div>
				<div class="span4" id="boton">
					<div class="row-fluid">
						<div class="span6"></div>
						<div class="span4"></div>	
					<div class="span1">
					<button class="btn btn-danger" id="guardar-evaluacion" <?php if(elEvaluadorAEvaluadoAlDocente($_SESSION['rfcDocente'])){ echo "disabled"; } ?>>Guardar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<form id="form-calificacion" method="post">
			<input type="hidden" name="json-evaluacion" id="json-evaluacion"/>
		</form>	
	</div>

</body>
</html>