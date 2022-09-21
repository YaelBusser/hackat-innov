-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : db:3306
-- Généré le : ven. 09 sep. 2022 à 10:40
-- Version du serveur : 10.4.24-MariaDB-1:10.4.24+maria~focal
-- Version de PHP : 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";




--
-- Base de données : `AP3_BD_HACKATHON_INITIAL`
--

-- --------------------------------------------------------

--
-- Structure de la table `ADMINISTRATEUR`
--

CREATE TABLE `ADMINISTRATEUR` (
  `idadministrateur` int(11) NOT NULL,
  `nom` varchar(128) COLLATE utf8_bin NOT NULL,
  `prenom` varchar(128) COLLATE utf8_bin NOT NULL,
  `motpasse` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `ADMINISTRATEUR`
--

INSERT INTO `ADMINISTRATEUR` (`idadministrateur`, `nom`, `prenom`, `motpasse`, `email`) VALUES
(1, 'admin', 'admin', '$2a$12$mJ7h1.AQewjLxApgFGiMfuYGeXaadSEWm4JRil6HUxpTWgaSuawre', 'admin@hackathon.fr');

-- --------------------------------------------------------

--
-- Structure de la table `EQUIPE`
--

CREATE TABLE `EQUIPE` (
  `idequipe` int(11) NOT NULL,
  `nomequipe` varchar(255) NOT NULL,
  `lienprototype` varchar(255) DEFAULT NULL,
  `nbparticipants` bigint(20) DEFAULT 0,
  `login` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `EQUIPE`
--

INSERT INTO `EQUIPE` (`idequipe`, `nomequipe`, `lienprototype`, `nbparticipants`, `login`, `password`) VALUES
(1, 'Les profs', NULL, 7, 'profs', '$2y$10$zhqnpXR7S37bDPDFHbSHtueFGDqZrXOS3zqc6Ry0gX8sf30YHGEQe'),
(2, 'Jobar team', NULL, 2, 'jobar', '$2y$10$zhqnpXR7S37bDPDFHbSHtueFGDqZrXOS3zqc6Ry0gX8sf30YHGEQe'),
(3, 'Team Valentin', '', 4, 'vbrosseau', '$2y$10$zhqnpXR7S37bDPDFHbSHtueFGDqZrXOS3zqc6Ry0gX8sf30YHGEQe');

-- --------------------------------------------------------

--
-- Structure de la table `HACKATHON`
--

CREATE TABLE `HACKATHON` (
  `idhackathon` int(11) NOT NULL,
  `dateheuredebuth` datetime NOT NULL,
  `dateheurefinh` datetime NOT NULL,
  `lieu` varchar(128) NOT NULL,
  `ville` varchar(128) NOT NULL,
  `conditions` varchar(255) DEFAULT NULL,
  `thematique` varchar(128) DEFAULT NULL,
  `affiche` varchar(255) DEFAULT NULL,
  `objectifs` varchar(255) DEFAULT NULL,
  `idorganisateur` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `HACKATHON`
--

INSERT INTO `HACKATHON` (`idhackathon`, `dateheuredebuth`, `dateheurefinh`, `lieu`, `ville`, `conditions`, `thematique`, `affiche`, `objectifs`, `idorganisateur`) VALUES
(1, '2022-06-26 11:54:57', '2023-06-30 11:54:43', 'Cité des sciences', 'Angers', 'Aucune', 'Code & Co', '/public/img/affiche.png', 'Apprendre le code', 1),
(2, '2024-06-27 12:24:48', '2025-06-27 12:24:54', 'Le Louvre', 'Paris', 'Aucune', 'Craft\It', '/public/img/affiche.png', 'Démo', 1),
(3, '2022-09-16 22:00:44', '2022-09-18 23:00:44', 'Manufacture Collaborative', 'NANTES', 'Aux porteurs de projets (entreprises, associations…) qui souhaitent challenger un projet/une idée pour l’éco-concevoir.', 'Hackathon de l’écoconception', '', 'Réduire l’impact écologique d’un produit ou d’un service en repensant son développement, ses fonctionnalités ou son usage.', 2),
(4, '2022-09-24 08:00:55', '2022-09-25 18:00:55', 'La salle de la Chapelle', 'Nantes', 'un développeur et un ingénieur transport dans chaque équipe au moins', 'Innovation et Transport', '', 'Trouver des solutions de transport innovant répondant aux critères environnementales de demain', 6);

-- --------------------------------------------------------

--
-- Structure de la table `INSCRIRE`
--

CREATE TABLE `INSCRIRE` (
  `idhackathon` int(11) NOT NULL,
  `idequipe` int(11) NOT NULL,
  `dateinscription` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `INSCRIRE`
--

INSERT INTO `INSCRIRE` (`idhackathon`, `idequipe`, `dateinscription`) VALUES
(1, 1, '2022-06-27'),
(1, 2, '2022-06-09'),
(1, 3, '2022-07-06'),
(2, 1, '2022-06-17');

-- --------------------------------------------------------

--
-- Structure de la table `MEMBRE`
--

CREATE TABLE `MEMBRE` (
  `idmembre` int(11) NOT NULL,
  `idequipe` int(11) DEFAULT NULL,
  `nom` varchar(128) NOT NULL,
  `prenom` varchar(128) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telephone` varchar(128) DEFAULT NULL,
  `datenaissance` date DEFAULT NULL,
  `lienportfolio` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `MEMBRE`
--

INSERT INTO `MEMBRE` (`idmembre`, `idequipe`, `nom`, `prenom`, `email`, `telephone`, `datenaissance`, `lienportfolio`) VALUES
(1, 1, 'Membre1', 'Roger', 'membre1@gmail.com', '0682245539', '1988-02-28', NULL),
(2, 2, 'Membre2', 'Roger', 'membre2@gmail.com', '0689726343', '2021-06-27', NULL),
(3, 1, 'Membre3', 'Roger', 'membre3@gmail.com', '0678965543', '1983-06-15', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `ORGANISATEUR`
--

CREATE TABLE `ORGANISATEUR` (
  `idorganisateur` int(11) NOT NULL,
  `nom` varchar(128) COLLATE utf8_bin NOT NULL,
  `prenom` varchar(128) COLLATE utf8_bin NOT NULL,
  `email` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `ORGANISATEUR`
--

INSERT INTO `ORGANISATEUR` (`idorganisateur`, `nom`, `prenom`, `email`) VALUES
(1, 'PIVERT', 'Thomas', 'thomas.pivert@assoINFO.org'),
(2, 'HERNANDEZ', 'Valérie', 'valerie.hernandez@evol.fr'),
(3, 'GUIVAZE', 'David', 'd.guivaze@envol.fr'),
(4, 'JAPONAIS', 'Charly', 'charly.japonais@assoInnov.com'),
(5, 'KERPLAIN', 'Aristide', 'a.kerplain@intertgv.com'),
(6, 'AZURA', 'Maude', 'm.azura@fr.fr');

-- --------------------------------------------------------

--
-- Structure de la table `TOKEN`
--

CREATE TABLE `TOKEN` (
  `uuid` varchar(128) NOT NULL,
  `idequipe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `TOKEN`
--

INSERT INTO `TOKEN` (`uuid`, `idequipe`) VALUES
('62ba1741eec91', 3),
('62ba179271911', 3),
('62ba1ac144dc0', 3),
('72cc6fdc-db66-492c-bb29-5c0a8e5331c4', 3);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `ADMINISTRATEUR`
--
ALTER TABLE `ADMINISTRATEUR`
  ADD PRIMARY KEY (`idadministrateur`);

--
-- Index pour la table `EQUIPE`
--
ALTER TABLE `EQUIPE`
  ADD PRIMARY KEY (`idequipe`),
  ADD UNIQUE KEY `ulogin` (`login`);

--
-- Index pour la table `HACKATHON`
--
ALTER TABLE `HACKATHON`
  ADD PRIMARY KEY (`idhackathon`),
  ADD KEY `hackathon_ibfk_1` (`idorganisateur`);

--
-- Index pour la table `INSCRIRE`
--
ALTER TABLE `INSCRIRE`
  ADD PRIMARY KEY (`idhackathon`,`idequipe`),
  ADD KEY `i_fk_inscrire_hackathon1` (`idhackathon`),
  ADD KEY `i_fk_inscrire_equipe1` (`idequipe`);

--
-- Index pour la table `MEMBRE`
--
ALTER TABLE `MEMBRE`
  ADD PRIMARY KEY (`idmembre`),
  ADD KEY `i_fk_membre_equipe1` (`idequipe`);

--
-- Index pour la table `ORGANISATEUR`
--
ALTER TABLE `ORGANISATEUR`
  ADD PRIMARY KEY (`idorganisateur`);

--
-- Index pour la table `TOKEN`
--
ALTER TABLE `TOKEN`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `i_fk_token_equipe1` (`idequipe`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `ADMINISTRATEUR`
--
ALTER TABLE `ADMINISTRATEUR`
  MODIFY `idadministrateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `EQUIPE`
--
ALTER TABLE `EQUIPE`
  MODIFY `idequipe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `HACKATHON`
--
ALTER TABLE `HACKATHON`
  MODIFY `idhackathon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `MEMBRE`
--
ALTER TABLE `MEMBRE`
  MODIFY `idmembre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `ORGANISATEUR`
--
ALTER TABLE `ORGANISATEUR`
  MODIFY `idorganisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `HACKATHON`
--
ALTER TABLE `HACKATHON`
  ADD CONSTRAINT `hackathon_ibfk_1` FOREIGN KEY (`idorganisateur`) REFERENCES `ORGANISATEUR` (`idorganisateur`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `INSCRIRE`
--
ALTER TABLE `INSCRIRE`
  ADD CONSTRAINT `inscrire_ibfk_1` FOREIGN KEY (`idhackathon`) REFERENCES `HACKATHON` (`idhackathon`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inscrire_ibfk_2` FOREIGN KEY (`idequipe`) REFERENCES `EQUIPE` (`idequipe`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `MEMBRE`
--
ALTER TABLE `MEMBRE`
  ADD CONSTRAINT `membre_ibfk_2` FOREIGN KEY (`idequipe`) REFERENCES `EQUIPE` (`idequipe`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `TOKEN`
--
ALTER TABLE `TOKEN`
  ADD CONSTRAINT `token_ibfk_1` FOREIGN KEY (`idequipe`) REFERENCES `EQUIPE` (`idequipe`) ON DELETE CASCADE ON UPDATE CASCADE;

