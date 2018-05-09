-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 09 mai 2018 à 14:46
-- Version du serveur :  5.7.21
-- Version de PHP :  7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `sportweab`
--
CREATE DATABASE IF NOT EXISTS `sportweab` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `sportweab`;

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `idArticle` int(11) NOT NULL AUTO_INCREMENT,
  `nomArticle` varchar(100) NOT NULL,
  `imageArticle` varchar(100) NOT NULL,
  `descriptionArticle` varchar(100) NOT NULL,
  `stock` int(3) NOT NULL,
  `idCategorie` int(11) NOT NULL,
  `idPrix` int(11) NOT NULL,
  PRIMARY KEY (`idArticle`),
  KEY `idPrix` (`idPrix`),
  KEY `idCategorie` (`idCategorie`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`idArticle`, `nomArticle`, `imageArticle`, `descriptionArticle`, `stock`, `idCategorie`, `idPrix`) VALUES
(1, 'T-shirt Blanc \"Money\"', 'white.png', 'T-shirt Blanc \"Money\" avec un logo au dos du t-shirt.', 10, 1, 1),
(2, 'T-shirt Noir \"Money\"', 'black.png', 'T-shirt Noir \"Money\" avec un logo au dos du t-shirt.', 10, 1, 1),
(3, 'T-shirt Beige \"Money\"', 'beige.png', 'T-shirt Beige \"Money\" avec un logo au dos du t-shirt.', 10, 1, 1),
(4, 'T-shirt Bleu marine \"Money\"', 'bleu.png', 'T-shirt Bleu marine \"Money\" avec un logo au dos du t-shirt.', 10, 1, 1),
(7, 'T-shirt Rouge\"Money\"', 'rouge.png', 'T-shirt Rouge \"Money\" avec un logo au dos du t-shirt.', 10, 1, 1),
(8, 'T-shirt Gris \"Money\"', 'gris.png', 'T-shirt Gris \"Money\" avec un logo au dos du t-shirt.', 10, 1, 1),
(9, 'T-shirt Kaki \"Money\"', 'kaki.png', 'T-shirt Kaki \"Money\" avec un logo au dos du t-shirt.', 10, 1, 1),
(10, 'Hoodie Blanc \"Sportweab\"', 'hoodie-blanc.png', 'Hoodie blanc edition \"Sportweab\" 100% Coton.', 10, 2, 3),
(11, 'Hoodie Noir \"Sportweab\"', 'hoodie-noir.png', 'Hoodie blanc edition \"Sportweab\" 100% Coton.', 10, 2, 3),
(12, 'Hoodie Bleu \"Sportweab\"', 'hoodie-bleu.png', 'Hoodie bleu edition \"Sportweab\" 100% Coton.', 10, 2, 3),
(13, 'Hoodie Gris \"Sportweab\"', 'hoodie-gris.png', 'Hoodie gris edition \"Sportweab\" 100% Coton.', 10, 2, 3),
(14, 'Hoodie Orange \"Sportweab\"', 'hoodie-orange.png', 'Hoodie orange edition \"Sportweab\" 100% Coton.', 10, 2, 3);

-- --------------------------------------------------------

--
-- Structure de la table `articles_concernant_commande`
--

