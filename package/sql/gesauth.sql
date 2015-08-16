-- Adminer 4.2.2 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `gesauth_companies`;
CREATE TABLE `gesauth_companies` (
  `ID` smallint(2) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) DEFAULT NULL,
  `ExcelLegend` varchar(10) DEFAULT NULL,
  `LogoPath` varchar(50) DEFAULT NULL,
  `StreetNumber` varchar(10) DEFAULT NULL,
  `Street` varchar(50) DEFAULT NULL,
  `City` varchar(50) DEFAULT NULL,
  `ZIP` int(11) DEFAULT NULL,
  `Country` varchar(50) DEFAULT NULL,
  `VAT` varchar(13) DEFAULT NULL,
  `CreatedBy` varchar(50) NOT NULL,
  `CreatedDate` timestamp NULL DEFAULT NULL,
  `ModifiedBy` varchar(50) NOT NULL,
  `ModifiedDate` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='"Société"';

INSERT INTO `gesauth_companies` (`ID`, `Name`, `ExcelLegend`, `LogoPath`, `StreetNumber`, `Street`, `City`, `ZIP`, `Country`, `VAT`, `CreatedBy`, `CreatedDate`, `ModifiedBy`, `ModifiedDate`) VALUES
(1,	'GesAuth Company',	'SOC1',	'gesauth.png',	'253W',	'28th street',	'New York',	10001,	'USA',	NULL,	'gaetan.cottrez',	'2014-06-13 05:17:08',	'gaetan.cottrez',	'2014-05-20 05:55:00');

DROP TABLE IF EXISTS `gesauth_languages`;
CREATE TABLE `gesauth_languages` (
  `id` smallint(2) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) DEFAULT NULL,
  `value` varchar(25) DEFAULT NULL,
  `CreatedBy` varchar(50) DEFAULT NULL,
  `CreatedDate` timestamp NULL DEFAULT NULL,
  `ModifiedBy` varchar(50) DEFAULT NULL,
  `ModifiedDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `gesauth_languages` (`id`, `name`, `value`, `CreatedBy`, `CreatedDate`, `ModifiedBy`, `ModifiedDate`) VALUES
(1,	'Français',	'french',	'gaetan.cottrez',	'2014-05-06 11:39:26',	'gaetan.cottrez',	'2014-05-06 11:39:26'),
(2,	'Anglais',	'english',	'gaetan.cottrez',	'2014-05-06 11:39:26',	'gaetan.cottrez',	'2014-05-06 11:39:26');

DROP TABLE IF EXISTS `gesauth_logs_authentification`;
CREATE TABLE `gesauth_logs_authentification` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `gesauth_logs_perms`;
CREATE TABLE `gesauth_logs_perms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(50) DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) DEFAULT NULL,
  `type` varchar(15) NOT NULL DEFAULT 'unknown',
  `url` text NOT NULL,
  `informations_log` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_logs_perms_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `gesauth_perms`;
CREATE TABLE `gesauth_perms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text,
  `definition` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `gesauth_perms` (`id`, `name`, `definition`) VALUES
(1,	'Liste utilisateurs',	'menu_users'),
(2,	'Liste des rôles',	'menu_roles'),
(3,	'Création utilisateur',	'create_user'),
(4,	'Modification utilisateur',	'modify_user'),
(5,	'Suppression utilisateur',	'delete_user'),
(6,	'Création rôle',	'create_role'),
(7,	'Modification rôle',	'modify_role'),
(8,	'Suppression rôle',	'delete_role');

DROP TABLE IF EXISTS `gesauth_perm_to_role`;
CREATE TABLE `gesauth_perm_to_role` (
  `perm_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `gesauth_perm_to_role` (`perm_id`, `role_id`) VALUES
(1,	3);

