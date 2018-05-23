-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 23 mai 2018 à 14:46
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
  `idPrixArticle` int(11) NOT NULL,
  PRIMARY KEY (`idArticle`),
  KEY `idCategorie` (`idCategorie`),
  KEY `idPrixArticle` (`idPrixArticle`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`idArticle`, `nomArticle`, `imageArticle`, `descriptionArticle`, `stock`, `idCategorie`, `idPrixArticle`) VALUES
(1, 'T-shirt Blanc \"Money\"', 'white.png', 'T-shirt Blanc \"Money\" avec un logo au dos du t-shirt.', 10, 1, 26),
(2, 'T-shirt Noir \"Money\"', 'black.png', 'T-shirt Noir \"Money\" avec un logo au dos du t-shirt.', 10, 1, 27),
(3, 'T-shirt Beige \"Money\"', 'beige.png', 'T-shirt Beige \"Money\" avec un logo au dos du t-shirt.', 10, 1, 28),
(4, 'T-shirt Bleu marine \"Money\"', 'bleu.png', 'T-shirt Bleu marine \"Money\" avec un logo au dos du t-shirt.', 10, 1, 29),
(7, 'T-shirt Rouge\"Money\"', 'rouge.png', 'T-shirt Rouge \"Money\" avec un logo au dos du t-shirt.', 10, 1, 30),
(8, 'T-shirt Gris \"Money\"', 'gris.png', 'T-shirt Gris \"Money\" avec un logo au dos du t-shirt.', 10, 1, 31),
(9, 'T-shirt Kaki \"Money\"', 'kaki.png', 'T-shirt Kaki \"Money\" avec un logo au dos du t-shirt.', 10, 1, 32),
(10, 'Hoodie Blanc ', 'hoodie-blanc.png', 'Hoodie blanc edition &#34;Sportweab&#34; 100% Coton.', 19, 2, 39),
(11, 'Hoodie Noir ', 'hoodie-noir.png', 'Hoodie blanc edition &#34;Sportweab&#34; 100% Coton.', 22, 2, 40),
(12, 'Hoodie Bleu ', '5afaa840b5cdd.png', 'Hoodie bleu edition &#34;Sportweab&#34; 100% Coton.', 7, 2, 35),
(13, 'Hoodie Gris \"Sportweab\"', 'hoodie-gris.png', 'Hoodie gris edition \"Sportweab\" 100% Coton.', 10, 2, 36),
(14, 'Hoodie Orange ', '5afaa7dcc229e.png', 'Hoodie orange edition &#34;Sportweab&#34; 100% Coton.', 9, 2, 37),
(15, 'T-shirt Gold', '5b045a5dcb145.png', 'Gold', 64, 1, 41),
(16, 'T-shirt édition Velvet', '5b045a8ab8bea.png', 'Velvet', 24, 1, 51),
(17, 'T-shirt édition orange', '5b045ab9e20da.png', 'Orange', 25, 1, 43),
(18, 'Hoodie Violet', '5b045b39846d3.png', 'Violet', 45, 2, 44),
(19, 'Casquette Grise', '5b045b9649922.png', 'Casquette grise logo brodé', 45, 3, 45),
(20, 'Casquette Jaune ', '5b045bb42aa12.png', 'Casquette jaune logo brodé', 45, 3, 46),
(21, 'Casquette Noire', '5b045bdb56a19.png', 'Casquette noire logo brodé', 45, 3, 47),
(22, 'Casquette Violette', '5b045bfaa7d77.png', 'Casquette violette logo brodé', 45, 3, 48),
(23, 'Casquette Verte', '5b045c1a18082.png', 'Casquette verte logo brodé', 45, 3, 49),
(24, 'Casquette édition Abeille', '5b045c433262c.png', 'Casquette édition limitée abeille', 43, 3, 50);

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

--
-- Déchargement des données de la table `articles_concernant_commande`
--

