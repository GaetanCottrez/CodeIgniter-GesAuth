-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Client: localhost:3307
-- Généré le: Lun 07 Juillet 2014 à 19:56
-- Version du serveur: 5.5.34-MariaDB
-- Version de PHP: 5.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `gesauth`
--
CREATE DATABASE IF NOT EXISTS `gesauth` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `gesauth`;

-- --------------------------------------------------------

--
-- Structure de la table `gesauth_groups`
--

CREATE TABLE IF NOT EXISTS `gesauth_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text,
  `CreatedBy` varchar(50) NOT NULL,
  `CreatedDate` timestamp NULL DEFAULT NULL,
  `ModifiedBy` varchar(50) NOT NULL,
  `ModifiedDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `gesauth_groups`
--

INSERT INTO `gesauth_groups` (`id`, `name`, `CreatedBy`, `CreatedDate`, `ModifiedBy`, `ModifiedDate`) VALUES
(1, 'Admin', 'gaetan.cottrez', '2014-06-06 19:49:42', 'gaetan.cottrez', '2014-06-17 19:46:05'),
(3, 'Default', 'gaetan.cottrez', '2014-06-06 19:49:42', 'gaetan.cottrez', '2014-06-17 19:46:43');

-- --------------------------------------------------------

--
-- Structure de la table `gesauth_languages`
--

CREATE TABLE IF NOT EXISTS `gesauth_languages` (
  `id` smallint(2) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) DEFAULT NULL,
  `value` varchar(25) DEFAULT NULL,
  `CreatedBy` varchar(50) DEFAULT NULL,
  `CreatedDate` timestamp NULL DEFAULT NULL,
  `ModifiedBy` varchar(50) DEFAULT NULL,
  `ModifiedDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `gesauth_languages`
--

INSERT INTO `gesauth_languages` (`id`, `name`, `value`, `CreatedBy`, `CreatedDate`, `ModifiedBy`, `ModifiedDate`) VALUES
(1, 'Français', 'french', 'gaetan.cottrez', '2014-05-06 11:39:26', 'gaetan.cottrez', '2014-05-06 11:39:26'),
(2, 'Anglais', 'english', 'gaetan.cottrez', '2014-05-06 11:39:26', 'gaetan.cottrez', '2014-05-06 11:39:26');

-- --------------------------------------------------------

--
-- Structure de la table `gesauth_logs_authentification`
--

CREATE TABLE IF NOT EXISTS `gesauth_logs_authentification` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(50) NOT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) DEFAULT NULL,
  `type` varchar(15) NOT NULL DEFAULT 'unknown',
  `informations_log` text NOT NULL,
  `authentification` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `fk_logs_authentification_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `gesauth_logs_perms`
--

CREATE TABLE IF NOT EXISTS `gesauth_logs_perms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(50) DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) DEFAULT NULL,
  `type` varchar(15) NOT NULL DEFAULT 'unknown',
  `informations_log` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_logs_perms_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `gesauth_perms`
--

CREATE TABLE IF NOT EXISTS `gesauth_perms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text,
  `definition` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `gesauth_perms`
--

INSERT INTO `gesauth_perms` (`id`, `name`, `definition`) VALUES
(1, 'Liste utilisateurs', 'menu_users'),
(2, 'Liste des groupes', 'menu_groups'),
(3, 'Création utilisateur', 'create_user'),
(4, 'Modification utilisateur', 'modify_user'),
(5, 'Suppression utilisateur', 'delete_user'),
(6, 'Création groupe', 'create_group'),
(7, 'Modification groupe', 'modify_group'),
(8, 'Suppression groupe', 'delete_group');

-- --------------------------------------------------------

--
-- Structure de la table `gesauth_perm_to_group`
--

CREATE TABLE IF NOT EXISTS `gesauth_perm_to_group` (
  `perm_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `gesauth_perm_to_group`
--

INSERT INTO `gesauth_perm_to_group` (`perm_id`, `group_id`) VALUES
(1, 3),
(6, 1),
(3, 1),
(2, 1),
(1, 1),
(7, 1),
(4, 1),
(8, 1),
(5, 1);

-- --------------------------------------------------------

--
-- Structure de la table `gesauth_sessions`
--

CREATE TABLE IF NOT EXISTS `gesauth_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) DEFAULT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `gesauth_sessions`
--

INSERT INTO `gesauth_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('75530e5210e29c4e7bb8fd68d17b53a0', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', 1404761862, 'a:3:{s:9:"user_data";s:0:"";s:18:"last_login_attempt";i:1404761862;s:16:"user_agent_close";i:0;}');

-- --------------------------------------------------------

--
-- Structure de la table `gesauth_users`
--

CREATE TABLE IF NOT EXISTS `gesauth_users` (
  `id` varchar(50) NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `name` text,
  `firstname` text,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `last_login` datetime DEFAULT NULL,
  `last_activity` datetime DEFAULT NULL,
  `last_login_attempt` datetime DEFAULT NULL,
  `forgot_exp` text,
  `remember_time` datetime DEFAULT NULL,
  `remember_exp` text,
  `language` smallint(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_gesauth_users_languages` (`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `gesauth_users`
--

INSERT INTO `gesauth_users` (`id`, `email`, `password`, `name`, `firstname`, `disabled`, `last_login`, `last_activity`, `last_login_attempt`, `forgot_exp`, `remember_time`, `remember_exp`, `language`) VALUES
('gaetan.cottrez', 'gaetan.cottrez@laviedunwebdeveloper.com', '0ef51ee05d9f051599650acbe46cce8afda3d2ec', 'Cottrez', 'Gaëtan', 0, '2014-07-07 11:02:47', '2014-07-07 11:07:59', '2014-07-02 23:16:29', NULL, '2014-05-02 00:00:00', '2PFp2hAHruXmWQiH', 1),
('john.doe', 'john.doe@laviedunwebdeveloper.com', '0ef51ee05d9f051599650acbe46cce8afda3d2ec', 'Doe', 'John', 0, NULL, '2014-07-02 23:21:58', NULL, NULL, NULL, NULL, 2);

-- --------------------------------------------------------

--
-- Structure de la table `gesauth_user_to_group`
--

CREATE TABLE IF NOT EXISTS `gesauth_user_to_group` (
  `user_id` varchar(50) NOT NULL,
  `group_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `gesauth_user_to_group`
--

INSERT INTO `gesauth_user_to_group` (`user_id`, `group_id`) VALUES
('gaetan.cottrez', 1),
('john.doe', 3);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
