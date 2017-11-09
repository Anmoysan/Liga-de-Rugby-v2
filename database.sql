-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 09, 2017 at 11:14 AM
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
(10, 'fff', 'http://9722830f0a071c238f31-0bf39b81254f02fe2190e0dd4584cc20.r24.cf2.rackcdn.com/imagen_radio/portadaImagenRadio_cio.jpg', 'Andalucia', '4', 'Liga Heineken', 44),
(11, 'qwewqe', 'eqweqw', 'Cantabria', 'qwe', 'Liga Heineken', 12),
(16, 'qwe', 'dwq', 'Andalucia', '23d', 'deq', 32);

-- --------------------------------------------------------

--
-- Table structure for table `jugador`
--

CREATE TABLE `jugador` (
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(60) NOT NULL,
  `dni` char(9) NOT NULL,
  `edad` int(3) NOT NULL,
  `altura` decimal(10,0) NOT NULL,
  `peso` decimal(10,0) NOT NULL,
  `posicion` tinytext NOT NULL,
  `mediaEnsayoPartido` decimal(11,0) NOT NULL,
  `mediaAmarillaPartido` decimal(11,0) NOT NULL,
  `mediaRojaPartido` decimal(11,0) NOT NULL,
  `equipo` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `liga`
--

CREATE TABLE `liga` (
  `id` int(11) NOT NULL,
  `nombre` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `liga`
--

INSERT INTO `liga` (`id`, `nombre`) VALUES
(6, 'Liga Heineken'),
(7, 'Liga Iberdrola'),
(9, 'deq');

-- --------------------------------------------------------

--
-- Table structure for table `partido`
--

CREATE TABLE `partido` (
  `id` int(11) NOT NULL,
  `equipo1` varchar(60) NOT NULL,
  `ensayosLocal` int(11) NOT NULL,
  `equipo2` varchar(60) NOT NULL,
  `ensayosVisitante` int(11) NOT NULL,
  `estadio` tinytext NOT NULL,
  `arbitro` tinytext NOT NULL,
  `fechaHora` datetime NOT NULL,
  `liga` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `equipo`
--
ALTER TABLE `equipo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `liga`
--
ALTER TABLE `liga`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `partido`
--
ALTER TABLE `partido`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `equipo`
--
ALTER TABLE `equipo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `liga`
--
ALTER TABLE `liga`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `partido`
--
ALTER TABLE `partido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
