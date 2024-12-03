-- Procedimiento de Registro de Usuarios
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

--------------------------------------------------------------------------------------------------------------------------

-- Procedimiento para la actualización del estado del usuario ActualizarEstadoUsuario.php
DELIMITER $$

CREATE PROCEDURE actualizarEstadoUsuario (
    IN p_EstadoCuenta VARCHAR(255),
    IN p_ID INT
)
BEGIN
    UPDATE Usuarios SET EstadoCuenta = p_EstadoCuenta WHERE ID = p_ID;
END $$

DELIMITER ;

--------------------------------------------------------------------------------------------------------------------------

-- Vista para la consulta de pedidos en allPedidos.php
CREATE VIEW PedidosEnviados AS
SELECT ID, Descripcion, DireccionDestino, EstadoActual
FROM Pedidos
WHERE EstadoActual NOT IN ('Entregado', 'Extraviado', 'Cancelado');

--------------------------------------------------------------------------------------------------------------------------

-- Procedimiento para cancelarPedido.php
DELIMITER $$

CREATE PROCEDURE actualizarEstadoPedido (
    IN p_ID INT,
    IN p_EstadoActual VARCHAR(255)
)
BEGIN
    UPDATE Pedidos SET EstadoActual = p_EstadoActual WHERE ID = p_ID;
END $$

DELIMITER ;

--------------------------------------------------------------------------------------------------------------------------

-- Procedimmiento para obtener el nombre del rol del usuario
DELIMITER $$

CREATE PROCEDURE obtenerNombreRol (
    IN p_ID INT
)
BEGIN
    SELECT NombreRol FROM Usuarios WHERE ID = p_ID;
END $$

DELIMITER ;

--------------------------------------------------------------------------------------------------------------------------

-- Procedimmiento para obtener el nombre del usuario
DELIMITER $$

CREATE PROCEDURE obtenerNombreUsuario(
    IN p_ID INT
)
BEGIN
    SELECT NombreUsuario FROM Usuarios WHERE ID = p_ID;
END $$

DELIMITER ;

--------------------------------------------------------------------------------------------------------------------------

-- Vista para MostrarUsuarios.php de admin
CREATE VIEW vista_usuarios AS
SELECT ID, NombreUsuario, Email, NombreRol, EstadoCuenta FROM Usuarios;

--------------------------------------------------------------------------------------------------------------------------

-- Procedimiento para registrar usuarios desde el menu de admin
DELIMITER $$

CREATE PROCEDURE insertarUsuario(
    IN p_ID INT,
    IN p_NombreUsuario VARCHAR(255),
    IN p_Email VARCHAR(255),
    IN p_RolID INT,
    IN p_NombreRol VARCHAR(255),
    IN p_PasswordHash VARCHAR(255)
)
BEGIN
    INSERT INTO Usuarios (ID, NombreUsuario, Email, RolID, NombreRol, PasswordHash, EstadoCuenta)
    VALUES (p_ID, p_NombreUsuario, p_Email, p_RolID, p_NombreRol, p_PasswordHash, 'Activo');
END $$

DELIMITER ;

--------------------------------------------------------------------------------------------------------------------------

-- Procedimiento para actualizar el estado del pedido de repartidor
DELIMITER $$

CREATE PROCEDURE actualizarEstadoPedidoRepartidor (
    IN p_ID INT,
    IN p_EstadoActual VARCHAR(255)
)
BEGIN
    UPDATE Pedidos SET EstadoActual = p_EstadoActual WHERE ID = p_ID;
END $$

DELIMITER ;

--------------------------------------------------------------------------------------------------------------------------

-- Procedimiento para obtener los pedidos asignados a un repartidor
DELIMITER $$

CREATE PROCEDURE obtenerPedidosEnviadosUsuario(
    IN p_IDUsuario INT
)
BEGIN
    SELECT Pedidos.ID, Pedidos.Descripcion, Pedidos.EstadoActual
    FROM Asignaciones
    JOIN Pedidos ON Asignaciones.PedidoID = Pedidos.ID
    WHERE Asignaciones.ID = p_IDUsuario
        AND Pedidos.EstadoActual NOT IN ('Entregado', 'Extraviado', 'Cancelado');
END $$
    
