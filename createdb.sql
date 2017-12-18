-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 18, 2017 at 04:13 PM
-- Server version: 5.6.34-log
-- PHP Version: 7.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rugbybd`
--

-- --------------------------------------------------------

--
-- Table structure for table `equipo`
--

CREATE TABLE `equipo` (
  `id` int(11) NOT NULL,
  `nombre` tinytext NOT NULL,
  `imagen` tinytext NOT NULL,
  `comunidad` tinytext NOT NULL,
  `entrenador` tinytext NOT NULL,
  `liga` tinytext NOT NULL,
  `puntuacion` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `equipo`
--

INSERT INTO `equipo` (`id`, `nombre`, `imagen`, `comunidad`, `entrenador`, `liga`, `puntuacion`, `created_at`, `updated_at`) VALUES
(20, 'Equipo VRAC Quesos Entrepinares', 'http://vracrugby.com/wp-content/uploads/2017/03/logo-moviles-pos.png', 'Castilla la Mancha', 'Juan Bedate', 'Liga Heineken', 53, '0000-00-00 00:00:00', '2017-12-15 17:44:37'),
(21, 'qwdqw', 'imagenes/sinimagen.jpg', 'Andalucia', 'qwdqwd', 'sdaf', 12, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, 'wqewqe', 'https://vignette.wikia.nocookie.net/linux/images/8/84/Sin_imagen_disponible.jpg/revision/latest?cb=20160321215614&path-prefix=es', 'Andalucia', 'qwe', 'wqewqe', 333, '2017-12-08 13:41:28', '2017-12-08 13:41:28'),
(23, 'eqweqwe', 'https://vignette.wikia.nocookie.net/linux/images/8/84/Sin_imagen_disponible.jpg/revision/latest?cb=20160321215614&path-prefix=es', 'Andalucia', 'dewd', 'eqweqwe', 12, '2017-12-08 13:44:55', '2017-12-08 13:44:55'),
(24, 'Equipo Senor Independiente Rugby', 'http://www.alcobendasrugby.com/wp-content/uploads/2016/10/Independiente-santander-420x420.png', 'Asturias', 'Jose Ignacio Garcia', 'Liga Heineken', 36, '2017-12-08 14:16:53', '2017-12-15 17:46:15'),
(27, 'Equipo Getxo Artea RT', 'http://ferugby.habitualdata.com/Ficheros/Adjuntos/65_escudo-4507.png', 'Pais Vasco', 'Beñat Lavin', 'Liga Iberdrola', 5, '2017-12-15 18:10:50', '2017-12-15 18:10:50'),
(28, 'Equipo CRAT A Coruña', 'http://ferugby.habitualdata.com/Ficheros/Adjuntos/19_crat-coru%c3%b1a.jpg', 'Galicia', 'Pablo Artime', 'Liga Division de Honor B', 29, '2017-12-15 18:18:25', '2017-12-15 18:18:25'),
(29, 'Equipo SilverStorm El Salvador Emerging', 'http://ferugby.habitualdata.com/Ficheros/Adjuntos/25_Salvador.jpg', 'Castilla la Mancha', 'Victor Acebes', 'Liga Division de Honor B', 15, '2017-12-15 18:19:50', '2017-12-15 18:19:50');

-- --------------------------------------------------------

--
-- Table structure for table `jugador`
--

CREATE TABLE `jugador` (
  `id` int(11) NOT NULL,
  `imagen` tinytext NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(60) NOT NULL,
  `edad` int(3) NOT NULL,
  `altura` decimal(10,0) NOT NULL,
  `peso` decimal(10,0) NOT NULL,
  `posicion` tinytext NOT NULL,
  `partidos` int(11) NOT NULL,
  `ensayos` int(11) NOT NULL,
  `amarillas` int(11) NOT NULL,
  `rojas` int(11) NOT NULL,
  `equipo` tinytext NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jugador`
--

