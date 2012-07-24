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
	<title>Asignación de documentos</title>

	<!-- css bootstrap framework -->
	<link rel="stylesheet" href="../../css/bootstrap.min.css" type="text/css">
	<link rel="stylesheet" href="../../css/bootstrap-responsive.min.css" type="text/css">

	<!-- css application -->
	<link rel="stylesheet" href="../../css/main.css" type="text/css">

   
   	<!-- js bootstrap framework -->
	<script type='text/javascript' src='../../js/jquery-1.7.2.min.js'></script> <!-- esta libreria siempre tiene que ir al inicio -->
	<script type='text/javascript' src='../../js/bootstrap.js'></script>
	<script type='text/javascript' src='../../js/bootstrap-modal.js'></script>
	<script type='text/javascript' src='../../js/bootstrap-tooltip.js'></script>
	<script type='text/javascript' src='../../js/bootstrap-dropdown.js'></script>
	<script type='text/javascript' src='../../js/jquery-ui-1.8.16.custom.min.js'></script>	
	<script type='text/javascript' src='../../js/json2.js'></script>


	<!-- js application -->
	<script type='text/javascript' src='../../js/main.js'></script>

	<!-- YUI -->
	<script src="http://yui.yahooapis.com/3.5.1/build/yui/yui-min.js"></script>

	<?php
		require_once("asignaciondocumentos_lib.php");

		$jsonAsignacion = $_POST['json_asignacion'];	
		$categoriaIndicador = $_GET['categoria_indicador'];	

		if(!empty($jsonAsignacion)){
			guardarAsignacion($jsonAsignacion, $categoriaIndicador);
		}
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
				    	<a href="#">Docente</a>
				    </li>

					<li class="active">
						<a id="nombre-persona" href="#"><?php echo $_SESSION['nombreUsuario']; ?></a>
					</li>
					
						<a href="#" class="brand-2">Asignación de documentos a indicadores</a>
					
					<div class="span2 position">
					<div class="btn-group pull-right open">
						<a class="btn dropdown-toggle" href="#" data-toggle="dropdown">
							<i class="icon-user"></i>
								<?php echo $_SESSION['rfcDocente']; ?>
						</a>
						<ul class="dropdown-menu">
							<li><a href="indicadores.php">Inicio</a></li>
							<li><a href="#">Cerrar Sesión</a></li>
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
								<a href="../recursos/GuiaE_DPA_2010_3.pdf" target="_blank">Guia</a>
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
							Puntuación máxima a obtener: 
							<a href="#"><?php echo $detalle[4]; ?></a>
						</li>
						
					</ul>
				
				</div>
				<div class="span2 seccion1-2" id="documentos-asignados">
					<!-- documentos asgindos --> 
					<?php echo consultaArchivosAsignadosHtml($categoriaIndicador); ?>
					<!-- termina documentos asignados --> 
				</div>
					<div class="row-fluid">
						<div class="span6"></div>
						<div class="span3"></div>
					<div class="span2">
						<button class="btn btn-danger" id="quitar-documento">Remover</button>
			</div>
			</div>
				
			</div>
			<div class="span6 seccion2">
				<div class="span2 seccion1-1" >
					<ul>
						<li>Documentos</li>
						<li>Seleccione los documentos</li>
					</ul>
				</div>
				<div class="span2 seccion1-2" id="documentos-trayectorias">
					<!-- documentos de trayectorias --> 
					<?php echo consultaArchivosHtml(); ?>
					<!-- termina documentos de trayectorias --> 
				</div>
				<div class="row-fluid">
					<div class="span6"></div>
					<div class="span3"></div>	
					<div class="span1">
						<button class="btn btn-primary" id="agregar-documento">Agregar</button>
					</div>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span6"></div>
				<div class="span4"></div>
					<form id="form-guardar-asignacion" method="post">
						<button id="guardar-cambios-asignacion" class="btn btn-primary" type="button">Guardar Cambios</button>
						<input id="json_asignacion" name="json_asignacion" type="hidden"/>
						<input id="categoia_indicador" name="categoria_indicador" type="hidden" value="<?php echo $categoriaIndicador; ?>"/>
					</form>
				</div>
			</div>
		</div>	
	</div>

</body>
</html>