-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 30, 2017 at 02:44 PM
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
  `puntuacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `equipo`
--

INSERT INTO `equipo` (`id`, `nombre`, `imagen`, `comunidad`, `entrenador`, `liga`, `puntuacion`) VALUES
(19, 'Equipo qwe', 'imagenes/sinimagen.jpg', 'La Rioja', 'qweqwe', 'Liga Heineken', 213),
(20, 'Equipo asdqwd', 'imagenes/sinimagen.jpg', 'Murcia', 'dqwdq', 'Liga Heineken', 2131),
(21, 'qwdqw', 'imagenes/sinimagen.jpg', 'Andalucia', 'qwdqwd', 'sdaf', 12);

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
  `equipo` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jugador`
--

INSERT INTO `jugador` (`id`, `imagen`, `nombre`, `apellido`, `edad`, `altura`, `peso`, `posicion`, `partidos`, `ensayos`, `amarillas`, `rojas`, `equipo`) VALUES
(2, 'imagenes/sinimagen.jpg', 'qweqwe', 'qwe', 12, 12, 12, 'Pilar(1, 3)', 123, 12, 12, 12, 'Equipo qwe'),
(4, 'imagenes/sinimagen.jpg', 'fwe', 'efwf', 3265, 23, 65, 'Pilar(1, 3)', 5, 234, 234, 234, 'Equipo qwe');

-- --------------------------------------------------------

--
-- Table structure for table `liga`
--

CREATE TABLE `liga` (
  `id` int(11) NOT NULL,
  `nombre` tinytext NOT NULL,
  `imagen` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `liga`
--

INSERT INTO `liga` (`id`, `nombre`, `imagen`) VALUES
(15, 'Liga Iberdrola', 'http://e00-marca.uecdn.es/assets/multimedia/imagenes/2017/10/05/15072132782915.png'),
(25, 'Liga Heineken', 'http://www.ferugby.es/userfiles/image/Imagenes%20Noticias%2017%2018/Liga/logo%20Liga%20Heineken_baja.jpg'),
(38, 'Liga sadas', 'http://www.phoenixpumps.com/uimages/manufacturers/Paco_Logo_2.png'),
(39, 'Liga qwe', 's');

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `equipo`
--
ALTER TABLE `equipo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `jugador`
--
ALTER TABLE `jugador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `liga`
--
ALTER TABLE `liga`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
