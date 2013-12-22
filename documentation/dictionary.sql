-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Client: 127.0.0.1
-- Généré le: Dim 22 Décembre 2013 à 10:53
-- Version du serveur: 5.5.32
-- Version de PHP: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `paint_something`
--

-- --------------------------------------------------------

--
-- Structure de la table `dictionary`
--

CREATE TABLE IF NOT EXISTS `dictionary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `word` varchar(255) NOT NULL,
  `difficulty` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `word` (`word`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Contenu de la table `dictionary`
--

INSERT INTO `dictionary` (`id`, `word`, `difficulty`) VALUES
(1, 'Pinapple', 1),
(2, 'Banana', 1),
(3, 'Car', 1),
(4, 'House', 1),
(5, 'Bird', 1),
(6, 'Cat', 1),
(7, 'Dog', 1),
(8, 'Tour Eiffel', 2),
(9, 'Imp', 2),
(10, 'Santa Claus', 2),
(11, 'Pizzaiolo', 3),
(12, 'USA', 2),
(13, 'China', 2),
(14, 'Brazil', 2),
(15, 'Clams', 3),
(16, 'Sleeping', 2),
(17, 'Sport', 3),
(18, 'Dress', 2),
(19, 'Ham', 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
