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
	<title>Perfil Docente</title>

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
		require_once("indicadores_lib.php");

		$evaluacionEnviada = $_POST['evaluacion-eviada'];
		if(!empty($_POST['evaluacion-eviada'])){
			// Enviar y cerrar evaluacion
			enviarEvaluacion();
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
					<a class="brand-2" href="#">Asignaci�n de evidencias </a>
					<div class="span2 position">
					<div class="btn-group pull-right">
						<a class="btn dropdown-toggle" href="#" data-toggle="dropdown">
							<i class="icon-user"></i>
								<?php echo $_SESSION['rfcDocente']; ?>
						</a>
						<ul class="dropdown-menu">
							<li><a href="indicadores.php">Inicio</a></li>
							<li><a href="#" class="cerrar-sesion">Cerrar Sesi�n</a></li>
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
						<div class="bar" style="width: <?php echo obtenerPorcentajeDeCaptura($_SESSION['rfcDocente'])."%"; ?> 	;">
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
						<div class="span3" id="encabezado">
							Categorias
						</div>
						<div class="span1" id="encabezado">	
							Porcentaje Categoria
						</div>
						<div class="span4" id="encabezado">
							Indicador
						</div>
						<div  class="span1" id="encabezado">
							Porcentaje Indicador
						</div>
						<div  class="span2" id="encabezado">
							Estado
						</div>
						<div class="span1" id="encabezado">
							Ver
						</div>
					</div>
					
					
				<!--Separador-->
					<div class="navbar-separador">
						
					</div>
					
				<?php echo generaIndicadoresHtml(); ?>

				
					<!--Botones -->
				<div class="row-fluid show-grid">
					<div class="span2 categorias"></div>
					
					<div class="span2 categorias">
						<button class="btn btn-danger">Imprimir reporte</button>
					</div>
					
					<div class="span1 categorias"></div>
					
					
					<div class="span2 categorias">
						<form id="form-enviar-al-evaluador" method="post">
							<button class="btn btn-danger" id="enviar-al-evaluador" <?php if(obtenerEstadoDeLaEvaluacion() == 1){ echo "disabled"; }?>>Enviar al evaluador</button>
							<input name="evaluacion-eviada" value="1" type="hidden"/>
						</form>
					</div>
					
					<div class="span1 categorias"></div>
					
					<div class="span2 categorias">
						<button class="btn btn-danger" <?php if(obtenerEstadoDeLaEvaluacion() == 0){ echo "disabled"; }?>>Imprimir acuse</button>
					</div>
					<div class="span2 categorias"></div>
				</div>
						
			</div>
			<br/>	
	</div>

	<?php 
		if($_SESSION['mensajeLegal'] == 0){ 
			$_SESSION['mensajeLegal'] = 1;
	?>

    <div class="modal hide" id="protesta-modal">
    	<div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal">�</button>
    		<h3>Importante</h3>
    	</div>
    	<div class="modal-body">
    		<p id="protesta">
				Se firma bajo protesta de decir verdad que la informaci�n  rendida es 
				cierta en todas y cada una de las partes que contiene para mi persona 
				el �Programa de Est�mulos� de la Universidad Tecnol�gica del Valle del 
				Mezquital. 

				Por lo que a la vez, se les hace del conocimiento el contenido del 
				Art�culo 313 del C�digo Penal para el Estado de Hidalgo, que establece 
				las sanciones penales cuando se emita informaci�n falsa ante autoridad 
				que act�a en funci�n de sus atribuciones legales, textualmente: 
				<a href="../recursos/articulo-313.html" target="_blank">Articulo 133</a>
    		</p>
    	</div>
    	<div class="modal-footer">
    		<a href="#" class="btn" data-dismiss="modal">Aceptar</a>
    	</div>
    </div>

    <?php 
		} 
    ?>

</body>
</html>