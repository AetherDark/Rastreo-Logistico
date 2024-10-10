-- Procedimiento de Registro de Usuarios

CREATE PROCEDURE registrarUsuario(
    IN p_NombreUsuario VARCHAR(100),
    IN p_Email VARCHAR(100),
    IN p_PasswordHash VARCHAR(255),
    IN p_RolID INT,
    IN p_NombreRol VARCHAR(50)
)
BEGIN
    -- Verificar si el nombre de usuario o el correo electrónico ya existen
    IF EXISTS (SELECT 1 FROM Usuarios WHERE NombreUsuario = p_NombreUsuario OR Email = p_Email) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'El nombre de usuario o el correo ya están en uso.';
    ELSE
        -- Insertar nuevo usuario
        INSERT INTO Usuarios (NombreUsuario, Email, PasswordHash, RolID, NombreRol, FechaCreacion)
        VALUES (p_NombreUsuario, p_Email, p_PasswordHash, p_RolID, p_NombreRol, NOW());
    END IF;
END;

-- Procedimiento de Logueo

CREATE PROCEDURE iniciarSesion(
    IN p_email VARCHAR(100),
    IN p_password VARCHAR(255),
    OUT p_id INT,
    OUT p_nombreUsuario VARCHAR(100),
    OUT p_rolID INT,
    OUT p_nombreRol VARCHAR(50)
)
BEGIN
    DECLARE v_passwordHash VARCHAR(255);
    
    -- Buscar el usuario por email
    SELECT ID, NombreUsuario, RolID, NombreRol, PasswordHash INTO p_id, p_nombreUsuario, p_rolID, p_nombreRol, v_passwordHash
    FROM Usuarios
    WHERE Email = p_email;

    -- Verificar si se encontró el usuario
    IF p_id IS NOT NULL THEN
        -- Verificar la contraseña
        IF v_passwordHash = p_password THEN
            -- Contraseña correcta, no se necesita hacer nada
            SET p_nombreUsuario = v_passwordHash; -- Para que sepa que se ha autenticado correctamente.
        ELSE
            -- Contraseña incorrecta
            SET p_id = NULL;
            SET p_nombreUsuario = NULL;
            SET p_rolID = NULL;
            SET p_nombreRol = NULL;
        END IF;
    ELSE
        -- Usuario no encontrado
        SET p_id = NULL;
        SET p_nombreUsuario = NULL;
        SET p_rolID = NULL;
        SET p_nombreRol = NULL;
    END IF;
END;