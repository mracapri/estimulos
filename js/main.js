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

		$("#guardar-evaluacion").click(function(){

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

			$("#form-calificacion").submit();
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

		$('#protesta-modal').modal('show');
		
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
	},

	/* funcion principal */
	main : function(){
		this.init();
	}
};

$(document).ready(function(){
	UTVM.main();
});
