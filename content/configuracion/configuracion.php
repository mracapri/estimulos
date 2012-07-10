<?php
	include "configuraciones_lib.php";
?>
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
	<link rel="stylesheet" href="/css/bootstrap.min.css" type="text/css">
	<link rel="stylesheet" href="/css/bootstrap-responsive.min.css" type="text/css">

	<!-- css application -->
	<link rel="stylesheet" href="/css/main.css" type="text/css">

   
   	<!-- js bootstrap framework -->
	<script src="/js/jquery-1.7.2.min.js"></script>
	<script type='text/javascript' src='/js/bootstrap.js'></script>
	<script type='text/javascript' src='/js/bootstrap-modal.js'></script>
	<script type='text/javascript' src='/js/bootstrap-dropdown.js'></script>

	<!-- js application -->
	<script type='text/javascript' src='/js/main.js'></script>

	<!-- YUI -->
	<script src="http://yui.yahooapis.com/3.5.1/build/yui/yui-min.js"></script>

	<style type="text/css">
#controles-configuracion div[class*=span] {
    border: 1px solid;
}
	</style>
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
								<a href="#">Guia</a>
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
				    <button class="btn btn-danger">Cerrar sesion</button>
			   	</div>
		</div>
			
		<!-- Contenido de configuracion -->
		<div id="controles-configuracion" class="container">
		    <div class="row-fluid">
			    <div class="span12">
				    <div class="row-fluid">
		    			<div class="span4">
		    				<form class="well">
								<input name="input-descripcion" type="text" class="span12" placeholder="Descripcion">
								<input name="input-anio" type="text" class="span12" placeholder="Anio">
								<input name="input-fecha-captura" type="text" class="span12" placeholder="Fecha captura">
								<input name="input-fecha-limite-captura" type="text" class="span12" placeholder="Fecha limite captura">
								<input name="input-fecha-evaluacion" type="text" class="span12" placeholder="Fecha evaluacion">
								<input name="input-fecha-limite-evaluacion" type="text" class="span12" placeholder="Fecha limite evaluacion">
								<button type="submit" class="btn">Nueva</button>
								<button type="submit" class="btn btn-info">Guardar</button>
								<button type="submit" class="btn btn-danger">Cancelar</button>
		    				</form>
		    				<div class="span">
		    					<ul>
		    						<li>Evaluacion 2010</li>
		    						<li>Evaluacion 2011</li>
		    						<li>Evaluacion 2012</li>
		    						<li>Evaluacion 2013</li>
		    						<li>Evaluacion 2014</li>
		    					</ul>
		    				</div>
		    			</div>
		    			<div class="span4">

		    			</div>
		    			<div class="span4">

		    			</div>
		    		</div>
		    	</div>
		    </div>
		</div>
	


</body>
</html>