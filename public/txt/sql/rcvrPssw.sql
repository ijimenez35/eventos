
DELIMITER $$

DROP PROCEDURE IF EXISTS sp_codigoTemporal $$

CREATE PROCEDURE sp_codigoTemporal(
    IN pTelefono VARCHAR(200),
    IN pCorreo VARCHAR(500))
BEGIN
    
    DECLARE verificaUsuario INT DEFAULT 0;
    DECLARE codigoTemporal INT DEFAULT 0;
    
    SET verificaUsuario = (SELECT count(id) FROM usuarios WHERE correo = pCorreo and telefono = pTelefono );
    
    IF verificaUsuario = 0 THEN 
    
        SELECT 'error' as estatus, 'usuario no existe' as mensaje, pCorreo as correo, pTelefono as telefono;
        
    ELSE 
    
        SET codigoTemporal = (SELECT FLOOR(RAND()*(5000-0+1))+1000);
        
        UPDATE usuarios SET cntrTmpr = codigoTemporal WHERE correo = pCorreo and telefono = pTelefono;

        SELECT 'reestablecida' as estatus, 'codigo actualizado' as mensaje, pCorreo as correo, pTelefono as telefono, codigoTemporal as codigo; 
        
    END IF;

END $$

CALL sp_codigoTemporal( @telefono, @correo ) $$

DROP PROCEDURE IF EXISTS sp_codigoTemporal $$
 
DELIMITER ;