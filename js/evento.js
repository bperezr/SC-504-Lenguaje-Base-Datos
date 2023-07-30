
// Obtener el formulario y agregar el evento de envío
var formularioEvento = document.getElementById('formularioEvento');
formularioEvento.addEventListener('submit', function (event) {
    event.preventDefault();
});


function previewImage() {
    var preview = document.getElementById("preview");
    var file = document.querySelector("input[type=file]").files[0];
    var reader = new FileReader();

    reader.onloadend = function () {
        preview.src = reader.result;
    };

    if (file) {
        reader.readAsDataURL(file);
    } else {
        preview.src = "img/no_disponible.webp"; // Imagen de reemplazo si no hay imagen seleccionada
    }
}

// Añadir el evento 'change' al input de tipo 'file'
document.getElementById("imagen").addEventListener("change", previewImage);

