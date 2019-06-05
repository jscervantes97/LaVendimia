-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-06-2019 a las 05:15:49
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bdconcredito`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos`
--

CREATE TABLE `articulos` (
  `CveArt` int(11) NOT NULL,
  `Descripcion` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Modelo` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Precio` decimal(9,2) DEFAULT NULL,
  `Existencia` int(11) DEFAULT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `articulos`
--

INSERT INTO `articulos` (`CveArt`, `Descripcion`, `Modelo`, `Precio`, `Existencia`, `Status`) VALUES
(1, 'articulo 1', 'modelo1', '99.50', 100, 0),
(2, 'Articulo 2', 'Modelo 2', '1999.00', 10, 0),
(3, 'Cevichurros de Abeja', 'Calidad Industrial', '35.00', 100, 0),
(4, 'Articulo 4', 'Modelo 4', '999.00', 10, 0),
(5, 'Comedor 4 Sillas', 'Carlos V', '4250.00', 10, 0),
(6, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `CveCte` int(11) NOT NULL,
  `Nombre` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ApePat` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ApeMat` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `RFC` varchar(12) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`CveCte`, `Nombre`, `ApePat`, `ApeMat`, `RFC`, `Status`) VALUES
(1, 'Jesus Alberto', 'Cervantes', 'Medina', 'JACM2912', 0),
(2, 'Rosita', 'Guerrero', 'Vazquez', 'RGV1022', 0),
(3, 'Irenia', 'Nuñez', 'Ruelaz', 'IMRN121', 0),
(4, 'Juan Leoncio', 'Nuñez', 'Armenta', 'JLNM122', 0),
(5, 'Jesus Astolfo', 'Rodriguez', 'Valenzuela', 'JARV0022', 0),
(6, 'Anahi', 'Manjarrez', 'Villalobos', 'AMV000', 0),
(7, 'Rosalio', 'Zatarain', 'Cabada', 'RZCLAI', 0),
(8, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `TazaFinanciamiento` decimal(5,2) NOT NULL,
  `Enganche` decimal(9,2) NOT NULL,
  `PlazoMaximo` decimal(9,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`TazaFinanciamiento`, `Enganche`, `PlazoMaximo`) VALUES
('2.90', '20.00', '20.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `folios`
--

CREATE TABLE `folios` (
  `ID` int(11) NOT NULL,
  `Folio` int(11) NOT NULL,
  `CveArt` int(11) NOT NULL,
  `Cantidad` int(11) DEFAULT NULL,
  `Importe` decimal(9,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `folios`
--

INSERT INTO `folios` (`ID`, `Folio`, `CveArt`, `Cantidad`, `Importe`) VALUES
(17, 1, 1, 1, '132.93'),
(18, 2, 3, 1, '46.76'),
(19, 3, 5, 1, '5678.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `Folio` int(11) NOT NULL,
  `CveCte` int(11) DEFAULT NULL,
  `Total` decimal(9,2) DEFAULT NULL,
  `Fecha` date DEFAULT NULL,
  `Estatus` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`Folio`, `CveCte`, `Total`, `Fecha`, `Estatus`, `Status`) VALUES
(1, 1, '79.04', '2019-06-05', 'Activa', 0),
(2, 2, '34.27', '2019-06-05', 'Activa', 0),
(3, 1, '3376.01', '2019-06-05', 'Activa', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD PRIMARY KEY (`CveArt`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`CveCte`),
  ADD UNIQUE KEY `RFC` (`RFC`);

--
-- Indices de la tabla `folios`
--
ALTER TABLE `folios`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`Folio`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articulos`
--
ALTER TABLE `articulos`
  MODIFY `CveArt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `CveCte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `folios`
--
ALTER TABLE `folios`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `Folio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
