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
	<title>Programa de Estimulos</title>

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

		$categoriaIndicador = $_GET['categoria_indicador'];	
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

					<li class="active">
						<a id="nombre-persona" href="#"><?php echo $_SESSION['nombreUsuario']; ?></a>
					</li>
					<a class="brand" href="#">Evaluación Documentos Indicador</a>
					<div class="span3">
					</div>
					<div class="btn-group pull-right open">
						<a class="btn dropdown-toggle" href="#" data-toggle="dropdown">
							<i class="icon-user"></i>
								Username
						</a>
						<ul class="dropdown-menu">
							<li><a href="#">Perfil</a></li>
							<li><a href="#">Settings</a></li>
							<li><a href="#">Out</a></li>
				</ul>
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
								<a href="#">Guia</a>
						</li>
					</ul>
				</div>
			</div>
			

			<div class="span2">
				 <a href="#">Estado de la captura</a>
			</div>

			<div class="span5">
				<div id="barra-estado" class="progress progress-striped active">
					<div class="bar" style="width: 80%;">
					</div>
				</div>
			</div>

			<div class="span2">
				<button class="btn btn-danger">Cerrar sesion</button>
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
						
							Categoría:
							<a href="#"><?php echo $detalle[1]; ?></a>
	
						</li>
						<li>
							Indicador:
							<a href="#"><?php echo $detalle[2]; ?></a>
	
						</li>
						<li>
							Descripción:
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
						<li>Evaluación</li>
						<li><a href="#">Verifique las evidencias y asigne la calificación</a></li>
					</ul>
				</div>
				<div class="span6 seccion1-2 " >
					<form class="well">
							<label>Elija la calificacion</label>
							<?php 
								echo presentaCalificacion($categoriaIndicador);
							?>
							<label class="checkbox">Incorrecto
								<input type="checkbox" id="incorrecto" name="incorrecto"/>
							</label>
							<textarea class="span4 text-area" placeholder="Comentario" id="input-comentario"></textarea>								
							</form>
						</div>
				<div class="span4" id="boton">
					<div class="row-fluid">
						<div class="span6"></div>
						<div class="span4"></div>	
					<div class="span1">
					<button class="btn btn-danger" id="guardar-evaluacion">Guardar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<form method="post">
			<input type="hidden" name="json-evaluacion" id="json-evaluacion"/>
		</form>	
	</div>

</body>
</html>