-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ALUMNO`
--

CREATE TABLE `ALUMNO` (
  `PROYECTO` int(11) NOT NULL,
  `DNI` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ARCHIVO`
--

CREATE TABLE `ARCHIVO` (
  `ID` int(10) NOT NULL,
  `NOMBRE` varchar(50) NOT NULL,
  `RUTA` varchar(100) NOT NULL,
  `TIPO` varchar(50) NOT NULL,
  `ID_ENTREGA` int(11) DEFAULT NULL,
  `PESO` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `COMENTARIOS`
--

CREATE TABLE `COMENTARIOS` (
  `ID` int(11) NOT NULL,
  `COMENTARIO` varchar(500) NOT NULL,
  `FECHA` datetime NOT NULL,
  `AUTOR` varchar(11) NOT NULL,
  `ID_ENTREGA` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `CONVOCATORIA`
--

CREATE TABLE `CONVOCATORIA` (
  `ID` int(11) NOT NULL,
  `FECHA_INICIO` date NOT NULL,
  `FECHA_FIN` date NOT NULL,
  `NOMBRE` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ENTREGA`
--

CREATE TABLE `ENTREGA` (
  `ID` int(11) NOT NULL,
  `TITULO` varchar(50) NOT NULL,
  `DESCRIPCION` varchar(500) NOT NULL,
  `FECHA` datetime NOT NULL,
  `ID_PROYECTO` int(11) NOT NULL,
  `AUTOR` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `LECTURA`
--

CREATE TABLE `LECTURA` (
  `ID` int(11) NOT NULL,
  `ID_PROYECTO` int(11) NOT NULL,
  `FECHA_LECTURA` date NOT NULL,
  `FECHA_LIMITE` datetime NOT NULL,
  `ID_CONVOCATORIA` int(11) NOT NULL,
  `HORA` time NOT NULL,
  `AULA` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `NOTIFICACIONES`
--

CREATE TABLE `NOTIFICACIONES` (
  `ID` int(10) NOT NULL,
  `BADGE` varchar(20) NOT NULL,
  `DESTINADO` varchar(11) NOT NULL,
  `MENSAJE` varchar(50) NOT NULL,
  `RUTA` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `PRESENTACION`
--

CREATE TABLE `PRESENTACION` (
  `ID` int(11) NOT NULL,
  `AUTOR` varchar(10) NOT NULL,
  `TITULO` varchar(100) NOT NULL,
  `OBSERVACIONES` varchar(500) NOT NULL,
  `ARCHIVO` int(11) NOT NULL,
  `ID_PROYECTO` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `PROFESOR`
--

CREATE TABLE `PROFESOR` (
  `PROYECTO` int(11) NOT NULL,
  `DNI` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `PROYECTO`
--

CREATE TABLE `PROYECTO` (
  `ID` int(11) NOT NULL,
  `NOMBRE` varchar(100) NOT NULL,
  `DESCRIPCION` varchar(100) NOT NULL,
  `NOTA_FINAL` decimal(4,2) DEFAULT NULL,
  `PALABRAS_CLAVE` varchar(500) DEFAULT NULL,
  `ESTADO` varchar(20) DEFAULT NULL,
  `PETICION_CONVOCATORIA` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `SOLICITUD`
--

CREATE TABLE `SOLICITUD` (
  `ID` int(11) NOT NULL,
  `DNI` varchar(20) NOT NULL,
  `ALUMNO` varchar(200) NOT NULL,
  `EMAIL` varchar(200) NOT NULL,
  `PROYECTO` varchar(50) NOT NULL,
  `DESCRIPCION` varchar(500) NOT NULL,
  `PALABRAS_CLAVE` varchar(200) NOT NULL,
  `TUTOR` varchar(200) NOT NULL,
  `ARCHIVO` varchar(200) NOT NULL,
  `ACEPTADO` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `TRIBUNAL`
--

CREATE TABLE `TRIBUNAL` (
  `ID` int(11) NOT NULL,
  `ID_LECTURA` int(11) NOT NULL,
  `ASISTENCIA` varchar(2) DEFAULT NULL,
  `MOTIVO` varchar(200) DEFAULT NULL,
  `DNI` varchar(10) NOT NULL,
  `ROL` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `USUARIO`
--

CREATE TABLE `USUARIO` (
  `NOMBRE` varchar(20) NOT NULL,
  `APELLIDOS` varchar(30) NOT NULL,
  `EMAIL` varchar(20) NOT NULL,
  `PASSWORD` varchar(100) NOT NULL,
  `DNI` varchar(10) NOT NULL,
  `ROL` varchar(20) NOT NULL,
  `FOTO` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `USUARIO`
--

INSERT INTO `USUARIO` (`NOMBRE`, `APELLIDOS`, `EMAIL`, `PASSWORD`, `DNI`, `ROL`, `FOTO`) VALUES
('Administrador', ' ', 'admin@admin.es', 'd4UOJFrQ45kE6', '12345678A', 'Admin', 'http://localhost/tfg/Archivos/Perfiles/12345678A/12345678A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `VALORACION`
--

CREATE TABLE `VALORACION` (
  `ID` int(11) NOT NULL,
  `PROYECTO` int(11) NOT NULL,
  `ALUMNO` varchar(10) NOT NULL,
  `AUTOR` varchar(10) NOT NULL,
  `VALORACION` varchar(500) NOT NULL,
  `NOTA` decimal(4,2) NOT NULL,
  `ROL` varchar(20) NOT NULL,
  `ID_ARCHIVO` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumno`
--
ALTER TABLE `ALUMNO`
  ADD PRIMARY KEY (`DNI`),
  ADD KEY `PROYECTO` (`PROYECTO`);

--
-- Indices de la tabla `archivo`
--
ALTER TABLE `ARCHIVO`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID_ENTREGA` (`ID_ENTREGA`);

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `COMENTARIOS`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `AUTOR` (`AUTOR`),
  ADD KEY `ID_ENTREGA` (`ID_ENTREGA`);

--
-- Indices de la tabla `convocatoria`
--
ALTER TABLE `CONVOCATORIA`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `entrega`
--
ALTER TABLE `ENTREGA`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_PROYECTO` (`ID_PROYECTO`),
  ADD KEY `AUTOR` (`AUTOR`);

--
-- Indices de la tabla `lectura`
--
ALTER TABLE `LECTURA`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_PROYECTO` (`ID_PROYECTO`),
  ADD KEY `ID_CONVOCATORIA` (`ID_CONVOCATORIA`),
  ADD KEY `FECHA_LECTURA` (`FECHA_LECTURA`);

--
-- Indices de la tabla `NOTIFICACIONES`
--
ALTER TABLE `NOTIFICACIONES`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `DESTINADO` (`DESTINADO`);

--
-- Indices de la tabla `presentacion`
--
ALTER TABLE `PRESENTACION`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `AUTOR` (`AUTOR`),
  ADD KEY `PROYECTO` (`ID_PROYECTO`),
  ADD KEY `ARCHIVO` (`ARCHIVO`);

--
-- Indices de la tabla `profesor`
--
ALTER TABLE `PROFESOR`
  ADD KEY `PROYECTO` (`PROYECTO`),
  ADD KEY `DNI` (`DNI`);

--
-- Indices de la tabla `proyecto`
--
ALTER TABLE `PROYECTO`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `PETICION_CONVOCATORIA` (`PETICION_CONVOCATORIA`);

--
-- Indices de la tabla `SOLICITUD`
--
ALTER TABLE `SOLICITUD`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `TRIBUNAL`
--
ALTER TABLE `TRIBUNAL`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_LECTURA` (`ID_LECTURA`),
  ADD KEY `DNI` (`DNI`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `USUARIO`
  ADD PRIMARY KEY (`DNI`),
  ADD UNIQUE KEY `DNI` (`DNI`);

--
-- Indices de la tabla `VALORACION`
--
ALTER TABLE `VALORACION`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `PROYECTO` (`PROYECTO`),
  ADD KEY `ALUMNO` (`ALUMNO`),
  ADD KEY `AUTOR` (`AUTOR`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `archivo`
--
ALTER TABLE `ARCHIVO`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `COMENTARIOS`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `convocatoria`
--
ALTER TABLE `CONVOCATORIA`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `entrega`
--
ALTER TABLE `ENTREGA`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `lectura`
--
ALTER TABLE `LECTURA`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `NOTIFICACIONES`
--
ALTER TABLE `NOTIFICACIONES`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `presentacion`
--
ALTER TABLE `PRESENTACION`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `proyecto`
--
ALTER TABLE `PROYECTO`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `solicitud`
--
ALTER TABLE `SOLICITUD`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `TRIBUNAL`
--
ALTER TABLE `TRIBUNAL`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `VALORACION`
--
ALTER TABLE `VALORACION`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alumno`
--
ALTER TABLE `ALUMNO`
  ADD CONSTRAINT `FK_ALUMNO_PROYECTO` FOREIGN KEY (`PROYECTO`) REFERENCES `PROYECTO` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_ALUMNO_USUARIO` FOREIGN KEY (`DNI`) REFERENCES `USUARIO` (`DNI`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ARCHIVO`
--
ALTER TABLE `ARCHIVO`
  ADD CONSTRAINT `FK_ARCHIVO_ENTREGA` FOREIGN KEY (`ID_ENTREGA`) REFERENCES `ENTREGA` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `COMENTARIOS`
--
ALTER TABLE `COMENTARIOS`
  ADD CONSTRAINT `FK_COMENTARIO_ENTREGA` FOREIGN KEY (`ID_ENTREGA`) REFERENCES `ENTREGA` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_COMENTARIO_USUARIO` FOREIGN KEY (`AUTOR`) REFERENCES `USUARIO` (`DNI`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ENTREGA`
--
ALTER TABLE `ENTREGA`
  ADD CONSTRAINT `FK_ENTREGA_AUTOR` FOREIGN KEY (`AUTOR`) REFERENCES `USUARIO` (`DNI`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_ENTREGA_PROYECTO` FOREIGN KEY (`ID_PROYECTO`) REFERENCES `PROYECTO` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `LECTURA`
--
ALTER TABLE `LECTURA`
  ADD CONSTRAINT `FK_LECTURA_CONVOCATORIA` FOREIGN KEY (`ID_CONVOCATORIA`) REFERENCES `CONVOCATORIA` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_LECTURA_PROYECTO` FOREIGN KEY (`ID_PROYECTO`) REFERENCES `PROYECTO` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `PRESENTACION`
--
ALTER TABLE `PRESENTACION`
  ADD CONSTRAINT `FK_PRESENTACION_ARCHIVO` FOREIGN KEY (`ARCHIVO`) REFERENCES `ARCHIVO` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_PRESENTACION_PROYECTO` FOREIGN KEY (`ID_PROYECTO`) REFERENCES `PROYECTO` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_PRESENTACION_USUARIO` FOREIGN KEY (`AUTOR`) REFERENCES `USUARIO` (`DNI`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `profesor`
--
ALTER TABLE `PROFESOR`
  ADD CONSTRAINT `FK_PROFESOR_PROYECTO` FOREIGN KEY (`PROYECTO`) REFERENCES `PROYECTO` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_PROFESOR_USUARIO` FOREIGN KEY (`DNI`) REFERENCES `USUARIO` (`DNI`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `TRIBUNAL`
--
ALTER TABLE `TRIBUNAL`
  ADD CONSTRAINT `FK_TRIBUNAL_LECTURA` FOREIGN KEY (`ID_LECTURA`) REFERENCES `LECTURA` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_TRIBUNAL_USUARIO` FOREIGN KEY (`DNI`) REFERENCES `USUARIO` (`DNI`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `VALORACION`
--
ALTER TABLE `VALORACION`
  ADD CONSTRAINT `FK_VALORACION_ALUMNO` FOREIGN KEY (`ALUMNO`) REFERENCES `ALUMNO` (`DNI`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_VALORACION_AUTOR` FOREIGN KEY (`AUTOR`) REFERENCES `USUARIO` (`DNI`),
  ADD CONSTRAINT `FK_VALORACION_PROYECTO` FOREIGN KEY (`PROYECTO`) REFERENCES `PROYECTO` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
