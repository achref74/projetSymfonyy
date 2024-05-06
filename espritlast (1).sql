-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 05, 2024 at 01:12 PM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `espritlast`
--

-- --------------------------------------------------------

--
-- Table structure for table `avis`
--

DROP TABLE IF EXISTS `avis`;
CREATE TABLE IF NOT EXISTS `avis` (
  `idAvis` int NOT NULL AUTO_INCREMENT,
  `rate` int NOT NULL,
  `idFormation` int DEFAULT NULL,
  `idOutil` int DEFAULT NULL,
  `idUser` int DEFAULT NULL,
  PRIMARY KEY (`idAvis`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `idCategorie` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  PRIMARY KEY (`idCategorie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `certificat`
--

DROP TABLE IF EXISTS `certificat`;
CREATE TABLE IF NOT EXISTS `certificat` (
  `idCertificat` int NOT NULL AUTO_INCREMENT,
  `titre` int NOT NULL,
  `description` varchar(255) NOT NULL,
  `dateObtention` date NOT NULL,
  `nbrCours` int NOT NULL,
  `idUser` int DEFAULT NULL,
  `idFormation` int DEFAULT NULL,
  PRIMARY KEY (`idCertificat`),
  KEY `idFormation` (`idFormation`),
  KEY `idUser` (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `certificat`
--

INSERT INTO `certificat` (`idCertificat`, `titre`, `description`, `dateObtention`, `nbrCours`, `idUser`, `idFormation`) VALUES
(1, 0, '', '0000-00-00', 0, NULL, NULL),
(2, 0, '', '0000-00-00', 0, NULL, NULL),
(3, 0, '', '0000-00-00', 0, NULL, NULL),
(4, 0, '', '0000-00-00', 0, NULL, NULL),
(5, 0, '', '0000-00-00', 0, NULL, NULL),
(6, 0, '', '0000-00-00', 0, NULL, NULL),
(7, 0, '', '0000-00-00', 0, NULL, NULL),
(8, 0, '', '0000-00-00', 0, NULL, NULL),
(9, 0, '', '0000-00-00', 0, NULL, NULL),
(10, 0, '', '0000-00-00', 0, NULL, NULL),
(11, 0, '', '0000-00-00', 0, NULL, NULL),
(12, 0, '', '0000-00-00', 0, NULL, NULL),
(13, 0, '', '0000-00-00', 0, NULL, NULL),
(14, 0, '', '0000-00-00', 0, NULL, NULL),
(15, 0, '', '0000-00-00', 0, NULL, NULL),
(16, 0, '', '0000-00-00', 0, NULL, NULL),
(17, 0, '', '0000-00-00', 0, NULL, NULL),
(18, 0, '', '0000-00-00', 0, NULL, NULL),
(19, 0, '', '0000-00-00', 0, NULL, NULL),
(20, 0, '', '0000-00-00', 0, NULL, NULL),
(21, 0, '', '0000-00-00', 0, NULL, NULL),
(22, 0, '', '0000-00-00', 0, NULL, NULL),
(23, 0, '', '0000-00-00', 0, NULL, NULL),
(24, 0, '', '0000-00-00', 0, NULL, NULL),
(25, 0, '', '0000-00-00', 0, NULL, NULL),
(26, 0, '', '0000-00-00', 0, NULL, NULL),
(27, 0, '', '0000-00-00', 0, NULL, NULL),
(28, 0, '', '0000-00-00', 0, NULL, NULL),
(29, 0, '', '0000-00-00', 0, NULL, NULL),
(30, 0, '', '0000-00-00', 0, NULL, NULL),
(31, 0, '', '0000-00-00', 0, NULL, NULL),
(32, 0, '', '0000-00-00', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
  `idCommentaire` int NOT NULL AUTO_INCREMENT,
  `dateCreation` date NOT NULL,
  `description` varchar(255) NOT NULL,
  `contenu` varchar(255) NOT NULL,
  `idForum` int DEFAULT NULL,
  PRIMARY KEY (`idCommentaire`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cours`
--

DROP TABLE IF EXISTS `cours`;
CREATE TABLE IF NOT EXISTS `cours` (
  `id_cours` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `duree` int NOT NULL,
  `prerequis` varchar(255) NOT NULL,
  `ressource` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `idFormation` int DEFAULT NULL,
  PRIMARY KEY (`id_cours`),
  KEY `idFormation` (`idFormation`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cours`
--

INSERT INTO `cours` (`id_cours`, `nom`, `description`, `date`, `duree`, `prerequis`, `ressource`, `image`, `idFormation`) VALUES
(74, ' chap4', 'svr', '2024-04-25', 100, 'srh', 'C:\\projetPIDEV\\gestionCours\\src\\main\\resources\\app.wav', 'vid.mp4', 3),
(77, 'chap1', 'chap1-geo', '2024-05-22', 20, 'rien', '66313cf06aa46.txt', '66313cf06b465.mp4', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `evaluation`
--

DROP TABLE IF EXISTS `evaluation`;
CREATE TABLE IF NOT EXISTS `evaluation` (
  `id_e` int NOT NULL AUTO_INCREMENT,
  `note` int NOT NULL,
  `nom` varchar(255) NOT NULL,
  `id_cours` int NOT NULL,
  PRIMARY KEY (`id_e`),
  KEY `id_cours` (`id_cours`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `evaluation`
--

INSERT INTO `evaluation` (`id_e`, `note`, `nom`, `id_cours`) VALUES
(1, 20, 'evalTest', 74),
(33, 20, 'evaluationFinale', 74),
(34, 20, 'eval_2', 77);

-- --------------------------------------------------------

--
-- Table structure for table `formation`
--

DROP TABLE IF EXISTS `formation`;
CREATE TABLE IF NOT EXISTS `formation` (
  `idFormation` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `dateD` date NOT NULL,
  `dateF` date NOT NULL,
  `prix` double NOT NULL,
  `nbrCours` int NOT NULL,
  `idUser` int DEFAULT NULL,
  `idCategorie` int DEFAULT NULL,
  `imageurl` varchar(255) NOT NULL,
  PRIMARY KEY (`idFormation`),
  KEY `idUser` (`idUser`),
  KEY `idCategorie` (`idCategorie`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `formation`
--

INSERT INTO `formation` (`idFormation`, `nom`, `description`, `dateD`, `dateF`, `prix`, `nbrCours`, `idUser`, `idCategorie`, `imageurl`) VALUES
(3, 'Formation Java Avancée', 'Approfondir les connaissances en Java', '2024-02-15', '2024-03-30', 20, 5, NULL, NULL, ''),
(6, 'Formation python', 'Apprendre python', '2024-02-15', '2024-03-30', 20, 5, NULL, NULL, ''),
(8, 'abc', 'abcabcabcabcabcabcabc', '2024-05-17', '2024-05-25', 20, 2, NULL, NULL, '/uploads/6632fb30e98e0.mp4');

-- --------------------------------------------------------

--
-- Table structure for table `forum`
--

DROP TABLE IF EXISTS `forum`;
CREATE TABLE IF NOT EXISTS `forum` (
  `idForum` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `dateCreation` date NOT NULL,
  `nbrMessage` int NOT NULL,
  `idUser` int DEFAULT NULL,
  `idFormation` int DEFAULT NULL,
  PRIMARY KEY (`idForum`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offre`
--

DROP TABLE IF EXISTS `offre`;
CREATE TABLE IF NOT EXISTS `offre` (
  `idOffre` int NOT NULL AUTO_INCREMENT,
  `codePromo` varchar(255) NOT NULL,
  `prixOffre` float NOT NULL,
  `description` varchar(255) NOT NULL,
  `dateD` date NOT NULL,
  `dateF` date NOT NULL,
  `idFormation` int DEFAULT NULL,
  PRIMARY KEY (`idOffre`),
  KEY `idFormation` (`idFormation`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `offre`
--

INSERT INTO `offre` (`idOffre`, `codePromo`, `prixOffre`, `description`, `dateD`, `dateF`, `idFormation`) VALUES
(1, 'sdfsdfsdf', 20, 'dsfsdfsdf', '2024-05-14', '2024-05-16', 3);

-- --------------------------------------------------------

--
-- Table structure for table `outil`
--

DROP TABLE IF EXISTS `outil`;
CREATE TABLE IF NOT EXISTS `outil` (
  `idOutil` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `prix` float NOT NULL,
  `ressources` varchar(255) NOT NULL,
  `disponiblite` tinyint(1) NOT NULL,
  PRIMARY KEY (`idOutil`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

DROP TABLE IF EXISTS `question`;
CREATE TABLE IF NOT EXISTS `question` (
  `id_q` int NOT NULL AUTO_INCREMENT,
  `ressource` varchar(255) NOT NULL,
  `duree` int NOT NULL,
  `point` int NOT NULL,
  `choix1` varchar(255) NOT NULL,
  `choix2` varchar(255) NOT NULL,
  `choix3` varchar(255) NOT NULL,
  `reponse` varchar(255) DEFAULT NULL,
  `crx` varchar(255) NOT NULL,
  `id_e` int NOT NULL,
  PRIMARY KEY (`id_q`),
  KEY `id_e` (`id_e`)
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`id_q`, `ressource`, `duree`, `point`, `choix1`, `choix2`, `choix3`, `reponse`, `crx`, `id_e`) VALUES
(83, 'dsdwsd', 10, 10, 'x', 'b', 'c', NULL, '1', 1),
(84, 'xxxx', 10, 10, 'h', 'y', 'u', NULL, '3', 1),
(85, 'ok', 10, 10, 'a', 'b', 'c', NULL, '1', 33),
(86, 'notOk', 10, 10, 'x', 'y', 'z', NULL, '2', 33),
(87, '1', 10, 5, 'a', 'b', 'c', NULL, 'a', 34),
(88, '2', 10, 5, 'h', 'j', 'k', '0', 'h', 34),
(89, '3', 10, 10, 'm', 'p', 'c', '0', 'm', 34);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `idUser` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `dateNaissance` date NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `numtel` int NOT NULL,
  `imageProfil` varchar(255) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `role` int NOT NULL,
  `specialite` varchar(255) NOT NULL,
  `niveauAcademique` varchar(255) NOT NULL,
  `disponiblite` int NOT NULL,
  `cv` varchar(255) NOT NULL,
  `niveau_scolaire` varchar(255) DEFAULT NULL,
  `auth_code` varchar(20) DEFAULT NULL,
  `activated` int DEFAULT NULL,
  `reset_token` varchar(20) NOT NULL,
  `otp` varchar(20) NOT NULL,
  PRIMARY KEY (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`idUser`, `nom`, `prenom`, `email`, `dateNaissance`, `adresse`, `numtel`, `imageProfil`, `genre`, `mdp`, `role`, `specialite`, `niveauAcademique`, `disponiblite`, `cv`, `niveau_scolaire`, `auth_code`, `activated`, `reset_token`, `otp`) VALUES
(1, 'bouguerra', 'loujein', 'loujein@gmail.com', '2024-04-15', 'faz', 22, '', '', '0000', 0, '', 'gf', 1, 'zf', '', NULL, NULL, '', ''),
(2, 'loujein', 'loujein', 'loujein@gmail.com', '2019-02-01', 'nabeul', 53946055, '/images/6600b399c00a2.jpg', 'Homme', '$2y$13$p91KA.dZ5SKczcnG0uZkOu7RDyRLTgZX4bXuyz6.Ui1E5izD0gxH6', 1, 'jhv', 'secondaire', 1, '/images/cvvv.jpg', NULL, NULL, NULL, '', ''),
(3, 'loujein', 'loujein', 'loujein.bouguerra@gmail.com', '2019-01-01', 'nabeul', 53946055, '/images/achref.jpg', 'Femme', '$2y$13$jsJ7q8VyZcfIywgcF7eZNOZksxwfAbfLqGwkLNoKnw2CFmOCSFoiG', 1, 'ac', 'secondaire', 1, '/images/cvvv.jpg', NULL, NULL, NULL, '', ''),
(4, 'chaabene', 'oussema', 'chaabeneoussema1@gmail.com', '2024-04-16', 'tunis,ariana', 26750633, '/images/trash-2-16.png', 'Homme', '$2y$13$.p0k1/CTt0l9EmoekCCIlOdIXBNl/.MefNQmGq1zdM0PxtGARqllu', 0, 'none', '', 0, '0', 'universitaire', NULL, 1, '', '745126');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `certificat`
--
ALTER TABLE `certificat`
  ADD CONSTRAINT `certificat_ibfk_1` FOREIGN KEY (`idFormation`) REFERENCES `formation` (`idFormation`),
  ADD CONSTRAINT `certificat_ibfk_2` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`);

--
-- Constraints for table `cours`
--
ALTER TABLE `cours`
  ADD CONSTRAINT `cours_ibfk_1` FOREIGN KEY (`idFormation`) REFERENCES `formation` (`idFormation`);

--
-- Constraints for table `evaluation`
--
ALTER TABLE `evaluation`
  ADD CONSTRAINT `evaluation_ibfk_1` FOREIGN KEY (`id_cours`) REFERENCES `cours` (`id_cours`);

--
-- Constraints for table `formation`
--
ALTER TABLE `formation`
  ADD CONSTRAINT `formation_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`),
  ADD CONSTRAINT `formation_ibfk_2` FOREIGN KEY (`idCategorie`) REFERENCES `categorie` (`idCategorie`);

--
-- Constraints for table `offre`
--
ALTER TABLE `offre`
  ADD CONSTRAINT `offre_ibfk_1` FOREIGN KEY (`idFormation`) REFERENCES `formation` (`idFormation`);

--
-- Constraints for table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`id_e`) REFERENCES `evaluation` (`id_e`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
