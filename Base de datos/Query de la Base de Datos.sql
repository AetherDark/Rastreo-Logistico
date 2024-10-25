create database RastreoLogistico;

use RastreoLogistico;

create table Roles -- Definir los roles y permisos
(
    ID int not null,
    Nombre varchar(50) not null,
    Descripcion varchar(255),
    primary key (ID,Nombre) -- Clave primaria compuesta
);

-- Insercion de roles
insert into Roles (ID, Nombre, Descripcion) values
(1, 'Admin', 'Rol de Administrador'),
(2, 'Repartidor', 'Rol de Repartidor'),
(3, 'Usuario', 'Rol de Usuario');

-- Para almacenar la información de cada usuario
create table Usuarios
(
    ID int AUTO_INCREMENT PRIMARY KEY,
    NombreUsuario varchar(100) not null unique,
    Email varchar(100) not null unique,
    PasswordHash varchar(255) not null,
    RolID int, -- Solo se guarda el ID del rol
    NombreRol varchar(50), --Solo se guarda el Nombre del Rol
    FechaCreacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (RolID, NombreRol) REFERENCES Roles(ID, Nombre) -- Referencia solo a ID y Nombre
);

-- Usuario de rol ADMIN
INSERT INTO Usuarios (NombreUsuario, Email, PasswordHash, RolID, NombreRol)
VALUES ('ADMIN', 'admin@gmail.com', '123456', 1, 'Admin');

-- Gestión de pedidos y rastreo

create table Pedidos -- Para registrar los pedidos
(
    ID int AUTO_INCREMENT primary key,
    UsuarioID int,
    FechaCreacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    Descripcion TEXT,
    EstadoActual varchar(50) not null, -- Estado Actual del pedido
    FOREIGN KEY (UsuarioID) REFERENCES Usuarios(ID)
)

CREATE TABLE EstadosPedido -- Para almacenar los diferentes estados
(
    ID INT AUTO_INCREMENT PRIMARY KEY,
    NombreEstado VARCHAR(50) NOT NULL -- Ej: 'En tránsito', 'Entregado', 'Perdido', 'Cancelado'
);

CREATE TABLE HistorialPedidos -- Para registrar los cambios de estado y quién los realizó
(
    ID INT AUTO_INCREMENT PRIMARY KEY,
    PedidoID INT,
    UsuarioID INT, -- Quien modificó el estado
    EstadoID INT,
    FechaCambio DATETIME DEFAULT CURRENT_TIMESTAMP,
    Comentario TEXT,
    FOREIGN KEY (PedidoID) REFERENCES Pedidos(ID),
    FOREIGN KEY (UsuarioID) REFERENCES Usuarios(ID),
    FOREIGN KEY (EstadoID) REFERENCES EstadosPedido(ID)
);

-- Tabla de recuperacion de contraseña
CREATE TABLE PasswordResets (
    Email VARCHAR(255) NOT NULL,
    Token VARCHAR(255) NOT NULL,
    FechaCreacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (Email),  -- Si solo va a haber un token activo por correo
    INDEX(Email)  -- Índice para consultas más rápidas
);
