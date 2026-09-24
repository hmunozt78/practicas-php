document.addEventListener('DOMContentLoaded', function() {
    const formulario = document.getElementById('formRegistro');

    formulario.addEventListener('submit', function(evento) {
        const nombre = document.getElementById('nombre').value.trim();
        const email = document.getElementById('email').value.trim();

        if (nombre === '' || email === '') {
            evento.preventDefault(); // Cancela el envío del formulario al servidor
            alert('⚠️ Por favor completa todos los campos requeridos en JavaScript.');
        }
    });
});