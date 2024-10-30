-- Procedimientos almacenados para el registro de usuarios
DELIMITER //

CREATE PROCEDURE registrarUsuario(
    IN p_NombreUsuario VARCHAR(100),  -- Nombre del usuario a registrar
    IN p_Email VARCHAR(100),            -- Correo electrónico del usuario
    IN p_PasswordHash VARCHAR(255),     -- Contraseña en formato hash
    IN p_RolID INT,                     -- ID del rol asignado al usuario
    IN p_NombreRol VARCHAR(50)          -- Nombre del rol asignado al usuario
)
BEGIN
    -- Intentar insertar un nuevo usuario en la tabla Usuarios
    INSERT INTO Usuarios (NombreUsuario, Email, PasswordHash, RolID, NombreRol, FechaCreacion)
    VALUES (p_NombreUsuario, p_Email, p_PasswordHash, p_RolID, p_NombreRol, NOW());
    -- Se utiliza NOW() para registrar la fecha y hora de creación
END //

DELIMITER ;



-- Procedimiento almacenado de Logueo de usuarios

DELIMITER //

CREATE PROCEDURE iniciarSesion(
    IN p_email VARCHAR(100),             -- Correo electrónico del usuario para iniciar sesión
    IN p_password VARCHAR(255),          -- Contraseña en formato hash ingresada por el usuario
    OUT p_id INT,                        -- ID del usuario encontrado
    OUT p_nombreUsuario VARCHAR(100),    -- Nombre de usuario del usuario encontrado
    OUT p_rolID INT,                     -- ID del rol del usuario encontrado
    OUT p_nombreRol VARCHAR(50)          -- Nombre del rol del usuario encontrado
)
BEGIN
    -- Declarar una variable para almacenar el hash de la contraseña
    DECLARE v_passwordHash VARCHAR(255);
    
    -- Buscar el usuario por correo electrónico
    SELECT ID, NombreUsuario, RolID, NombreRol, PasswordHash INTO p_id, p_nombreUsuario, p_rolID, p_nombreRol, v_passwordHash
    FROM Usuarios
    WHERE Email = p_email;

    -- Verificar si se encontró el usuario
    IF p_id IS NOT NULL THEN
        -- Comparar el hash de la contraseña almacenado con la contraseña ingresada
        IF v_passwordHash = p_password THEN
            -- La contraseña es correcta; se devuelve el nombre de usuario y otros datos
            SET p_nombreUsuario = v_nombreUsuario; -- Almacena el nombre de usuario en el parámetro de salida
        ELSE
            -- La contraseña es incorrecta; limpiar los parámetros de salida
            SET p_id = NULL;
            SET p_nombreUsuario = NULL;
            SET p_rolID = NULL;
            SET p_nombreRol = NULL;
        END IF;
    ELSE
        -- No se encontró ningún usuario; limpiar los parámetros de salida
        SET p_id = NULL;
        SET p_nombreUsuario = NULL;
        SET p_rolID = NULL;
        SET p_nombreRol = NULL;
    END IF;
END //

DELIMITER ;
