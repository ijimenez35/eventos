DELIMITER $$

DROP PROCEDURE IF EXISTS sp_verificaCorreo $$
 
CREATE PROCEDURE sp_verificaCorreo(
    IN pCorreo VARCHAR(500),
    IN pAccion VARCHAR(500))
BEGIN
    
    DECLARE existeMail INT DEFAULT 0;
    DECLARE codigoConfirmacion INT DEFAULT 0;
    DECLARE existeUsuario INT DEFAULT 0;
    DECLARE idCorreo INT DEFAULT 0;
    DECLARE accion INT DEFAULT 0;
    
    SET existeMail = (SELECT count(id) FROM correos WHERE correo = pCorreo );
    
    IF existeMail = 0 THEN 
    
        SET codigoConfirmacion = (SELECT FLOOR(RAND()*(100-0+1))+100);
        
        INSERT INTO correos 
            (correo,codigoConfirmacion,confirmado,fechaConfirmado)
        VALUES 
            (pCorreo,codigoConfirmacion,0,null);
        
        SELECT LAST_INSERT_ID() AS ID, 'insertado' as estatus, 'correo agregado' as mensaje, pCorreo as correo, codigoConfirmacion as codigo;
        
    ELSE 
        SET existeUsuario = (SELECT count(id) FROM usuarios WHERE correo = pCorreo );
        
        IF existeUsuario = 0 THEN 
        
            SET idCorreo = ( SELECT correos.id FROM correos WHERE correos.correo = pCorreo ORDER BY id DESC LIMIT 1);
            
            SET codigoConfirmacion = ( SELECT correos.codigoConfirmacion FROM correos WHERE correos.correo = pCorreo ORDER BY id DESC LIMIT 1);
            
            IF IFNULL(pAccion, 0) = 1 THEN 
                
                SET codigoConfirmacion = ( SELECT FLOOR(RAND()*(100-0+1))+100 );
                
                UPDATE correos SET correos.codigoConfirmacion = codigoConfirmacion WHERE correos.id = idCorreo;
                
                SELECT idCorreo AS ID, 'actualizado' as estatus, 'codigo actualizado' as mensaje, pCorreo as correo, codigoConfirmacion as codigo;
                
            ELSE 
            
                SELECT idCorreo AS ID, 'enviado' as estatus, 'codigo enviado' as mensaje, pCorreo as correo;
                
            END IF;
            
        ELSE 
            
            SELECT 0 AS ID, 'existe' as estatus, 'correo existe en el sistema' as mensaje, pCorreo as correo, '' as codigo;
        
        END IF;
        
    END IF;

END $$

CALL sp_verificaCorreo( @mail, @accion ) $$

DROP PROCEDURE IF EXISTS sp_verificaCorreo $$
 
DELIMITER ;