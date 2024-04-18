-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 14 avr. 2024 à 23:36
-- Version du serveur : 10.4.25-MariaDB
-- Version de PHP : 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `esprit`
--

-- --------------------------------------------------------

--
-- Structure de la table `cours`
--

CREATE TABLE `cours` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `duree` int(11) NOT NULL,
  `prerequis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ressource` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_formation` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `cours`
--

INSERT INTO `cours` (`id`, `nom`, `description`, `date`, `duree`, `prerequis`, `ressource`, `image`, `id_formation`) VALUES
(1, 'math', 'math', '2024-04-10', 60, 'sdfsdf', 'qsfd<', NULL, NULL),
(3, 'xxxxxxxxx', 'xxxxxxx', '2019-01-01', 1, 'xxxxxxx', 'xxxxxxxx', NULL, NULL),
(4, 'dsdsqd', 'sdsd', '2019-01-01', 2, 'sdsd', 'sdsdd', NULL, NULL),
(5, 'dddd', 'dddd', '2019-01-01', 2, 'dddddd', 'dddd', NULL, NULL),
(6, 'ttttttttt', 'ttttttt', '2019-01-01', 2, 'ttttttt', 'tttttttt', NULL, NULL),
(7, 'rrrrrrrr', 'rrrrrrrrrr', '2019-01-01', 2, 'rrrrrrrrrr', 'rrrrrrrrrrr', NULL, NULL),
(8, 'wwwwww', 'wwwwww', '2019-01-01', 1, 'wwwwwww', 'wwwwww', NULL, NULL),
(9, 'wwwwwww', 'wwwwwwwww', '2019-01-01', 1, 'wwwww', 'wwwwww', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20240402201343', '2024-04-03 16:03:28', 50);

-- --------------------------------------------------------

--
-- Structure de la table `evaluation`
--

CREATE TABLE `evaluation` (
  `id` int(11) NOT NULL,
  `cours_id` int(11) NOT NULL,
  `note` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `evaluation`
--

INSERT INTO `evaluation` (`id`, `cours_id`, `note`, `nom`) VALUES
(2, 1, 50, 'sdfsdgvsfdsfsd'),
(8, 1, 52, 'ds2'),
(9, 1, 52, 'ds2'),
(10, 1, 52, 'ds2'),
(11, 1, 12, 'bac 2012 - math'),
(12, 1, 12, 'bac 2012 - math'),
(13, 1, 12, 'bac 2012 - math'),
(14, 1, 22, 'gfhfhgfh'),
(15, 1, 112, 'Espace');

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `question`
--

CREATE TABLE `question` (
  `id` int(11) NOT NULL,
  `evaluation_id` int(11) NOT NULL,
  `ressource` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duree` int(11) NOT NULL,
  `point` int(11) NOT NULL,
  `choix1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `choix2` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `choix3` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reponse` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `crx` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `idUser` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateNaissance` date NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numtel` int(11) NOT NULL,
  `imageProfil` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `genre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mdp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` int(11) NOT NULL,
  `specialite` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `niveauAcademique` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disponiblite` int(11) DEFAULT NULL,
  `cv` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `niveau_scolaire` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`idUser`, `nom`, `prenom`, `email`, `dateNaissance`, `adresse`, `numtel`, `imageProfil`, `genre`, `mdp`, `role`, `specialite`, `niveauAcademique`, `disponiblite`, `cv`, `niveau_scolaire`) VALUES
(1, 'gdfgfdg', 'nnnn', 'nnn@nnn.com', '2024-04-03', 'nnnn', 52139788, '/images/actor-mr-bean-310007_large.jpg', 'nnnn', '$2y$13$rJIj8uJURxNZisE4c6oLF.OQv3RhdzlbNDq5ZNPMESzcT5nEpqSTS', 2, NULL, NULL, NULL, NULL, 'nnnn'),
(2, 'zerzer', 'zerzer', 'dfsd@xdgsd.com', '2019-01-01', 'zerzer', 88888888, NULL, 'hgfhfh', '$2y$13$vPKoxKxeIPwDnBievb0MLe8rmtR5oh0g91TOlytfoHej3dYCAMOtS', 0, NULL, NULL, NULL, NULL, 'secondaire'),
(3, 'guui', 'bugubuii', 'ugugugu@ugugugui.com', '2019-01-01', 'yyuiujj', 12345678, NULL, 'Femme', '$2y$13$cNnVEesAG956HUAtbeQ0sednVgMw6st.wor2BA3HD4dsqHy5KC5e.', 0, NULL, NULL, NULL, NULL, 'secondaire');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `cours`
--
ALTER TABLE `cours`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `evaluation`
--
ALTER TABLE `evaluation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_1323A5757ECF78B0` (`cours_id`);

--
-- Index pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Index pour la table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B6F7494E456C5646` (`evaluation_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `cours`
--
ALTER TABLE `cours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `evaluation`
--
ALTER TABLE `evaluation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `question`
--
ALTER TABLE `question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