DELIMITER ;

--------------------------------------------------------------------------------------------------------------------------

-- Procedimiento para obtener el id del usuario
DELIMITER $$

CREATE PROCEDURE obtenerIDUsuario(
    IN p_ID INT
)
BEGIN
    SELECT IDUsuario FROM Usuarios WHERE ID = p_ID;
END $$

DELIMITER ;

--------------------------------------------------------------------------------------------------------------------------

-- Procedimiento para almacenar los pedidos a recibir
DELIMITER $$

CREATE PROCEDURE insertarPedidoRecibir(
    IN p_ID INT,
    IN p_UsuarioID INT
)
BEGIN
    INSERT INTO pedidosRecibir (ID, UsuarioID)
    VALUES (p_ID, p_UsuarioID);
END $$

DELIMITER ;

--------------------------------------------------------------------------------------------------------------------------

-- Procedimiento para el envio de pedidos
DELIMITER $$

CREATE PROCEDURE insertarPedido(
    IN p_ID INT,
    IN p_UsuarioID INT,
    IN p_Destinatario VARCHAR(255),
    IN p_DireccionDestino VARCHAR(255),
    IN p_Descripcion TEXT,
    IN p_EstadoActual VARCHAR(255)
)
BEGIN
    INSERT INTO Pedidos (ID, UsuarioID, Destinatario, DireccionDestino, Descripcion, EstadoActual)
    VALUES (p_ID, p_UsuarioID, p_Destinatario, p_DireccionDestino, p_Descripcion, p_EstadoActual);
END $$

DELIMITER ;


--------------------------------------------------------------------------------------------------------------------------

-- Procediiento para obtener la lista de pedidos enviados
DELIMITER $$

CREATE PROCEDURE obtenerPedidosPorUsuario(
    IN p_UsuarioID INT
)
BEGIN
    SELECT ID, Descripcion, Destinatario
    FROM Pedidos
    WHERE UsuarioID = p_UsuarioID;
END $$

DELIMITER ;

--------------------------------------------------------------------------------------------------------------------------

-- Procedimiento para obtener los pedidos a recibir
DELIMITER $$

CREATE PROCEDURE obtenerPedidosRecibir(
    IN p_UsuarioID INT
)
BEGIN
    SELECT Pedidos.ID, Pedidos.Descripcion, Usuarios.NombreUsuario
    FROM pedidosRecibir
    JOIN Pedidos ON pedidosRecibir.ID = Pedidos.ID
    JOIN Usuarios ON Pedidos.UsuarioID = Usuarios.IDUsuario
    WHERE pedidosRecibir.UsuarioID = p_UsuarioID;
END $$

DELIMITER ;

--------------------------------------------------------------------------------------------------------------------------

-- Procedimiento para obtener el estado del pedido anonimamente
DELIMITER $$

CREATE PROCEDURE obtenerEstadoPedido(
    IN p_ID INT
)
BEGIN
    SELECT EstadoActual FROM Pedidos WHERE ID = p_ID;
END $$

DELIMITER ;

--------------------------------------------------------------------------------------------------------------------------

-- Procedimiento para asinar repartidor
DELIMITER $$

CREATE PROCEDURE insertarAsignacion(
    IN p_ID INT,
    IN p_PedidoID INT
)
BEGIN
    INSERT INTO Asignaciones (ID, PedidoID) VALUES (p_ID, p_PedidoID);
END $$

DELIMITER ;

--------------------------------------------------------------------------------------------------------------------------

-- Vista de los pedidos pendientes de asignar
CREATE VIEW vista_pedidos_en_proceso AS
SELECT
    Pedidos.ID,
    Usuarios.NombreUsuario,
    Pedidos.Destinatario,
    Pedidos.Descripcion
FROM
    Pedidos
JOIN
    Usuarios ON Pedidos.UsuarioID = Usuarios.IDUsuario
WHERE
    Pedidos.EstadoActual = 'Paquete en proceso';

--------------------------------------------------------------------------------------------------------------------------

-- Vista para los repartidores activos
CREATE VIEW vista_repartidores_activos AS
SELECT ID, NombreUsuario, Email, EstadoCuenta
FROM Usuarios
WHERE RolID = 2 AND EstadoCuenta = 'Activo';
