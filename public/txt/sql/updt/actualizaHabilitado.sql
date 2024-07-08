update usuarios set 
habilitado = @habilitado 
where id = @idUsuario;

select 'actualizado' as estatus 