-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Machine: 127.0.0.1
-- Gegenereerd op: 27 jan 2015 om 09:02
-- Serverversie: 5.6.16
-- PHP-versie: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `pizzashop`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bestelling`
--

CREATE TABLE IF NOT EXISTS `bestelling` (
  `bestelId` int(11) NOT NULL AUTO_INCREMENT,
  `klantId` int(11) NOT NULL,
  `prijs` int(11) NOT NULL,
  `info` varchar(50) NOT NULL,
  PRIMARY KEY (`bestelId`),
  KEY `klantId` (`klantId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `klant`
--

CREATE TABLE IF NOT EXISTS `klant` (
  `klantId` int(11) NOT NULL AUTO_INCREMENT,
  `naam` varchar(20) NOT NULL,
  `voornaam` varchar(15) NOT NULL,
  `straat` varchar(50) NOT NULL,
  `huisnummer` int(4) NOT NULL,
  `busnummer` int(11) DEFAULT NULL,
  `plaatsId` int(11) NOT NULL,
  `tel` varchar(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `wachtwoord` varchar(40) NOT NULL,
  `extra` varchar(40) DEFAULT NULL,
  `promo` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`klantId`),
  KEY `plaatsId` (`plaatsId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Gegevens worden geëxporteerd voor tabel `klant`
--

INSERT INTO `klant` (`klantId`, `naam`, `voornaam`, `straat`, `huisnummer`, `busnummer`, `plaatsId`, `tel`, `email`, `wachtwoord`, `extra`, `promo`) VALUES
(1, 'Gahide', 'Valentino', 'Ingooigemstraat', 14, 0, 17, '0479454213', 'valentinogahide@gmail.com', 'e5e9fa1ba31ecd1ae84f75caaa474f3a663f05f4', 'Test', 1),
(2, 'De Bouwer', 'Bob', 'Timmerstraat', 18, 5, 1, '056772474', 'bob@gmail.com', '8001cb33b427b6a037f2229424c364b22e6ff5f1', 'Hey jongens', 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `pizza`
--

CREATE TABLE IF NOT EXISTS `pizza` (
  `pizzaId` int(11) NOT NULL AUTO_INCREMENT,
  `pizzaNaam` varchar(40) NOT NULL,
  `prijs` int(10) NOT NULL,
  `promoprijs` int(10) NOT NULL,
  `beschikbaar` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`pizzaId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Gegevens worden geëxporteerd voor tabel `pizza`
--

INSERT INTO `pizza` (`pizzaId`, `pizzaNaam`, `prijs`, `promoprijs`, `beschikbaar`) VALUES
(1, 'Margherita', 11, 9, 1),
(2, 'Napolitana', 11, 9, 1),
(3, 'Sicilianna', 11, 9, 1),
(4, 'Veneziana', 11, 9, 1),
(5, 'Prosciutto', 11, 9, 1),
(6, 'Salami', 11, 9, 1),
(7, 'Arrabiata', 12, 10, 1),
(8, 'Tono', 10, 8, 1),
(9, 'Funghi', 14, 12, 1),
(10, 'Capricciosa', 13, 11, 1),
(11, 'Sophia Loren', 14, 12, 1),
(12, 'Verde Campagna', 13, 11, 1),
(13, 'Quatro Stagioni', 13, 11, 1),
(14, 'Primavera', 12, 10, 1),
(15, 'Pepperoni', 14, 12, 1),
(16, 'Pepperoni Salami', 14, 12, 1),
(17, 'Hawai', 13, 11, 1),
(18, 'Calzone', 15, 13, 1),
(19, 'Frutti Di Mare', 12, 10, 1),
(20, 'Rimni', 13, 11, 1),
(21, 'Quattro Formaggi', 15, 13, 1),
(22, 'Carpaccio', 12, 10, 1),
(23, 'Bollognaise', 14, 12, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `pizza_per_bestelling`
--

CREATE TABLE IF NOT EXISTS `pizza_per_bestelling` (
  `pizzabestelId` int(11) NOT NULL AUTO_INCREMENT,
  `pizzaId` int(11) NOT NULL,
  `bestelId` int(11) NOT NULL,
  `aantal` int(11) NOT NULL,
  PRIMARY KEY (`pizzabestelId`),
  KEY `pizzaId` (`pizzaId`),
  KEY `bestelId` (`bestelId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `plaats`
--

CREATE TABLE IF NOT EXISTS `plaats` (
  `plaatsId` int(11) NOT NULL AUTO_INCREMENT,
  `postcode` int(4) NOT NULL,
  `plaats` varchar(50) NOT NULL,
  `leverplaats` tinyint(1) NOT NULL,
  PRIMARY KEY (`plaatsId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Gegevens worden geëxporteerd voor tabel `plaats`
--

INSERT INTO `plaats` (`plaatsId`, `postcode`, `plaats`, `leverplaats`) VALUES
(1, 8500, 'Kortrijk', 1),
(2, 8501, 'Bissegem', 0),
(3, 8501, 'Heule', 0),
(4, 8510, 'Bellegem', 0),
(5, 8510, 'Rollegem', 0),
(6, 8510, 'Marke', 0),
(7, 8510, 'Kooigem', 0),
(8, 8511, 'Aalbeke', 0),
(9, 8520, 'Kuurne', 0),
(10, 8530, 'Harelbeke', 1),
(11, 8531, 'Hulste', 0),
(12, 8531, 'Bavikhove', 0),
(13, 8540, 'Deerlijk', 1),
(14, 8550, 'Zwevegem', 1),
(15, 8551, 'Heestert', 1),
(16, 8552, 'Moen', 1),
(17, 8553, 'Otegem', 1),
(18, 8554, 'Sint-Denijs', 1),
(19, 8560, 'Wevelgem', 0),
(20, 8560, 'Moorsele', 0),
(21, 8560, 'Gullegem', 0),
(22, 8570, 'Gijzelbrechtegem', 1),
(23, 8570, 'Vichte', 1),
(24, 8570, 'ingooigem', 1),
(25, 8570, 'Anzegem', 1),
(26, 8572, 'Kaster', 1),
(27, 8573, 'Tiegem', 1),
(28, 8580, 'Avelgem', 1),
(29, 8581, 'Kerkhove', 1),
(30, 8581, 'Waarmaarde', 1),
(31, 8582, 'Outrijve', 1),
(32, 8583, 'Bossuit', 1),
(33, 8587, 'Helkijn', 1),
(34, 8587, 'Spiere-Helkijn', 1),
(35, 8587, 'Spiere', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `producten`
--

CREATE TABLE IF NOT EXISTS `producten` (
  `productId` int(11) NOT NULL AUTO_INCREMENT,
  `productnaam` varchar(50) NOT NULL,
  PRIMARY KEY (`productId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Gegevens worden geëxporteerd voor tabel `producten`
--

INSERT INTO `producten` (`productId`, `productnaam`) VALUES
(1, 'mozzerella'),
(2, 'tomaten'),
(3, 'ansjovis'),
(4, 'olijven'),
(5, 'kappertjes'),
(6, 'uien'),
(7, 'champignons'),
(8, 'ham'),
(9, 'salami'),
(10, 'salami pikant'),
(11, 'tonijn'),
(12, 'parmaham'),
(13, 'ei'),
(14, 'artisjokken'),
(15, 'vegetarisch'),
(16, 'paprika'),
(17, 'ananas'),
(18, 'zeevruchten'),
(19, '4 kazen'),
(20, 'rundsvlees'),
(21, 'parmesan'),
(22, 'gehakt'),
(23, 'look');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `producten_per_pizza`
--

CREATE TABLE IF NOT EXISTS `producten_per_pizza` (
  `productpizzaId` int(11) NOT NULL AUTO_INCREMENT,
  `pizzaId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  PRIMARY KEY (`productpizzaId`),
  KEY `pizzaId` (`pizzaId`),
  KEY `productId` (`productId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=87 ;

--
-- Gegevens worden geëxporteerd voor tabel `producten_per_pizza`
--

INSERT INTO `producten_per_pizza` (`productpizzaId`, `pizzaId`, `productId`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 1),
(4, 2, 2),
(5, 2, 3),
(6, 2, 4),
(7, 3, 1),
(8, 3, 2),
(9, 3, 3),
(10, 3, 5),
(11, 4, 1),
(12, 4, 2),
(13, 4, 6),
(14, 4, 7),
(15, 5, 1),
(16, 5, 2),
(17, 5, 8),
(18, 6, 1),
(19, 6, 2),
(20, 6, 9),
(21, 7, 1),
(22, 7, 2),
(23, 7, 10),
(24, 8, 1),
(25, 8, 2),
(26, 8, 11),
(27, 9, 1),
(28, 9, 2),
(29, 9, 7),
(30, 10, 1),
(31, 10, 2),
(32, 10, 3),
(33, 10, 12),
(34, 10, 7),
(35, 11, 1),
(36, 11, 2),
(37, 11, 8),
(38, 11, 7),
(39, 11, 13),
(40, 12, 1),
(41, 12, 2),
(42, 12, 14),
(43, 12, 23),
(44, 12, 3),
(45, 12, 12),
(46, 13, 1),
(47, 13, 2),
(48, 13, 9),
(49, 13, 7),
(50, 13, 14),
(51, 13, 4),
(52, 14, 15),
(53, 15, 1),
(54, 15, 2),
(55, 15, 16),
(56, 16, 1),
(57, 16, 2),
(58, 16, 16),
(59, 16, 9),
(60, 17, 1),
(61, 17, 2),
(62, 17, 8),
(63, 17, 17),
(64, 18, 1),
(65, 18, 2),
(66, 18, 7),
(67, 18, 8),
(68, 19, 1),
(69, 19, 2),
(70, 19, 18),
(71, 20, 1),
(72, 20, 2),
(73, 20, 8),
(74, 20, 7),
(75, 21, 1),
(76, 21, 2),
(77, 21, 19),
(78, 22, 1),
(79, 22, 2),
(80, 22, 20),
(81, 22, 21),
(82, 23, 1),
(83, 23, 2),
(84, 23, 16),
(85, 23, 6),
(86, 23, 22);

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `bestelling`
--
ALTER TABLE `bestelling`
  ADD CONSTRAINT `bestelling_ibfk_1` FOREIGN KEY (`klantId`) REFERENCES `klant` (`klantId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `klant`
--
ALTER TABLE `klant`
  ADD CONSTRAINT `klant_ibfk_1` FOREIGN KEY (`plaatsId`) REFERENCES `plaats` (`plaatsId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `klant_ibfk_2` FOREIGN KEY (`plaatsId`) REFERENCES `plaats` (`plaatsId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `pizza_per_bestelling`
--
ALTER TABLE `pizza_per_bestelling`
  ADD CONSTRAINT `pizza_per_bestelling_ibfk_1` FOREIGN KEY (`pizzaId`) REFERENCES `pizza` (`pizzaId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pizza_per_bestelling_ibfk_2` FOREIGN KEY (`bestelId`) REFERENCES `bestelling` (`bestelId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `producten_per_pizza`
--
ALTER TABLE `producten_per_pizza`
  ADD CONSTRAINT `producten_per_pizza_ibfk_1` FOREIGN KEY (`pizzaId`) REFERENCES `pizza` (`pizzaId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `producten_per_pizza_ibfk_2` FOREIGN KEY (`productId`) REFERENCES `producten` (`productId`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
