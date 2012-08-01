<?php 
	session_start();	
 ?>
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
	<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
	<link rel="stylesheet" href="css/bootstrap-responsive.min.css" type="text/css">

	<!-- css application -->
	<link rel="stylesheet" href="css/main.css" type="text/css">

   
   	<!-- js bootstrap framework -->
	<script type='text/javascript' src='js/jquery-1.7.2.min.js'></script> <!-- esta libreria siempre tiene que ir al inicio -->
	<script type='text/javascript' src='js/bootstrap.js'></script>
	<script type='text/javascript' src='js/bootstrap-modal.js'></script>
	<script type='text/javascript' src='js/bootstrap-dropdown.js'></script>


	<!-- js application -->
	<script type='text/javascript' src='js/main.js'></script>

	<!-- YUI -->
	<script src="http://yui.yahooapis.com/3.5.1/build/yui/yui-min.js"></script>

	<?php 
		require_once("lib/librerias.php");
		logIn();
	?>

</head>

<body>

	<!-- barra negro -->
	<div class="navbar">
	    <div class="navbar-inner">
		    <div class="container-fluid">
				<a class="brand" href="#">Programa de Estimulos</a>
				<ul class="nav">
					<li class="active">
						<a id="nombre-persona" href="#">B i e n v e n i d o</a>
					</li>
					<a class="brand-2" href="#"></a>
					
				</ul>
		    </div>
	    </div>
	</div>

	<!-- contenedor principal -->
	<div class="container">
		<div class="row-fluid">
			<div class="seccion5 span9 container row-fluid">
				<div class="seccionconter">
					<div class="textopreda container ">
						<div class="preda " ></div>

							<b>PROGRAMA DE RECONOCIMIENTO Y ESTÍMULO AL DESEMPEÑO DEL PERSONAL ACADÉMICO (PREDA).</b> El presente Programa de Reconocimiento y Estímulo al Desempeño del Personal Académico 
							(PREDA) de la Universidad Tecnológica del Valle del Mezquital, pretende ser un instrumento que propicie la mejora continua y retribuya al personal docente su destacada actuación,
							entrega,  compromiso, alto desempeño y participación; que coadyuve al logro de la misión institucional. Asimismo este documento establece el mecanismo de evaluación, los requisitos
							y criterios requeridos para que un docente de tiempo completo o asignatura pueda participar en el mismo.
						
					</div>
					
					
					
				</div>
				<div class="seccionlarge ">
					<span class="label label-info" "seleccion-documento"="">Importante: Esta aplicaci&oacute;n solo es compatible con los siguientes navegadores.</span>	<br/><br/>
						
						<div class="span2 ">
							<a class="firefox" href="http://www.mozilla.org/es-MX/firefox/new/" target="_blank"></a>
								<div class="span8 seccion3-2-1-2">
									<a class="btn btn-success" title="first tooltip" rel="tooltip" href="http://www.mozilla.org/es-MX/firefox/new/" target="_blank">Descargar</a>
			</div>
						</div>
						<div class="span2 ">
							<a class="chrome" href="https://www.google.com/chrome/" target="_blank"></a>
								<div class="span8 seccion3-2-1-2">
									<a class="btn btn-success" title="first tooltip" rel="tooltip" href="https://www.google.com/chrome/"target="_blank">Descargar</a>
								</div>
						</div>
						<div class="span2 ">
							<a class="safari" href="http://www.apple.com/mx/safari/" target="_blank"></a>
								<div class="span12 seccion3-2-1-2">
									<a  class="btn btn-success" title="first tooltip" rel="tooltip" href="http://www.apple.com/mx/safari/" target="_blank">Descargar</a>
								</div>
						</div>
						<div class="span2 ">
							<a class="opera" href="http://www.opera.com/" target="_blank"></a>
								<div class="span8 seccion3-2-1-2">
									<a class="btn btn-success" title="first tooltip" rel="tooltip" href="http://www.opera.com/" target="_blank">Descargar</a>
								</div>
						</div>
				</div>
			</div>
			<div class="span3 seccion5" id="form-section">
				<div class="seccion1-1-1">
				</div>
				<form class="well" method="post">
					<label>Usuario</label>
					<input class="span12" type="text" placeholder="RFC" name="usuario"/>
					<label>Clave</label>
					<input class="span12" type="password" placeholder="Clave de red" name="clave"/>
					<div class="span5"></div>
					<button class="btn btn-primary" type="submit" >Entrar</button>
				</form>
			</div>
		</div>
	</div>

</body>
</html>