update usuarios set 
administrador = @administrador 
where id = @idUsuario;

select 'actualizado' as estatus 