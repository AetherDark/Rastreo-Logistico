-- Procedimiento de Registro de Usuarios
-- Verificación de la existencia de un usuario
DELIMITER //

CREATE TRIGGER verificarDuplicadosAntesDeInsertar
BEFORE INSERT ON Usuarios
FOR EACH ROW
BEGIN
    -- Verificar si el nombre de usuario o el correo electrónico ya existen
    IF EXISTS (SELECT 1 FROM Usuarios WHERE NombreUsuario = NEW.NombreUsuario OR Email = NEW.Email) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'El nombre de usuario o el correo ya están en uso.';
    END IF;
END//

DELIMITER ;

-- Procedimiento de registros de usuarios
DELIMITER //

CREATE PROCEDURE registrarUsuario(
	IN p_ID BIGINT,
    IN p_NombreUsuario VARCHAR(100),
    IN p_Email VARCHAR(100),
    IN p_PasswordHash VARCHAR(255),
    IN p_RolID INT,
    IN p_NombreRol VARCHAR(50)
)
BEGIN
    -- Insertar nuevo usuario con EstadoCuentaID predeterminado
    INSERT INTO Usuarios (ID, NombreUsuario, Email, PasswordHash, RolID, NombreRol, EstadoCuenta, FechaCreacion)
    VALUES (p_ID, p_NombreUsuario, p_Email, p_PasswordHash, p_RolID, p_NombreRol, 'Activo', NOW());
END//

DELIMITER ;

--------------------------------------------------------------------------------------------------------------------------------

-- Procedimiento de Logueo

DELIMITER //
CREATE PROCEDURE iniciarSesion(
    IN p_email VARCHAR(100),
    IN p_password VARCHAR(255),
    OUT p_id BIGINT,
    OUT p_nombreUsuario VARCHAR(100),
    OUT p_rolID INT,
    OUT p_nombreRol VARCHAR(50)
)
BEGIN
    DECLARE v_passwordHash VARCHAR(255);

    -- Buscar el usuario por email y obtener la contraseña cifrada
    SELECT ID, NombreUsuario, RolID, NombreRol, PasswordHash INTO p_id, p_nombreUsuario, p_rolID, p_nombreRol, v_passwordHash
    FROM Usuarios
    WHERE Email = p_email;

    -- Verificar si se encontró el usuario
    IF p_id IS NOT NULL THEN
        -- Comparar la contraseña ingresada con la almacenada (asegúrate de que estén cifradas de la misma manera)
        IF v_passwordHash = p_password THEN
            -- Contraseña correcta
            SET p_nombreUsuario = p_nombreUsuario; 
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
END //
DELIMITER ;

--------------------------------------------------------------------------------------------------------------------------

-- Procedimiento para la eliminacion de usuarios
DELIMITER //

CREATE PROCEDURE eliminarUsuario(IN userID INT)
BEGIN
    DELETE FROM Usuarios WHERE ID = userID;
END //

DELIMITER ;
