$(document).ready(function(){

    'use strict';
	
    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');

        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
            }, false);
        });
    }, false);
	
	document.getElementById('mensaje').onload = function () {
		document.getElementById('mensaje-count').innerHTML = (this.value.length)+'/240';
	};

	document.getElementById('mensaje').onkeyup = function () {
		document.getElementById('mensaje-count').innerHTML = (this.value.length)+'/240';
	};

});