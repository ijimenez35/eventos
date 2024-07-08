
DELIMITER $$

DROP PROCEDURE IF EXISTS sp_setClave $$

CREATE PROCEDURE sp_setClave(
    IN pCorreo VARCHAR(500),
    IN pClave VARCHAR(200)) 
BEGIN
    
    DECLARE verificaUsuario INT DEFAULT 0;
    
    SET verificaUsuario = (SELECT count(id) FROM usuarios WHERE correo = pCorreo );
    
    IF verificaUsuario = 0 THEN 
    
        SELECT 'error' as estatus, 'usuario no existe' as mensaje, pCorreo as correo;
        
    ELSE 
    
        UPDATE usuarios SET cntrTmpr = '', cntr = pClave WHERE correo = pCorreo;

        SELECT 'exito' as estatus, 'clave de acceso actualizada' as mensaje, pCorreo as correo ; 
        
    END IF;

END $$

CALL sp_setClave( @correo, @cntr ) $$

DROP PROCEDURE IF EXISTS sp_setClave $$
 
DELIMITER ;