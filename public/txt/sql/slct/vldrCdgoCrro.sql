DELIMITER $$

DROP PROCEDURE IF EXISTS sp_validarCodigo $$

CREATE PROCEDURE sp_validarCodigo(
    IN pClave VARCHAR(200),
    IN pCorreo VARCHAR(500))
BEGIN
    
    DECLARE verificaCodigo INT DEFAULT 0;
    
    SET verificaCodigo = (SELECT count(id) FROM usuarios WHERE correo = pCorreo and codigoConfirmacion = pClave );
    
    IF verificaCodigo = 0 THEN 
    
        SELECT 'error' as estatus, 'codigo invalido' as mensaje, pCorreo as correo;
        
    ELSE 
        
        UPDATE usuarios SET correoConfirmado = 1 where  correo = pCorreo;
        
        SELECT 'verificado' as estatus, 'codigo valido' as mensaje, pCorreo as correo;
        
    END IF;

END $$

CALL sp_validarCodigo( @codigo, @correo ) $$

DROP PROCEDURE IF EXISTS sp_validarCodigo $$
 
DELIMITER ;