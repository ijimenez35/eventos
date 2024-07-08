DELIMITER $$

DROP PROCEDURE IF EXISTS sp_altaUsuario $$

CREATE PROCEDURE sp_altaUsuario(
    IN pId INT,
    IN pNombre VARCHAR(200), 
    IN pAPaterno VARCHAR(200), 
    IN pAMaterno VARCHAR(200), 
    IN pTelefono VARCHAR(100), 
    IN pCorreo VARCHAR(200),
    IN pIdUsuarioAlta INT)
BEGIN
    
    IF pId = 0 THEN 
    
        INSERT INTO usuarios
            (nombre, aPaterno, aMaterno, telefono, correo, idUsuarioAlta)
        VALUES 
            (pNombre, pAPaterno, pAMaterno, pTelefono, pCorreo, pIdUsuarioAlta);
        
        SELECT LAST_INSERT_ID() AS id, 'insertado' as estatus, 'registro insertado' as mensaje;
        
    ELSE 
    
        UPDATE usuarios SET 
            nombre  = pNombre,
            aPaterno = pAPaterno,
            aMaterno = pAMaterno,
            telefono = pTelefono
        WHERE id = pId;

        SELECT pId as id, 'actualizado' as estatus, 'registro actualizado' as mensaje; 
        
    END IF;
        
END $$

CALL sp_altaUsuario(
    @id,@nombre,@aPaterno,@aMaterno,@telefono,@correo,@idUsuario
) $$

DROP PROCEDURE IF EXISTS sp_altaUsuario $$
