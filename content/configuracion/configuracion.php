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
	<title>Mantenimiento</title>

	<!-- css bootstrap framework -->
	<link rel="stylesheet" href="../../css/bootstrap.min.css" type="text/css">
	<link rel="stylesheet" href="../../css/bootstrap-responsive.min.css" type="text/css">

	<!-- css application -->
	<link rel="stylesheet" href="../../css/main.css" type="text/css">

   
   	<!-- js bootstrap framework -->
	<script type='text/javascript' src="../../js/jquery-1.7.2.min.js"></script>
	<script type='text/javascript' src='../../js/bootstrap.js'></script>
	<script type='text/javascript' src='../../js/bootstrap-modal.js'></script>
	<script type='text/javascript' src='../../js/bootstrap-dropdown.js'></script>
	<script type='text/javascript' src='../../js/bootstrap-alert.js'></script>
	<script type='text/javascript' src='../../js/bootstrap-tooltip.js'></script>
	<script type='text/javascript' src='../../js/bootstrap-popover.js'></script>	

	<!-- js application -->
	<script type='text/javascript' src='../../js/main.php'></script>

	<!-- YUI -->
	<script src="http://yui.yahooapis.com/3.5.1/build/yui/yui-min.js"></script>
	
	<?php
		require_once("configuraciones_lib.php");
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
				    	<a href="#">Admin.</a>
				    </li>

					<li class="active">
						<a id="nombre-persona" href="#"><?php echo $_SESSION['nombreUsuario']; ?></a>
					</li>
					<a class="brand-2" href="#">Mantenimiento</a>
					<div class="span2 position">
					<div class="btn-group pull-right">
						<a class="btn dropdown-toggle" href="#" data-toggle="dropdown">
							<i class="icon-user"></i>
								<?php echo $_SESSION['rfcDocente']; ?>
						</a>
						<ul class="dropdown-menu">
							<li><a href="configuracion.php">Inicio</a></li>
							<li><a href="#" class="cerrar-sesion">Cerrar Sesi&oacute;n</a></li>
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
				</div>
			    <div class="span2 categorias">
				</div>
				<div class="span6 categorias">
				</div>
				<div class="span2 categorias">
			   	</div>
		</div>
			
		<!-- Contenido de configuracion -->
		<div id="controles-configuracion" class="container">
		    <div class="row-fluid">
			    <div class="span12">
				    <div class="row-fluid">
		    			<div class="span4">
	    					<span class="badge badge-info">1</span>
	    					<b>Generar la evaluaci&oacuten respecto al anio actual</b>
		    				<br/><br/>	
							<span class="label label-important">Importante</span> 
							El generar una nueva evaluaci&oacuten, se limpiar&aacute la 
							tabla de participantes y evaluadores
							<br/><br/>

		    				<form class="well" method="post">
		    					<label>Descripcion</label>
								<input id="input-descripcion" name="input-descripcion" type="text" class="span12" value="<?php echo $inputDescripcion; ?>">
								<label>Anio</label>
								<input name="input-anio" placeholder="AAAA" type="text" class="span12" value="<?php echo $inputAnio; ?>">
								<label>Fecha captura</label>
								<input name="input-fecha-captura" placeholder="AAAA-MM-DD" type="text" class="span12" value="<?php echo $inputFechaCaptura; ?>">
								<label>Fecha limite captura</label>
								<input name="input-fecha-limite-captura" placeholder="AAAA-MM-DD" type="text" class="span12" value="<?php echo $inputFechaLimiteCaptura; ?>">
								<label>Fecha evaluacion</label>
								<input name="input-fecha-evaluacion" placeholder="AAAA-MM-DD" type="text" class="span12" value="<?php echo $inputFechaEvaluacion; ?>">
								<label>Fecha limite evaluacion</label>
								<input name="input-fecha-limite-evaluacion" placeholder="AAAA-MM-DD" type="text" class="span12" value="<?php echo $inputFechaLimiteEvaluacion; ?>">

								<!-- botonos del formulario -->
								<button type="button" class="btn btn-info" id="btn-guardar">Guardar</button>
								<button type="button" class="btn btn-danger">Cancelar</button>

								<!-- campos ocultos -->
								<input id="guardar-evaluacion" name="guardar-evaluacion" type="hidden">


								<!-- Vetana modal -->
								<div class="modal hide" id="modal-evaluaciones">
									<div class="modal-header">
										<h3>Evaluaciones</h3>
									</div>
									
									<div class="modal-body">
										<p>Esta seguro de capturar la informacion</p>
									</div>
									<div class="modal-footer">
										<a href="#" class="btn" data-dismiss="modal">No</a>
										<button id="btn-guardar-si" type="submit" class="btn">Si</button>
									</div>
								</div>

		    				</form>


		    				<?php 
		    					if(!empty($resultado)){
		    						echo $resultado;
		    					}
		    				 ?>

	    					<!-- tabla de periodos -->
							<table class="table">
								<thead>
									<tr>
										<th>#</th>
										<th>periodo</th>
									</tr>
								</thead>
								<tbody>
									<?php echo consultaEvaluaciones(); ?>
								</tbody>
							</table>

		    			</div>

		    			<div class="span4">
		    				<div class="span12">
		    					<span class="badge badge-info">2</span>
		    					<b>Cargar los particpantes del periodo actual</b>
		    				</div>
		    				<div class="span12">
		    					<form id="form-eliminar-participantes" method="post">
		    						<input id="eliminar-participantes" name="eliminar-participantes" type="hidden" />
		    					</form>
								<form method="post">
									<button type="submit" class="btn" id="btn-cargar-usuarios">Cargar participantes</button>
									<br/><br/>
									<span class="label label-important">Importante</span> 
									Para eliminar a los participantes, es necesario seleccionarlos y presionar el boton "Eliminar participantes"
									<br/>
									<br/>
									<button class="btn" type="button" id="btn-eliminar-participantes">Eliminar participantes</button>
									<br/>
									<a id="seleccionar-todos-participantes">Seleccionar todos</a>
									<b>|</b>
									<a id="eliminar-seleccion-participantes">Eliminar selecci&oacuten</a>
									<!-- botonos ocultos de la forma -->
									<input id="guardar-permiso" name="cargar-usuarios" type="hidden">

									<!-- permisos especiales -->
									<table class="table">
										<thead>
											<tr>
												<th>#</th>
												<th>Docente</th>
												<th>Participaci&oacuten</th>
											</tr>
										</thead>
										<tbody>
											<?php echo consultaParticipantes(); ?>
										</tbody>
									</table>
								</form>
		    				</div>
		    			</div>

		    			<div class="span4">
		    				<div class="span12">
								<button type="submit" class="btn" id="btn-agregar-permiso">Agregar Permisos</button>
								<!-- permisos especiales -->
								<table class="table">
									<thead>
										<tr>
											<th>#</th>
											<th>Docente</th>
										</tr>
									</thead>
									<tbody>
										<?php echo consultaPermisosEspeciales(); ?>
									</tbody>
								</table>

								<form method="post">
									<!-- Vetana modal -->
									<div class="modal hide" id="modal-permisos">
										<div class="modal-header">
											<h3>Permisos especiales</h3>
										</div>
										
										<div class="modal-body">
											<p>Introduzca el RFC</p>
											<input name="input-rfc-permisos" type="text" class="span12"/>
										</div>
										<div class="modal-footer">
											<a href="#" class="btn" data-dismiss="modal">No</a>
											<button id="btn-guardar-si-permisos" type="submit" class="btn">Si</button>
										</div>
									</div>

									<!-- botonos ocultos de la forma -->
									<input id="guardar-permiso" name="guardar-permiso" type="hidden">
								</form>
		    				</div>

	    					<span class="badge badge-info">3</span>
	    					<b>Agregar evaluadores</b>
	    					<br/><br/>

							<button type="submit" class="btn" id="btn-agregar-evaluador" name="btn-agregar-evaluador">Agregar Evaluador</button>

							<?php 
								if(filter_has_var(INPUT_POST, "btn-guardar-si-evaluador")){
									// Registrando evaluador
									echo registraEvaluador();
								}
							?>

							<!-- Evaluador -->
							<table class="table">
								<thead>
									<tr>
										<th>#</th>
										<th>RFC</th>
										<th>Evaluador</th>
										<th>Tipo</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<?php echo consultaEvaluadores(); ?>
								</tbody>
							</table>


							<form method="post">
								<!-- Vetana modal -->
								<div class="modal hide" id="modal-evaluador">
									<div class="modal-header">
										<h3>Evaluadores</h3>
									</div>
									
									<div class="modal-body">
										<p>Introduzca el RFC</p>
										<input name="input-rfc-evaluador" type="text" class="span12"/>
										<p>Nombre</p>
										<input name="input-nombre-evaluador" type="text" class="span12"/>
										<p>Tipo</p>
										<select name="input-tipo-evaluador">
											<option value="I">Interno</option>
											<option value="E">Externo</option>
										</select>
									</div>
									<div class="modal-footer">
										<a href="#" class="btn" data-dismiss="modal">Cancelar</a>
										<button id="btn-guardar-si-evaluador" name="btn-guardar-si-evaluador" type="submit" class="btn">Agregar</button>
									</div>
								</div>

								<!-- botonos ocultos de la forma -->
								<input id="guardar-evaluador" name="guardar-evaluador" type="hidden">
							</form>

							<form class="well" method="post">
		    					<label>Periodo actual</label>
								<input
									id="input-periodo-actual" 
									name="input-periodo-actual" 
									type="text" 
									class="span12"
									value="<?php echo obtienePeriodoDeParametrosConfiguracion(); ?>" />
								<button
									type="submit" 
									class="btn">Guardar</button>
							</form>
		    			</div>

		    		</div>
		    	</div>
		    </div>
		</div>

</body>
</html>