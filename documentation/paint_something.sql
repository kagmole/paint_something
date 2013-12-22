-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Client: 127.0.0.1
-- Généré le: Dim 22 Décembre 2013 à 19:39
-- Version du serveur: 5.6.11
-- Version de PHP: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `paint_something`
--
CREATE DATABASE IF NOT EXISTS `paint_something` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `paint_something`;

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
(0, 'Raspberry', 1),
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

-- --------------------------------------------------------

--
-- Structure de la table `friends`
--

CREATE TABLE IF NOT EXISTS `friends` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user1` int(10) unsigned NOT NULL,
  `id_user2` int(10) unsigned NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `confirmed` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user1` (`id_user1`),
  KEY `id_user2` (`id_user2`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `friends`
--

INSERT INTO `friends` (`id`, `id_user1`, `id_user2`, `date_creation`, `confirmed`) VALUES
(3, 7, 6, '2013-12-21 08:33:08', 0),
(5, 7, 9, '2013-12-21 19:08:05', 0),
(6, 7, 8, '2013-12-21 19:08:37', 0);

-- --------------------------------------------------------

--
-- Structure de la table `games`
--

CREATE TABLE IF NOT EXISTS `games` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_dictionary` int(10) unsigned NOT NULL,
  `date_creation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `date_start` timestamp NULL DEFAULT NULL,
  `date_find_limit` timestamp NULL DEFAULT NULL,
  `rounds_count` int(11) NOT NULL DEFAULT '0',
  `started` tinyint(1) NOT NULL,
  `finished` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(20) NOT NULL,
  `password` varchar(64) NOT NULL,
  `email` varchar(40) NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_last_connection` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `activated` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `email`, `date_creation`, `date_last_connection`, `activated`) VALUES
(6, 'Michel', '2c7f9fd20fbeb41ce8894ec4653d66fa7f3b6e1a', 'etienne.frank@he-arc.ch', '2013-12-06 07:21:40', '2013-12-04 08:43:01', 1),
(7, 'Daniel', '3d0f3b9ddcacec30c4008c5e030e6c13a478cb4f', 'dany.jupille@he-arc.ch', '2013-12-06 07:21:40', '2013-12-04 08:43:01', 1),
(8, 'Bernard', '0b8e0b1f37895567811a9d382317c26804f86e3a', 'bernard.octet@yopmail.com', '2013-12-21 15:06:09', '2013-12-21 15:06:09', 1),
(9, 'Toto', '0b9c2625dc21ef05f6ad4ddf47c5f203837aa32c', 'toto.usertest@yopmail.com', '2013-12-21 15:12:07', '2013-12-21 15:12:07', 1);

-- --------------------------------------------------------

--
-- Structure de la table `users_games`
--

CREATE TABLE IF NOT EXISTS `users_games` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(10) unsigned NOT NULL,
  `id_game` int(10) unsigned NOT NULL,
  `score` int(11) NOT NULL,
  `is_ready` tinyint(1) NOT NULL,
  `is_painter` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_game` (`id_game`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=54 ;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `friends`
--
ALTER TABLE `friends`
  ADD CONSTRAINT `friends_ibfk_1` FOREIGN KEY (`id_user1`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `friends_ibfk_2` FOREIGN KEY (`id_user2`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `users_games`
--
ALTER TABLE `users_games`
  ADD CONSTRAINT `users_games_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_games_ibfk_2` FOREIGN KEY (`id_game`) REFERENCES `games` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
