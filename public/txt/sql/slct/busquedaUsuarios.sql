SELECT 
    usuarios.id,
    usuarios.nombre, 
    usuarios.aPaterno, 
    usuarios.aMaterno, 
    usuarios.telefono, 
    usuarios.correo
FROM usuarios 
WHERE 
    usuarios.correo like CONCAT('%', @correo, '%') and 
    usuarios.telefono like CONCAT('%', @telefono, '%') and 
    usuarios.nombre like CONCAT('%', @nombre, '%') and 
    usuarios.aPaterno like CONCAT('%', @aPaterno, '%') and 
    usuarios.aMaterno like CONCAT('%', @aMaterno, '%') 