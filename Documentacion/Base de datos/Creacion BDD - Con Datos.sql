-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-06-2020 a las 17:59:14
-- Versión del servidor: 10.1.37-MariaDB
-- Versión de PHP: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbtfg`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno`
--

CREATE TABLE `alumno` (
  `PROYECTO` int(11) NOT NULL,
  `DNI` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivo`
--

CREATE TABLE `archivo` (
  `ID` int(10) NOT NULL,
  `NOMBRE` varchar(50) NOT NULL,
  `RUTA` varchar(100) NOT NULL,
  `TIPO` varchar(50) NOT NULL,
  `ID_ENTREGA` int(11) DEFAULT NULL,
  `PESO` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `ID` int(11) NOT NULL,
  `COMENTARIO` varchar(500) NOT NULL,
  `FECHA` datetime NOT NULL,
  `AUTOR` varchar(11) NOT NULL,
  `ID_ENTREGA` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `convocatoria`
--

CREATE TABLE `convocatoria` (
  `ID` int(11) NOT NULL,
  `FECHA_INICIO` date NOT NULL,
  `FECHA_FIN` date NOT NULL,
  `NOMBRE` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `convocatoria`
--

INSERT INTO `convocatoria` (`ID`, `FECHA_INICIO`, `FECHA_FIN`, `NOMBRE`) VALUES
(1, '2020-06-19', '2020-06-30', 'Junio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrega`
--

CREATE TABLE `entrega` (
  `ID` int(11) NOT NULL,
  `TITULO` varchar(50) NOT NULL,
  `DESCRIPCION` varchar(500) NOT NULL,
  `FECHA` datetime NOT NULL,
  `ID_PROYECTO` int(11) NOT NULL,
  `AUTOR` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lectura`
--

CREATE TABLE `lectura` (
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
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `ID` int(10) NOT NULL,
  `BADGE` varchar(20) NOT NULL,
  `DESTINADO` varchar(11) NOT NULL,
  `MENSAJE` varchar(50) NOT NULL,
  `RUTA` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presentacion`
--

CREATE TABLE `presentacion` (
  `ID` int(11) NOT NULL,
  `AUTOR` varchar(10) NOT NULL,
  `TITULO` varchar(100) NOT NULL,
  `OBSERVACIONES` varchar(500) NOT NULL,
  `ARCHIVO` int(11) NOT NULL,
  `ID_PROYECTO` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesor`
--

CREATE TABLE `profesor` (
  `PROYECTO` int(11) NOT NULL,
  `DNI` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyecto`
--

CREATE TABLE `proyecto` (
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
-- Estructura de tabla para la tabla `solicitud`
--

CREATE TABLE `solicitud` (
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
-- Estructura de tabla para la tabla `tribunal`
--

CREATE TABLE `tribunal` (
  `ID` int(11) NOT NULL,
  `ID_LECTURA` int(11) NOT NULL,
  `ASISTENCIA` varchar(2) DEFAULT NULL,
  `MOTIVO` varchar(200) DEFAULT NULL,
  `DNI` varchar(10) NOT NULL,
  `ROL` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `NOMBRE` varchar(20) NOT NULL,
  `APELLIDOS` varchar(30) NOT NULL,
  `EMAIL` varchar(20) NOT NULL,
  `PASSWORD` varchar(100) NOT NULL,
  `DNI` varchar(10) NOT NULL,
  `ROL` varchar(20) NOT NULL,
  `FOTO` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`NOMBRE`, `APELLIDOS`, `EMAIL`, `PASSWORD`, `DNI`, `ROL`, `FOTO`) VALUES
('Profesor', 'Snape', 'snape@hoghwarts.com', 'd4McvMQBgSOEY', '111111111A', 'Profesor', 'http://localhost/tfg/Archivos/Perfiles/111111111A/111111111A'),
('Administrador', ' ', 'admin@admin.es', 'd4UOJFrQ45kE6', '12345678A', 'Admin', 'http://localhost/tfg/Archivos/Perfiles/12345678A/12345678A'),
('Michael', 'Jordan', 'mjordan@jordan.com', 'd4YvTG5tiIfzk', '222222222A', 'Profesor', 'http://localhost/tfg/Archivos/Perfiles/222222222A/222222222A'),
('Luis Manuel', 'VÃ¡zquez', 'lmvazquez@gmail.com', 'd4olt92IaHO/A', '27339252A', 'Profesor', 'http://localhost/tfg/Archivos/Perfiles/27339252A/27339252A'),
('Pablo Emilio', 'Escobar Gaviria', 'pescobar@gmail.com', 'd4Tvw1nnWzXXY', '52552463Q', 'Profesor', 'http://localhost/tfg/Archivos/Perfiles/52552463Q/52552463Q'),
('Manuel', 'SÃ¡nchez', 'msanchez@gmail.com', 'd4mo051vPzszw', '79165345M', 'Alumno', 'http://localhost/tfg/Archivos/Perfiles/79165345M/79165345M'),
('Juan Mariano', 'Centeno Ariza', 'jmca111197@gmail.com', 'd4mo051vPzszw', '79165345N', 'Alumno', 'http://localhost/tfg/Archivos/Perfiles/79165345N/79165345N');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valoracion`
--

CREATE TABLE `valoracion` (
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
ALTER TABLE `alumno`
  ADD PRIMARY KEY (`DNI`),
  ADD KEY `PROYECTO` (`PROYECTO`);

--
-- Indices de la tabla `archivo`
--
ALTER TABLE `archivo`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID_ENTREGA` (`ID_ENTREGA`);

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `AUTOR` (`AUTOR`),
  ADD KEY `ID_ENTREGA` (`ID_ENTREGA`);

--
-- Indices de la tabla `convocatoria`
--
ALTER TABLE `convocatoria`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `entrega`
--
ALTER TABLE `entrega`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_PROYECTO` (`ID_PROYECTO`),
  ADD KEY `AUTOR` (`AUTOR`);

--
-- Indices de la tabla `lectura`
--
ALTER TABLE `lectura`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_PROYECTO` (`ID_PROYECTO`),
  ADD KEY `ID_CONVOCATORIA` (`ID_CONVOCATORIA`),
  ADD KEY `FECHA_LECTURA` (`FECHA_LECTURA`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `DESTINADO` (`DESTINADO`);

--
-- Indices de la tabla `presentacion`
--
ALTER TABLE `presentacion`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `AUTOR` (`AUTOR`),
  ADD KEY `PROYECTO` (`ID_PROYECTO`),
  ADD KEY `ARCHIVO` (`ARCHIVO`);

--
-- Indices de la tabla `profesor`
--
ALTER TABLE `profesor`
  ADD KEY `PROYECTO` (`PROYECTO`),
  ADD KEY `DNI` (`DNI`);

--
-- Indices de la tabla `proyecto`
--
ALTER TABLE `proyecto`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `PETICION_CONVOCATORIA` (`PETICION_CONVOCATORIA`);

--
-- Indices de la tabla `solicitud`
--
ALTER TABLE `solicitud`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `tribunal`
--
ALTER TABLE `tribunal`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_LECTURA` (`ID_LECTURA`),
  ADD KEY `DNI` (`DNI`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`DNI`),
  ADD UNIQUE KEY `DNI` (`DNI`);

--
-- Indices de la tabla `valoracion`
--
ALTER TABLE `valoracion`
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
ALTER TABLE `archivo`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `convocatoria`
--
ALTER TABLE `convocatoria`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `entrega`
--
ALTER TABLE `entrega`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lectura`
--
ALTER TABLE `lectura`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `presentacion`
--
ALTER TABLE `presentacion`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proyecto`
--
ALTER TABLE `proyecto`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `solicitud`
--
ALTER TABLE `solicitud`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tribunal`
--
ALTER TABLE `tribunal`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `valoracion`
--
ALTER TABLE `valoracion`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alumno`
--
ALTER TABLE `alumno`
  ADD CONSTRAINT `FK_ALUMNO_PROYECTO` FOREIGN KEY (`PROYECTO`) REFERENCES `proyecto` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_ALUMNO_USUARIO` FOREIGN KEY (`DNI`) REFERENCES `usuario` (`DNI`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `archivo`
--
ALTER TABLE `archivo`
  ADD CONSTRAINT `FK_ARCHIVO_ENTREGA` FOREIGN KEY (`ID_ENTREGA`) REFERENCES `entrega` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `FK_COMENTARIO_ENTREGA` FOREIGN KEY (`ID_ENTREGA`) REFERENCES `entrega` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_COMENTARIO_USUARIO` FOREIGN KEY (`AUTOR`) REFERENCES `usuario` (`DNI`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `entrega`
--
ALTER TABLE `entrega`
  ADD CONSTRAINT `FK_ENTREGA_AUTOR` FOREIGN KEY (`AUTOR`) REFERENCES `usuario` (`DNI`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_ENTREGA_PROYECTO` FOREIGN KEY (`ID_PROYECTO`) REFERENCES `proyecto` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `lectura`
--
ALTER TABLE `lectura`
  ADD CONSTRAINT `FK_LECTURA_CONVOCATORIA` FOREIGN KEY (`ID_CONVOCATORIA`) REFERENCES `convocatoria` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_LECTURA_PROYECTO` FOREIGN KEY (`ID_PROYECTO`) REFERENCES `proyecto` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `presentacion`
--
ALTER TABLE `presentacion`
  ADD CONSTRAINT `FK_PRESENTACION_ARCHIVO` FOREIGN KEY (`ARCHIVO`) REFERENCES `archivo` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_PRESENTACION_PROYECTO` FOREIGN KEY (`ID_PROYECTO`) REFERENCES `proyecto` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_PRESENTACION_USUARIO` FOREIGN KEY (`AUTOR`) REFERENCES `usuario` (`DNI`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `profesor`
--
ALTER TABLE `profesor`
  ADD CONSTRAINT `FK_PROFESOR_PROYECTO` FOREIGN KEY (`PROYECTO`) REFERENCES `proyecto` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_PROFESOR_USUARIO` FOREIGN KEY (`DNI`) REFERENCES `usuario` (`DNI`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tribunal`
--
ALTER TABLE `tribunal`
  ADD CONSTRAINT `FK_TRIBUNAL_LECTURA` FOREIGN KEY (`ID_LECTURA`) REFERENCES `lectura` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_TRIBUNAL_USUARIO` FOREIGN KEY (`DNI`) REFERENCES `usuario` (`DNI`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `valoracion`
--
ALTER TABLE `valoracion`
  ADD CONSTRAINT `FK_VALORACION_ALUMNO` FOREIGN KEY (`ALUMNO`) REFERENCES `alumno` (`DNI`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_VALORACION_AUTOR` FOREIGN KEY (`AUTOR`) REFERENCES `usuario` (`DNI`),
  ADD CONSTRAINT `FK_VALORACION_PROYECTO` FOREIGN KEY (`PROYECTO`) REFERENCES `proyecto` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
