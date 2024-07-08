-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 26-06-2024 a las 15:34:35
-- Versión del servidor: 5.7.26
-- Versión de PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de datos: `webersmx_Eventos`
--
-- Estructura de tabla para la tabla `usuarios`
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `aPaterno` varchar(200) NOT NULL,
  `aMaterno` varchar(200) NOT NULL,
  `correo` varchar(500) DEFAULT NULL,
  `cntr` varchar(200) DEFAULT NULL,
  `cntrTmpr` varchar(200) NOT NULL,
  `lang` varchar(10) NOT NULL DEFAULT 'es',
  `ladaPais` int(11) NOT NULL DEFAULT '52',
  `telefono` varchar(200) DEFAULT NULL,
  `codigoConfirmacion` mediumint(9) NOT NULL,
  `correoConfirmado` tinyint(4) NOT NULL DEFAULT '0',
  `idUsuarioAlta` int(11) NOT NULL,
  `fechaAlta` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estatus` smallint(6) NOT NULL DEFAULT '1',
  `habilitado` tinyint(4) NOT NULL DEFAULT '0',
  `administrador` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `usuarios` (`id`, `nombre`, `aPaterno`, `aMaterno`, `correo`, `cntr`, `cntrTmpr`, `lang`, `ladaPais`, `telefono`, `codigoConfirmacion`, `correoConfirmado`, `idUsuarioAlta`, `fechaAlta`, `estatus`, `habilitado`, `administrador`) VALUES
(1, 'Israel', 'Jimenez', '', 'ijimenez35@gmail.com', ':qYð…†LCqg8JâÝ¬gý|!–×ÂO', '', 'es', 52, '5591902797', 148, 1, 0, '2023-07-05 00:56:09', 1, 1, 1);

-- Estructura de tabla para la tabla `correos`
--
CREATE TABLE `correos` (
  `id` int(11) NOT NULL,
  `correo` varchar(200) NOT NULL,
  `codigoConfirmacion` mediumint(9) NOT NULL,
  `confirmado` tinyint(4) NOT NULL DEFAULT '0',
  `fechaConfirmado` timestamp NULL DEFAULT NULL,
  `fechaAlta` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estatus` smallint(6) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `correos` (`id`, `correo`, `codigoConfirmacion`, `confirmado`, `fechaConfirmado`, `fechaAlta`, `estatus`) VALUES
(1, 'ijimenez35@gmail.com', 148, 1, '2023-07-05 00:56:09', '2023-07-05 00:54:56', 1);

-- Estructura de tabla para la tabla `rol`
--
CREATE TABLE `rol` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(300) NOT NULL,
  `idUsuarioAlta` int(11) NOT NULL,
  `fechaCreacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estatus` smallint(6) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `rol` (`id`, `descripcion`, `idUsuarioAlta`, `fechaCreacion`, `estatus`) VALUES
(1, 'administrador', 0, '2020-01-21 02:56:20', 1),
(2, 'consulta', 0, '2020-01-21 02:56:53', 1);

-- Estructura de tabla para la tabla `rolUsuario`
--
CREATE TABLE `rolUsuario` (
  `id` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idRol` int(11) NOT NULL,
  `idFolio` int(11) NOT NULL DEFAULT '0',
  `idUsuarioAlta` int(11) NOT NULL,
  `estatus` smallint(6) NOT NULL DEFAULT '1',
  `fechaCreacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Estructura de tabla para la tabla `usuarios`
--
CREATE TABLE `personas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `aPaterno` varchar(200) NOT NULL,
  `aMaterno` varchar(200) NOT NULL,
  `correo` varchar(500) DEFAULT NULL,
  `cntr` varchar(200) DEFAULT NULL,
  `cntrTmpr` varchar(200) NOT NULL,
  `lang` varchar(10) NOT NULL DEFAULT 'es',
  `ladaPais` int(11) NOT NULL DEFAULT '52',
  `telefono` varchar(200) DEFAULT NULL,
  `codigoConfirmacion` mediumint(9) NOT NULL,
  `correoConfirmado` tinyint(4) NOT NULL DEFAULT '0',
  `idUsuarioAlta` int(11) NOT NULL,
  `fechaAlta` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estatus` smallint(6) NOT NULL DEFAULT '1',
  `habilitado` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Indices de la tabla `correos`
ALTER TABLE `correos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idCorreo` (`id`);
-- Indices de la tabla `rol`
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);
-- Indices de la tabla `rolUsuario`
ALTER TABLE `rolUsuario`
  ADD PRIMARY KEY (`id`);
