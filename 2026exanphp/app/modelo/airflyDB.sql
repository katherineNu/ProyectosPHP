-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 27-01-2026 a las 19:09:16
-- Versión del servidor: 10.6.22-MariaDB-0ubuntu0.22.04.1
-- Versión de PHP: 8.1.2-1ubuntu2.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `airflyDB`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Vuelos`
--

CREATE TABLE `Vuelos` (
  `cod_vuelo` varchar(10) NOT NULL,
  `destino` varchar(50) NOT NULL,
  `aerolinea` varchar(50) NOT NULL,
  `clase` int(11) NOT NULL,
  `precio_billete` float NOT NULL,
  `asientos_libres` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Vuelos`
--

INSERT INTO `Vuelos` (`cod_vuelo`, `destino`, `aerolinea`, `clase`, `precio_billete`, `asientos_libres`) VALUES
('FLY-006', 'Japón', 'Tokyo Air', 1, 450, 15),
('FLY-007', 'Japón', 'Nippon Airways', 2, 920, 4),
('FLY-008', 'Japón', 'Pacific Fly', 1, 390, 20),
('FLY-009', 'Italia', 'Venice Wings', 2, 210, 12),
('FLY-010', 'Italia', 'Sky Tuscany', 1, 95, 8),
('FLY-011', 'México', 'Azteca Air', 1, 550, 60),
('FLY-012', 'México', 'Maya Jets', 2, 890, 25),
('FLY-013', 'Francia', 'Paris Star', 3, 1100, 0),
('FLY-014', 'Francia', 'EuroFlight', 1, 120, 0),
('FLY-015', 'EE.UU.', 'Liberty Air', 3, 2500, 5),
('FLY-016', 'EE.UU.', 'Atlantic Route', 2, 1300, 3),
('FLY-017', 'EE.UU.', 'Global Connect', 1, 750, 45);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Vuelos`
--
ALTER TABLE `Vuelos`
  ADD PRIMARY KEY (`cod_vuelo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