INSERT INTO `jugador` (`id`, `imagen`, `nombre`, `apellido`, `edad`, `altura`, `peso`, `posicion`, `partidos`, `ensayos`, `amarillas`, `rojas`, `equipo`, `created_at`, `updated_at`) VALUES
(6, 'https://vignette.wikia.nocookie.net/linux/images/8/84/Sin_imagen_disponible.jpg/revision/latest?cb=20160321215614&path-prefix=es', 'asdasd', 'adasdasdasdsd', 12, 1, 55, 'Pilar(1, 3)', 123, 12, 123, 123, 'Equipo asdqwd', '1996-12-02 00:00:00', '2017-12-12 00:51:33'),
(7, 'http://ferugby.habitualdata.com/Ficheros/Adjuntos/Federados/9233_Sin%20t%c3%adtulo.jpg', 'Fernando', 'Alvarez', 31, 2, 118, 'Pilar(1, 3)', 569, 0, 4, 2, 'Equipo Senor Independiente Rugby', '2017-12-15 17:51:01', '2017-12-15 18:01:37'),
(8, 'http://ferugby.habitualdata.com/Ficheros/Adjuntos/Federados/2906_villegas%20losada.jpg', 'Manuel', 'Gutierrez', 21, 2, 88, 'Centro(12, 13)', 2, 1, 0, 0, 'Equipo Senor Independiente Rugby', '2017-12-15 18:03:19', '2017-12-15 18:03:19'),
(9, 'http://ferugby.habitualdata.com/Ficheros/Adjuntos/Federados/8018_PER_2723_7609343788765226.jpg', 'Martin', 'Alonso', 18, 2, 69, 'Media Mele(9)', 160, 0, 3, 1, 'Equipo VRAC Quesos Entrepinares', '2017-12-15 18:09:09', '2017-12-15 18:09:09'),
(10, 'http://ferugby.habitualdata.com/Ficheros/Adjuntos/Federados/3725_Sin%20t%c3%adtulo.png', 'Maider', 'Gutierrez', 30, 2, 56, 'Pilar(1, 3)', 265, 3, 0, 0, 'Equipo Getxo Artea RT', '2017-12-15 18:13:14', '2017-12-15 18:13:14'),
(11, 'http://ferugby.habitualdata.com/Ficheros/Adjuntos/Federados/815_Rapha%c3%abl%20Blanco.JPG', 'Raphaël', 'Blanco', 21, 2, 90, 'Zaguero(15)', 800, 6, 1, 2, 'Equipo SilverStorm El Salvador Emerging', '2017-12-15 18:21:48', '2017-12-15 18:21:48'),
(12, 'http://ferugby.habitualdata.com/Ficheros/Adjuntos/Federados/2030_Gabriel%20Fern%c3%a1ndez.JPG', 'Gabriel', 'Fernandez', 20, 2, 105, 'Talonador(2)', 316, 0, 3, 2, 'Equipo SilverStorm El Salvador Emerging', '2017-12-15 18:22:58', '2017-12-15 18:22:58'),
(13, 'http://ferugby.habitualdata.com/Ficheros/Adjuntos/Federados/9134_Emmanuel%20Avaca.jpg', 'Emmanuel', 'Avaca', 30, 2, 85, 'Apertura(10)', 880, 14, 1, 0, 'Equipo CRAT A Coruña', '2017-12-15 18:24:42', '2017-12-15 18:24:42');

-- --------------------------------------------------------

--
-- Table structure for table `liga`
--

CREATE TABLE `liga` (
  `id` int(11) NOT NULL,
  `nombre` tinytext NOT NULL,
  `imagen` tinytext NOT NULL,
  `max_equipos` int(2) NOT NULL,
  `inicio_liga` date NOT NULL,
  `fin_liga` date NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `liga`
--

INSERT INTO `liga` (`id`, `nombre`, `imagen`, `max_equipos`, `inicio_liga`, `fin_liga`, `created_at`, `updated_at`) VALUES
(15, 'Liga Iberdrola', 'http://e00-marca.uecdn.es/assets/multimedia/imagenes/2017/10/05/15072132782915.png', 12, '2017-06-15', '2018-06-22', '0000-00-00 00:00:00', '2017-12-15 18:09:48'),
(25, 'Liga Heineken', 'https://www.revista22.es/wp-content/uploads/2017/09/logo-Liga-Heineken_baja.jpg', 12, '2017-09-15', '2018-06-13', '0000-00-00 00:00:00', '2017-12-15 17:40:54'),
(38, 'Liga Division de Honor B', 'http://90minutos.com.uy/wp-content/uploads/2015/10/SEGUNDA-DIVISION.jpg', 12, '2017-06-15', '2018-06-22', '0000-00-00 00:00:00', '2017-12-15 18:17:29');

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nombre` tinytext NOT NULL,
  `email` tinytext NOT NULL,
  `password` tinytext NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Metilk', 'tonymoyasanchez@gmail.com', '$2y$10$hUD42Y3h8QaWiakj3CdHXu7mGdQ8zVZrXCJrkViCTsG6rEU2AB.QS', '2017-12-08 19:41:48', '2017-12-08 19:41:48'),
(2, 'anmoysan', 'tonimoyasanchez@gmail.com', '$2y$10$Ijl54/gR7OBdfoaclVEW9OYV5G8orj7PO1g5u8WJ.IzfyY1tH.P8e', '2017-12-08 19:47:32', '2017-12-08 19:47:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `equipo`
--
ALTER TABLE `equipo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jugador`
--
ALTER TABLE `jugador`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `liga`
--
ALTER TABLE `liga`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `equipo`
--
ALTER TABLE `equipo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `jugador`
--
ALTER TABLE `jugador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `liga`
--
ALTER TABLE `liga`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
