SELECT 
    rolUsuario.id, 
    rolUsuario.idUsuario, 
    rolUsuario.idRol as idRol, 
    rolUsuario.estatus,
    rol.descripcion as rolNombre,
    rolUsuario.idFolio as idFolioRol, 
    case rolUsuario.idRol 
        when 1 then (select CONCAT(usuarios.nombre,' ',usuarios.aPaterno) from usuarios where rolUsuario.idFolio = usuarios.id ) 
        when 2 then (select CONCAT(usuarios.nombre,' ',usuarios.aPaterno) from usuarios where rolUsuario.idFolio = usuarios.id ) 
        else '' 
    end 
    as folioNombre
FROM rolUsuario 
    left outer join rol on rolUsuario.idRol = rol.id 
where rolUsuario.idUsuario = @idUsuario and rolUsuario.estatus = 1 