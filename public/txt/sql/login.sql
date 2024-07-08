SELECT 
    id,
	nombre,
	aPaterno,
	aMaterno,
	correo,
	lang,
	ladaPais,
	telefono,
	correoConfirmado,
	idUsuarioAlta,
	fechaAlta,
	estatus,
	habilitado,
	administrador, 
	case when cntrTmpr = @cntr then 1 else 0 end as cntrTmpr 
FROM usuarios 
where 
    correo = @email and 
    (cntr = AES_ENCRYPT(@cntr,'solucionAfore') or cntrTmpr = @cntr ) and 
    estatus = 1 