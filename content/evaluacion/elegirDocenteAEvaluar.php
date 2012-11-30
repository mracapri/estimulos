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
	<title>Docente a evaluar</title>

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
	<script type='text/javascript' src='../../js/main.php'></script>

	<!-- YUI -->
	<script src="http://yui.yahooapis.com/3.5.1/build/yui/yui-min.js"></script>

	<?php
		require_once("../../lib/librerias.php");
		if(!verificarSesionDelUsuario()){ die(); };
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
					<a class="brand-2" href="#">Elegir docente a evaluar</a>
					<div class="span2 position">
					<div class="btn-group pull-right">
						<a class="btn dropdown-toggle" href="#" data-toggle="dropdown">
							<i class="icon-user"></i>
								<?php echo $_SESSION['rfcEvaluador']; ?>
						</a>
						<ul class="dropdown-menu">
							<li><a href="elegirDocenteAEvaluar.php">Inicio</a></li>
							<li><a href="elegirDocenteAEvaluar.php?killsession=1" class="cerrar-sesion">Cerrar Sesi&oacute;n</a></li>
							<li><a href="#"></a></li>
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
				require_once("elegirDocenteAEvaluar_lib.php");
				verificarSesionDelUsuario();
			?>
			<div class="span12 seccion3">
				<div class="span5 secciontext">
					<ul>
						<li>
							<p class="formato">Docentes a evaluar</p>
							<a href="#" id="enviadas">
								Enviadas
							</a>
							-
							<a href="#" id="no-enviadas">
								No Enviadas
							</a>
							-
							<a href="#" id="evaluadas">
								Evaluadas
							</a>
							-
							<a href="#" id="todas">
								Todas
							</a>
						</li>
					</ul>					
				</div>
				<div class="span11 seccion3-1">
					<?php echo consultaDocentesAEvaluar(); ?>
				</div>
			</div>
		</div>
</body>
</html>