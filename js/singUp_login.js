function validateSignupForm() {
    console.log("Validating form...");
    const signupEmail = document.getElementById('signupEmail');
    const signupPassword = document.getElementById('contrasena');
    const signupConfirmPassword = document.getElementById('contrasena2');

    const correo = signupEmail.value.trim();

    if (!/^[\w\.-]+@[\w\.-]+\.\w{2,3}$/.test(correo)) {
        alert("Ingrese un correo electrónico válido");
        return false;
    }

    if (signupPassword.value !== signupConfirmPassword.value) {
        alert("Las contraseñas no coinciden");
        return false;
    }

    const passwordPattern = /^(?=.*[-\#\$\.\%\&\@\!\+\=\\*])(?=.*[a-zA-Z])(?=.*\d).{8,12}$/;

    if (!passwordPattern.test(signupPassword.value)) {
        alert("La contraseña debe tener al menos una letra mayúscula, una letra minúscula, un numéro, un carácter especial y una longitud mínima de 8 caracteres");
        return false;
    }

    return true;
}