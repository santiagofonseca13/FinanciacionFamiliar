-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-11-2024 a las 18:29:02
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
-- Base de datos: `dbhogar`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoriagastos`
--

CREATE TABLE `categoriagastos` (
  `id_categoria` int(11) NOT NULL,
  `nombre_categoria` varchar(50) DEFAULT NULL,
  `descripcion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoriagastos`
--

INSERT INTO `categoriagastos` (`id_categoria`, `nombre_categoria`, `descripcion`) VALUES
(1, 'Alimentación', 'Gastos relacionados con la compra de alimentos y b'),
(2, 'Vivienda', 'Gastos de alquiler, hipoteca, y servicios públicos'),
(3, 'Transporte', 'Gastos de transporte, incluyendo gasolina y manten'),
(4, 'Salud', 'Gastos médicos, medicamentos y seguros de salud'),
(5, 'Educación', 'Gastos en matrícula, libros y materiales educativo'),
(6, 'Entretenimiento', 'Gastos en ocio, como cine, restaurantes y activida'),
(7, 'Ropa', 'Gastos en prendas de vestir y accesorios'),
(8, 'Ahorro', 'Dinero destinado al ahorro y la inversión'),
(9, 'Mascotas', 'Gastos relacionados con el cuidado de mascotas, co'),
(10, 'Otros', 'Gastos que no se clasifican en las categorías ante');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `familia`
--

CREATE TABLE `familia` (
  `id_familia` int(3) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `familia`
--

INSERT INTO `familia` (`id_familia`, `descripcion`) VALUES
(1, 'Carol\'s Family'),
(2, 'Santiago\'s Family');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gastos`
--

CREATE TABLE `gastos` (
  `id_gastos` int(11) NOT NULL,
  `monto_ga` int(15) DEFAULT NULL,
  `fecha_ga` date DEFAULT NULL,
  `id_categoria` int(8) DEFAULT NULL,
  `id_usuario` int(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `gastos`
--

INSERT INTO `gastos` (`id_gastos`, `monto_ga`, `fecha_ga`, `id_categoria`, `id_usuario`) VALUES
(1, 10000, '2024-11-14', 6, 4),
(2, 20000, '2024-11-06', 1, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingresos`
--

CREATE TABLE `ingresos` (
  `id_ingreso` int(11) NOT NULL,
  `monto_in` int(15) DEFAULT NULL,
  `fuente_in` varchar(30) DEFAULT NULL,
  `fecha_in` date DEFAULT NULL,
  `id_usuario` int(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ingresos`
--

INSERT INTO `ingresos` (`id_ingreso`, `monto_in`, `fuente_in`, `fecha_in`, `id_usuario`) VALUES
(1, 10000, 'Venta', '2024-11-05', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(8) NOT NULL,
  `nombre` varchar(30) DEFAULT NULL,
  `rol` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `contasena` varchar(255) DEFAULT NULL,
  `id_familia` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `rol`, `email`, `contasena`, `id_familia`) VALUES
(3, 'Carol', 'mama', 'carolospina.la@uniminuto.edu.co', '$2y$10$IhEqVMoP4.oeMwn/jKPK4OfXB5WARpKaew.thx7cno5GM9xCqmHA.', 1),
(4, 'Santiago', 'mama', 'santiago@gmail.com', '$2y$10$RuzjFYnQDaiehV3NZYG2Re5wojbwGmTJCt1NXDzkvhsYcLPkeblta', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoriagastos`
--
ALTER TABLE `categoriagastos`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `familia`
--
ALTER TABLE `familia`
  ADD PRIMARY KEY (`id_familia`);

--
-- Indices de la tabla `gastos`
--
ALTER TABLE `gastos`
  ADD PRIMARY KEY (`id_gastos`),
  ADD KEY `fk_categoria` (`id_categoria`),
  ADD KEY `fk_usuario_gastos` (`id_usuario`);

--
-- Indices de la tabla `ingresos`
--
ALTER TABLE `ingresos`
  ADD PRIMARY KEY (`id_ingreso`),
  ADD KEY `fk_usuario_ingresos` (`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `fk_familia` (`id_familia`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoriagastos`
--
ALTER TABLE `categoriagastos`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `familia`
--
ALTER TABLE `familia`
  MODIFY `id_familia` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `gastos`
--
ALTER TABLE `gastos`
  MODIFY `id_gastos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ingresos`
--
ALTER TABLE `ingresos`
  MODIFY `id_ingreso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `gastos`
--
ALTER TABLE `gastos`
  ADD CONSTRAINT `fk_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categoriagastos` (`id_categoria`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_usuario_gastos` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `ingresos`
--
ALTER TABLE `ingresos`
  ADD CONSTRAINT `fk_usuario_ingresos` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_familia` FOREIGN KEY (`id_familia`) REFERENCES `familia` (`id_familia`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
