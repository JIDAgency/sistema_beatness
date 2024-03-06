$(function () {

	// Establecer validaciones
	$("#forma-editar-disciplina").validate({
		rules: {
			"nombre": {
				required: true
            },
            
            "url_banner": {
				required: true
            },
            
            "url_titulo": {
				required: true
            },
            
            "url_logo": {
				required: true
			},
            
            "sucursal_id": {
				required: true
            },
            
            "estatus": {
				required: true
			},
			
            
		},
		messages: {
			"nombre": {
				required: "Este campo es requerido"
			},
			"url_banner": {
				required: "Este campo es requerido"
            },

            "url_titulo": {
				required: "Este campo es requerido"
            },

            "url_logo": {
				required: "Este campo es requerido"
            },

            "sucursal_id": {
				required: "Este campo es requerido"
            },

            "estatus": {
				required: "Este campo es requerido"
            },
            
		},
		errorClass: "has-error"
	});
});