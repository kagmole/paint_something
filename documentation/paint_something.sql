-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Client: 127.0.0.1
-- Généré le: Mer 04 Décembre 2013 à 09:52
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `friends`
--

INSERT INTO `friends` (`id`, `id_user1`, `id_user2`, `date_creation`, `confirmed`) VALUES
(2, 6, 7, '2013-12-04 08:43:24', 1);

-- --------------------------------------------------------

--
-- Structure de la table `games`
--

CREATE TABLE IF NOT EXISTS `games` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date_creation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `date_start` timestamp NULL DEFAULT NULL,
  `date_find_limit` timestamp NULL DEFAULT NULL,
  `image_path` varchar(40) NOT NULL,
  `started` tinyint(1) NOT NULL,
  `finished` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `games`
--

INSERT INTO `games` (`id`, `date_creation`, `date_start`, `date_find_limit`, `image_path`, `started`, `finished`) VALUES
(1, '2013-11-30 23:00:00', '2013-12-02 07:00:00', '2013-12-02 23:00:00', 'img/image001.png', 1, 1);

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
  `activated` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `email`, `date_creation`, `activated`) VALUES
(6, 'Michel', '10b05c446ea776cdcae1ab10f5dcdbad5eeb9250a8b6f62752e6d4e755850fab', 'frank.etienne@he-arc.ch', '2013-12-04 08:43:01', 1),
(7, 'Daniel', 'bd3dae5fb91f88a4f0978222dfd58f59a124257cb081486387cbae9df11fb879', 'dany.jupille@he-arc.ch', '2013-12-04 08:43:01', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `users_games`
--

INSERT INTO `users_games` (`id`, `id_user`, `id_game`, `score`, `is_ready`, `is_painter`) VALUES
(1, 6, 1, 100, 1, 0),
(2, 7, 1, 30, 1, 1);

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
  ADD CONSTRAINT `users_games_ibfk_2` FOREIGN KEY (`id_game`) REFERENCES `games` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_games_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;