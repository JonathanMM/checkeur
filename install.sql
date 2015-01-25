-- phpMyAdmin SQL Dump
-- version 4.1.9
-- http://www.phpmyadmin.net
--
-- Client :  mysql51-34.perso
-- Généré le :  Dim 25 Janvier 2015 à 17:41
-- Version du serveur :  5.1.73-2+squeeze+build1+1-log
-- Version de PHP :  5.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `noclemain`
--

-- --------------------------------------------------------

--
-- Structure de la table `anonymous`
--

CREATE TABLE IF NOT EXISTS `anonymous` (
  `id_check` int(11) NOT NULL,
  `pseudo` varchar(128) NOT NULL,
  PRIMARY KEY (`id_check`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `checks`
--

CREATE TABLE IF NOT EXISTS `checks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_checkeur` int(11) NOT NULL,
  `id_checke` int(11) NOT NULL,
  `moment` datetime NOT NULL,
  `evenement` int(11) NOT NULL,
  `if_reput` tinyint(1) NOT NULL,
  `reput` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Structure de la table `codes`
--

CREATE TABLE IF NOT EXISTS `codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `code` varchar(64) DEFAULT NULL,
  `id_evenement` int(11) NOT NULL,
  `date_debut` datetime NOT NULL,
  `date_fin` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Structure de la table `evenements`
--

CREATE TABLE IF NOT EXISTS `evenements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(128) NOT NULL,
  `date_debut` datetime NOT NULL,
  `date_fin` datetime NOT NULL,
  `lieu` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(64) NOT NULL,
  `mdp` varchar(512) NOT NULL,
  `code` varchar(16) NOT NULL,
  `valide` tinyint(1) NOT NULL,
  `uid` int(11) NOT NULL,
  `nb_msg` int(11) NOT NULL,
  `date_inscription` date NOT NULL,
  `lieu` varchar(256) NOT NULL,
  `date_checklieu` datetime NOT NULL,
  `photo` varchar(64) DEFAULT NULL,
  `avatar` int(11) NOT NULL,
  `pts_reput` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
