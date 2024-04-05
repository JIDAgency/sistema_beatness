var table;

var actual_url = document.URL;
var method_call = "";

if(actual_url.indexOf("index") < 0){
    method_call = "ventas/";
}

/**
 * Este línea desactiva los mensajes de error de DataTables();
 */
$.fn.dataTable.ext.errMode = 'throw';

$(document).ready(function(){
    table = $('#tabla').DataTable({ 
        "scrollX": true,
        "deferRender": true,
        'processing': true,
        "order": [[0, "desc"]],
        "lengthMenu": [[25, 50, 100, 250, 500, -1], [25, 50, 100, 250, 500, "Todos"]],
        "ajax": {
            "url" : method_call+"get_lista_de_ventas_del_mes_para_fd_con_permisos",
            "type" : 'POST'
        },
        
        "columns": [
            { "data": "id" },
            { "data": "concepto" },
            { "data": "metodo_de_pago" },
            { "data": "comprador" },
            { "data": "categoria" },
            { "data": "estatus" },
            { "data": "costo" },
            { "data": "cantidad" },
            { "data": "total" },
            { "data": "fecha_venta" },
            { "data": "usuario_id" },
            { "data": "comprador_correo" },
            { "data": "comprador_nombre_completo" },
            { "data": "asignacion_id" },
            { "data": "asignacion" },
            { "data": "asignacion_vigencia_en_dias" },
            { "data": "asignacion_clases_del_plan" },
            { "data": "asignacion_openpay_suscripcion_id" },
            { "data": "asignacion_openpay_cliente_id" },
            { "data": "asignacion_suscripcion_estatus_del_pago" },
            { "data": "asignacion_suscripcion_fecha_de_actualizacion" },
            { "data": "sucursal" },
            { "data": "vendedor" },
            { "data": "opciones" },
        ],
        'language': {
            "sProcessing":     '<i class="fa fa-spinner spinner"></i> Cargando...',
            "sLengthMenu":     "Mostrar _MENU_",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla =(",
            "sInfo":           "Mostrando del _START_ al _END_ de _TOTAL_",
            "sInfoEmpty":      "Mostrando del 0 al 0 de 0",
            "sInfoFiltered":   "(filtrado _MAX_)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "&nbsp;",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     ">",
                "sPrevious": "<"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            },
            "buttons": {
                "copy": "Copiar",
                "colvis": "Visibilidad"
            }
        },
    });

    var buttons = new $.fn.dataTable.Buttons(table, {
        buttons: [
            'excelHtml5',
        ]
    }).container().appendTo($('#buttons'));

    $("#mes_a_consultar").change(function () {
        //clear datatable
        table.clear().draw();

        $("#mes_a_consultar").load(this.value);
        mes_a_consultar = $(this).val();
        url = method_call+"get_lista_de_ventas_del_mes_para_fd_con_permisos/"+mes_a_consultar;
        reload_table();
        generar_datos_de_reporte_de_ventas(mes_a_consultar);
    });

});

function reload_table()
{
    table.ajax.url(url).load();
    table.ajax.reload( null, false ); //reload datatable ajax 
}

