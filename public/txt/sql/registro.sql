DELIMITER $$

DROP PROCEDURE IF EXISTS sp_registro $$
 
CREATE PROCEDURE sp_registro(
    IN pClave VARCHAR(200),
    IN pCodigo MEDIUMINT(9),
    IN pNombre VARCHAR(200),
    IN pAPaterno VARCHAR(200),
    IN pAMaterno VARCHAR(200),
    IN pCorreo VARCHAR(500),
    IN pTelefono VARCHAR(50))
BEGIN
    
    DECLARE existeMailUsuario INT DEFAULT 0;
    DECLARE existeCorreo INT DEFAULT 0;
    
    SET existeMailUsuario = (SELECT count(id) FROM usuarios WHERE correo = pCorreo );
    SET existeCorreo = (SELECT count(id) FROM correos WHERE correo = pCorreo and codigoConfirmacion = pCodigo);
    
    IF existeCorreo = 0 THEN 
    
        SELECT 0 AS ID, 'error' as estatus, 'correo no confirmado' as mensaje, pCorreo as correo;
        
    ELSE 
        IF existeMailUsuario = 0 THEN 
        
            UPDATE correos SET confirmado = 1, fechaConfirmado = current_timestamp() WHERE correo = pCorreo and codigoConfirmacion = pCodigo;
        
            INSERT INTO usuarios
                (cntr,nombre,aPaterno,aMaterno,correo,telefono,correoConfirmado,idUsuarioAlta,codigoConfirmacion)
            VALUES 
                (AES_ENCRYPT(pClave,'solucionAfore'),pNombre,pAPaterno,pAMaterno,pCorreo,pTelefono,1,0,pCodigo);
            
            SELECT LAST_INSERT_ID() AS ID, 'insertado' as estatus, 'usuario insertado' as mensaje, pCorreo as correo;
            
        ELSE 
        
            SELECT 0 AS ID, 'error' as estatus, 'correo existe' as mensaje, pCorreo as correo;
        
        END IF;
        
    END IF;

END $$

CALL sp_registro( @clave, @codigo, @nombre, @aPaterno, @aMaterno, @correo, @telefono ) $$

DROP PROCEDURE IF EXISTS sp_registro $$
 
DELIMITER ;