-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-10-2024 a las 15:29:44
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `banco`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas`
--

CREATE TABLE `cuentas` (
  `NroCuenta` varchar(24) NOT NULL,
  `Saldo` double(9,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cuentas`
--

INSERT INTO `cuentas` (`NroCuenta`, `Saldo`) VALUES
('000000673854258486838310', 5000.00),
('000001435358635016525548', 5000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transacciones`
--

CREATE TABLE `transacciones` (
  `IdTransaccion` int(11) NOT NULL,
  `NroCuentaOrigen` varchar(24) NOT NULL,
  `NroCuentaDestinatario` varchar(24) NOT NULL,
  `Fecha` date NOT NULL,
  `Monto` double(9,2) DEFAULT NULL,
  `Concepto` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `Id` int(11) NOT NULL,
  `NroCuenta` varchar(24) NOT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Apellido` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`Id`, `NroCuenta`, `Email`, `password`, `Nombre`, `Apellido`) VALUES
(1, '000001435358635016525548', 'prueba@gmail.com', '$2y$10$xwszpyUyEZueEIzIsnxQZuJEz3Nogu1gVNKGwiPvzbRqTABWT.qjK', 'Alejandro', 'Prueba'),
(2, '000000673854258486838310', 'prueba2@gmail.com', '$2y$10$yAZhLIoFfhkrR1etLSv6XOcI3THdeJfQq1uNqucfgaQhGewjuxTQG', 'Pedro', 'Probado');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cuentas`
--
ALTER TABLE `cuentas`
  ADD PRIMARY KEY (`NroCuenta`);

--
-- Indices de la tabla `transacciones`
--
ALTER TABLE `transacciones`
  ADD PRIMARY KEY (`IdTransaccion`),
  ADD KEY `NroCuentaOrigen` (`NroCuentaOrigen`),
  ADD KEY `NroCuentaDestinatario` (`NroCuentaDestinatario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `NroCuenta` (`NroCuenta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `transacciones`
--
ALTER TABLE `transacciones`
  MODIFY `IdTransaccion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `transacciones`
--
ALTER TABLE `transacciones`
  ADD CONSTRAINT `transacciones_ibfk_1` FOREIGN KEY (`NroCuentaOrigen`) REFERENCES `cuentas` (`NroCuenta`),
  ADD CONSTRAINT `transacciones_ibfk_2` FOREIGN KEY (`NroCuentaDestinatario`) REFERENCES `cuentas` (`NroCuenta`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`NroCuenta`) REFERENCES `cuentas` (`NroCuenta`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
