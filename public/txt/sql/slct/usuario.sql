SELECT 
    usuarios.id,
    usuarios.estatus,
    usuarios.habilitado, 
    usuarios.administrador
FROM usuarios 

WHERE 
    usuarios.id = @id 