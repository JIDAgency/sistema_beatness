$(function () {

	// Establecer validaciones
	$("#forma-editar-sucursales").validate({
		rules: {
			"nombre": {
				required: true
			},
			"locacion": {
				required: true
			},
			/*"dificultad": {
				required: true
            },*/
            "descripcion": {
				required: true
			},
			"direccion": {
				required: true,
			},
			"url": {
				required: true
			},
			"url_whatsapp": {
				required: true
            },
            "url_ubicacion": {
				required: true
            },
            "url_logo": {
				required: true
            },

            "url_banner": {
				required: true
            },

            "orden_mostrar": {
                required: true,
                number: true
            },

            "estatus": {
				required: true
            }
            
		},
		messages: {
			"nombre": {
				required: "Este campo es requerido"
			},
			"locacion": {
				required: "Debe ingresar una locación"
			},
			/*"dificultad": {
				required: "Este campo es requerido"
            },*/
            
            "descripcion": {
				required: "Debe ingresar una descripción"
			},

			"direccion": {
				required: "Este campo es requerido",
			},
			"url": {
				required: "Este campo es requerido",
			},
			"url_whatsapp": {
				required: "Este campo es requerido",
            },
            "url_ubicacion": {
				required: "Este campo es requerido",
            },
            "url_logo": {
				required: "Este campo es requerido",
            },
            "url_banner": {
				required: "Este campo es requerido",
            },

            "orden_mostrar": {
                required: "Este campo es requerido",
                number: "Debe ser un valor numerico"
            },
            
            "estatus": {
				required: "Este campo es requerido",
			}
		},
		errorClass: "has-error"
	});
});