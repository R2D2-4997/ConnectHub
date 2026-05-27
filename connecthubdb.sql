-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 27 mai 2026 à 21:31
-- Version du serveur : 8.4.7
-- Version de PHP : 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `connecthubdb`
--

-- --------------------------------------------------------

--
-- Structure de la table `abonnements`
--

DROP TABLE IF EXISTS `abonnements`;
CREATE TABLE IF NOT EXISTS `abonnements` (
  `Suiveur_ID` int NOT NULL,
  `Suivi_ID` int NOT NULL,
  PRIMARY KEY (`Suiveur_ID`,`Suivi_ID`),
  KEY `Suivi_ID` (`Suivi_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `abonnements`
--

INSERT INTO `abonnements` (`Suiveur_ID`, `Suivi_ID`) VALUES
(2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

DROP TABLE IF EXISTS `commentaires`;
CREATE TABLE IF NOT EXISTS `commentaires` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Publication_ID` int NOT NULL,
  `Auteur_ID` int NOT NULL,
  `Contenu` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Date_Commentaire` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  KEY `Publication_ID` (`Publication_ID`),
  KEY `Auteur_ID` (`Auteur_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `communautes`
--

DROP TABLE IF EXISTS `communautes`;
CREATE TABLE IF NOT EXISTS `communautes` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Description` text COLLATE utf8mb4_unicode_ci,
  `Createur_ID` int NOT NULL,
  `Date_Creation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  KEY `Createur_ID` (`Createur_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `communautes`
--

INSERT INTO `communautes` (`ID`, `Nom`, `Description`, `Createur_ID`, `Date_Creation`) VALUES
(1, 'Street Workout & Calisthenics', 'Partage de routines, progressions sur les muscle-ups, front levers et conseils pour la prise de masse au poids du corps.', 1, '2026-05-25 15:24:29'),
(2, 'Marathon 2026', 'Groupe de motivation pour ceux qui préparent leur premier marathon. Partage de plans d\'entraînement et de parcours.', 1, '2026-05-25 15:24:29'),
(3, 'Street Workout France', 'Le repère pour partager vos routines, vos blocages sur les figures et parler hypertrophie au poids de corps.', 1, '2026-05-27 13:48:35'),
(4, 'Le repaire des Devs Web', 'React, PHP, SQL... On debug ensemble vos projets et vos requêtes récalcitrantes.', 1, '2026-05-27 13:48:35');

-- --------------------------------------------------------

--
-- Structure de la table `discussions_communaute`
--

DROP TABLE IF EXISTS `discussions_communaute`;
CREATE TABLE IF NOT EXISTS `discussions_communaute` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Communaute_ID` int NOT NULL,
  `Auteur_ID` int NOT NULL,
  `Titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Contenu` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Score` int DEFAULT '0',
  `Date_Creation` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  KEY `Communaute_ID` (`Communaute_ID`),
  KEY `Auteur_ID` (`Auteur_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `discussions_communaute`
--

INSERT INTO `discussions_communaute` (`ID`, `Communaute_ID`, `Auteur_ID`, `Titre`, `Contenu`, `Score`, `Date_Creation`) VALUES
(1, 1, 1, 'Muscle-up strict : mes conseils de progression', 'Pour passer le muscle-up strict, arrêtez le kipping. Concentrez-vous d abord sur des tractions explosives au torse et des transitions aux anneaux. Vous validez ?', 15, '2026-05-27 15:48:35'),
(2, 1, 1, 'Programme push/pull/legs sans matériel ?', 'Hello, comment vous organisez votre PPL avec juste une barre de traction et des barres parallèles pour les dips ? Je cherche à prendre en masse.', 4, '2026-05-27 15:48:35'),
(3, 2, 1, 'Un useState qui boucle à l infini...', 'Aidez-moi s il vous plaît, j ai mis un tableau de dépendances vide dans mon useEffect mais ça re-render en boucle, je ne comprends plus rien !', 8, '2026-05-27 15:48:35');

-- --------------------------------------------------------

--
-- Structure de la table `evenements`
--

DROP TABLE IF EXISTS `evenements`;
CREATE TABLE IF NOT EXISTS `evenements` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Titre` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Description` text COLLATE utf8mb4_unicode_ci,
  `Date_Evenement` datetime NOT NULL,
  `Lieu` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Createur_ID` int NOT NULL,
  `Date_Creation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  KEY `Createur_ID` (`Createur_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `evenements`
--

INSERT INTO `evenements` (`ID`, `Titre`, `Description`, `Date_Evenement`, `Lieu`, `Createur_ID`, `Date_Creation`) VALUES
(1, 'Rassemblement Street Workout', 'Grosse session freestyle au parc. Débutants acceptés, ramenez votre magnésie et votre motivation ! 💪', '2026-06-15 14:00:00', 'Parc de la Villette, Paris', 1, '2026-05-25 20:41:45');

-- --------------------------------------------------------

--
-- Structure de la table `likes`
--

DROP TABLE IF EXISTS `likes`;
CREATE TABLE IF NOT EXISTS `likes` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Publication_ID` int NOT NULL,
  `Utilisateur_ID` int NOT NULL,
  `Date_Like` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `unique_like` (`Publication_ID`,`Utilisateur_ID`),
  KEY `Utilisateur_ID` (`Utilisateur_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `likes`
--

INSERT INTO `likes` (`ID`, `Publication_ID`, `Utilisateur_ID`, `Date_Like`) VALUES
(3, 1, 1, '2026-05-25 15:01:55'),
(4, 2, 2, '2026-05-26 16:45:35'),
(6, 2, 1, '2026-05-26 19:50:47'),
(7, 3, 2, '2026-05-27 21:10:36');

-- --------------------------------------------------------

--
-- Structure de la table `membres_communautes`
--

DROP TABLE IF EXISTS `membres_communautes`;
CREATE TABLE IF NOT EXISTS `membres_communautes` (
  `Utilisateur_ID` int NOT NULL,
  `Communaute_ID` int NOT NULL,
  `Role_Communaute` enum('Membre','Moderateur') COLLATE utf8mb4_unicode_ci DEFAULT 'Membre',
  `Statut` enum('En_Attente','Accepte') COLLATE utf8mb4_unicode_ci DEFAULT 'En_Attente',
  `Date_Demande` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Utilisateur_ID`,`Communaute_ID`),
  KEY `Communaute_ID` (`Communaute_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `membres_communautes`
--

INSERT INTO `membres_communautes` (`Utilisateur_ID`, `Communaute_ID`, `Role_Communaute`, `Statut`, `Date_Demande`) VALUES
(2, 3, 'Membre', 'Accepte', '2026-05-27 17:02:19'),
(1, 1, 'Moderateur', 'Accepte', '2026-05-27 21:30:49'),
(1, 2, 'Moderateur', 'Accepte', '2026-05-27 21:30:49'),
(1, 3, 'Moderateur', 'Accepte', '2026-05-27 21:30:49'),
(1, 4, 'Moderateur', 'Accepte', '2026-05-27 21:30:49');

-- --------------------------------------------------------

--
-- Structure de la table `membres_salons`
--

DROP TABLE IF EXISTS `membres_salons`;
CREATE TABLE IF NOT EXISTS `membres_salons` (
  `Salon_ID` int NOT NULL,
  `Utilisateur_ID` int NOT NULL,
  PRIMARY KEY (`Salon_ID`,`Utilisateur_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `membres_salons`
--

INSERT INTO `membres_salons` (`Salon_ID`, `Utilisateur_ID`) VALUES
(1, 1),
(1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `messages_evenements`
--

DROP TABLE IF EXISTS `messages_evenements`;
CREATE TABLE IF NOT EXISTS `messages_evenements` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Evenement_ID` int NOT NULL,
  `Expediteur_ID` int NOT NULL,
  `Contenu` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Date_Envoi` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  KEY `Evenement_ID` (`Evenement_ID`),
  KEY `Expediteur_ID` (`Expediteur_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `messages_prives`
--

DROP TABLE IF EXISTS `messages_prives`;
CREATE TABLE IF NOT EXISTS `messages_prives` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Expediteur_ID` int NOT NULL,
  `Destinataire_ID` int NOT NULL,
  `Contenu` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Date_Envoi` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `Statut` enum('Accepte','En_Attente') COLLATE utf8mb4_unicode_ci DEFAULT 'Accepte',
  PRIMARY KEY (`ID`),
  KEY `Expediteur_ID` (`Expediteur_ID`),
  KEY `Destinataire_ID` (`Destinataire_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `messages_prives`
--

INSERT INTO `messages_prives` (`ID`, `Expediteur_ID`, `Destinataire_ID`, `Contenu`, `Date_Envoi`, `Statut`) VALUES
(1, 2, 1, 'Viens ce soir 19h', '2026-05-25 16:59:46', 'Accepte'),
(2, 3, 2, 'bonjour tomas', '2026-05-25 17:06:41', 'Accepte'),
(3, 2, 3, 'Salut beuaté ', '2026-05-25 17:24:18', 'Accepte'),
(4, 2, 1, 'flemme', '2026-05-25 21:25:48', 'Accepte'),
(5, 1, 2, 'aller stp', '2026-05-25 21:40:14', 'Accepte'),
(6, 2, 1, 'fait pas ta radine', '2026-05-25 21:40:31', 'Accepte'),
(7, 1, 2, 'kkkk', '2026-05-25 21:41:21', 'Accepte'),
(8, 1, 2, 'uhub', '2026-05-25 21:41:23', 'Accepte'),
(9, 1, 2, 'beagyu', '2026-05-25 21:41:24', 'Accepte'),
(10, 1, 2, 'byujbahje', '2026-05-25 21:41:25', 'Accepte'),
(11, 2, 1, 'coucou', '2026-05-25 21:54:08', 'En_Attente'),
(12, 2, 1, '\n\n--- Performance partagée ---\nDe : Sophie D.\n&quot;Nouvelle progression aux dips aujourd&#039;hui ! L&#039;objectif d&#039;hypertrophie commence vraiment à payer, la prise de masse est propre. Je vise les +20kg lests le mois prochain. 💪&quot;\n--------------------------', '2026-05-27 20:59:07', 'En_Attente');

-- --------------------------------------------------------

--
-- Structure de la table `messages_salons`
--

DROP TABLE IF EXISTS `messages_salons`;
CREATE TABLE IF NOT EXISTS `messages_salons` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Salon_ID` int NOT NULL,
  `Expediteur_ID` int NOT NULL,
  `Contenu` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Date_Envoi` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `messages_salons`
--

INSERT INTO `messages_salons` (`ID`, `Salon_ID`, `Expediteur_ID`, `Contenu`, `Date_Envoi`) VALUES
(1, 1, 2, 'hello', '2026-05-27 23:04:57');

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Utilisateur_ID` int NOT NULL,
  `Acteur_ID` int NOT NULL,
  `Type_Action` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Cible_ID` int DEFAULT NULL,
  `Lu` tinyint(1) DEFAULT '0',
  `Date_Notification` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  KEY `Utilisateur_ID` (`Utilisateur_ID`),
  KEY `Acteur_ID` (`Acteur_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `participants_evenements`
--

DROP TABLE IF EXISTS `participants_evenements`;
CREATE TABLE IF NOT EXISTS `participants_evenements` (
  `Evenement_ID` int NOT NULL,
  `Utilisateur_ID` int NOT NULL,
  PRIMARY KEY (`Evenement_ID`,`Utilisateur_ID`),
  KEY `Utilisateur_ID` (`Utilisateur_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `participants_evenements`
--

INSERT INTO `participants_evenements` (`Evenement_ID`, `Utilisateur_ID`) VALUES
(1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `publications`
--

DROP TABLE IF EXISTS `publications`;
CREATE TABLE IF NOT EXISTS `publications` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Auteur_ID` int NOT NULL,
  `Contenu` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Media_URL` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Date_Publication` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  KEY `Auteur_ID` (`Auteur_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `publications`
--

INSERT INTO `publications` (`ID`, `Auteur_ID`, `Contenu`, `Media_URL`, `Date_Publication`) VALUES
(2, 1, 'Nouvelle progression aux dips aujourd\'hui ! L\'objectif d\'hypertrophie commence vraiment à payer, la prise de masse est propre. Je vise les +20kg lests le mois prochain. 💪', NULL, '2026-05-25 15:14:27'),
(3, 1, '10km validés ce matin sous la pluie 🌧️ Rien de tel pour forger le mental !', NULL, '2026-05-25 15:14:27');

-- --------------------------------------------------------

--
-- Structure de la table `salons_prives`
--

DROP TABLE IF EXISTS `salons_prives`;
CREATE TABLE IF NOT EXISTS `salons_prives` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Createur_ID` int NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `salons_prives`
--

INSERT INTO `salons_prives` (`ID`, `Nom`, `Createur_ID`) VALUES
(1, 'Running dimanche ', 2);

-- --------------------------------------------------------

--
-- Structure de la table `signalements`
--

DROP TABLE IF EXISTS `signalements`;
CREATE TABLE IF NOT EXISTS `signalements` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Publication_ID` int DEFAULT NULL,
  `Signaleur_ID` int NOT NULL,
  `Motif` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Statut` enum('En_Attente','Approuve','Rejete') COLLATE utf8mb4_unicode_ci DEFAULT 'En_Attente',
  `Date_Signalement` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `Utilisateur_Cible_ID` int DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `Publication_ID` (`Publication_ID`),
  KEY `Signaleur_ID` (`Signaleur_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `signalements`
--

INSERT INTO `signalements` (`ID`, `Publication_ID`, `Signaleur_ID`, `Motif`, `Statut`, `Date_Signalement`, `Utilisateur_Cible_ID`) VALUES
(1, 2, 2, 'Racisme', 'En_Attente', '2026-05-27 13:56:59', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `MotDePasse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Role` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'Membre',
  `Created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `Photo_Profil` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`ID`, `Nom`, `Email`, `MotDePasse`, `Role`, `Created_at`, `Photo_Profil`) VALUES
(2, 'Thomas', 'thomas@sport.com', '$2y$10$MDEFUIF2kzVPZG3QitruM./esxmbCE6ru0jz7GNb8daZZsZ/aNy/m', 'Moderateur', '2026-05-25 16:24:02', NULL),
(1, 'Sophie D.', 'sophie@connecthub.com', '$2y$10$FAA.5f5ztibNvcsdy987mOGZPmBBq5z6wbNR17RJ3ShI56aDAqTkC', 'Membre', '2026-05-25 17:06:27', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `votes_discussions`
--

DROP TABLE IF EXISTS `votes_discussions`;
CREATE TABLE IF NOT EXISTS `votes_discussions` (
  `Utilisateur_ID` int NOT NULL,
  `Discussion_ID` int NOT NULL,
  `Valeur` int NOT NULL,
  PRIMARY KEY (`Utilisateur_ID`,`Discussion_ID`),
  KEY `Discussion_ID` (`Discussion_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
