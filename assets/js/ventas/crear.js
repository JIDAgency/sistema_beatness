$(document).ready(function () {

    var seleccionar_sucursal = document.getElementById("seleccionar_sucursal");

    seleccionar_sucursal.onchange = function (event) {

        var sucursal = event.target.options[event.target.selectedIndex].dataset.sucursal;
        console.log("sucursal: " + sucursal);

        var ficha_nombre_compador = document.getElementById("ficha_sucursal");
        ficha_nombre_compador.innerHTML = sucursal;
    };

    var seleccionar_comprador = document.getElementById("seleccionar_cliente");

    seleccionar_comprador.onchange = function (event) {

        var nombre_completo = event.target.options[event.target.selectedIndex].dataset.nombre_completo;
        console.log("nombre_completo: " + nombre_completo);

        var ficha_nombre_compador = document.getElementById("ficha_nombre_compador");
        ficha_nombre_compador.innerHTML = nombre_completo;
    };

    var selection = document.getElementById("seleccionar_plan");

    selection.onchange = function (event) {

        var costo = event.target.options[event.target.selectedIndex].dataset.costo;
        var nombre = event.target.options[event.target.selectedIndex].dataset.nombre;
        console.log("costo: " + costo);

        var ficha_nombre_producto = document.getElementById("ficha_nombre_producto");
        ficha_nombre_producto.innerHTML = nombre;

        var ficha_costo_unitario = document.getElementById("ficha_costo_unitario");
        ficha_costo_unitario.innerHTML = costo;

        var ficha_cantidad_a_vender = document.getElementById("ficha_cantidad_a_vender");
        ficha_cantidad_a_vender.innerHTML = 1;

        var ficha_precio_total = document.getElementById("ficha_precio_total");
        ficha_precio_total.innerHTML = costo;
    };


});

function getRating(el) {
    var ficha_metodo_pago = document.getElementById("ficha_metodo_pago");
    if (el.dataset.metodos_pago == "Cortesía") {
        ficha_metodo_pago.innerHTML = el.dataset.metodos_pago + '<br><small class="red">(El total será de $0.°°)</small>';
    } else {
        ficha_metodo_pago.innerHTML = el.dataset.metodos_pago;
    }
}