DROP TABLE IF EXISTS `gesauth_roles`;
CREATE TABLE `gesauth_roles` (
  `id` smallint(3) NOT NULL AUTO_INCREMENT,
  `name` text,
  `CreatedBy` varchar(50) NOT NULL,
  `CreatedDate` timestamp NULL DEFAULT NULL,
  `ModifiedBy` varchar(50) NOT NULL,
  `ModifiedDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `gesauth_roles` (`id`, `name`, `CreatedBy`, `CreatedDate`, `ModifiedBy`, `ModifiedDate`) VALUES
(1,	'Admin',	'gaetan.cottrez',	'2014-06-06 19:49:42',	'gaetan.cottrez',	'2014-07-23 20:23:23'),
(3,	'Default',	'gaetan.cottrez',	'2014-06-06 19:49:42',	'gaetan.cottrez',	'2014-06-17 19:46:43');

DROP TABLE IF EXISTS `gesauth_sessions`;
CREATE TABLE `gesauth_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ci_sessions_id_ip` (`id`,`ip_address`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `gesauth_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('0ff45f003601373a86043c31bd3ca209aa95e312',	'::1',	1439755379,	'__ci_last_regenerate|i:1439755379;last_login_attempt|i:1439755379;user_agent_close|i:0;'),
('69bbcdd1da8d7ad7b4eb8a5d767b8b508766accd',	'::1',	1439753902,	'__ci_last_regenerate|i:1439753553;last_login_attempt|i:1439747545;user_agent_close|i:1;user_id|s:1:\"1\";user_login|s:14:\"gaetan.cottrez\";user_name|s:7:\"Cottrez\";user_firstname|s:7:\"Gaëtan\";user_email|s:39:\"gaetan.cottrez@laviedunwebdeveloper.com\";user_language|s:6:\"french\";user_last_login|s:19:\"2015-01-16 22:07:17\";user_loggedin|b:1;user_roles|a:2:{i:0;a:2:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:5:\"Admin\";}i:1;a:2:{s:2:\"id\";s:1:\"3\";s:4:\"name\";s:7:\"Default\";}}user_last_url_visited|s:49:\"http://localhost/GesAuth/login/ajax_close_browser\";'),
('aff49f1d4733ec9ce3671644ca7dcf82d2a3353f',	'::1',	1439754733,	'__ci_last_regenerate|i:1439754585;last_login_attempt|i:1439747545;user_agent_close|i:0;user_id|s:1:\"1\";user_login|s:14:\"gaetan.cottrez\";user_name|s:7:\"Cottrez\";user_firstname|s:7:\"Gaëtan\";user_email|s:39:\"gaetan.cottrez@laviedunwebdeveloper.com\";user_language|s:6:\"french\";user_last_login|s:19:\"2015-01-16 22:07:17\";user_loggedin|b:1;user_roles|a:2:{i:0;a:2:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:5:\"Admin\";}i:1;a:2:{s:2:\"id\";s:1:\"3\";s:4:\"name\";s:7:\"Default\";}}user_last_url_visited|s:30:\"http://localhost/GesAuth/users\";'),
('dbf073f3c67cefaa3b5ba6d8799ead82bd365493',	'::1',	1439754585,	'__ci_last_regenerate|i:1439754206;last_login_attempt|i:1439747545;user_agent_close|i:1;user_id|s:1:\"1\";user_login|s:14:\"gaetan.cottrez\";user_name|s:7:\"Cottrez\";user_firstname|s:7:\"Gaëtan\";user_email|s:39:\"gaetan.cottrez@laviedunwebdeveloper.com\";user_language|s:6:\"french\";user_last_login|s:19:\"2015-01-16 22:07:17\";user_loggedin|b:1;user_roles|a:2:{i:0;a:2:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:5:\"Admin\";}i:1;a:2:{s:2:\"id\";s:1:\"3\";s:4:\"name\";s:7:\"Default\";}}user_last_url_visited|s:49:\"http://localhost/GesAuth/login/ajax_close_browser\";'),
('df4f4e619e1f2f6f9bed645147c37fd4f42572f2',	'::1',	1439754205,	'__ci_last_regenerate|i:1439753902;last_login_attempt|i:1439747545;user_agent_close|i:1;user_id|s:1:\"1\";user_login|s:14:\"gaetan.cottrez\";user_name|s:7:\"Cottrez\";user_firstname|s:7:\"Gaëtan\";user_email|s:39:\"gaetan.cottrez@laviedunwebdeveloper.com\";user_language|s:6:\"french\";user_last_login|s:19:\"2015-01-16 22:07:17\";user_loggedin|b:1;user_roles|a:2:{i:0;a:2:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:5:\"Admin\";}i:1;a:2:{s:2:\"id\";s:1:\"3\";s:4:\"name\";s:7:\"Default\";}}user_last_url_visited|s:49:\"http://localhost/GesAuth/login/ajax_close_browser\";');

DROP TABLE IF EXISTS `gesauth_users`;
CREATE TABLE `gesauth_users` (
  `id` mediumint(5) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL,
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

INSERT INTO `gesauth_users` (`id`, `login`, `email`, `password`, `name`, `firstname`, `disabled`, `last_login`, `last_activity`, `last_login_attempt`, `forgot_exp`, `remember_time`, `remember_exp`, `language`) VALUES
(1,	'gaetan.cottrez',	'gaetan.cottrez@laviedunwebdeveloper.com',	'0ef51ee05d9f051599650acbe46cce8afda3d2ec',	'Cottrez',	'Gaëtan',	0,	'2015-08-16 20:50:17',	'2015-08-16 22:02:58',	'2014-07-02 23:16:29',	NULL,	'2014-05-02 00:00:00',	'2PFp2hAHruXmWQiH',	1),
(2,	'john.doe',	'john.doe@laviedunwebdeveloper.com',	'0ef51ee05d9f051599650acbe46cce8afda3d2ec',	'Doe',	'John',	0,	'2014-11-05 10:43:59',	'2014-11-05 10:44:08',	NULL,	NULL,	NULL,	NULL,	2),
(3,	'john.doee',	'centsur@gmail.com',	'0ef51ee05d9f051599650acbe46cce8afda3d2ec',	'Doee',	'John',	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1);

DROP TABLE IF EXISTS `gesauth_user_to_role`;
CREATE TABLE `gesauth_user_to_role` (
  `user_id` varchar(50) NOT NULL,
  `role_id` smallint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `gesauth_user_to_role` (`user_id`, `role_id`) VALUES
('1',	1),
('1',	3),
('2',	3),
('3',	1);

-- 2015-08-16 20:14:19