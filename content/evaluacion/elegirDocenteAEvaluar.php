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
		require_once("../../lib/librerias.php");
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
					<a class="brand" href="#">Elegir Docente a Evaluar</a>
					<div class="span4">
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
			<div class="span12 seccion3">
				<div class="span2 secciontext">
					<ul>
						<li>
							<p class="formato">Docentes a evaluar</p>
						</li>
						<li>
							<a href="#">Elegir docente a evaluar</a>
						</li>
					</ul>
				</div>
				<div class="span11 seccion3-1">
					<div class="span1 seccion1-3">
						<span class="label label-info" "seleccion-documento">Evaluado</span>
						<div class="usuario">
							<a href='http://localhost/estimulos/content/evaluacion/VentanaEvaluacion.php' class='usuario'></a>
						</div>
						<div class="span1 seccion3-3">
							<a href="#">Nombredocente</a>
					</div>
					</div>
					<div class="span1 seccion1-3">
						<span class="label label-important" "seleccion-documento">Sin evaluar</span>
						<div class="usuario">
							<a href='#' class='usuario'></a>
						</div>
						<div class="span1 seccion3-3">
							<a href="#">Nombredocente</a>
					</div>
					</div>
					<div class="span1 seccion1-3">
						<span class="label label-info" "seleccion-documento">Evaluado</span>
						<div class="usuario">
							<a href='#' class='usuario'></a>
						</div>
						<div class="span1 seccion3-3">
							<a href="#">Nombredocente</a>
					</div>
					</div>
					<div class="span1 seccion1-3">
						<span class="label label-info" "seleccion-documento">Evaluado</span>
						<div class="usuario">
							<a href='#' class='usuario'></a>
						</div>
						<div class="span1 seccion3-3">
							<a href="#">Nombredocente</a>
					</div>
					</div>
					<div class="span1 seccion1-3">
						<span class="label label-info" "seleccion-documento">Evaluado</span>
						<div class="usuario">
							<a href='#' class='usuario'></a>
						</div>
						<div class="span1 seccion3-3">
							<a href="#">Nombredocente</a>
					</div>
					</div>
					<div class="span1 seccion1-3">
						<span class="label label-info" "seleccion-documento">Evaluado</span>
						<div class="usuario">
							<a href='#' class='usuario'></a>
						</div>
						<div class="span1 seccion3-3">
							<a href="#">Nombredocente</a>
					</div>
					</div>
					<div class="span1 seccion1-3">
						<span class="label label-info" "seleccion-documento">Evaluado</span>
						<div class="usuario">
							<a href='#' class='usuario'></a>
						</div>
						<div class="span1 seccion3-3">
							<a href="#">Nombredocente</a>
					</div>
					</div>
					<div class="span1 seccion1-3">
						<span class="label label-info" "seleccion-documento">Evaluado</span>
						<div class="usuario">
							<a href='#' class='usuario'></a>
						</div>
						<div class="span1 seccion3-3">
							<a href="#">Nombredocente</a>
					</div>
					</div>
					<div class="span1 seccion1-3">
						<span class="label label-info" "seleccion-documento">Evaluado</span>
						<div class="usuario">
							<a href='#' class='usuario'></a>
						</div>
						<div class="span1 seccion3-3">
							<a href="#">Nombredocente</a>
					</div>
					</div>
					<div class="span1 seccion1-3">
						<span class="label label-info" "seleccion-documento">Evaluado</span>
						<div class="usuario">
							<a href='#' class='usuario'></a>
						</div>
						<div class="span1 seccion3-3">
							<a href="#">Nombredocente</a>
					</div>
					</div>
					<div class="span1 seccion1-3">
						<span class="label label-info" "seleccion-documento">Evaluado</span>
						<div class="usuario">
							<a href='#' class='usuario'></a>
						</div>
						<div class="span1 seccion3-3">
							<a href="#">Nombredocente</a>
					</div>
						</div>
					<div class="span1 seccion1-3">
						<span class="label label-important" "seleccion-documento">Sin evaluar</span>
						<div class="usuario">
							<a href='#' class='usuario'></a>
					</div>
						<div class="span1 seccion3-3">
							<a href="#">Nombredocente</a>
						</div>
					</div>
					<div class="span1 seccion1-3">
						<span class="label label-important" "seleccion-documento">Sin evaluar</span>
						<div class="usuario">
							<a href='#' class='usuario'></a>
						</div>
						<div class="span1 seccion3-3">
							<a href="#">Nombredocente</a>
					</div>
						</div>
					<div class="span1 seccion1-3">
						<span class="label label-important" "seleccion-documento">Sin evaluar</span>
						<div class="usuario">
							<a href='#' class='usuario'></a>
					</div>
						<div class="span1 seccion3-3">
							<a href="#">Nombredocente</a>
						</div>
					</div>
					<div class="span1 seccion1-3">
						<span class="label label-important" "seleccion-documento">Sin evaluar</span>
						<div class="usuario">
							<a href='#' class='usuario'></a>
						</div>
						<div class="span1 seccion3-3">
							<a href="#">Nombredocente</a>
						</div>
					</div>
			</div>
		</div>	
	</div>

</body>
</html>