function generar_datos_de_reporte_de_ventas(mes_a_consultar_var) {
    if (mes_a_consultar_var == null) {

        $.ajax({
            url: method_call+"get_numeros_de_ventas_del_mes_para_fd_con_permisos",
            type: "GET",
            dataType:'json',
            success: function(data) {
                $.each(data, function(index,item){
                    if(document.getElementById("no_ventas")){
                        document.getElementById('no_ventas').innerHTML = item.no_ventas;
                    }
                    
                    if(document.getElementById("ventas_total")){
                        document.getElementById('ventas_total').innerHTML = item.ventas_total;
                    }
                    
                    if(document.getElementById("no_ventas_canceladas_total")){
                        document.getElementById('no_ventas_canceladas_total').innerHTML = item.no_ventas_canceladas_total;
                    }
                    
                    if(document.getElementById("no_ventas_efectivo")){
                        document.getElementById('no_ventas_efectivo').innerHTML = item.no_ventas_efectivo;
                    }
                    if(document.getElementById("ventas_efectivo")){
                        document.getElementById('ventas_efectivo').innerHTML = item.ventas_efectivo;
                    }
                    
                    if(document.getElementById("no_ventas_tarjeta")){
                        document.getElementById('no_ventas_tarjeta').innerHTML = item.no_ventas_tarjeta;
                    }
                    if(document.getElementById("ventas_tarjeta")){
                        document.getElementById('ventas_tarjeta').innerHTML = item.ventas_tarjeta;
                    }
                    
                    if(document.getElementById("no_ventas_openpay")){
                        document.getElementById('no_ventas_openpay').innerHTML = item.no_ventas_openpay;
                    }
                    if(document.getElementById("ventas_openpay")){
                        document.getElementById('ventas_openpay').innerHTML = item.ventas_openpay;
                    }

                    if(document.getElementById("no_ventas_openpay_b3")){
                        document.getElementById('no_ventas_openpay_b3').innerHTML = item.no_ventas_openpay_b3;
                    }
                    if(document.getElementById("ventas_openpay_b3")){
                        document.getElementById('ventas_openpay_b3').innerHTML = item.ventas_openpay_b3;
                    }

                    if(document.getElementById("no_ventas_openpay_insan3")){
                        document.getElementById('no_ventas_openpay_insan3').innerHTML = item.no_ventas_openpay_insan3;
                    }
                    if(document.getElementById("ventas_openpay_insan3")){
                        document.getElementById('ventas_openpay_insan3').innerHTML = item.ventas_openpay_insan3;
                    }
                    
                    if(document.getElementById("no_ventas_b3family")){
                        document.getElementById('no_ventas_b3family').innerHTML = item.no_ventas_b3family;
                    }
                    if(document.getElementById("ventas_b3family")){
                        document.getElementById('ventas_b3family').innerHTML = item.ventas_b3family;
                    }
                    
                    if(document.getElementById("no_ventas_suscripcion")){
                        document.getElementById('no_ventas_suscripcion').innerHTML = item.no_ventas_suscripcion;
                    }
                    if(document.getElementById("ventas_suscripcion")){
                        document.getElementById('ventas_suscripcion').innerHTML = item.ventas_suscripcion;
                    }
                    
                    if(document.getElementById("no_periodos_prueba_suscripcion")){
                        document.getElementById('no_periodos_prueba_suscripcion').innerHTML = item.no_periodos_prueba_suscripcion;
                    }
                    if(document.getElementById("periodos_prueba_suscripcion")){
                        document.getElementById('periodos_prueba_suscripcion').innerHTML = item.periodos_prueba_suscripcion;
                    }

                    /** Metodos de pago B3 */
                    
                    if(document.getElementById("b3_no_ventas_total")){
                        document.getElementById('b3_no_ventas_total').innerHTML = item.b3_no_ventas_total;
                    }
                    if(document.getElementById("b3_ventas_total")){
                        document.getElementById('b3_ventas_total').innerHTML = item.b3_ventas_total;
                    }
                    
                    if(document.getElementById("b3_no_ventas_efectivo")){
                        document.getElementById('b3_no_ventas_efectivo').innerHTML = item.b3_no_ventas_efectivo;
                    }
                    if(document.getElementById("b3_ventas_efectivo")){
                        document.getElementById('b3_ventas_efectivo').innerHTML = item.b3_ventas_efectivo;
                    }
                    
                    if(document.getElementById("b3_no_ventas_tarjeta")){
                        document.getElementById('b3_no_ventas_tarjeta').innerHTML = item.b3_no_ventas_tarjeta;
                    }
                    if(document.getElementById("b3_ventas_tarjeta")){
                        document.getElementById('b3_ventas_tarjeta').innerHTML = item.b3_ventas_tarjeta;
                    }
                    
                    if(document.getElementById("b3_no_ventas_b3family")){
                        document.getElementById('b3_no_ventas_b3family').innerHTML = item.b3_no_ventas_b3family;
                    }
                    if(document.getElementById("b3_ventas_b3family")){
                        document.getElementById('b3_ventas_b3family').innerHTML = item.b3_ventas_b3family;
                    }

                    /** Metodos de pago VELA */
                    
                    if(document.getElementById("vela_no_ventas_total")){
                        document.getElementById('vela_no_ventas_total').innerHTML = item.vela_no_ventas_total;
                    }
                    if(document.getElementById("vela_ventas_total")){
                        document.getElementById('vela_ventas_total').innerHTML = item.vela_ventas_total;
                    }
                    
                    if(document.getElementById("vela_no_ventas_efectivo")){
                        document.getElementById('vela_no_ventas_efectivo').innerHTML = item.vela_no_ventas_efectivo;
                    }
                    if(document.getElementById("vela_ventas_efectivo")){
                        document.getElementById('vela_ventas_efectivo').innerHTML = item.vela_ventas_efectivo;
                    }
                    
                    if(document.getElementById("vela_no_ventas_tarjeta")){
                        document.getElementById('vela_no_ventas_tarjeta').innerHTML = item.vela_no_ventas_tarjeta;
                    }
                    if(document.getElementById("vela_ventas_tarjeta")){
                        document.getElementById('vela_ventas_tarjeta').innerHTML = item.vela_ventas_tarjeta;
                    }
                    
                    if(document.getElementById("vela_no_ventas_b3family")){
                        document.getElementById('vela_no_ventas_b3family').innerHTML = item.vela_no_ventas_b3family;
                    }
                    if(document.getElementById("vela_ventas_b3family")){
                        document.getElementById('vela_ventas_b3family').innerHTML = item.vela_ventas_b3family;
                    }
                    /** Metodos de pago DORADO */
                    
                    if(document.getElementById("dorado_no_ventas_total")){
                        document.getElementById('dorado_no_ventas_total').innerHTML = item.dorado_no_ventas_total;
                    }
                    if(document.getElementById("dorado_ventas_total")){
                        document.getElementById('dorado_ventas_total').innerHTML = item.dorado_ventas_total;
                    }
                    
                    if(document.getElementById("dorado_no_ventas_efectivo")){
                        document.getElementById('dorado_no_ventas_efectivo').innerHTML = item.dorado_no_ventas_efectivo;
                    }
                    if(document.getElementById("dorado_ventas_efectivo")){
                        document.getElementById('dorado_ventas_efectivo').innerHTML = item.dorado_ventas_efectivo;
                    }
                    
                    if(document.getElementById("dorado_no_ventas_tarjeta")){
                        document.getElementById('dorado_no_ventas_tarjeta').innerHTML = item.dorado_no_ventas_tarjeta;
                    }
                    if(document.getElementById("dorado_ventas_tarjeta")){
                        document.getElementById('dorado_ventas_tarjeta').innerHTML = item.dorado_ventas_tarjeta;
                    }
                    
                    if(document.getElementById("dorado_no_ventas_b3family")){
                        document.getElementById('dorado_no_ventas_b3family').innerHTML = item.dorado_no_ventas_b3family;
                    }
                    if(document.getElementById("dorado_ventas_b3family")){
                        document.getElementById('dorado_ventas_b3family').innerHTML = item.dorado_ventas_b3family;
                    }
                    /** Metodos de pago insan3 */
                    
                    if(document.getElementById("insan3_no_ventas_total")){
                        document.getElementById('insan3_no_ventas_total').innerHTML = item.insan3_no_ventas_total;
                    }
                    if(document.getElementById("insan3_ventas_total")){
                        document.getElementById('insan3_ventas_total').innerHTML = item.insan3_ventas_total;
                    }
                    
                    if(document.getElementById("insan3_no_ventas_efectivo")){
                        document.getElementById('insan3_no_ventas_efectivo').innerHTML = item.insan3_no_ventas_efectivo;
                    }
                    if(document.getElementById("insan3_ventas_efectivo")){
                        document.getElementById('insan3_ventas_efectivo').innerHTML = item.insan3_ventas_efectivo;
                    }
                    
                    if(document.getElementById("insan3_no_ventas_tarjeta")){
                        document.getElementById('insan3_no_ventas_tarjeta').innerHTML = item.insan3_no_ventas_tarjeta;
                    }
                    if(document.getElementById("insan3_ventas_tarjeta")){
                        document.getElementById('insan3_ventas_tarjeta').innerHTML = item.insan3_ventas_tarjeta;
                    }
                    
                    if(document.getElementById("insan3_no_ventas_b3family")){
                        document.getElementById('insan3_no_ventas_b3family').innerHTML = item.insan3_no_ventas_b3family;
                    }
                    if(document.getElementById("insan3_ventas_b3family")){
                        document.getElementById('insan3_ventas_b3family').innerHTML = item.insan3_ventas_b3family;
                    }
                });
            }
        });

    } else{

        $.ajax({
            url: method_call+"get_numeros_de_ventas_del_mes_para_fd_con_permisos/"+mes_a_consultar_var,
            type: "GET",
            dataType:'json',
            success: function(data) {
                $.each(data, function(index,item){
                    document.getElementById('mes_reportado').innerHTML = item.mes_reportado;

                    if(document.getElementById("no_ventas")){
                        document.getElementById('no_ventas').innerHTML = item.no_ventas;
                    }
                    
                    if(document.getElementById("ventas_total")){
                        document.getElementById('ventas_total').innerHTML = item.ventas_total;
                    }
                    
                    if(document.getElementById("no_ventas_canceladas_total")){
                        document.getElementById('no_ventas_canceladas_total').innerHTML = item.no_ventas_canceladas_total;
                    }
                    
                    if(document.getElementById("no_ventas_efectivo")){
                        document.getElementById('no_ventas_efectivo').innerHTML = item.no_ventas_efectivo;
                    }
                    if(document.getElementById("ventas_efectivo")){
                        document.getElementById('ventas_efectivo').innerHTML = item.ventas_efectivo;
                    }
                    
                    if(document.getElementById("no_ventas_tarjeta")){
                        document.getElementById('no_ventas_tarjeta').innerHTML = item.no_ventas_tarjeta;
                    }
                    if(document.getElementById("ventas_tarjeta")){
                        document.getElementById('ventas_tarjeta').innerHTML = item.ventas_tarjeta;
                    }
                    
                    if(document.getElementById("no_ventas_openpay")){
                        document.getElementById('no_ventas_openpay').innerHTML = item.no_ventas_openpay;
                    }
                    if(document.getElementById("ventas_openpay")){
                        document.getElementById('ventas_openpay').innerHTML = item.ventas_openpay;
                    }

                    if(document.getElementById("no_ventas_openpay_b3")){
                        document.getElementById('no_ventas_openpay_b3').innerHTML = item.no_ventas_openpay_b3;
                    }
                    if(document.getElementById("ventas_openpay_b3")){
                        document.getElementById('ventas_openpay_b3').innerHTML = item.ventas_openpay_b3;
                    }

                    if(document.getElementById("no_ventas_openpay_insan3")){
                        document.getElementById('no_ventas_openpay_insan3').innerHTML = item.no_ventas_openpay_insan3;
                    }
                    if(document.getElementById("ventas_openpay_insan3")){
                        document.getElementById('ventas_openpay_insan3').innerHTML = item.ventas_openpay_insan3;
                    }
                    
                    if(document.getElementById("no_ventas_b3family")){
                        document.getElementById('no_ventas_b3family').innerHTML = item.no_ventas_b3family;
                    }
                    if(document.getElementById("ventas_b3family")){
                        document.getElementById('ventas_b3family').innerHTML = item.ventas_b3family;
                    }
                    
                    if(document.getElementById("no_ventas_suscripcion")){
                        document.getElementById('no_ventas_suscripcion').innerHTML = item.no_ventas_suscripcion;
                    }
                    if(document.getElementById("ventas_suscripcion")){
                        document.getElementById('ventas_suscripcion').innerHTML = item.ventas_suscripcion;
                    }
                    
                    if(document.getElementById("no_periodos_prueba_suscripcion")){
                        document.getElementById('no_periodos_prueba_suscripcion').innerHTML = item.no_periodos_prueba_suscripcion;
                    }
                    if(document.getElementById("periodos_prueba_suscripcion")){
                        document.getElementById('periodos_prueba_suscripcion').innerHTML = item.periodos_prueba_suscripcion;
                    }

                    /** Metodos de pago B3 */
                    
                    if(document.getElementById("b3_no_ventas_total")){
                        document.getElementById('b3_no_ventas_total').innerHTML = item.b3_no_ventas_total;
                    }
                    if(document.getElementById("b3_ventas_total")){
                        document.getElementById('b3_ventas_total').innerHTML = item.b3_ventas_total;
                    }
                    
                    if(document.getElementById("b3_no_ventas_efectivo")){
                        document.getElementById('b3_no_ventas_efectivo').innerHTML = item.b3_no_ventas_efectivo;
                    }
                    if(document.getElementById("b3_ventas_efectivo")){
                        document.getElementById('b3_ventas_efectivo').innerHTML = item.b3_ventas_efectivo;
                    }
                    
                    if(document.getElementById("b3_no_ventas_tarjeta")){
                        document.getElementById('b3_no_ventas_tarjeta').innerHTML = item.b3_no_ventas_tarjeta;
                    }
                    if(document.getElementById("b3_ventas_tarjeta")){
                        document.getElementById('b3_ventas_tarjeta').innerHTML = item.b3_ventas_tarjeta;
                    }
                    
                    if(document.getElementById("b3_no_ventas_b3family")){
                        document.getElementById('b3_no_ventas_b3family').innerHTML = item.b3_no_ventas_b3family;
                    }
                    if(document.getElementById("b3_ventas_b3family")){
                        document.getElementById('b3_ventas_b3family').innerHTML = item.b3_ventas_b3family;
                    }

                    /** Metodos de pago VELA */
                    
                    if(document.getElementById("vela_no_ventas_total")){
                        document.getElementById('vela_no_ventas_total').innerHTML = item.vela_no_ventas_total;
                    }
                    if(document.getElementById("vela_ventas_total")){
                        document.getElementById('vela_ventas_total').innerHTML = item.vela_ventas_total;
                    }
                    
                    if(document.getElementById("vela_no_ventas_efectivo")){
                        document.getElementById('vela_no_ventas_efectivo').innerHTML = item.vela_no_ventas_efectivo;
                    }
                    if(document.getElementById("vela_ventas_efectivo")){
                        document.getElementById('vela_ventas_efectivo').innerHTML = item.vela_ventas_efectivo;
                    }
                    
                    if(document.getElementById("vela_no_ventas_tarjeta")){
                        document.getElementById('vela_no_ventas_tarjeta').innerHTML = item.vela_no_ventas_tarjeta;
                    }
                    if(document.getElementById("vela_ventas_tarjeta")){
                        document.getElementById('vela_ventas_tarjeta').innerHTML = item.vela_ventas_tarjeta;
                    }
                    
                    if(document.getElementById("vela_no_ventas_b3family")){
                        document.getElementById('vela_no_ventas_b3family').innerHTML = item.vela_no_ventas_b3family;
                    }
                    if(document.getElementById("vela_ventas_b3family")){
                        document.getElementById('vela_ventas_b3family').innerHTML = item.vela_ventas_b3family;
                    }

                    /** Metodos de pago DORADO */
                    
                    if(document.getElementById("dorado_no_ventas_total")){
                        document.getElementById('dorado_no_ventas_total').innerHTML = item.dorado_no_ventas_total;
                    }
                    if(document.getElementById("dorado_ventas_total")){
                        document.getElementById('dorado_ventas_total').innerHTML = item.dorado_ventas_total;
                    }
                    
                    if(document.getElementById("dorado_no_ventas_efectivo")){
                        document.getElementById('dorado_no_ventas_efectivo').innerHTML = item.dorado_no_ventas_efectivo;
                    }
                    if(document.getElementById("dorado_ventas_efectivo")){
                        document.getElementById('dorado_ventas_efectivo').innerHTML = item.dorado_ventas_efectivo;
                    }
                    
                    if(document.getElementById("dorado_no_ventas_tarjeta")){
                        document.getElementById('dorado_no_ventas_tarjeta').innerHTML = item.dorado_no_ventas_tarjeta;
                    }
                    if(document.getElementById("dorado_ventas_tarjeta")){
                        document.getElementById('dorado_ventas_tarjeta').innerHTML = item.dorado_ventas_tarjeta;
                    }
                    
                    if(document.getElementById("dorado_no_ventas_b3family")){
                        document.getElementById('dorado_no_ventas_b3family').innerHTML = item.dorado_no_ventas_b3family;
                    }
                    if(document.getElementById("dorado_ventas_b3family")){
                        document.getElementById('dorado_ventas_b3family').innerHTML = item.dorado_ventas_b3family;
                    }
                    /** Metodos de pago insan3 */
                    
                    if(document.getElementById("insan3_no_ventas_total")){
                        document.getElementById('insan3_no_ventas_total').innerHTML = item.insan3_no_ventas_total;
                    }
                    if(document.getElementById("insan3_ventas_total")){
                        document.getElementById('insan3_ventas_total').innerHTML = item.insan3_ventas_total;
                    }
                    
                    if(document.getElementById("insan3_no_ventas_efectivo")){
                        document.getElementById('insan3_no_ventas_efectivo').innerHTML = item.insan3_no_ventas_efectivo;
                    }
                    if(document.getElementById("insan3_ventas_efectivo")){
                        document.getElementById('insan3_ventas_efectivo').innerHTML = item.insan3_ventas_efectivo;
                    }
                    
                    if(document.getElementById("insan3_no_ventas_tarjeta")){
                        document.getElementById('insan3_no_ventas_tarjeta').innerHTML = item.insan3_no_ventas_tarjeta;
                    }
                    if(document.getElementById("insan3_ventas_tarjeta")){
                        document.getElementById('insan3_ventas_tarjeta').innerHTML = item.insan3_ventas_tarjeta;
                    }
                    
                    if(document.getElementById("insan3_no_ventas_b3family")){
                        document.getElementById('insan3_no_ventas_b3family').innerHTML = item.insan3_no_ventas_b3family;
                    }
                    if(document.getElementById("insan3_ventas_b3family")){
                        document.getElementById('insan3_ventas_b3family').innerHTML = item.insan3_ventas_b3family;
                    }
                });
            }
        });
    }
}