SET @codigoConfirmacion = (SELECT FLOOR(RAND()*(5000-0+1))+1000);

update usuarios set codigoConfirmacion = @codigoConfirmacion where correo = @correo;

SELECT  @correo as correo, 'actualizado' as estatus, 'codigo actualizado' as mensaje, @codigoConfirmacion as codigo ; 