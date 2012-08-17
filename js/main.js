var UTVM = {
	appName : "Estimulos UTVM",

	/* funcion que permite enviar mensajes a la consola del navegador */
	log: function(message){
		$this = this;
		/*
		YUI().use('console', function (Y) {
			Y.log(message, "info",  $this.appName);
		});
		*/
	},

	/* funcion de inicio de la aplicacion */
	init : function(){
		this.log("Iniciando aplicacion");
		$('.dropdown-toggle').dropdown();

		/* pantalla de coonfiguracion */

		// boton guardar evaluaciones
		$("#btn-guardar").click(function(){
			$('#modal-evaluaciones').modal();
		});

		$('#btn-guardar-si').click(function(){
			$('input#guardar-evaluacion').val("1");
		});

		// boton guardar permisos
		$("#btn-agregar-permiso").click(function(){
			$('#modal-permisos').modal();
		});

		$('#btn-guardar-si-permisos').click(function(){
			$('input#guardar-permisos').val("1");
		});


		// boton guardar evaluador
		$("#btn-agregar-evaluador").click(function(){
			$('#modal-evaluador').modal();
		});

		$('#btn-guardar-si-evaluador').click(function(){
			$('input#guardar-evaluador').val("1");
		});

		/* captura de documentos */
		$('#agregar-documento').click(function(){
			var documentosSeleccionados = $("#documentos-trayectorias input[type=checkbox]:checked");
			if(documentosSeleccionados.size() > 0){
				$.each(documentosSeleccionados, function(key, value){
					var documento = $(value).parent().parent().clone();
					$(documento).appendTo("#documentos-asignados");
				});
			}else{
				alert("Seleccione las evidencias de la lista derecha");
			}
			$("#documentos-trayectorias input[type=checkbox]:checked").removeAttr("checked");
			$("#documentos-asignados input[type=checkbox]:checked").removeAttr("checked");
		});

		/* captura de documentos */
		$('#quitar-documento').click(function(){
			var documentosSeleccionados = $("#documentos-asignados input[type=checkbox]:checked");
			if(documentosSeleccionados.size() > 0){
				$.each(documentosSeleccionados, function(key, value){
					var documento = $(value).parent().parent().remove();
				});
			}
		});

		$("#guardar-cambios-asignacion").click(function(){			
			var documentos = new Array();
			$.each($("#documentos-asignados input[type=checkbox]"), function(key, value){
				var nombreDocumento = $(value).attr('data-nombre-archivo');

				var documento ={
					nombre: ""
				};				
				documento.nombre = nombreDocumento;

				// guardando objetos
				documentos[key] = documento;
			});

			// set json data
			$("#json_asignacion").val(JSON.stringify(documentos));
			$("#form-guardar-asignacion").submit();
		});

		$("#input-calificacion").keyup(function(){
			var calificacionMaxima = parseInt($(this).attr("title"));
			var calificacionCapturada = parseInt($(this).val());
			if(!isNaN(calificacionCapturada)){
				if(!(calificacionCapturada >= 0 && calificacionCapturada <= calificacionMaxima) ){
					$(this).val($(this).attr("title"));
				}
			}
		});


		$("#incorrecto").click(function(){
			var checkboxSeleccionado = $("#incorrecto").attr("checked");
			if(typeof checkboxSeleccionado == "undefined"){
				$("#input-calificacion").val($("#input-calificacion").attr("title"));
				$("#input-comentario").attr("dataset-obligatorio","0");
			}else{
				$("#input-comentario").attr("dataset-obligatorio","1");
				$("#input-calificacion").val("0");
			}
		});

		$("#input-comentario").attr("dataset-obligatorio","0");
		$("#input-calificacion").keyup(function(){
			var calificacion, calificacionMaxima;			
			calificacion = $(this).val();			
			if(calificacion != ""){
				calificacion = parseInt(calificacion);
				calificacionMaxima = parseInt($("#input-calificacion").attr("title"));
				if(!isNaN(calificacion)){
					if(calificacion < calificacionMaxima){
						$("#input-comentario").attr("dataset-obligatorio","1");
					}else{
						$("#input-comentario").attr("dataset-obligatorio","0");
					}
				}
			}
		});


		$("#guardar-evaluacion").click(function(){

			var validarComentario = $("#input-comentario").attr("dataset-obligatorio");
			var multiPorcentaje = $("#input-calificacion option:selected").size();
			var idPorcentajeindicador = 0;

			if(multiPorcentaje > 0){
				idPorcentajeindicador = $("#input-calificacion option:selected").attr("data-id-porcentajeindicador");	
			}else{
				idPorcentajeindicador = $("#input-calificacion").attr("data-id-porcentajeindicador");
			}

			var evaluacionIncorrecta = true;
			if($("#incorrecto:checked").size() == 0 ){
				evaluacionIncorrecta = false;
			}

			var evaluacion = {
				idPorcentajeindicador: idPorcentajeindicador,
				calificacion: $("#input-calificacion").val(),
				comentario: $("#input-comentario").val(),
				estado: "" + evaluacionIncorrecta + ""
			};

			$("#json-evaluacion").val(JSON.stringify(evaluacion));

			/* valida captura de comentarios */
			if(validarComentario == "1"){
				var valorComentario = $("#input-comentario").val();
				if(valorComentario != ""){
					$("#form-calificacion").submit();
				}else{
					alert("Es obligatorio capturar el comentario del indicador");
				}
			}else{
				$("#form-calificacion").submit();
			}
		});

		$("#enviar-al-evaluador").click(function(){
			$("#envio-modal").modal('show');
			return false;
		});

		$("#btn-enviar-evaluador").click(function(){
			$("#form-enviar-al-evaluador").submit();
		});

		// configura todos los botones para cerrar la sesion
		$(".cerrar-sesion").attr("href", "/estimulos/lib/logout.php?killsession=1");
		
		
		$("#terminar-evaluacion").click(function(){
			$('#informacion').modal('show');
		});

		$("#btn-terminar-evaluacion").click(function(){
			var comentario = $("#input-comentario").val();
			if(comentario == ''){
				$("#alerta-caomentario-obligatorio").show();
				return false;
			}else{
				$("#form-terminar-evaluacion").submit();
				return true;
			}
		});

		$("#enviadas").click(function(){
			$(".seccion1-3-1").hide();
			$(".seccion1-3-1").find(".seleccion-documento[title=enviada]").parent().show();
		});

		$("#no-enviadas").click(function(){
			$(".seccion1-3-1").hide();
			$(".seccion1-3-1").find(".seleccion-documento[title=no-enviada]").parent().show();
		});

		$("#evaluadas").click(function(){
			$(".seccion1-3-1").hide();
			$(".seccion1-3-1").find(".seleccion-documento[title=evaluada]").parent().show();
		});

		$("#todas").click(function(){
			$(".seccion1-3-1").show();
		});

		$("#imprimir-acuse").click(function(){
			var isDisabled = $(this).attr("disabled");
			if(typeof isDisabled == "undefined"){
				return true;
			}else{
				return false;
			}			
		});


		$('#protesta-modal').modal('show');		

	    $('#protesta-modal').on('hidden', function () {
			$('#aviso-modal').modal('show');
	    });

	},

	/* funcion principal */
	main : function(){
		this.init();
	}
};

$(document).ready(function(){
	UTVM.main();
});
