CREATE DATABASE RastreoLogistico;

USE RastreoLogistico;

-- Tabla de Roles
CREATE TABLE Roles 
(
    ID BIGINT NOT NULL,
    Nombre VARCHAR(50) NOT NULL,
    Descripcion VARCHAR(255),
    PRIMARY KEY (ID, Nombre) -- Clave primaria compuesta
);

-- Inserción de roles
INSERT INTO Roles (ID, Nombre, Descripcion) VALUES
(1, 'Admin', 'Rol de Administrador'),
(2, 'Repartidor', 'Rol de Repartidor'),
(3, 'Usuario', 'Rol de Usuario');

-- Tabla Usuarios
CREATE TABLE Usuarios
(
	IDUsuario BIGINT AUTO_INCREMENT PRIMARY KEY,
	ID BIGINT,
    NombreUsuario VARCHAR(100) NOT NULL UNIQUE,
    Email VARCHAR(100) NOT NULL UNIQUE,
    PasswordHash VARCHAR(255) NOT NULL,
    RolID BIGINT, -- ID del rol
    NombreRol VARCHAR(50), -- Nombre del rol
    EstadoCuenta VARCHAR(50), -- Nombre del estado de la cuenta
    FechaCreacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (RolID, NombreRol) REFERENCES Roles(ID, Nombre)
);

-- Usuario de rol ADMIN
INSERT INTO Usuarios (ID, NombreUsuario, Email, PasswordHash, RolID, NombreRol, EstadoCuenta)
VALUES (1, 'ADMIN', 'admin@gmail.com', '123456', 1, 'Admin', 'Activo');

-- Tabla de Pedidos
CREATE TABLE Pedidos 
(
    ID BIGINT AUTO_INCREMENT UNIQUE PRIMARY KEY, -- ID del pedido
    UsuarioID BIGINT, -- Remitente del que envia
    Destinatario VARCHAR(50), -- Nombre del destinatario
    DireccionDestino VARCHAR(255), -- Dirección de destino
    Descripcion TEXT, -- Descripcion del pedido a enviar
    EstadoActual VARCHAR(50) NOT NULL, -- Estado Actual del pedido (Paquete en proceso, paquete enviado, en transito, entregado)
    FechaCreacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (UsuarioID) REFERENCES Usuarios(IDUsuario)
);

-- Tabla de pedidos a recibir
CREATE TABLE pedidosRecibir
(
    IDRecibir BIGINT AUTO_INCREMENT PRIMARY KEY, -- ID de la tabla
    ID BIGINT, -- ID del pedido
    UsuarioID BIGINT, -- ID del que recibira el pedido
    FOREIGN KEY (UsuarioID) REFERENCES Usuarios(IDUsuario),
    FOREIGN KEY (ID) REFERENCES Pedidos(ID)
);

-- Tabla para asignar pedidos a repartidores
CREATE TABLE Asignaciones
(
	IDAsignacion BIGINT AUTO_INCREMENT PRIMARY KEY, -- ID de la asignacion
    ID BIGINT, -- ID de la asignacion
    PedidoID BIGINT, -- ID del pedido
    FOREIGN KEY (ID) REFERENCES Usuarios(IDUsuario),
    FOREIGN KEY (PedidoID) REFERENCES Pedidos(ID)
);