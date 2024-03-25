$(function () {
    jQuery.fn.dataTable.Api.register( 'sum()', function () {
        return this.flatten().reduce( function ( a, b ) {
            return (a*1) + (b*1); // cast values in-case they are strings
        });
    });

	var table = $("#tabla-ventas").DataTable({
        "scrollX": true,
        "autoWidth": false,
        "deferRender": true,
        'processing': true,
        "lengthMenu": [[100, 250, 500, -1],[100, 250, 500, "Todos"]],
        "dom": 'Bfrtip',
        "buttons": ['pageLength','excel','copy'],    // adds the excel button
        order: [[ 0, 'desc' ]],
        "language": {
            "search": "Buscar",
            "infoEmpty": "No hay registros que mostrar",
            "infoFiltered": " - ( filtrado de _MAX_ registros )",
            "zeroRecords": "No hay registros que mostrar",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "paginate": {
                "first": "«",
                "last": "»",
                "next": ">",
                "previous": "<"
            },
            "buttons": {
                "pageLength": {
                    _: "Mostrar %d",
                    '-1': "Mostrar ∞"
                },
                "copy": 'Copiar',
                "copySuccess": {
                    1: "Copio una fila al portapapeles",
                    _: "Copio %d filas al portapapeles"
                },
                "copyTitle": 'Copiar al portapapeles',
            }
        }
    });
    
    $("#tabla-ventas").on('search.dt', function() {
        var rest = [], suma = 0;
        var resultado = table.column( 6, {page:'current'} ).data();
        
        for (var i = 0; i < resultado.length; i++) {
            rest[i] = resultado[i].replace( /[^\d\.]*/g, '');
            suma += parseFloat(rest[i]);
        }
        
        console.log(rest);
        document.getElementById("ttl").textContent = formatMoney(suma);
    });

    function formatMoney(n, c, d, t) {
        var c = isNaN(c = Math.abs(c)) ? 2 : c,
          d = d == undefined ? "." : d,
          t = t == undefined ? "," : t,
          s = n < 0 ? "-" : "",
          i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
          j = (j = i.length) > 3 ? j % 3 : 0;
      
        return "$" + s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    };
});
