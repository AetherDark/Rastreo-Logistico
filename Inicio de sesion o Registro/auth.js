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

// Verificar si el usuario está autenticado y el estado de su cuenta
async function checkAuth() {
    const userID = getCookie("user_id");
    if (!userID) {
        // Si la cookie no existe, redirige al inicio de sesión
        window.location.href = "../Inicio de sesion o Registro/Sesion.html";
    } else {
        try {
            const response = await fetch("../Inicio de sesion o Registro/CheckAccountStatus.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                }
            });
    
            const data = await response.json();
    
            if (data.status && data.status === "Suspendido") {
                window.location.href = "../Inicio de sesion o Registro/Sesion.html?Suspendido=1";
            } else if (data.status && data.status === "Activo") {
                console.log("Cuenta activa. Acceso permitido.");
            } else {
                console.error("Error al verificar el estado de la cuenta:", data.message);
                window.location.href = "../Inicio de sesion o Registro/Sesion.html?ErrorCuenta=1";
            }            
        } catch (error) {
            console.error("Error en la verificación de la cuenta:", error);
            // Redirigir al login en caso de error en la comunicación
            window.location.href = "../Inicio de sesion o Registro/Sesion.html";
        }
    }
}

// Ejecutar la verificación de autenticación al cargar la página
document.addEventListener("DOMContentLoaded", checkAuth);