var cargar_imagen_boton = function(event) {
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById('preview_url_imagen_boton');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
};

var cargar_imagen_page = function(event) {
  var reader = new FileReader();
  reader.onload = function(){
    var output = document.getElementById('preview_url_imagen_page');
    output.src = reader.result;
  };
  reader.readAsDataURL(event.target.files[0]);
};

var cargar_imagen_vista = function(event) {
  var reader = new FileReader();
  reader.onload = function(){
    var output = document.getElementById('preview_url_imagen_vista');
    output.src = reader.result;
  };
  reader.readAsDataURL(event.target.files[0]);
};