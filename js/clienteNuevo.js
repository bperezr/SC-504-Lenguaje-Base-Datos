
/*  */
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
        preview.src = "img/no_disponible.webp";
    }
}

document.getElementById("imagen").addEventListener("change", previewImage);
