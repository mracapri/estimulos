<?php
	include "content/indicadores_lib.php";
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
	<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
	<link rel="stylesheet" href="css/bootstrap-responsive.min.css" type="text/css">

	<!-- css application -->
	<link rel="stylesheet" href="css/main.css" type="text/css">

   
   	<!-- js bootstrap framework -->
	<script src="js/jquery-1.7.2.min.js"></script>
	<script type='text/javascript' src='js/bootstrap.js'></script>
	<script type='text/javascript' src='js/bootstrap-modal.js'></script>
	<script type='text/javascript' src='js/bootstrap-dropdown.js'></script>

	<!-- js application -->
	<script type='text/javascript' src='js/main.js'></script>

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
						<button class="btn btn-danger">Imprimir Reporte</button>
					</div>
					
					<div class="span1 categorias"></div>
					
					
					<div class="span2 categorias">
						<button class="btn btn-danger">Enviar al Evaluador</button>
					</div>
					
					<div class="span1 categorias"></div>
					
					<div class="span2 categorias">
						<button class="btn btn-danger">Imprimir Acuse</button>
					</div>
					<div class="span2 categorias"></div>
					
				</div>
						
			</div>
			<br/>	
	</div>
	


</body>
</html>