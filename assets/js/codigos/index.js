function cargar_modal_nota(codigo, identificador, nota){
    $('#modal_nota').modal('show');
    document.getElementById("codigo").innerText = codigo;
    document.getElementById("identificador").value = identificador;
    document.getElementById("nota").value = nota;
}
