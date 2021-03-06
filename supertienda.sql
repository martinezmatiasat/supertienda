-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 10-11-2019 a las 16:44:03
-- Versión del servidor: 5.7.26
-- Versión de PHP: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `supertienda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin_session`
--

DROP TABLE IF EXISTS `admin_session`;
CREATE TABLE IF NOT EXISTS `admin_session` (
  `session_id` varchar(255) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `admin_session`
--

INSERT INTO `admin_session` (`session_id`, `user_id`) VALUES
('vh6cdm56bfioc0b020vt4v7k96', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

DROP TABLE IF EXISTS `categoria`;
CREATE TABLE IF NOT EXISTS `categoria` (
  `categoria_id` int(11) NOT NULL AUTO_INCREMENT,
  `subcategoria_id` int(11) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `destacada` tinyint(4) DEFAULT NULL,
  `orden` int(11) DEFAULT NULL,
  PRIMARY KEY (`categoria_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `extra_variables`
--

DROP TABLE IF EXISTS `extra_variables`;
CREATE TABLE IF NOT EXISTS `extra_variables` (
  `extra_variables_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `module` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`extra_variables_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `extra_variables`
--

INSERT INTO `extra_variables` (`extra_variables_id`, `name`, `value`, `module`) VALUES
(1, 'NO_REPLY_NAME', ' noreply', 1),
(2, 'SMAIL_SMTP', '1', 1),
(3, 'SMAIL_HOST', 'localhost', 1),
(4, 'SMAIL_PORT', ' 25', 1),
(5, 'SMAIL_AUTH', '0', 1),
(6, 'SMAIL_USERNAME', 'test', 1),
(7, 'SMAIL_PASSWORD', 'test', 1),
(8, 'SMAIL_DEBUG', '0', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `meta_tag`
--

DROP TABLE IF EXISTS `meta_tag`;
CREATE TABLE IF NOT EXISTS `meta_tag` (
  `meta_tag_id` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `keywords` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `author` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`meta_tag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `meta_tag`
--

INSERT INTO `meta_tag` (`meta_tag_id`, `description`, `keywords`, `author`) VALUES
(1, '11', '22', '33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

DROP TABLE IF EXISTS `producto`;
CREATE TABLE IF NOT EXISTS `producto` (
  `producto_id` int(11) NOT NULL AUTO_INCREMENT,
  `vendedor_id` int(11) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `descuento` decimal(10,2) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `duracion` int(11) DEFAULT NULL,
  `descripcion` longtext,
  `eliminado` tinyint(4) DEFAULT NULL,
  `categorias` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`producto_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_imagen`
--

DROP TABLE IF EXISTS `producto_imagen`;
CREATE TABLE IF NOT EXISTS `producto_imagen` (
  `producto_imagen_id` int(11) NOT NULL AUTO_INCREMENT,
  `producto_id` int(11) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `orden` int(11) DEFAULT NULL,
  PRIMARY KEY (`producto_imagen_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `system_variables`
--

DROP TABLE IF EXISTS `system_variables`;
CREATE TABLE IF NOT EXISTS `system_variables` (
  `system_variables_id` int(11) NOT NULL,
  `ADMIN_LANGUAGE` varchar(10) DEFAULT NULL,
  `PAGE_NAME` varchar(255) DEFAULT NULL,
  `NO_REPLY_EMAIL` varchar(255) DEFAULT NULL,
  `DATETIME_FORMAT` varchar(45) DEFAULT NULL,
  `DATE_FORMAT` varchar(45) DEFAULT NULL,
  `FRONT_LANGUAGE` varchar(20) DEFAULT NULL,
  `CONTACT_EMAIL` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`system_variables_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `system_variables`
--

INSERT INTO `system_variables` (`system_variables_id`, `ADMIN_LANGUAGE`, `PAGE_NAME`, `NO_REPLY_EMAIL`, `DATETIME_FORMAT`, `DATE_FORMAT`, `FRONT_LANGUAGE`, `CONTACT_EMAIL`) VALUES
(1, 'es', 'CMS2', 'noreply@domain.com', 'Y-m-d', 'y-m-d', 'es', 'contacto@domain.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `u1`
--

DROP TABLE IF EXISTS `u1`;
CREATE TABLE IF NOT EXISTS `u1` (
  `u1_id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(255) DEFAULT NULL,
  `clave` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `rol` tinyint(4) DEFAULT NULL,
  `vendedor_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`u1_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `u1`
--

INSERT INTO `u1` (`u1_id`, `usuario`, `clave`, `email`, `rol`, `vendedor_id`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'admin@admin.com', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vendedor`
--

DROP TABLE IF EXISTS `vendedor`;
CREATE TABLE IF NOT EXISTS `vendedor` (
  `vendedor_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `apellido` varchar(255) DEFAULT NULL,
  `nombre_tienda` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  `u1_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`vendedor_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
