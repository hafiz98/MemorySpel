-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Gegenereerd op: 09 mrt 2018 om 10:40
-- Serverversie: 5.7.19
-- PHP-versie: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `memoryspel`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `kaarten`
--

DROP TABLE IF EXISTS `kaarten`;
CREATE TABLE IF NOT EXISTS `kaarten` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naam` text NOT NULL,
  `level` varchar(11) NOT NULL,
  `url` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `kaarten`
--

INSERT INTO `kaarten` (`id`, `naam`, `level`, `url`) VALUES
(1, 'alien', '2', 'img/alien.jpg'),
(22, 'jamesspader', '3', 'img/jamesspader.jpg'),
(3, 'cool', '2', 'img/cool.jpg'),
(4, 'ghost', '2', 'img/ghost.jpg'),
(5, 'love', '2', 'img/love.jpg'),
(6, 'monkey', '2', 'img/monkey.jpg'),
(7, 'music', '2', 'img/music.jpg'),
(8, 'nerd', '2', 'img/nerd.jpg'),
(9, 'okay', '2', 'img/okay.jpg'),
(10, 'panda', '2', 'img/panda.jpg'),
(11, 'shit', '2', 'img/shit.jpg'),
(12, 'spotify', '1', 'img/spotify.jpg'),
(13, 'twitter', '1', 'img/twitter.jpg'),
(14, 'apple', '1', 'img/apple.jpg'),
(15, 'postnl', '1', 'img/postnl.jpg'),
(16, 'whatsapp', '1', 'img/whatsapp.jpg'),
(17, 'facebook', '1', 'img/facebook.jpg'),
(18, 'skype', '1', 'img/skype.jpg'),
(19, 'jumbo', '1', 'img/jumbo.jpg'),
(20, 'xbox', '1', 'img/xbox.jpg'),
(21, 'beats', '1', 'img/beats.jpg'),
(23, 'susanblommeart', '3', 'img/susanblommaert.jpg'),
(24, 'ryaneggold', '3', 'img/ryaneggold.jpg'),
(25, 'stephenamell', '3', 'img/stephenamell.jpg'),
(26, 'patrickadams', '3', 'img/patrickadams.jpg'),
(27, 'sarahrafferty', '3', 'img/sarahrafferty.jpg'),
(28, 'wagnermoura', '3', 'img/wagnermoura.jpg'),
(29, 'pedropascal', '3', 'img/pedropascal.jpg'),
(30, 'boydholbrook', '3', 'img/boydholbrook.jpg'),
(31, 'gabrielmacht', '3', 'img/gabrielmacht.jpg');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `level`
--

DROP TABLE IF EXISTS `level`;
CREATE TABLE IF NOT EXISTS `level` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `level`
--

INSERT INTO `level` (`id`, `level`) VALUES
(1, 'Makkelijk'),
(2, 'Normaal'),
(3, 'Moeilijk'),
(4, 'Extreem');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `resultaten`
--

DROP TABLE IF EXISTS `resultaten`;
CREATE TABLE IF NOT EXISTS `resultaten` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tijd` time DEFAULT NULL,
  `klik` int(11) NOT NULL,
  `ip` varchar(100) DEFAULT NULL,
  `naam` text NOT NULL,
  `gevonden` int(2) DEFAULT NULL,
  `level` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=83 DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `resultaten`
--

INSERT INTO `resultaten` (`id`, `datum`, `tijd`, `klik`, `ip`, `naam`, `gevonden`, `level`) VALUES
(69, '2018-03-08 14:12:57', '00:01:20', 22, NULL, 'Haffoo', 10, 1),
(70, '2018-03-08 14:17:58', '00:01:23', 50, '::1', 'Frank', 10, 2),
(71, '2018-03-08 14:21:14', '00:00:58', 38, '::1', 'Els', 10, 1),
(72, '2018-03-08 14:24:41', '00:01:35', 38, '::1', 'Annemarie', 10, 1),
(73, '2018-03-08 14:35:04', '00:01:04', 36, '::1', 'Haffoo', 10, 1),
(74, '2018-03-08 14:40:00', '00:00:52', 24, '::1', 'Frankenstijn', 10, 1),
(75, '2018-03-08 14:41:42', '00:01:06', 38, '::1', 'Appie', 10, 2),
(76, '2018-03-08 14:43:05', '00:00:55', 26, '::1', 'Bert', 10, 3),
(77, '2018-03-08 14:49:35', '00:00:11', 2, '::1', 'Snelle jelle', 1, 4),
(78, '2018-03-08 14:50:57', '00:00:12', 2, '::1', 'Kikker', 1, 4),
(79, '2018-03-08 14:57:15', '00:00:03', 2, '::1', 'Franke', 1, 4),
(80, '2018-03-08 14:58:16', '00:00:03', 2, '::1', 'Snelle Hans', 1, 4),
(81, '2018-03-08 14:59:16', '00:00:03', 2, '::1', 'Gimme', 1, 4),
(82, '2018-03-09 10:39:23', '00:01:25', 68, '::1', 'poep', 10, 2);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
