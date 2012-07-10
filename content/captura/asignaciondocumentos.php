<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
 "http://www.w3.org/TR/html4/strict.dtd">
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
	<script type='text/javascript' src='../../js/jquery-ui-1.8.21.custom.min.js'></script>	


	<!-- js application -->
	<script type='text/javascript' src='../../js/main.js'></script>

	<!-- YUI -->
	<script src="http://yui.yahooapis.com/3.5.1/build/yui/yui-min.js"></script>

</head>

<body>

	<!-- barra negro -->
	<div class="navbar">
	    <div class="navbar-inner">
		    <div class="container">
				<a class="brand" href="#">Programa de Estimulos</a>
				<ul class="nav">
				    <li>
				    	<a href="#">Docente</a>
				    </li>

					<li class="active">
						<a id="nombre-persona" href="#">Mario Rivera Angeles</a>
					</li>
					<li class="brand">
					<a href="#">Asignación de Documentos a Indicadores</a>
					</li>
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
			<div class="span6 seccion1">
				<div class="span2 seccion1-1" >
					<ul>
						<li>
						
							Categoría:
							<a href="#">cat</a>
	
						</li>
						<li>
							Indicador:
							<a href="#">indicador</a>
	
						</li>
						<li>
							Descripción:
							<a href="#">des</a>
	
						</li>
						<li>
							Puntuación máxima a obtener: 
							<a href="#">punt</a>
	
						</li>
						
					</ul>
				
				</div>
				<div class="span2 seccion1-2">
					<div class="span1 seccion1-3" >
						<span class="seleccion-documento"><input type="checkbox" /></span>
						<span class="etiqueta-documento">
							asdff dfv x
						</span>
					</div>
					<div class="span1 seccion1-3">
					</div>
					<div class="span1 seccion1-3">
					</div>
					<div class="span1 seccion1-3">
					</div>
					<div class="span1 seccion1-3">
					</div>
					<div class="span1 seccion1-3">
					</div>
					<div class="span1 seccion1-3">
					</div>
					<div class="span1 seccion1-3">
					</div>
					<div class="span1 seccion1-3">
					</div>
					<div class="span1 seccion1-3">
					</div>
					<div class="span1 seccion1-3">
					</div>
					<div class="span1 seccion1-3">
					</div>
					<div class="span1 seccion1-3">
					</div>
					<div class="span1 seccion1-3">
					</div>
					<div class="span1 seccion1-3">
					</div>
					<div class="span1 seccion1-3">
					</div>
					<div class="span1 seccion1-3">
					</div>
				</div>
				<div class="span2" >
					<button class="btn btn-danger">Guardar</button>
				</div>
			</div>
			<div class="span6 seccion2">
				<div class="span2 seccion1-1" >
					<ul>
						<li>Documentos</li>
						<li>Seleccione los documentos y arrástrelos a la izquierda</li>
					</ul>
				</div>
				<div class="span2 seccion1-2" >
					<div class="span1 seccion1-3">	
						<span class="seleccion-documento"><input type="checkbox" /></span>
					</div>
					<div class="span1 seccion1-3">
					</div>
					<div class="span1 seccion1-3">
					</div>
					<div class="span1 seccion1-3">	
					</div>
					<div class="span1 seccion1-3">
					</div>
					<div class="span1 seccion1-3">
					</div>
					<div class="span1 seccion1-3">
					</div>
					<div class="span1 seccion1-3">
					</div>
					<div class="span1 seccion1-3">
					</div>
					<div class="span1 seccion1-3">
					</div>
				</div>
			</div>
		</div>	
	</div>

</body>
</html>