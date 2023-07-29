function validarFormulario(event) {
    event.preventDefault();

    // Validar el nombre
    var nombreInput = document.getElementById('nombre');
    var nombre = nombreInput.value.trim();

    if (nombre.length === 0 || nombre.length > 50 || !/^[\w\sáéíóúñÁÉÍÓÚÑ]+$/.test(nombre)) {
        mostrarMensajeError('nombre', 'Ingrese un nombre válido (máximo 50 caracteres, solo letras, espacios)');
        return;
    }

    // Validar el correo
    var correoInput = document.getElementById('correo');
    var correo = correoInput.value.trim();

    if (!/^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(correo)) {
        mostrarMensajeError('correo', 'Ingrese un correo válido');
        return;
    }

    // Validar la fecha
    var fechaInput = document.getElementById('fecha');
    var fecha = fechaInput.value.trim();

    if (fecha === '') {
        mostrarMensajeError('fecha', 'Seleccione una fecha');
        return;
    }

    var fechaSeleccionada = new Date(fecha);
    var hoy = new Date();
    hoy.setHours(0, 0, 0, 0);

    var diaSemana = fechaSeleccionada.getDay();


    // Validar el horario
    var horarioInput = document.getElementById('horario');
    var horario = horarioInput.value.trim();

    // Obtener la hora actual
    var horaActual = hoy.getHours();

    // Establecer el nuevo horario límite (de 8 AM a 5 PM)
    var horarioLimite = 17; //formato de 24 horas

    // Convertir el horario seleccionado a un número entero para comparar
    var horaSeleccionada = parseInt(horario.substring(0, 2));

    if (diaSemana >= 1 && diaSemana <= 5 && (horaSeleccionada < 8 || horaSeleccionada > horarioLimite)) {
        mostrarMensajeError('horario', 'Seleccione un horario válido (de lunes a viernes de 8 AM a 5 PM, y sábados de 8 AM a 12 PM)');
        return;
    }

    // Si es sábado, se permite seleccionar el horario hasta las 12 PM (hora 12)
    if (diaSemana === 6 && horaSeleccionada > 12) {
        mostrarMensajeError('horario', 'Seleccione un horario válido (de lunes a viernes de 8 AM a 5 PM, y sábados de 8 AM a 12 PM)');
        return;
    }

    if (horario === '') {
        mostrarMensajeError('horario', 'Seleccione un horario');
        return;
    }

    // Validar el servicio
    var servicioInput = document.getElementById('servicio');
    var servicio = servicioInput.value.trim();

    if (servicio === '') {
        mostrarMensajeError('servicio', 'Seleccione un servicio');
        return;
    }

    // Validar la mascota
    var mascotaInput = document.getElementById('mascota');
    var mascota = mascotaInput.value.trim();

    if (mascota === '') {
        mostrarMensajeError('mascota', 'Seleccione la mascota');
        return;
    }

    // Si todos los campos son válidos, se puede enviar el formulario
    console.log('Formulario válido. Enviar datos al servidor.');
    alert('Cita programada correctamente.');
    formulario.reset();
}


// Función para mostrar un mensaje de error
function mostrarMensajeError(campo, mensaje) {
    var contenedorMensaje = document.querySelector('.contenedor-mensaje');

    // Crear un elemento de mensaje de error
    var mensajeError = document.createElement('p');
    mensajeError.className = 'mensaje-error';
    mensajeError.textContent = mensaje;

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
var formulario = document.getElementById('formulario');

// Agregar el evento de validación al enviar el formulario
formulario.addEventListener('submit', validarFormulario);

function setMinDate() {
    var fechaInput = document.getElementById('fecha');
    var hoy = new Date();
    var diaSemana = hoy.getDay(); // 0: domingo, 1: lunes, ..., 6: sábado

    // Si hoy es sábado (6) o domingo (0), establecer la fecha mínima como el próximo lunes
    if (diaSemana === 6) {
        hoy.setDate(hoy.getDate() + 2); // Establecer fecha mínima para el próximo lunes
    } else if (diaSemana === 0) {
        hoy.setDate(hoy.getDate() + 1); // Establecer fecha mínima para el próximo lunes
    } else {
        hoy.setDate(hoy.getDate() + 1); // Establecer fecha mínima como mañana
    }

    var mes = (hoy.getMonth() + 1).toString().padStart(2, '0');
    var dia = hoy.getDate().toString().padStart(2, '0');
    var fechaMinima = hoy.getFullYear() + '-' + mes + '-' + dia;
    fechaInput.setAttribute('min', fechaMinima);
}

// Llamar a la función para establecer la fecha mínima cuando se carga la página
setMinDate();
