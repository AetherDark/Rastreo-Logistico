create database RastreoLogistico

use RastreoLogistico

-- Gestion de usuarios y roles --
create table Roles -- Para definir los roles y permisos --
(
ID int identity(1,1) primary key,
Nombre nvarchar(50) not null,
Descripcion nvarchar(255)
)

create table Usuarios -- Para almacenar la informacion de cada usuario --
(
ID int identity(1,1) primary key,
NombreUsuario nvarchar(100) not null unique,
Email nvarchar(100) not null unique,
PasswordHash nvarchar(255) not null,
RolID int foreign key references Roles(ID),
FechaCreacion datetime default getdate()
)

-- Si se necesita multiples roles para cada usuario, se usa esta tabla intermedia --
create table RolesUsuarios -- Para asignar roles a usuarios --
(
UsuarioID int foreign key references Usuarios(ID),
RolID int foreign key references Roles(ID),
primary key (UsuarioID, RolID)
)

-- Gestion de pedidos y rastreo --
create table Pedidos -- Para registrar los pedidos --
(
ID int identity(1,1) primary key,
UsuarioID int foreign key references Usuarios(ID),
FechaCreacion datetime default getdate(),
Descripcion nvarchar(max),
EstadoActual nvarchar(50) not null -- Estado Actual del pedido --
)

create table EstadosPedido -- Para almacenar los diferentes estados --
(
ID int identity(1,1) primary key,
NombreEstado nvarchar(50) not null -- Ej: 'En transito', 'Entregado', 'Perdido', 'Cnacelado'
)

create table HistorialPedidos -- Para registrar los cambios de estado y quien los realizo --
(
ID int identity(1,1) primary key,
PedidoID int foreign key references Pedidos(ID),
UsuarioID int foreign key references Usuarios(ID), -- Quien modifico el estado --
EstadoID int foreign key references EstadosPedido(ID),
FechaCambio datetime default getdate(),
Comentario nvarchar(max)
)