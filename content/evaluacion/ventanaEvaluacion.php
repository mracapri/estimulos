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
	<title>Evaluador</title>

	<!-- css bootstrap framework -->
	<link rel="stylesheet" href="../../css/bootstrap.min.css" type="text/css">
	<link rel="stylesheet" href="../../css/bootstrap-responsive.min.css" type="text/css">

	<!-- css application -->
	<link rel="stylesheet" href="../../css/main.css" type="text/css">

   
   	<!-- js bootstrap framework -->
	<script src="../../js/jquery-1.7.2.min.js"></script>
	<script type='text/javascript' src='../../js/bootstrap.js'></script>
	<script type='text/javascript' src='../../js/bootstrap-modal.js'></script>
	<script type='text/javascript' src='../../js/bootstrap-dropdown.js'></script>

	<!-- js application -->
	<script type='text/javascript' src='../../js/main.js'></script>

	<!-- YUI -->
	<script src="http://yui.yahooapis.com/3.5.1/build/yui/yui-min.js"></script>
	
	<?php
		require_once("ventanaEvaluacion_lib.php");
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
					<a class="brand" href="#">Evaluación</a>
					<div class="span6">
					</div>
					<div class="btn-group pull-right open">
						<a class="btn dropdown-toggle" href="#" data-toggle="dropdown">
							<i class="icon-user"></i>
								<?php echo $_SESSION['rfcDocente']; ?>
						</a>
						<ul class="dropdown-menu">
							<li><a href="ventanaEvaluacion.php">Inicio</a></li>
							<li><a href="elegirDocenteAEvaluar.php">Elegir docente</a></li>
							<li><a href="#">Cerrar Sesión</a></li>
						</ul>
					</div>
				</ul>
		    </div>
	    </div>
	</div>

	<!-- contenedor principal -->
	<div class="container">
		<div class="row-fluid">
			    <div class="span2 categorias">
					<div class="btn-group">
					    <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
					    Documentos
					    <span class="caret"></span>
					    </a>
					    <ul class="dropdown-menu">
							<li>
								<a href="../recursos/GuiaE_DPA_2010_3.pdf" target="_blank">Guia</a>
							</li>
					    </ul>
					 </div>
				</div>
			    <div class="span2 categorias">
				   	<a href="#">Estado de la captura</a>
				</div>
				<div class="span6 categorias">
					<div id="barra-estado" class="progress progress-striped active">
						<div class="bar" style="width: <?php echo "20%"?> 	;">
						</div>	
					</div>
				</div>
				<div class="span2 categorias">
				    
			   	</div>
		</div>
			
			<!--Contenido de categorias e Indicadores-->
			
			
			<div id="indicadores" class="container">
				<!--Linea de encabezado-->
					<div class="row-fluid" id="indicadores-headers">
						<div class="span2" id="encabezado">
							Categorias
						</div>
						<div class="span1" id="encabezado">	
							Porcentaje Categoria
						</div>
						<div class="span3" id="encabezado">
							Indicador
						</div>
						<div  class="span1" id="encabezado">
							Porcentaje Indicador
						</div>
						<div  class="span2" id="encabezados">
							Estado
						</div>
						<div class="span2" id="encabezado">
							Observacion
						</div>
						<div class="span1" id="encabezado">
							Ver
						</div>
					</div>
					
					
				<!--Separador-->
					<div class="navbar-separador">
						
					</div>
					
				<?php echo generaIndicadoresHtml(); ?>
			</div>
			<br/>	
			
			<!--Botones -->
				<div class="row-fluid show-grid">
					<div class="span2 categorias"></div>
					
					<div class="span12 categorias">
						<button class="btn btn-danger">Imprimir Reporte</button>
					</div>
					
					
				</div>
	</div>
</body>
</html>