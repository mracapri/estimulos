var UTVM = {
	appName : "Estimulos UTVM",

	/* funcion que permite enviar mensajes a la consola del navegador */
	log: function(message){
		$this = this;
		YUI().use('console', function (Y) {
			Y.log(message, "info",  $this.appName);
		});
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
	},

	/* funcion principal */
	main : function(){
		this.init();
	}
};

$(document).ready(function(){
	UTVM.main();
});