DROP TABLE IF EXISTS `articles_concernant_commande`;
CREATE TABLE IF NOT EXISTS `articles_concernant_commande` (
  `idArticle` int(11) NOT NULL,
  `idCommande` int(11) NOT NULL,
  KEY `idArticle` (`idArticle`),
  KEY `idCommande` (`idCommande`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `idCategorie` int(11) NOT NULL AUTO_INCREMENT,
  `nomCategorie` varchar(50) NOT NULL,
  `descriptionCategorie` varchar(100) NOT NULL,
  PRIMARY KEY (`idCategorie`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`idCategorie`, `nomCategorie`, `descriptionCategorie`) VALUES
(1, 'T-shirt', 'T-shirts avec les nouveaux designs.'),
(2, 'Hoodie', 'Pulls à capuche avec nos derniers designs.'),
(3, 'Casquette', 'Casquettes avec les derniers designs brodés dessus.');

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `idClient` int(11) NOT NULL AUTO_INCREMENT,
  `nomClient` varchar(100) NOT NULL,
  `prenomClient` varchar(100) NOT NULL,
  `adresseClient` varchar(100) NOT NULL,
  `codePostal` int(10) NOT NULL,
  `ville` varchar(100) NOT NULL,
  `pays` varchar(40) NOT NULL,
  `telephone` varchar(50) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `motPasse` varchar(50) NOT NULL,
  `idUtilisateur` int(11) NOT NULL,
  PRIMARY KEY (`idClient`),
  KEY `idUtilisateur` (`idUtilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`idClient`, `nomClient`, `prenomClient`, `adresseClient`, `codePostal`, `ville`, `pays`, `telephone`, `mail`, `motPasse`, `idUtilisateur`) VALUES
(1, 'Jo', 'Da', '38 rue dede', 1202, 'Gnv', 'Suisse', '234234234', 'd@d.ch', '1202', 1),
(2, 'Rivera', 'Loic', '38 rue de la Paix', 1202, 'Genève', 'Suisse', '076 693 09 82', 'loic@rivera.ch', '1202', 2),
(6, 'sad', 'asd', '38 rue de ', 1202, 'gre', 'St Barthelemy', '0921213', 'asd@asd.ch', 'b17f4787f2799f2665e5f119fc2f47d569212c4c', 9),
(7, 'asd', 'asd', '48 e324', 213, 'gnv', 'Denmark', '123123123', 'asd32@fds.ch', 'b17f4787f2799f2665e5f119fc2f47d569212c4c', 10),
(8, 'asd', 'asd', '48 e324', 213, 'gnv', 'French Guiana', '123123123', 'dfssdfsdfs@fds.ch', 'b17f4787f2799f2665e5f119fc2f47d569212c4c', 11);

-- --------------------------------------------------------

--
-- Structure de la table `client_passant_commande`
--

DROP TABLE IF EXISTS `client_passant_commande`;
CREATE TABLE IF NOT EXISTS `client_passant_commande` (
  `idClient` int(11) NOT NULL,
  `idCommande` int(11) NOT NULL,
  KEY `idClient` (`idClient`),
  KEY `idCommande` (`idCommande`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `factures`
--

DROP TABLE IF EXISTS `factures`;
CREATE TABLE IF NOT EXISTS `factures` (
  `idFacture` int(11) NOT NULL AUTO_INCREMENT,
  `montantTotal` decimal(5,2) NOT NULL,
  `idCommande` int(11) NOT NULL,
  PRIMARY KEY (`idFacture`),
  KEY `idCommande` (`idCommande`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `historiques_prix`
--

DROP TABLE IF EXISTS `historiques_prix`;
CREATE TABLE IF NOT EXISTS `historiques_prix` (
  `idPrix` int(11) NOT NULL,
  `idArticle` int(11) NOT NULL,
  KEY `idPrix` (`idPrix`),
  KEY `idArticle` (`idArticle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `panier_commandes`
--

DROP TABLE IF EXISTS `panier_commandes`;
CREATE TABLE IF NOT EXISTS `panier_commandes` (
  `idCommande` int(11) NOT NULL AUTO_INCREMENT,
  `numCommande` int(11) NOT NULL,
  `dateCommande` date NOT NULL,
  `taille` varchar(2) NOT NULL,
  `idClient` int(11) NOT NULL,
  `idArticle` int(11) NOT NULL,
  PRIMARY KEY (`idCommande`),
  KEY `idArticle` (`idArticle`),
  KEY `idClient` (`idClient`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `portemonnaie`
--

DROP TABLE IF EXISTS `portemonnaie`;
CREATE TABLE IF NOT EXISTS `portemonnaie` (
  `idPorteMonnaie` int(4) NOT NULL AUTO_INCREMENT,
  `solde` decimal(5,2) NOT NULL DEFAULT '300.00',
  `idUtilisateur` int(11) NOT NULL,
  PRIMARY KEY (`idPorteMonnaie`),
  KEY `idUtilisateur` (`idUtilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `portemonnaie`
--

INSERT INTO `portemonnaie` (`idPorteMonnaie`, `solde`, `idUtilisateur`) VALUES
(2, '300.00', 9),
(3, '300.00', 10),
(4, '300.00', 11);

-- --------------------------------------------------------

--
-- Structure de la table `prix`
--

DROP TABLE IF EXISTS `prix`;
CREATE TABLE IF NOT EXISTS `prix` (
  `idPrix` int(11) NOT NULL AUTO_INCREMENT,
  `prix` decimal(5,2) NOT NULL,
  `datePrix` date NOT NULL,
  PRIMARY KEY (`idPrix`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `prix`
--

INSERT INTO `prix` (`idPrix`, `prix`, `datePrix`) VALUES
(1, '20.00', '2018-05-08'),
(2, '15.00', '2018-05-08'),
(3, '40.00', '2018-05-08');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `idUtilisateur` int(11) NOT NULL AUTO_INCREMENT,
  `mailUtilisateur` varchar(50) NOT NULL,
  `motPasse` varchar(50) NOT NULL,
  `typeUtilisateur` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idUtilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`idUtilisateur`, `mailUtilisateur`, `motPasse`, `typeUtilisateur`) VALUES
(1, 'd@d.ch', 'b17f4787f2799f2665e5f119fc2f47d569212c4c', 'Administrateur'),
(2, 'loic@rivera.ch', '1202', ''),
(9, 'asd@asd.ch', 'b17f4787f2799f2665e5f119fc2f47d569212c4c', NULL),
(10, 'asd32@fds.ch', 'b17f4787f2799f2665e5f119fc2f47d569212c4c', NULL),
(11, 'dfssdfsdfs@fds.ch', 'b17f4787f2799f2665e5f119fc2f47d569212c4c', NULL);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`idPrix`) REFERENCES `prix` (`idPrix`),
  ADD CONSTRAINT `articles_ibfk_2` FOREIGN KEY (`idCategorie`) REFERENCES `categories` (`idCategorie`) ON DELETE CASCADE;

--
-- Contraintes pour la table `articles_concernant_commande`
--
ALTER TABLE `articles_concernant_commande`
  ADD CONSTRAINT `articles_concernant_commande_ibfk_1` FOREIGN KEY (`idArticle`) REFERENCES `articles` (`idArticle`),
  ADD CONSTRAINT `articles_concernant_commande_ibfk_2` FOREIGN KEY (`idCommande`) REFERENCES `panier_commandes` (`idCommande`) ON DELETE CASCADE;

--
-- Contraintes pour la table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_ibfk_1` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateurs` (`idUtilisateur`) ON DELETE CASCADE;

--
-- Contraintes pour la table `client_passant_commande`
--
ALTER TABLE `client_passant_commande`
  ADD CONSTRAINT `client_passant_commande_ibfk_1` FOREIGN KEY (`idClient`) REFERENCES `clients` (`idClient`),
  ADD CONSTRAINT `client_passant_commande_ibfk_2` FOREIGN KEY (`idCommande`) REFERENCES `panier_commandes` (`idCommande`) ON DELETE CASCADE;

--
-- Contraintes pour la table `factures`
--
ALTER TABLE `factures`
  ADD CONSTRAINT `factures_ibfk_1` FOREIGN KEY (`idCommande`) REFERENCES `panier_commandes` (`idCommande`) ON DELETE CASCADE;

--
-- Contraintes pour la table `historiques_prix`
--
ALTER TABLE `historiques_prix`
  ADD CONSTRAINT `historiques_prix_ibfk_1` FOREIGN KEY (`idArticle`) REFERENCES `articles` (`idArticle`) ON DELETE CASCADE,
  ADD CONSTRAINT `historiques_prix_ibfk_2` FOREIGN KEY (`idPrix`) REFERENCES `prix` (`idPrix`) ON DELETE CASCADE;

--
-- Contraintes pour la table `panier_commandes`
--
ALTER TABLE `panier_commandes`
  ADD CONSTRAINT `panier_commandes_ibfk_1` FOREIGN KEY (`idClient`) REFERENCES `clients` (`idClient`),
  ADD CONSTRAINT `panier_commandes_ibfk_2` FOREIGN KEY (`idArticle`) REFERENCES `articles` (`idArticle`) ON DELETE CASCADE;

--
-- Contraintes pour la table `portemonnaie`
--
ALTER TABLE `portemonnaie`
  ADD CONSTRAINT `portemonnaie_ibfk_1` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateurs` (`idUtilisateur`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
