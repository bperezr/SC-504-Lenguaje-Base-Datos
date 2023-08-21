// Función para validar el formulario de contacto
function validarFormulario(event) {
    if (event) {
        event.preventDefault();
    }

    // Validar el nombre
    var nombreInput = document.getElementById('nombre');
    var nombre = nombreInput.value.trim();

    if (nombre.length === 0 || nombre.length > 50 || !/^[\w\sáéíóúñÁÉÍÓÚÑ]+$/.test(nombre)) {
        mostrarMensajeError('nombre', 'Ingrese un nombre válido (máximo 50 caracteres, solo letras, espacios)');
        return;
    }

    // Validar el teléfono
    var telefonoInput = document.getElementById('telefono');
    var telefono = telefonoInput.value.trim();

    if (telefono.length < 8 || !/^\d+$/.test(telefono)) {
        mostrarMensajeError('telefono', 'Ingrese un teléfono válido (mínimo 8 dígitos)');
        return;
    }

    // Validar el correo
    var correoInput = document.getElementById('correo');
    var correo = correoInput.value.trim();

    if (!/^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(correo)) {
        mostrarMensajeError('correo', 'Ingrese un correo válido');
        return;
    }

    // Validar el mensaje
    var mensajeInput = document.querySelector('#mensaje');
    var mensaje = mensajeInput.value.trim();

    if (mensaje.length === 0) {
        mostrarMensajeError('mensaje', 'Ingrese su mensaje');
        return;
    }

    // Si todos los campos son válidos, se puede enviar el formulario
    console.log('Formulario válido. Enviar datos al servidor.');
    alert('Mensaje enviado correctamente.');
    formulario.reset();
}

// Función para mostrar un mensaje de error
function mostrarMensajeError(campo, mensaje) {
    var contenedorMensaje = document.querySelector('.contenedor-mensaje');

    // Crear un elemento de mensaje de error
    var mensajeError = document.createElement('p');
    mensajeError.className = 'mensaje-error';
    mensajeError.textContent = mensaje;

    // Eliminar el mensaje de error anterior (si existe)
    var mensajeErrorAnterior = contenedorMensaje.querySelector('.mensaje-error');
    if (mensajeErrorAnterior) {
        contenedorMensaje.removeChild(mensajeErrorAnterior);
    }

    // Insertar el nuevo mensaje de error
    contenedorMensaje.appendChild(mensajeError);

    // Resaltar el campo con error
    var campoError = document.getElementById(campo);
    campoError.classList.add('campo-error');

    // Temporizador para ocultar el mensaje de error después de 5 segundos
    setTimeout(function () {
        contenedorMensaje.removeChild(mensajeError);
        campoError.classList.remove('campo-error');
    }, 5000);
}

// Obtener el formulario
var formulario = document.querySelector('.formulario');

// Agregar el evento de validación al enviar el formulario
formulario.addEventListener('submit', validarFormulario);

document.getElementById("enviarBtn").addEventListener("click", function(event) {
    // Llamar a la función de validación del formulario pasando el evento
    validarFormulario(event);

    // Obtener el estado de las validaciones
    var contenedorMensaje = document.querySelector('.contenedor-mensaje');
    var mensajeError = contenedorMensaje.querySelector('.mensaje-error');
    
    if (!mensajeError) {
        // Si no hay mensajes de error, enviar el correo
        var nombre = document.getElementById("nombre").value;
        var telefono = document.getElementById("telefono").value;
        var correo = document.getElementById("correo").value;
        var mensaje = document.getElementById("mensaje").value;

        var mailtoLink = "mailto:happyPaws@email.com" +
                        "?subject=Formulario de contacto Happy Paws" +
                        "&body=Nombre: " + encodeURIComponent(nombre) +
                        "%0ATeléfono: " + encodeURIComponent(telefono) +
                        "%0ACorreo: " + encodeURIComponent(correo) +
                        "%0AMensaje: " + encodeURIComponent(mensaje);

        window.location.href = mailtoLink;
    }
});
