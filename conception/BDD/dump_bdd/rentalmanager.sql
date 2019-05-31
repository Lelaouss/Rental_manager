-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le :  ven. 24 mai 2019 à 14:23
-- Version du serveur :  8.0.12
-- Version de PHP :  7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `rentalmanager`
--
CREATE DATABASE IF NOT EXISTS `rentalmanager` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `rentalmanager`;

-- --------------------------------------------------------

--
-- Structure de la table `adress`
--

DROP TABLE IF EXISTS `adress`;
CREATE TABLE IF NOT EXISTS `adress` (
  `id_adress` int(11) NOT NULL AUTO_INCREMENT,
  `id_city` int(11) DEFAULT NULL,
  `street` varchar(255) NOT NULL,
  `additional_adress` varchar(255) DEFAULT 'NULL',
  PRIMARY KEY (`id_adress`),
  KEY `adress_city_FK` (`id_city`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `city`
--

DROP TABLE IF EXISTS `city`;
CREATE TABLE IF NOT EXISTS `city` (
  `id_city` int(11) NOT NULL AUTO_INCREMENT,
  `id_county` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `zip_code` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `county_code` varchar(3) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id_city`),
  KEY `ville_departement` (`county_code`),
  KEY `ville_nom_reel` (`name`),
  KEY `ville_code_postal` (`zip_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `country`
--

DROP TABLE IF EXISTS `country`;
CREATE TABLE IF NOT EXISTS `country` (
  `id_country` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_country`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `county`
--

DROP TABLE IF EXISTS `county`;
CREATE TABLE IF NOT EXISTS `county` (
  `id_county` int(11) NOT NULL AUTO_INCREMENT,
  `id_country` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_county`),
  KEY `IDX_58E2FF255CA5BEA7` (`id_country`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `document`
--

DROP TABLE IF EXISTS `document`;
CREATE TABLE IF NOT EXISTS `document` (
  `id_document` int(11) NOT NULL AUTO_INCREMENT,
  `id_document_type` int(11) DEFAULT NULL,
  `label` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_document`),
  KEY `document_document_type_FK` (`id_document_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `document_type`
--

DROP TABLE IF EXISTS `document_type`;
CREATE TABLE IF NOT EXISTS `document_type` (
  `id_document_type` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_document_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `document__property`
--

DROP TABLE IF EXISTS `document__property`;
CREATE TABLE IF NOT EXISTS `document__property` (
  `id_document` int(11) NOT NULL,
  `id_property` int(11) NOT NULL,
  PRIMARY KEY (`id_document`,`id_property`),
  KEY `IDX_B70A711FDB29F04B` (`id_property`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `document__rent`
--

DROP TABLE IF EXISTS `document__rent`;
CREATE TABLE IF NOT EXISTS `document__rent` (
  `id_rent` int(11) NOT NULL,
  `id_document` int(11) NOT NULL,
  PRIMARY KEY (`id_rent`,`id_document`),
  KEY `IDX_36FC4BA588B266E3` (`id_document`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
CREATE TABLE IF NOT EXISTS `migration_versions` (
  `version` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `person`
--

DROP TABLE IF EXISTS `person`;
CREATE TABLE IF NOT EXISTS `person` (
  `id_person` int(11) NOT NULL AUTO_INCREMENT,
  `id_adress` int(11) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `civility` tinyint(4) NOT NULL,
  `birthday` datetime DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  `cell_phone` varchar(45) DEFAULT NULL,
  `landline_phone` varchar(45) DEFAULT NULL,
  `family_situation` tinyint(4) DEFAULT NULL,
  `occupation` varchar(255) DEFAULT NULL,
  `banished` datetime DEFAULT NULL,
  PRIMARY KEY (`id_person`),
  KEY `person_adress_FK` (`id_adress`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `person__rent`
--

DROP TABLE IF EXISTS `person__rent`;
CREATE TABLE IF NOT EXISTS `person__rent` (
  `id_rent` int(11) NOT NULL,
  `id_tenant` int(11) NOT NULL,
  PRIMARY KEY (`id_rent`,`id_tenant`),
  KEY `IDX_F36B2213686E718F` (`id_tenant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `person__rent__guarantor`
--

DROP TABLE IF EXISTS `person__rent__guarantor`;
CREATE TABLE IF NOT EXISTS `person__rent__guarantor` (
  `id_rent_gurantor` int(11) NOT NULL,
  `id_guarantor` int(11) NOT NULL,
  PRIMARY KEY (`id_rent_gurantor`,`id_guarantor`),
  KEY `IDX_DC14D907A19849B2` (`id_guarantor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `property`
--

DROP TABLE IF EXISTS `property`;
CREATE TABLE IF NOT EXISTS `property` (
  `id_property` int(11) NOT NULL AUTO_INCREMENT,
  `id_adress` int(11) DEFAULT NULL,
  `label` varchar(45) NOT NULL,
  `construction_date` datetime DEFAULT NULL,
  `purchase_date` datetime DEFAULT NULL,
  `purchase_price` float DEFAULT NULL,
  `sale_date` datetime DEFAULT NULL,
  `sale_price` float DEFAULT NULL,
  `surface_area` float DEFAULT NULL,
  `nb_rooms` int(11) DEFAULT NULL,
  `details` longtext,
  PRIMARY KEY (`id_property`),
  KEY `property_adress_FK` (`id_adress`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `property__owner`
--

DROP TABLE IF EXISTS `property__owner`;
CREATE TABLE IF NOT EXISTS `property__owner` (
  `id_property` int(11) NOT NULL,
  `id_owner` int(11) NOT NULL,
  PRIMARY KEY (`id_property`,`id_owner`),
  KEY `IDX_3B2F659C21E5A74C` (`id_owner`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `rent`
--

DROP TABLE IF EXISTS `rent`;
CREATE TABLE IF NOT EXISTS `rent` (
  `id_rent` int(11) NOT NULL AUTO_INCREMENT,
  `id_property` int(11) DEFAULT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime DEFAULT NULL,
  `rent_amount` float NOT NULL,
  `rent_charges` float NOT NULL,
  `rent_total_amount` float NOT NULL,
  `rent_guarantee` float NOT NULL,
  `furnished` tinyint(4) NOT NULL,
  PRIMARY KEY (`id_rent`),
  KEY `rent_property_FK` (`id_property`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `id_person` int(11) NOT NULL,
  `id_user_type` int(11) NOT NULL,
  `login` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  `banished` datetime DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `user_person_AK` (`id_person`),
  KEY `user_user_type0_FK` (`id_user_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `user_type`
--

DROP TABLE IF EXISTS `user_type`;
CREATE TABLE IF NOT EXISTS `user_type` (
  `id_user_type` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(45) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_user_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `adress`
--
ALTER TABLE `adress`
  ADD CONSTRAINT `adress_city_FK` FOREIGN KEY (`id_city`) REFERENCES `city_old` (`id_city`);

--
-- Contraintes pour la table `document`
--
ALTER TABLE `document`
  ADD CONSTRAINT `document_document_type_FK` FOREIGN KEY (`id_document_type`) REFERENCES `document_type` (`id_document_type`);

--
-- Contraintes pour la table `document__property`
--
ALTER TABLE `document__property`
  ADD CONSTRAINT `document__property_document_FK` FOREIGN KEY (`id_document`) REFERENCES `document` (`id_document`),
  ADD CONSTRAINT `document__property_property0_FK` FOREIGN KEY (`id_property`) REFERENCES `property` (`id_property`);

--
-- Contraintes pour la table `document__rent`
--
ALTER TABLE `document__rent`
  ADD CONSTRAINT `document__rent_document0_FK` FOREIGN KEY (`id_document`) REFERENCES `document` (`id_document`),
  ADD CONSTRAINT `document__rent_rent_FK` FOREIGN KEY (`id_rent`) REFERENCES `rent` (`id_rent`);

--
-- Contraintes pour la table `person`
--
ALTER TABLE `person`
  ADD CONSTRAINT `person_adress_FK` FOREIGN KEY (`id_adress`) REFERENCES `adress` (`id_adress`);

--
-- Contraintes pour la table `person__rent`
--
ALTER TABLE `person__rent`
  ADD CONSTRAINT `person__rent_person0_FK` FOREIGN KEY (`id_tenant`) REFERENCES `person` (`id_person`),
  ADD CONSTRAINT `person__rent_rent_FK` FOREIGN KEY (`id_rent`) REFERENCES `rent` (`id_rent`);

--
-- Contraintes pour la table `person__rent__guarantor`
--
ALTER TABLE `person__rent__guarantor`
  ADD CONSTRAINT `person__rent__guarantor_person0_FK` FOREIGN KEY (`id_guarantor`) REFERENCES `person` (`id_person`),
  ADD CONSTRAINT `person__rent__guarantor_rent_FK` FOREIGN KEY (`id_rent_gurantor`) REFERENCES `rent` (`id_rent`);

--
-- Contraintes pour la table `property`
--
ALTER TABLE `property`
  ADD CONSTRAINT `property_adress_FK` FOREIGN KEY (`id_adress`) REFERENCES `adress` (`id_adress`);

--
-- Contraintes pour la table `property__owner`
--
ALTER TABLE `property__owner`
  ADD CONSTRAINT `property__owner_person0_FK` FOREIGN KEY (`id_owner`) REFERENCES `person` (`id_person`),
  ADD CONSTRAINT `property__owner_property_FK` FOREIGN KEY (`id_property`) REFERENCES `property` (`id_property`);

--
-- Contraintes pour la table `rent`
--
ALTER TABLE `rent`
  ADD CONSTRAINT `rent_property_FK` FOREIGN KEY (`id_property`) REFERENCES `property` (`id_property`);

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_person_FK` FOREIGN KEY (`id_person`) REFERENCES `person` (`id_person`),
  ADD CONSTRAINT `user_user_type0_FK` FOREIGN KEY (`id_user_type`) REFERENCES `user_type` (`id_user_type`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
