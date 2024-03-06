$(document).ready(function() {
    $("#search_reservar").autocomplete({
        minLength: 0,
        appendTo: "#container",
        source: "search_reservar",
        select:function(e,ui) { 
            $('#usuario_id').val(ui.item.ref);
        }
    });
});