INSERT INTO `articles_concernant_commande` (`idArticle`, `idCommande`) VALUES
(24, 1),
(24, 2),
(16, 4),
(16, 5),
(10, 7),
(17, 11),
(15, 12);

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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`idClient`, `nomClient`, `prenomClient`, `adresseClient`, `codePostal`, `ville`, `pays`, `telephone`, `mail`, `motPasse`, `idUtilisateur`) VALUES
(1, 'Jo', 'Da', '38 rue dede', 1202, 'Gnv', 'Suisse', '234234234', 'd@d.ch', '1202', 1),
(2, 'Rivera', 'Loic', '38 rue de la Paix', 1202, 'Genève', 'Suisse', '076 693 09 82', 'loic@rivera.ch', '1202', 2),
(6, 'sad', 'asd', '38 rue de ', 1202, 'gre', 'St Barthelemy', '0921213', 'asd@asd.ch', 'b17f4787f2799f2665e5f119fc2f47d569212c4c', 9),
(7, 'asd', 'asd', '48 e324', 213, 'gnv', 'Denmark', '123123123', 'asd32@fds.ch', 'b17f4787f2799f2665e5f119fc2f47d569212c4c', 10),
(8, 'asd', 'asd', '48 e324', 213, 'gnv', 'French Guiana', '123123123', 'dfssdfsdfs@fds.ch', 'b17f4787f2799f2665e5f119fc2f47d569212c4c', 11),
(9, 'Jovanovic', 'Damjan', '38 rue de Vermont', 1202, 'Genève', 'Switzerland', '076 693 45 87', 'damjan@jovanovic.ch', 'b17f4787f2799f2665e5f119fc2f47d569212c4c', 12),
(11, 'Oklm', 'Boob', '38 reuer', 1202, 'Genève', 'St Barthelemy', '123123', 'boob@ad.ch', 'b17f4787f2799f2665e5f119fc2f47d569212c4c', 14),
(12, 'asdsa', 'sdasda', '232 wqe', 1202, 'genève', 'Seychelles', '123123213123', 'da@c.ch', 'b17f4787f2799f2665e5f119fc2f47d569212c4c', 15),
(13, 'Jovb', 'Damjn', '28 we', 1202, 'genève', 'St Kitts-Nevis', '23123121', 'ko@ko.ch', 'b17f4787f2799f2665e5f119fc2f47d569212c4c', 16);

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

--
-- Déchargement des données de la table `client_passant_commande`
--

INSERT INTO `client_passant_commande` (`idClient`, `idCommande`) VALUES
(2, 1),
(2, 2),
(2, 4),
(2, 5),
(2, 7),
(2, 11),
(2, 12);

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
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `factures`
--

INSERT INTO `factures` (`idFacture`, `montantTotal`, `idCommande`) VALUES
(1, '0.00', 1),
(3, '0.00', 1),
(4, '105.00', 1),
(5, '105.00', 1),
(6, '105.00', 2),
(7, '105.00', 4),
(8, '105.00', 5),
(9, '75.00', 1),
(10, '75.00', 2),
(11, '75.00', 4),
(12, '75.00', 5),
(13, '75.00', 7),
(14, '30.00', 1),
(15, '30.00', 2),
(16, '30.00', 4),
(17, '30.00', 5),
(18, '30.00', 7),
(19, '30.00', 11),
(20, '30.00', 1),
(21, '30.00', 2),
(22, '30.00', 4),
(23, '30.00', 5),
(24, '30.00', 7),
(25, '30.00', 11),
(26, '30.00', 12);

-- --------------------------------------------------------

--
-- Structure de la table `panier_commandes`
--

