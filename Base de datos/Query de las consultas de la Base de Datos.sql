-- Consultas con joins --

-- Ver el historial de un pedido --
select p.ID as PedidoID, p.Descripcion as Descripcion, u.NombreUsuario, e.NombreEstado as Estado, h.FechaCambio, h.Comentario from HistorialPedidos h
inner join Pedidos p on h.PedidoID = p.ID
inner join Usuarios u on h.UsuarioID = u.ID
inner join EstadosPedido e on h.EstadoID = e.ID
where p.ID = @PedidoID
-- Se usa ese parametro de @PedidoID para sea el usuario que rellene ese campo y se haga la consulta al ID que este dio del pedido --
-- Para que este pueda ver el estado de su pedido ya sea entregado o en transito --

-- Consultar pedidos y su estado actual --
select p.ID as PedidoID, u.NombreUsuario, p.Descripcion, p.EstadoActual, p.FechaCreacion from Pedidos p
inner join Usuarios u on p.UsuarioID = u.ID
where u.RolID = 3 -- Filtra por rol si es necesario, por ejemplo, "Repartidor" --

-- Ver los usuarios con su Rol --
select u.NombreUsuario, r.Nombre as Rol from Usuarios u
inner join Roles r on u.RolID = r.ID