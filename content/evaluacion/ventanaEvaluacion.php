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
	<script type='text/javascript' src='../../js/main.php'></script>

	<!-- YUI -->
	<script src="http://yui.yahooapis.com/3.5.1/build/yui/yui-min.js"></script>
	
	<?php
		require_once("ventanaEvaluacion_lib.php");
		if(!verificarSesionDelUsuario()){ die(); };

		// mantiene en sesion el rfc del docente a evaluar
		$_SESSION['rfcDocente'] = $_GET["rfc"];

		$comentarioFinal = $_POST['input-comentario'];

		if(!empty($comentarioFinal)){
			terminarEvaluacion($_SESSION['rfcDocente'], $comentarioFinal);			
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
				    	<a href="#">Evaluador</a>
				    </li>

					<li class="active2">
						<a id="nombre-persona" href="#"><?php echo $_SESSION['nombreUsuario']; ?></a>
					</li>
					<a class="brand-3" href="#">Evaluando a: <?php echo obtenerNombreUsuario($_SESSION['rfcDocente']); ?></a>
					<div class="span2 position">
					<div class="btn-group pull-right">
						<a class="btn dropdown-toggle" href="#" data-toggle="dropdown">
							<i class="icon-user"></i>
								<?php echo $_SESSION['rfcEvaluador']; ?>
						</a>
						<ul class="dropdown-menu">
							<li><a href="elegirDocenteAEvaluar.php">Elegir docente</a></li>
							<li><a href="#" class="cerrar-sesion">Cerrar Sesi&oacute;n</a></li>
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
			    <div class="span2 categorias">
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
			    <div class="span2 categorias">
				   	<a href="#">Estado de la evaluaci&oacute;n</a>
				</div>
				<div class="span6 categorias">
					<div id="barra-estado" class="progress progress-striped active">
						<div class="bar" style="width: <?php echo obtenerPorcentajeDeEvaluacion($_SESSION['rfcDocente'])."%"; ?> 	;">
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
							Porcentaje Categor&iacute;a
						</div>
						<div class="span3" id="encabezado">
							Indicador
						</div>
						<div  class="span1" id="encabezado">
							Porcentaje Indicador
						</div>
						<div  class="span1" id="encabezado">
							Estado
						</div>
						<div  class="span1" id="encabezado">
							Porcentaje Obtenido
						</div>
						<div class="span2" id="encabezado">
							Observaci&oacute;n
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
					<div class="span2 categorias">
						<a href="../reportes/reportedeevaluacion.php" target="_blank" class="btn btn-danger">Imprimir Reporte</a>
					</div>
					<div class="span4 categorias"></div>
					<div class="span4 categorias"></div>
					<div class="span2 categorias">
						<button class="btn btn-danger" id="terminar-evaluacion" <?php if(elEvaluadorAEvaluadoAlDocente($_SESSION['rfcDocente'])){ echo "disabled"; } ?> >Terminar Evaluaci&oacute;n</button>
					</div>
				</div>
	</div>
	
	<div class="modal hide" id="informacion">
    	<div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal">×</button>
    		<?php 
    			$porcentajeCaptura = obtenerPorcentajeDeCaptura($_SESSION['rfcDocente']);
    			$porcentajeRestante = 100 - $porcentajeCaptura;
    		?>
    		<p>
    				Estimado Evaluador, el usuario evaluado, captur&oacute; el 
    				<?php echo $porcentajeCaptura; ?>% de los indicadores y el 
    				<?php echo $porcentajeRestante ;?>%, que son los no 
    				capturados, se muestran a continuaci&oacute;n:
    		</p>
    	</div>
    	<div class="modal-body">
			<div class="contenedor-tablas">
			<table class="table">
				<thead>
					<tr>
						<th>#</th>
						<th>Categoria</th>
						<th>Indicador</th>
					</tr>
				</thead>
				<tbody>
					<?php echo obtieneIndicadoresNoEvaluados(); ?>
				</tbody>	
			</table>
			</div>
			<form id="form-terminar-evaluacion" method="post">
				<textarea id="input-comentario" name="input-comentario" class="span4 text-area" placeholder="Comentario final" style="width: 500px; height: 96px;"></textarea>
			</form>
			<div id="alerta-caomentario-obligatorio" class="alert alert-error hide">Comentario obligatorio</div>
    	</div>
    	<div class="modal-footer">    		
			<button class="btn" data-dismiss="modal" id="btn-terminar-evaluacion">Terminar</button>
		</div>
	</div>
</body>
</html>