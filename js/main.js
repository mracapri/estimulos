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
	},

	/* funcion principal */
	main : function(){
		this.init();
	}
};

$(document).ready(function(){
	UTVM.main();
});
