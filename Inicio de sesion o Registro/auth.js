// auth.js: Archivo para manejar la autenticación con cookies

// Función para obtener una cookie por su nombre
function getCookie(name) {
    let cookieArr = document.cookie.split(";");
    for (let i = 0; i < cookieArr.length; i++) {
        let cookiePair = cookieArr[i].split("=");
        if (name === cookiePair[0].trim()) {
            return decodeURIComponent(cookiePair[1]);
        }
    }
    return null;
}

// Verificar si el usuario está autenticado
function checkAuth() {
    const userID = getCookie("user_id");
    if (!userID) {
        // Si la cookie no existe, redirige al inicio de sesión
        window.location.href = "../Inicio de sesion o Registro/Sesion.html";
    } else {
        console.log("User ID:", userID);
        // Aquí puedes añadir lógica adicional si es necesario
    }
}

// Ejecutar la verificación de autenticación al cargar la página
document.addEventListener("DOMContentLoaded", checkAuth);
