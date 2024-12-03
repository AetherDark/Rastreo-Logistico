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
    try {
        const response = await fetch("CheckRolUsuario.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            }
        });

        const data = await response.json();

        if (data.status && data.status !== "Usuario") {
            window.location.href = "../InicioDeSesionORegistro/Sesion.html?Auto=1";
            alert("Error al verificar las credenciales. Por favor, intente de nuevo.");
        } else if (data.status && data.status === "Usuario") {
            console.log("Rol Correcto.");
        } else {
            console.error("Error al verificar el estado de la cuenta:", data.message);
            window.location.href = "../InicioDeSesionORegistro/Sesion.html?ErrorAuto=1";
            alert("Error al verificar la cuenta. Por favor, intente de nuevo.");
        }            
    } catch (error) {
        console.error("Error en la verificación de la cuenta:", error);
        // Redirigir al login en caso de error en la comunicación
        window.location.href = "../InicioDeSesionORegistro/Sesion.html";
        alert("Error al verificar el estado de la cuenta. Por favor, intente de nuevo.");
    }
}

// Ejecutar la verificación de autenticación al cargar la página
document.addEventListener("DOMContentLoaded", checkAuth);
