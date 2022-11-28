-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 28, 2022 at 05:42 PM
-- Server version: 5.7.24
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lefnica`
--

-- --------------------------------------------------------

--
-- Table structure for table `alimento`
--

CREATE TABLE `alimento` (
  `Id_alimento` int(11) NOT NULL,
  `Alimento` varchar(40) NOT NULL,
  `Humedad_ideal_rango_mayor` varchar(10) DEFAULT NULL,
  `Humedad_ideal_rango_menor` varchar(10) DEFAULT NULL,
  `Temperatura_ideal_rango_mayor` varchar(10) DEFAULT NULL,
  `Temperatura_ideal_rango_menor` varchar(10) DEFAULT NULL,
  `Tiempo` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `alimento`
--

INSERT INTO `alimento` (`Id_alimento`, `Alimento`, `Humedad_ideal_rango_mayor`, `Humedad_ideal_rango_menor`, `Temperatura_ideal_rango_mayor`, `Temperatura_ideal_rango_menor`, `Tiempo`) VALUES
(1, 'CARNE', '95', '90', '5', '4', '00:00:00'),
(2, 'VERDURAS', '90', '85', '13', '1', '00:00:01'),
(3, 'FRUTA', '90', '85', '13', '1', '00:00:02'),
(4, 'LEGUMBRES', '88', '86', '20', '3', '00:00:03'),
(5, 'PESCADO', '95', '90', '5', '4', '00:00:04'),
(6, 'POLLO', '95', '90', '4', '3', '00:00:05');

-- --------------------------------------------------------

--
-- Table structure for table `loginform`
--

CREATE TABLE `loginform` (
  `ID` int(11) NOT NULL,
  `User` varchar(255) NOT NULL,
  `Pass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `loginform`
--

INSERT INTO `loginform` (`ID`, `User`, `Pass`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `nodemcu`
--

CREATE TABLE `nodemcu` (
  `id_regist` int(11) NOT NULL,
  `Temperatura` int(11) DEFAULT NULL,
  `Humedad` int(11) DEFAULT NULL,
  `Tiempo` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alimento`
--
ALTER TABLE `alimento`
  ADD PRIMARY KEY (`Id_alimento`);

--
-- Indexes for table `loginform`
--
ALTER TABLE `loginform`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `nodemcu`
--
ALTER TABLE `nodemcu`
  ADD PRIMARY KEY (`id_regist`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alimento`
--
ALTER TABLE `alimento`
  MODIFY `Id_alimento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `loginform`
--
ALTER TABLE `loginform`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `nodemcu`
--
ALTER TABLE `nodemcu`
  MODIFY `id_regist` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
