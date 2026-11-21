-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 21-11-2026 a las 03:50:40
-- Versión del servidor: 8.4.7
-- Versión de PHP: 8.3.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `preparacionkm`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

DROP TABLE IF EXISTS `administrador`;
CREATE TABLE IF NOT EXISTS `administrador` (
  `idadministrador` int NOT NULL AUTO_INCREMENT,
  `usuario_idusuario` int NOT NULL,
  PRIMARY KEY (`idadministrador`),
  KEY `fk_administrador_usuario1_idx` (`usuario_idusuario`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`idadministrador`, `usuario_idusuario`) VALUES
(1, 9),
(2, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

DROP TABLE IF EXISTS `carrito`;
CREATE TABLE IF NOT EXISTS `carrito` (
  `idcarrito` int NOT NULL AUTO_INCREMENT,
  `estado` enum('activo','cerrado') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo',
  `fecha_creacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estudiante_idestudiante` int NOT NULL,
  PRIMARY KEY (`idcarrito`),
  KEY `fk_carrito_estudiante1_idx` (`estudiante_idestudiante`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`idcarrito`, `estado`, `fecha_creacion`, `estudiante_idestudiante`) VALUES
(1, 'cerrado', '2026-11-03 09:00:00', 1),
(2, 'cerrado', '2026-11-03 09:05:00', 2),
(3, 'cerrado', '2026-11-03 09:10:00', 3),
(4, 'cerrado', '2026-11-03 09:15:00', 4),
(5, 'cerrado', '2026-11-03 09:20:00', 5),
(6, 'activo', '2026-11-05 08:00:00', 1),
(7, 'activo', '2026-11-05 08:05:00', 2),
(8, 'activo', '2026-11-05 08:10:00', 3),
(9, 'activo', '2026-11-05 08:15:00', 4),
(10, 'activo', '2026-11-05 08:20:00', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito_cursos`
--

DROP TABLE IF EXISTS `carrito_cursos`;
CREATE TABLE IF NOT EXISTS `carrito_cursos` (
  `idcarrito_cursos` int NOT NULL AUTO_INCREMENT,
  `fecha_agregado` datetime DEFAULT CURRENT_TIMESTAMP,
  `carrito_idcarrito` int NOT NULL,
  `curso_idcurso` int NOT NULL,
  PRIMARY KEY (`idcarrito_cursos`),
  KEY `fk_carrito_cursos_carrito1_idx` (`carrito_idcarrito`),
  KEY `fk_carrito_cursos_curso1_idx` (`curso_idcurso`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `carrito_cursos`
--

INSERT INTO `carrito_cursos` (`idcarrito_cursos`, `fecha_agregado`, `carrito_idcarrito`, `curso_idcurso`) VALUES
(1, '2026-11-03 09:01:00', 1, 1),
(2, '2026-11-03 09:06:00', 2, 2),
(3, '2026-11-03 09:11:00', 3, 3),
(4, '2026-11-03 09:16:00', 4, 4),
(5, '2026-11-03 09:21:00', 5, 5),
(6, '2026-11-05 08:01:00', 6, 6),
(7, '2026-11-05 08:06:00', 7, 7),
(8, '2026-11-05 08:11:00', 8, 8),
(9, '2026-11-05 08:16:00', 9, 9),
(10, '2026-11-05 08:21:00', 10, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `certificado`
--

DROP TABLE IF EXISTS `certificado`;
CREATE TABLE IF NOT EXISTS `certificado` (
  `idcertificado` int NOT NULL AUTO_INCREMENT,
  `identificador_unico` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ruta_pdf` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_generacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estudiante_idestudiante` int NOT NULL,
  `curso_idcurso` int NOT NULL,
  PRIMARY KEY (`idcertificado`),
  UNIQUE KEY `identificador_unico_UNIQUE` (`identificador_unico`),
  KEY `fk_certificado_estudiante1_idx` (`estudiante_idestudiante`),
  KEY `fk_certificado_curso1_idx` (`curso_idcurso`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `certificado`
--

INSERT INTO `certificado` (`idcertificado`, `identificador_unico`, `ruta_pdf`, `fecha_generacion`, `estudiante_idestudiante`, `curso_idcurso`) VALUES
(1, 'CERT-001', 'certificados/cert_1.pdf', '2026-11-04 12:00:00', 1, 1),
(2, 'CERT-002', 'certificados/cert_2.pdf', '2026-11-04 12:10:00', 2, 2),
(3, 'CERT-003', 'certificados/cert_3.pdf', '2026-11-04 12:20:00', 3, 3),
(4, 'CERT-004', 'certificados/cert_4.pdf', '2026-11-04 12:30:00', 4, 4),
(5, 'CERT-005', 'certificados/cert_5.pdf', '2026-11-04 12:40:00', 5, 5),
(6, 'CERT-006', 'certificados/cert_6.pdf', '2026-11-04 12:50:00', 1, 6),
(7, 'CERT-007', 'certificados/cert_7.pdf', '2026-11-04 13:00:00', 2, 7),
(8, 'CERT-008', 'certificados/cert_8.pdf', '2026-11-04 13:10:00', 3, 8),
(9, 'CERT-009', 'certificados/cert_9.pdf', '2026-11-04 13:20:00', 4, 9),
(10, 'CERT-010', 'certificados/cert_10.pdf', '2026-11-04 13:30:00', 5, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `codigo_ins`
--

DROP TABLE IF EXISTS `codigo_ins`;
CREATE TABLE IF NOT EXISTS `codigo_ins` (
  `idcodigo_ins` int NOT NULL AUTO_INCREMENT,
  `codigo` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` enum('activo','utilizado') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo',
  `fecha_gen` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `instructor_idinstructor` int DEFAULT NULL,
  `administrador_idadministrador` int NOT NULL,
  PRIMARY KEY (`idcodigo_ins`),
  UNIQUE KEY `codigo_UNIQUE` (`codigo`),
  KEY `fk_codigo_ins_instructor1_idx` (`instructor_idinstructor`),
  KEY `fk_codigo_ins_administrador1_idx` (`administrador_idadministrador`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `codigo_ins`
--

INSERT INTO `codigo_ins` (`idcodigo_ins`, `codigo`, `estado`, `fecha_gen`, `instructor_idinstructor`, `administrador_idadministrador`) VALUES
(1, 'CODINS01', 'utilizado', '2026-11-01 07:00:00', 1, 1),
(2, 'CODINS02', 'utilizado', '2026-11-01 07:05:00', 2, 1),
(3, 'CODINS03', 'utilizado', '2026-11-01 07:10:00', 3, 2),
(4, 'CODINS04', 'activo', '2026-11-01 07:15:00', NULL, 1),
(5, 'CODINS05', 'activo', '2026-11-01 07:20:00', NULL, 1),
(6, 'CODINS06', 'activo', '2026-11-01 07:25:00', NULL, 2),
(7, 'CODINS07', 'activo', '2026-11-01 07:30:00', NULL, 2),
(8, 'CODINS08', 'activo', '2026-11-01 07:35:00', NULL, 1),
(9, 'CODINS09', 'activo', '2026-11-01 07:40:00', NULL, 2),
(10, 'CODINS10', 'activo', '2026-11-01 07:45:00', NULL, 1),
(11, 'INS-78CFDC8B', 'utilizado', '2026-11-20 17:56:33', 3, 1),
(12, 'INS-FEB378ED', 'activo', '2026-11-20 18:04:58', 4, 2),
(13, 'INS-131BBC5B', 'utilizado', '2026-11-20 20:22:32', 4, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `codigo_ver`
--

DROP TABLE IF EXISTS `codigo_ver`;
CREATE TABLE IF NOT EXISTS `codigo_ver` (
  `idcodigo_ver` int NOT NULL AUTO_INCREMENT,
  `codigo` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_gen` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_exp` datetime NOT NULL,
  `estado` enum('activo','utilizado','expirado') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo',
  `usuario_idusuario` int NOT NULL,
  PRIMARY KEY (`idcodigo_ver`),
  KEY `fk_codigo_ver_usuario1_idx` (`usuario_idusuario`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `codigo_ver`
--

INSERT INTO `codigo_ver` (`idcodigo_ver`, `codigo`, `fecha_gen`, `fecha_exp`, `estado`, `usuario_idusuario`) VALUES
(1, 'CODVER01', '2026-11-01 08:00:00', '2026-11-02 08:00:00', 'utilizado', 1),
(2, 'CODVER02', '2026-11-01 08:10:00', '2026-11-02 08:10:00', 'utilizado', 2),
(3, 'CODVER03', '2026-11-01 08:20:00', '2026-11-02 08:20:00', 'utilizado', 3),
(4, 'CODVER04', '2026-11-01 08:30:00', '2026-11-02 08:30:00', 'utilizado', 4),
(5, 'CODVER05', '2026-11-01 08:40:00', '2026-11-02 08:40:00', 'activo', 5),
(6, 'CODVER06', '2026-11-01 09:00:00', '2026-11-02 09:00:00', 'utilizado', 6),
(7, 'CODVER07', '2026-11-01 09:10:00', '2026-11-02 09:10:00', 'utilizado', 7),
(8, 'CODVER08', '2026-11-01 09:20:00', '2026-11-02 09:20:00', 'activo', 8),
(9, 'CODVER09', '2026-11-01 10:00:00', '2026-11-02 10:00:00', 'utilizado', 9),
(10, 'CODVER10', '2026-11-01 10:10:00', '2026-11-02 10:10:00', 'utilizado', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

DROP TABLE IF EXISTS `compra`;
CREATE TABLE IF NOT EXISTS `compra` (
  `idcompra` int NOT NULL AUTO_INCREMENT,
  `total` decimal(10,2) NOT NULL,
  `transaccion_paypal` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_pago` enum('pendiente','aprobado','rechazado','cancelado') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pendiente',
  `fecha_transaccion` datetime DEFAULT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estudiante_idestudiante` int NOT NULL,
  PRIMARY KEY (`idcompra`),
  UNIQUE KEY `transaccion_paypal_UNIQUE` (`transaccion_paypal`),
  KEY `fk_compra_estudiante1_idx` (`estudiante_idestudiante`),
  KEY `INDICE_fecha_transaccion` (`fecha_transaccion`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`idcompra`, `total`, `transaccion_paypal`, `estado_pago`, `fecha_transaccion`, `fecha_creacion`, `estudiante_idestudiante`) VALUES
(1, 100.00, 'PAYPAL001', 'aprobado', '2026-11-03 10:00:00', '2026-11-03 09:55:00', 1),
(2, 200.00, 'PAYPAL002', 'aprobado', '2026-11-03 10:10:00', '2026-11-03 10:05:00', 2),
(3, 300.00, 'PAYPAL003', 'aprobado', '2026-11-03 10:20:00', '2026-11-03 10:15:00', 3),
(4, 400.00, 'PAYPAL004', 'aprobado', '2026-11-03 10:30:00', '2026-11-03 10:25:00', 4),
(5, 500.00, 'PAYPAL005', 'aprobado', '2026-11-03 10:40:00', '2026-11-03 10:35:00', 5),
(6, 600.00, 'PAYPAL006', 'aprobado', '2026-11-03 10:50:00', '2026-11-03 10:45:00', 1),
(7, 700.00, 'PAYPAL007', 'pendiente', NULL, '2026-11-03 10:55:00', 2),
(8, 800.00, 'PAYPAL008', 'rechazado', '2026-11-03 11:10:00', '2026-11-03 11:05:00', 3),
(9, 900.00, 'PAYPAL009', 'cancelado', '2026-11-03 11:20:00', '2026-11-03 11:15:00', 4),
(10, 1000.00, 'PAYPAL010', 'aprobado', '2026-11-03 11:30:00', '2026-11-03 11:25:00', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contenido`
--

DROP TABLE IF EXISTS `contenido`;
CREATE TABLE IF NOT EXISTS `contenido` (
  `idcontenido` int NOT NULL AUTO_INCREMENT,
  `tipo` enum('imagen','video') COLLATE utf8mb4_unicode_ci NOT NULL,
  `ruta_archivo` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre_original` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_subida` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `leccion_idleccion` int NOT NULL,
  PRIMARY KEY (`idcontenido`),
  KEY `fk_contenido_leccion1_idx` (`leccion_idleccion`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `contenido`
--

INSERT INTO `contenido` (`idcontenido`, `tipo`, `ruta_archivo`, `nombre_original`, `fecha_subida`, `leccion_idleccion`) VALUES
(1, 'imagen', 'ruta/archivo_1.jpg', 'archivo_1.jpg', '2026-11-02 14:00:00', 1),
(2, 'video', 'ruta/archivo_2.mp4', 'archivo_2.mp4', '2026-11-02 14:05:00', 2),
(3, 'imagen', 'ruta/archivo_3.png', 'archivo_3.png', '2026-11-02 14:10:00', 3),
(4, 'video', 'ruta/archivo_4.mp4', 'archivo_4.mp4', '2026-11-02 14:15:00', 4),
(5, 'imagen', 'ruta/archivo_5.jpg', 'archivo_5.jpg', '2026-11-02 14:20:00', 5),
(6, 'video', 'ruta/archivo_6.mp4', 'archivo_6.mp4', '2026-11-02 14:25:00', 6),
(7, 'imagen', 'ruta/archivo_7.png', 'archivo_7.png', '2026-11-02 14:30:00', 7),
(8, 'video', 'ruta/archivo_8.mp4', 'archivo_8.mp4', '2026-11-02 14:35:00', 8),
(9, 'imagen', 'ruta/archivo_9.jpg', 'archivo_9.jpg', '2026-11-02 14:40:00', 9),
(10, 'video', 'ruta/archivo_10.mp4', 'archivo_10.mp4', '2026-11-02 14:45:00', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso`
--

DROP TABLE IF EXISTS `curso`;
CREATE TABLE IF NOT EXISTS `curso` (
  `idcurso` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `imagen_portada` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `estado` enum('disponible','inactivo','eliminado') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'disponible',
  `instructor_idinstructor` int NOT NULL,
  PRIMARY KEY (`idcurso`),
  KEY `fk_curso_instructor1_idx` (`instructor_idinstructor`),
  KEY `INDICE_nombre` (`nombre`),
  KEY `INDICE_fecha_creacion` (`fecha_creacion`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `curso`
--

INSERT INTO `curso` (`idcurso`, `nombre`, `descripcion`, `imagen_portada`, `precio`, `fecha_creacion`, `estado`, `instructor_idinstructor`) VALUES
(1, 'Curso 1', 'Descripcion del curso 1', 'portada_curso_1.jpg', 100.00, '2026-11-02 10:00:00', 'disponible', 1),
(2, 'Curso 2', 'Descripcion del curso 2', 'portada_curso_2.jpg', 200.00, '2026-11-02 10:10:00', 'disponible', 1),
(3, 'Curso 3', 'Descripcion del curso 3', 'portada_curso_3.jpg', 300.00, '2026-11-02 10:20:00', 'disponible', 1),
(4, 'Curso 4', 'Descripcion del curso 4', 'portada_curso_4.jpg', 400.00, '2026-11-02 10:30:00', 'disponible', 2),
(5, 'Curso 5', 'Descripcion del curso 5', 'portada_curso_5.jpg', 500.00, '2026-11-02 10:40:00', 'disponible', 2),
(6, 'Curso 6', 'Descripcion del curso 6', 'portada_curso_6.jpg', 600.00, '2026-11-02 10:50:00', 'disponible', 2),
(7, 'Curso 7', 'Descripcion del curso 7', 'portada_curso_7.jpg', 700.00, '2026-11-02 11:00:00', 'disponible', 3),
(8, 'Curso 8', 'Descripcion del curso 8', 'portada_curso_8.jpg', 800.00, '2026-11-02 11:10:00', 'disponible', 3),
(9, 'Curso 9', 'Descripcion del curso 9', 'portada_curso_9.jpg', 900.00, '2026-11-02 11:20:00', 'inactivo', 3),
(10, 'Curso 10', 'Descripcion del curso 10', 'portada_curso_10.jpg', 1000.00, '2026-11-02 11:30:00', 'disponible', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compra`
--

DROP TABLE IF EXISTS `detalle_compra`;
CREATE TABLE IF NOT EXISTS `detalle_compra` (
  `iddetalle_compra` int NOT NULL AUTO_INCREMENT,
  `precio_unitario` decimal(10,2) NOT NULL,
  `compra_idcompra` int NOT NULL,
  `curso_idcurso` int NOT NULL,
  PRIMARY KEY (`iddetalle_compra`),
  KEY `fk_detalle_compra_compra1_idx` (`compra_idcompra`),
  KEY `fk_detalle_compra_curso1_idx` (`curso_idcurso`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `detalle_compra`
--

INSERT INTO `detalle_compra` (`iddetalle_compra`, `precio_unitario`, `compra_idcompra`, `curso_idcurso`) VALUES
(1, 100.00, 1, 1),
(2, 200.00, 2, 2),
(3, 300.00, 3, 3),
(4, 400.00, 4, 4),
(5, 500.00, 5, 5),
(6, 600.00, 6, 6),
(7, 700.00, 7, 7),
(8, 800.00, 8, 8),
(9, 900.00, 9, 9),
(10, 1000.00, 10, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante`
--

DROP TABLE IF EXISTS `estudiante`;
CREATE TABLE IF NOT EXISTS `estudiante` (
  `idestudiante` int NOT NULL AUTO_INCREMENT,
  `usuario_idusuario` int NOT NULL,
  PRIMARY KEY (`idestudiante`),
  KEY `fk_estudiante_usuario_idx` (`usuario_idusuario`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `estudiante`
--

INSERT INTO `estudiante` (`idestudiante`, `usuario_idusuario`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 11),
(7, 16);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instructor`
--

DROP TABLE IF EXISTS `instructor`;
CREATE TABLE IF NOT EXISTS `instructor` (
  `idinstructor` int NOT NULL AUTO_INCREMENT,
  `estado_validacion` enum('pendiente','validado','rechazado') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pendiente',
  `usuario_idusuario` int NOT NULL,
  PRIMARY KEY (`idinstructor`),
  KEY `fk_instructor_usuario1_idx` (`usuario_idusuario`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `instructor`
--

INSERT INTO `instructor` (`idinstructor`, `estado_validacion`, `usuario_idusuario`) VALUES
(1, 'validado', 6),
(2, 'validado', 7),
(3, 'validado', 8),
(4, 'validado', 13),
(5, 'pendiente', 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `leccion`
--

DROP TABLE IF EXISTS `leccion`;
CREATE TABLE IF NOT EXISTS `leccion` (
  `idleccion` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `contenido_texto` mediumtext COLLATE utf8mb4_unicode_ci,
  `orden` int NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estado` enum('activa','inactiva','eliminada') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activa',
  `curso_idcurso` int NOT NULL,
  PRIMARY KEY (`idleccion`),
  UNIQUE KEY `titulo_UNIQUE` (`titulo`),
  KEY `fk_leccion_curso1_idx` (`curso_idcurso`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `leccion`
--

INSERT INTO `leccion` (`idleccion`, `titulo`, `descripcion`, `contenido_texto`, `orden`, `fecha_creacion`, `estado`, `curso_idcurso`) VALUES
(1, 'Leccion 1', 'Descripcion leccion 1', 'Texto de la leccion 1', 1, '2026-11-02 12:00:00', 'activa', 1),
(2, 'Leccion 2', 'Descripcion leccion 2', 'Texto de la leccion 2', 1, '2026-11-02 12:10:00', 'activa', 2),
(3, 'Leccion 3', 'Descripcion leccion 3', 'Texto de la leccion 3', 1, '2026-11-02 12:20:00', 'activa', 3),
(4, 'Leccion 4', 'Descripcion leccion 4', 'Texto de la leccion 4', 1, '2026-11-02 12:30:00', 'activa', 4),
(5, 'Leccion 5', 'Descripcion leccion 5', 'Texto de la leccion 5', 1, '2026-11-02 12:40:00', 'activa', 5),
(6, 'Leccion 6', 'Descripcion leccion 6', 'Texto de la leccion 6', 1, '2026-11-02 12:50:00', 'activa', 6),
(7, 'Leccion 7', 'Descripcion leccion 7', 'Texto de la leccion 7', 1, '2026-11-02 13:00:00', 'activa', 7),
(8, 'Leccion 8', 'Descripcion leccion 8', 'Texto de la leccion 8', 1, '2026-11-02 13:10:00', 'activa', 8),
(9, 'Leccion 9', 'Descripcion leccion 9', 'Texto de la leccion 9', 1, '2026-11-02 13:20:00', 'activa', 9),
(10, 'Leccion 10', 'Descripcion leccion 10', 'Texto de la leccion 10', 1, '2026-11-02 13:30:00', 'activa', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `progreso`
--

DROP TABLE IF EXISTS `progreso`;
CREATE TABLE IF NOT EXISTS `progreso` (
  `idprogreso` int NOT NULL AUTO_INCREMENT,
  `fecha_visualizacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estado` enum('visto','no_visto') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'visto',
  `estudiante_idestudiante` int NOT NULL,
  `leccion_idleccion` int NOT NULL,
  PRIMARY KEY (`idprogreso`),
  KEY `fk_progreso_estudiante1_idx` (`estudiante_idestudiante`),
  KEY `fk_progreso_leccion1_idx` (`leccion_idleccion`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `progreso`
--

INSERT INTO `progreso` (`idprogreso`, `fecha_visualizacion`, `estado`, `estudiante_idestudiante`, `leccion_idleccion`) VALUES
(1, '2026-11-04 09:00:00', 'visto', 1, 1),
(2, '2026-11-04 09:10:00', 'visto', 2, 2),
(3, '2026-11-04 09:20:00', 'visto', 3, 3),
(4, '2026-11-04 09:30:00', 'visto', 4, 4),
(5, '2026-11-04 09:40:00', 'visto', 5, 5),
(6, '2026-11-04 09:50:00', 'visto', 1, 6),
(7, '2026-11-04 10:00:00', 'no_visto', 2, 7),
(8, '2026-11-04 10:10:00', 'no_visto', 3, 8),
(9, '2026-11-04 10:20:00', 'no_visto', 4, 9),
(10, '2026-11-04 10:30:00', 'visto', 5, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sesion`
--

DROP TABLE IF EXISTS `sesion`;
CREATE TABLE IF NOT EXISTS `sesion` (
  `idsesion` int NOT NULL AUTO_INCREMENT,
  `token_sesion` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_inicio` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_expiracion` datetime NOT NULL,
  `usuario_idusuario` int NOT NULL,
  PRIMARY KEY (`idsesion`),
  UNIQUE KEY `token_sesion_UNIQUE` (`token_sesion`),
  KEY `fk_sesion_usuario1_idx` (`usuario_idusuario`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sesion`
--

INSERT INTO `sesion` (`idsesion`, `token_sesion`, `fecha_inicio`, `fecha_expiracion`, `usuario_idusuario`) VALUES
(1, 'TOKEN_SESION_01', '2026-11-05 09:00:00', '2026-11-05 21:00:00', 1),
(2, 'TOKEN_SESION_02', '2026-11-05 09:05:00', '2026-11-05 21:05:00', 2),
(3, 'TOKEN_SESION_03', '2026-11-05 09:10:00', '2026-11-05 21:10:00', 3),
(4, 'TOKEN_SESION_04', '2026-11-05 09:15:00', '2026-11-05 21:15:00', 4),
(5, 'TOKEN_SESION_05', '2026-11-05 09:20:00', '2026-11-05 21:20:00', 5),
(6, 'TOKEN_SESION_06', '2026-11-05 09:25:00', '2026-11-05 21:25:00', 6),
(7, 'TOKEN_SESION_07', '2026-11-05 09:30:00', '2026-11-05 21:30:00', 7),
(8, 'TOKEN_SESION_08', '2026-11-05 09:35:00', '2026-11-05 21:35:00', 8),
(9, 'TOKEN_SESION_09', '2026-11-05 09:40:00', '2026-11-05 21:40:00', 9),
(10, 'TOKEN_SESION_10', '2026-11-05 09:45:00', '2026-11-05 21:45:00', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `idusuario` int NOT NULL AUTO_INCREMENT,
  `correo` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contrasena` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido` varchar(55) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `biografia` text COLLATE utf8mb4_unicode_ci,
  `fotografia` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rol` enum('admin','estudiante','instructor') COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado_cuenta` enum('pendiente','verificada','activa','inactiva') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pendiente',
  `fecha_registro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idusuario`),
  UNIQUE KEY `correo_UNIQUE` (`correo`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `correo`, `contrasena`, `nombre`, `apellido`, `biografia`, `fotografia`, `rol`, `estado_cuenta`, `fecha_registro`) VALUES
(1, 'usuario1@correo.com', '12345678', 'Nombre1', 'Apellido1', 'Biografia usuario 1', 'foto_perfil_1.jpg', 'estudiante', 'activa', '2026-11-01 08:00:00'),
(2, 'usuario2@correo.com', '23456789', 'Nombre2', 'Apellido2', 'Biografia usuario 2', 'foto_perfil_2.jpg', 'estudiante', 'activa', '2026-11-01 08:10:00'),
(3, 'usuario3@correo.com', '34567890', 'Nombre3', 'Apellido3', 'Biografia usuario 3', 'foto_perfil_3.jpg', 'estudiante', 'verificada', '2026-11-01 08:20:00'),
(4, 'usuario4@correo.com', '45678901', 'Nombre4', 'Apellido4', 'Biografia usuario 4', 'foto_perfil_4.jpg', 'estudiante', 'verificada', '2026-11-01 08:30:00'),
(5, 'usuario5@correo.com', '56789012', 'prueba uno', 'apellido uon', 'aaaaaqqqqq', 'uploads/perfiles/perfil_usr_5_23921024f3c88c9e.jpg', 'estudiante', 'pendiente', '2026-11-01 08:40:00'),
(6, 'usuario6@correo.com', '67890123', 'Nombre6', 'Apellido6', 'Biografia usuario 6', 'foto_perfil_6.jpg', 'instructor', 'activa', '2026-11-01 09:00:00'),
(7, 'usuario7@correo.com', '78901234', 'Nombre7', 'Apellido7', 'Biografia usuario 7', 'foto_perfil_7.jpg', 'instructor', 'activa', '2026-11-01 09:10:00'),
(8, 'usuario8@correo.com', '89012345', 'Nombre8', 'Apellido8', 'Biografia usuario 8', 'foto_perfil_8.jpg', 'instructor', 'pendiente', '2026-11-01 09:20:00'),
(9, 'usuario9@correo.com', '90123456', 'Nombre9', 'Apellido9', 'Biografia usuario 9', 'foto_perfil_9.jpg', 'admin', 'activa', '2026-11-01 10:00:00'),
(10, 'usuario10@correo.com', '01234567', 'Nombre10', 'Apellido10', 'Biografia usuario 10', 'foto_perfil_10.jpg', 'admin', 'activa', '2026-11-01 10:10:00'),
(11, 'algo@algo.com', '$argon2id$v=19$m=65536,t=4,p=1$TEpRTFZqMWRubDFVOTV4RQ$a3qTpyB1EiZBX895i7A4ys9LNdin8qRXM+WQU3RG4pU', 'pruebaA', 'apellido A', 'aaaaaaaaaaa', NULL, 'estudiante', 'activa', '2026-11-18 21:23:51'),
(12, 'prubaA@pruebaA.com', '$argon2id$v=19$m=65536,t=4,p=1$WHVEZ3Rpa1FaQkhyUW5nRQ$x6e0Wi5x7Q6+YHXzzcie10g2tvPfcWpW+BXIaPrMC+U', 'nombre A', 'apellido A', 'qqqqqqqqq', NULL, 'estudiante', 'verificada', '2026-11-20 17:30:10'),
(13, 'prueba@instructor.com', '$argon2id$v=19$m=65536,t=4,p=1$S2ZJLjM4NjFLdFh4eE9weA$j53n2NjNDKZBh7vGJPZAqy+ICXFiEhS6usKM8lsm6xM', 'instru nom', 'instru apell', 'sssssss', NULL, 'instructor', 'pendiente', '2026-11-20 17:55:22'),
(14, 'prueba@instru2.com', '$argon2id$v=19$m=65536,t=4,p=1$eWpMY0dMUHJ1Wk1mcE5KcA$IiSRqlMFPg8xCSoqCbg1yKdyH6tEib4CPDr2LViDPYY', 'nombre instru dos', 'apelli instru dos', 'qqqqqqqqq', NULL, 'instructor', 'pendiente', '2026-11-20 18:00:56'),
(15, 'trigger@prueba1.com', '$argon2id$v=19$m=65536,t=4,p=1$Sk9SNU1JeENaVkdHUzZ2dA$xeIH1nB/JddRVRPx8Y90xq4FTpB6SYr5VaupZjuBtUs', 'trigger uno', 'apellido trigger uno', 'ooooooooo', NULL, 'instructor', 'pendiente', '2026-11-20 20:19:02'),
(16, 'trigger2@prueba.com', '$argon2id$v=19$m=65536,t=4,p=1$WDY2eExicE81UFV4ZGJaQQ$KakiJ6IyDyOpdDklzRtQhV6mqzA9x162iPTEWSbEaQY', 'nombre t dos', 'apelli t dos', 'llllllll', NULL, 'estudiante', 'pendiente', '2026-11-20 20:20:45');

--
-- Disparadores `usuario`
--
DROP TRIGGER IF EXISTS `trg_usuario_ai_estudiante`;
DELIMITER $$
CREATE TRIGGER `trg_usuario_ai_estudiante` AFTER INSERT ON `usuario` FOR EACH ROW BEGIN
    -- Si el rol se define como estudiante, entonces 
    IF NEW.rol = 'estudiante' THEN
    -- Crea un nuevo registro en la tabla estudiante. 
        INSERT INTO `estudiante` (`usuario_idusuario`)
        VALUES (NEW.idusuario);
    END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `trg_usuario_ai_instructor`;
DELIMITER $$
CREATE TRIGGER `trg_usuario_ai_instructor` AFTER INSERT ON `usuario` FOR EACH ROW BEGIN
    -- Si el rol se define como instructor, entonces 
    IF NEW.rol = 'instructor' THEN
    -- Crea un nuevo registro en la tabla instructor. 
        INSERT INTO `instructor` (`estado_validacion`, `usuario_idusuario`)
        VALUES ('pendiente', NEW.idusuario);
    END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `trg_usuario_au_estudiante`;
DELIMITER $$
CREATE TRIGGER `trg_usuario_au_estudiante` AFTER UPDATE ON `usuario` FOR EACH ROW BEGIN
    -- Si el rol cambió hacia 'estudiante', crea el registro si no existe
    IF OLD.rol <> NEW.rol AND NEW.rol = 'estudiante' THEN
        IF NOT EXISTS (
            SELECT 1 FROM `estudiante` WHERE `usuario_idusuario` = NEW.idusuario
        ) THEN
            -- Si no existe el registro, lo realiza.  
            INSERT INTO `estudiante` (`usuario_idusuario`)
            VALUES (NEW.idusuario);
        END IF;
    END IF;

    -- Si dejó de ser 'estudiante', elimina su registro de especialización
    IF OLD.rol = 'estudiante' AND NEW.rol <> 'estudiante' THEN
        DELETE FROM `estudiante` WHERE `usuario_idusuario` = OLD.idusuario;
    END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `trg_usuario_au_instructor`;
DELIMITER $$
CREATE TRIGGER `trg_usuario_au_instructor` AFTER UPDATE ON `usuario` FOR EACH ROW BEGIN
    -- Si el rol cambió hacia 'instructor', crea el registro si no existe
    IF OLD.rol <> NEW.rol AND NEW.rol = 'instructor' THEN
        IF NOT EXISTS (
            SELECT 1 FROM `instructor` WHERE `usuario_idusuario` = NEW.idusuario
        ) THEN
            -- Si no existe el registro, lo realiza.  
            INSERT INTO `instructor` (`estado_validacion`, `usuario_idusuario`)
            VALUES ('pendiente', NEW.idusuario);
        END IF;
    END IF;

    -- Si dejó de ser 'instructor', elimina su registro de la tabla instructor. 
    IF OLD.rol = 'instructor' AND NEW.rol <> 'instructor' THEN
        DELETE FROM `instructor` WHERE `usuario_idusuario` = OLD.idusuario;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_usuarios_segura`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `vista_usuarios_segura`;
CREATE TABLE IF NOT EXISTS `vista_usuarios_segura` (
`apellido` varchar(55)
,`correo` varchar(225)
,`estado_cuenta` enum('pendiente','verificada','activa','inactiva')
,`fecha_registro` datetime
,`fotografia` varchar(225)
,`idadministrador` int
,`idestudiante` int
,`idinstructor` int
,`idusuario` int
,`nombre` varchar(55)
,`rol` enum('admin','estudiante','instructor')
,`validacion_instructor` enum('pendiente','validado','rechazado')
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_usuarios_segura`
--
DROP TABLE IF EXISTS `vista_usuarios_segura`;

DROP VIEW IF EXISTS `vista_usuarios_segura`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY INVOKER VIEW `vista_usuarios_segura`  AS SELECT `u`.`idusuario` AS `idusuario`, `u`.`correo` AS `correo`, `u`.`nombre` AS `nombre`, `u`.`apellido` AS `apellido`, `u`.`fotografia` AS `fotografia`, `u`.`rol` AS `rol`, `u`.`estado_cuenta` AS `estado_cuenta`, `u`.`fecha_registro` AS `fecha_registro`, `e`.`idestudiante` AS `idestudiante`, `i`.`idinstructor` AS `idinstructor`, `i`.`estado_validacion` AS `validacion_instructor`, `a`.`idadministrador` AS `idadministrador` FROM (((`usuario` `u` left join `estudiante` `e` on((`u`.`idusuario` = `e`.`usuario_idusuario`))) left join `instructor` `i` on((`u`.`idusuario` = `i`.`usuario_idusuario`))) left join `administrador` `a` on((`u`.`idusuario` = `a`.`usuario_idusuario`))) ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD CONSTRAINT `fk_administrador_usuario1` FOREIGN KEY (`usuario_idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `fk_carrito_estudiante1` FOREIGN KEY (`estudiante_idestudiante`) REFERENCES `estudiante` (`idestudiante`) ON DELETE CASCADE;

--
-- Filtros para la tabla `carrito_cursos`
--
ALTER TABLE `carrito_cursos`
  ADD CONSTRAINT `fk_carrito_cursos_carrito1` FOREIGN KEY (`carrito_idcarrito`) REFERENCES `carrito` (`idcarrito`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_carrito_cursos_curso1` FOREIGN KEY (`curso_idcurso`) REFERENCES `curso` (`idcurso`);

--
-- Filtros para la tabla `certificado`
--
ALTER TABLE `certificado`
  ADD CONSTRAINT `fk_certificado_curso1` FOREIGN KEY (`curso_idcurso`) REFERENCES `curso` (`idcurso`),
  ADD CONSTRAINT `fk_certificado_estudiante1` FOREIGN KEY (`estudiante_idestudiante`) REFERENCES `estudiante` (`idestudiante`) ON DELETE CASCADE;

--
-- Filtros para la tabla `codigo_ins`
--
ALTER TABLE `codigo_ins`
  ADD CONSTRAINT `fk_codigo_ins_administrador1` FOREIGN KEY (`administrador_idadministrador`) REFERENCES `administrador` (`idadministrador`),
  ADD CONSTRAINT `fk_codigo_ins_instructor1` FOREIGN KEY (`instructor_idinstructor`) REFERENCES `instructor` (`idinstructor`) ON DELETE CASCADE;

--
-- Filtros para la tabla `codigo_ver`
--
ALTER TABLE `codigo_ver`
  ADD CONSTRAINT `fk_codigo_ver_usuario1` FOREIGN KEY (`usuario_idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `fk_compra_estudiante1` FOREIGN KEY (`estudiante_idestudiante`) REFERENCES `estudiante` (`idestudiante`) ON DELETE CASCADE;

--
-- Filtros para la tabla `contenido`
--
ALTER TABLE `contenido`
  ADD CONSTRAINT `fk_contenido_leccion1` FOREIGN KEY (`leccion_idleccion`) REFERENCES `leccion` (`idleccion`) ON DELETE CASCADE;

--
-- Filtros para la tabla `curso`
--
ALTER TABLE `curso`
  ADD CONSTRAINT `fk_curso_instructor1` FOREIGN KEY (`instructor_idinstructor`) REFERENCES `instructor` (`idinstructor`);

--
-- Filtros para la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD CONSTRAINT `fk_detalle_compra_compra1` FOREIGN KEY (`compra_idcompra`) REFERENCES `compra` (`idcompra`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_detalle_compra_curso1` FOREIGN KEY (`curso_idcurso`) REFERENCES `curso` (`idcurso`);

--
-- Filtros para la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD CONSTRAINT `fk_estudiante_usuario` FOREIGN KEY (`usuario_idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `instructor`
--
ALTER TABLE `instructor`
  ADD CONSTRAINT `fk_instructor_usuario1` FOREIGN KEY (`usuario_idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `leccion`
--
ALTER TABLE `leccion`
  ADD CONSTRAINT `fk_leccion_curso1` FOREIGN KEY (`curso_idcurso`) REFERENCES `curso` (`idcurso`) ON DELETE CASCADE;

--
-- Filtros para la tabla `progreso`
--
ALTER TABLE `progreso`
  ADD CONSTRAINT `fk_progreso_estudiante1` FOREIGN KEY (`estudiante_idestudiante`) REFERENCES `estudiante` (`idestudiante`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_progreso_leccion1` FOREIGN KEY (`leccion_idleccion`) REFERENCES `leccion` (`idleccion`) ON DELETE CASCADE;

--
-- Filtros para la tabla `sesion`
--
ALTER TABLE `sesion`
  ADD CONSTRAINT `fk_sesion_usuario1` FOREIGN KEY (`usuario_idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
