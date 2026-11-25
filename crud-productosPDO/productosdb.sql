-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 09-11-2026 a las 21:17:58
-- Versión del servidor: 10.6.23-MariaDB-0ubuntu0.22.04.1
-- Versión de PHP: 8.3.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ProductosDB`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Productos`
--

CREATE TABLE `Productos` (
  `codigo` int(4) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `stock` int(5) NOT NULL,
  `stock_min` int(5) NOT NULL,
  `precio` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `Productos`
--

INSERT INTO `Productos` (`codigo`, `nombre`, `stock`, `stock_min`, `precio`) VALUES
(1001, 'Morcillas', 10, 5, 12),
(1002, 'Chorizo', 30, 5, 12.5),
(1003, 'Chope', 70, 15, 4.5),
(1004, 'Fuet', 5, 25, 2.5),
(1501, 'Lacón ', 10, 15, 20.5),
(2001, 'Tocino', 10, 5, 1.5),
(3021, 'Jamón York', 60, 50, 10),
(4201, 'Torreznos', 120, 5, 13.7),
(6001, 'Mortadela', 20, 5, 20.5),
(6002, 'Queso Burgos', 2, 2, 23.15);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Productos`
--
ALTER TABLE `Productos`
  ADD PRIMARY KEY (`codigo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