DROP TABLE IF EXISTS `panier_commandes`;
CREATE TABLE IF NOT EXISTS `panier_commandes` (
  `idCommande` int(11) NOT NULL AUTO_INCREMENT,
  `numCommande` varchar(100) DEFAULT NULL,
  `dateCommande` date NOT NULL,
  `taille` varchar(2) NOT NULL,
  `idClient` int(11) NOT NULL,
  `idPrixArticle` int(11) NOT NULL,
  PRIMARY KEY (`idCommande`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `panier_commandes`
--

INSERT INTO `panier_commandes` (`idCommande`, `numCommande`, `dateCommande`, `taille`, `idClient`, `idPrixArticle`) VALUES
(1, '2018-05-235b052e2eeaa60', '2018-05-22', 'M', 2, 50),
(2, '2018-05-235b05353aeb2f9', '2018-05-23', 'L', 2, 50),
(4, '2018-05-235b05353aeb2f9', '2018-05-22', 'XS', 2, 42),
(5, '2018-05-235b05353aeb2f9', '2018-05-23', 'S', 2, 51),
(7, '2018-05-235b0574d057ffc', '2018-05-23', 'XS', 2, 39),
(11, '2018-05-235b05764f5b3b9', '2018-05-23', 'XS', 2, 43),
(12, '2018-05-235b057689ea753', '2018-05-23', 'L', 2, 41);

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `portemonnaie`
--

INSERT INTO `portemonnaie` (`idPorteMonnaie`, `solde`, `idUtilisateur`) VALUES
(2, '300.00', 9),
(3, '300.00', 10),
(4, '300.00', 11),
(5, '300.00', 12),
(7, '300.00', 14),
(8, '300.00', 15),
(9, '300.00', 16),
(10, '270.00', 2);

-- --------------------------------------------------------

--
-- Structure de la table `prixarticles`
--

DROP TABLE IF EXISTS `prixarticles`;
CREATE TABLE IF NOT EXISTS `prixarticles` (
  `idPrixArticle` int(11) NOT NULL AUTO_INCREMENT,
  `prix` decimal(5,2) NOT NULL,
  `dateDebut` date NOT NULL,
  `dateFin` date DEFAULT NULL,
  `idArticle` int(11) DEFAULT NULL,
  PRIMARY KEY (`idPrixArticle`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `prixarticles`
--

INSERT INTO `prixarticles` (`idPrixArticle`, `prix`, `dateDebut`, `dateFin`, `idArticle`) VALUES
(26, '25.00', '2018-05-21', '2018-05-28', 1),
(27, '25.00', '2018-05-21', '2018-05-28', 2),
(28, '25.00', '2018-05-21', '2018-05-28', 3),
(29, '25.00', '2018-05-21', '2018-05-28', 4),
(30, '25.00', '2018-05-21', '2018-05-28', 7),
(31, '25.00', '2018-05-21', '2018-05-28', 8),
(32, '25.00', '2018-05-21', '2018-05-28', 9),
(33, '50.00', '2018-05-20', '2018-05-28', 10),
(34, '50.00', '2018-05-21', '2018-05-28', 11),
(35, '50.00', '2018-05-21', '2018-05-28', 12),
(36, '50.00', '2018-05-21', '2018-05-28', 13),
(37, '50.00', '2018-05-21', '2018-05-28', 14),
(39, '75.00', '2018-05-21', '2018-05-24', 10),
(40, '10.00', '2018-05-21', '2018-05-24', 11),
(41, '30.00', '2018-05-22', '2018-05-30', 15),
(42, '30.00', '2018-05-22', '2018-05-30', 16),
(43, '30.00', '2018-05-22', '2018-05-30', 17),
(44, '50.00', '2018-05-22', '2018-05-31', 18),
(45, '27.00', '2018-05-22', '2018-05-31', 19),
(46, '27.00', '2018-05-22', '2018-05-31', 20),
(47, '27.00', '2018-05-22', '2018-05-31', 21),
(48, '27.00', '2018-05-22', '2018-05-31', 22),
(49, '27.00', '2018-05-22', '2018-05-31', 23),
(50, '30.00', '2018-05-22', '2018-05-31', 24),
(51, '45.00', '2018-05-23', '2018-05-30', 16);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `idUtilisateur` int(11) NOT NULL AUTO_INCREMENT,
  `mailUtilisateur` varchar(50) NOT NULL,
  `motPasse` varchar(50) NOT NULL,
  `typeUtilisateur` varchar(20) NOT NULL DEFAULT 'en attente',
  PRIMARY KEY (`idUtilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`idUtilisateur`, `mailUtilisateur`, `motPasse`, `typeUtilisateur`) VALUES
(1, 'd@d.ch', 'b17f4787f2799f2665e5f119fc2f47d569212c4c', 'Administrateur'),
(2, 'loic@rivera.ch', 'b17f4787f2799f2665e5f119fc2f47d569212c4c', 'Utilisateur'),
(9, 'asd@asd.ch', 'b17f4787f2799f2665e5f119fc2f47d569212c4c', 'Utilisateur'),
(10, 'asd32@fds.ch', 'b17f4787f2799f2665e5f119fc2f47d569212c4c', 'en attente'),
(11, 'dfssdfsdfs@fds.ch', 'b17f4787f2799f2665e5f119fc2f47d569212c4c', 'en attente'),
(12, 'damjan@jovanovic.ch', 'b17f4787f2799f2665e5f119fc2f47d569212c4c', 'Utilisateur'),
(14, 'boob@ad.ch', 'b17f4787f2799f2665e5f119fc2f47d569212c4c', 'en attente'),
(15, 'da@c.ch', 'b17f4787f2799f2665e5f119fc2f47d569212c4c', 'en attente'),
(16, 'ko@ko.ch', 'b17f4787f2799f2665e5f119fc2f47d569212c4c', 'en attente');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`idCategorie`) REFERENCES `categories` (`idCategorie`) ON DELETE CASCADE,
  ADD CONSTRAINT `articles_ibfk_2` FOREIGN KEY (`idPrixArticle`) REFERENCES `prixarticles` (`idPrixArticle`);

--
-- Contraintes pour la table `articles_concernant_commande`
--
ALTER TABLE `articles_concernant_commande`
  ADD CONSTRAINT `articles_concernant_commande_ibfk_1` FOREIGN KEY (`idArticle`) REFERENCES `articles` (`idArticle`) ON DELETE CASCADE,
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
  ADD CONSTRAINT `client_passant_commande_ibfk_1` FOREIGN KEY (`idClient`) REFERENCES `clients` (`idClient`) ON DELETE CASCADE,
  ADD CONSTRAINT `client_passant_commande_ibfk_2` FOREIGN KEY (`idCommande`) REFERENCES `panier_commandes` (`idCommande`) ON DELETE CASCADE;

--
-- Contraintes pour la table `factures`
--
ALTER TABLE `factures`
  ADD CONSTRAINT `factures_ibfk_1` FOREIGN KEY (`idCommande`) REFERENCES `panier_commandes` (`idCommande`) ON DELETE CASCADE;

--
-- Contraintes pour la table `portemonnaie`
--
ALTER TABLE `portemonnaie`
  ADD CONSTRAINT `portemonnaie_ibfk_1` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateurs` (`idUtilisateur`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
