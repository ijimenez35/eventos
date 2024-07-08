SELECT 
    usuarios.id,
    usuarios.nombre, 
    usuarios.aPaterno, 
    usuarios.aMaterno, 
    usuarios.telefono, 
    usuarios.correo
    
FROM usuarios 

WHERE 
    usuarios.id = @idUsuario