-- Indices de la tabla `usuarios`
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `IDUsuario` (`id`);
-- Indices de la tabla `personas`
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `IDPersona` (`id`);
-- AUTO_INCREMENT de la tabla `correos`
ALTER TABLE `correos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
-- AUTO_INCREMENT de la tabla `rol`
ALTER TABLE `rol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
-- AUTO_INCREMENT de la tabla `rolUsuario`
ALTER TABLE `rolUsuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
-- AUTO_INCREMENT de la tabla `usuarios`
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;
-- AUTO_INCREMENT de la tabla `rolUsuario`
ALTER TABLE `personas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


-- Estructura de tabla para la tabla `sedes`
CREATE TABLE `sedes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `aforo` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `sedes` (`id`, `nombre`, `aforo`) VALUES
(1, 'Estadio Irapuato', 20000);

-- Estructura de tabla para la tabla `secciones`
CREATE TABLE `secciones` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `idSede` int(11) NOT NULL,
  `aforo` int(11) NOT NULL DEFAULT '0',
  `costo` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `secciones` (`id`, `nombre`, `idSede`, `aforo`, `costo`) VALUES
(1, 'General Norte', 1, 0, 0),
(2, 'General Sur', 1, 0, 0),
(3, 'Cabecera Norte', 1, 0, 0),
(4, 'Cabecera Sur', 1, 0, 0),
(5, 'Plateas', 1, 0, 0),
(6, 'Palcos', 1, 0, 0),
(7, 'Palco Presidencial', 1, 0, 0),
(8, 'disponible', 1, 0, 0);
-- Estructura de tabla para la tabla `eventos`
CREATE TABLE `eventos` (
  `id` int(11) NOT NULL,
  `idSede` int(11) NOT NULL,
  `fechaEvento` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fechaInicioVenta` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
-- Estructura de tabla para la tabla `boletosEvento`
CREATE TABLE `boletosEvento` (
  `id` int(11) NOT NULL,
  `idEvento` int(11) NOT NULL,
  `estatus` tinyint(4) NOT NULL DEFAULT '1',
  `importe` int(11) NOT NULL,
  `moneda` int(11) NOT NULL,
  `idSeccion` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
-- Estructura de tabla para la tabla `ticket`
CREATE TABLE `ticket` (
  `id` int(11) NOT NULL,
  `idEvento` int(11) NOT NULL,
  `formaPago` int(11) NOT NULL DEFAULT '1',
  `importe` int(11) NOT NULL,
  `moneda` int(11) NOT NULL,
  `fechaCreacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usuarioCrea` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
-- Estructura de tabla para la tabla `boletosTicket`
CREATE TABLE `boletosTicket` (
  `id` int(11) NOT NULL,
  `idTicket` int(11) NOT NULL,
  `idBoletoEvento` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
-- Estructura de tabla para la tabla `formaPago`
CREATE TABLE `formaPago` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `formaPago` (`id`, `nombre`) VALUES
(1, 'Contado'),
(2, 'Débito'),
(3, 'Crédito'),
(3, 'Pay Pal');
-- Estructura de tabla para la tabla `moneda`
CREATE TABLE `moneda` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `nombreCorto` varchar(100) NOT NULL,
  `idPais` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `moneda` (`id`, `nombre`, `nombreCorto`, `idPais`) VALUES
(1, 'Pesos Mexicanos', 'MXN', 1),
(2, 'Dolar Estadounidense', 'USD', 2);


-- Indices de la tabla `boletosEvento`
ALTER TABLE `boletosEvento`
  ADD PRIMARY KEY (`id`);
-- Indices de la tabla `boletosTicket`
ALTER TABLE `boletosTicket`
  ADD PRIMARY KEY (`id`);
-- Indices de la tabla `eventos`
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id`);
-- Indices de la tabla `formaPago`
ALTER TABLE `formaPago`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);
-- Indices de la tabla `moneda
ALTER TABLE `moneda`
  ADD PRIMARY KEY (`id`);
-- Indices de la tabla `secciones`
ALTER TABLE `secciones`
  ADD PRIMARY KEY (`id`);
-- Indices de la tabla `sedes`
ALTER TABLE `sedes`
  ADD PRIMARY KEY (`id`);
-- Indices de la tabla `ticket`
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id`);
-- AUTO_INCREMENT de la tabla `boletosEvento`
ALTER TABLE `boletosEvento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
-- AUTO_INCREMENT de la tabla `boletosTicket`
ALTER TABLE `boletosTicket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
-- AUTO_INCREMENT de la tabla `eventos`
ALTER TABLE `eventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
-- AUTO_INCREMENT de la tabla `formaPago`
ALTER TABLE `formaPago`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
-- AUTO_INCREMENT de la tabla `moneda`
ALTER TABLE `moneda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
-- AUTO_INCREMENT de la tabla `secciones`
ALTER TABLE `secciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
-- AUTO_INCREMENT de la tabla `sedes`
ALTER TABLE `sedes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
-- AUTO_INCREMENT de la tabla `ticket`
ALTER TABLE `ticket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
