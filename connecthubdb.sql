-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 30 mai 2026 à 20:39
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
(1, 2),
(2, 1),
(5, 4),
(5, 6),
(6, 1);

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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `commentaires`
--

INSERT INTO `commentaires` (`ID`, `Publication_ID`, `Auteur_ID`, `Contenu`, `Date_Commentaire`) VALUES
(1, 4, 1, 'Bien joué !', '2026-05-29 16:14:16'),
(2, 13, 6, 'beau cul', '2026-05-30 15:35:27'),
(3, 13, 6, 'beau cul', '2026-05-30 15:35:27'),
(4, 13, 6, 'beau cul', '2026-05-30 15:35:27'),
(5, 13, 6, 'beau cul', '2026-05-30 15:35:27'),
(6, 6, 2, 'en vrai jss bien d\'accord', '2026-05-30 15:50:55');

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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `communautes`
--

INSERT INTO `communautes` (`ID`, `Nom`, `Description`, `Createur_ID`, `Date_Creation`) VALUES
(1, 'Street Workout & Calisthenics', 'Partage de routines, progressions sur les muscle-ups, front levers et conseils pour la prise de masse au poids du corps.', 1, '2026-05-25 15:24:29'),
(2, 'Marathon 2026', 'Groupe de motivation pour ceux qui préparent leur premier marathon. Partage de plans d\'entraînement et de parcours.', 1, '2026-05-25 15:24:29'),
(3, 'Street Workout France', 'Le repère pour partager vos routines, vos blocages sur les figures et parler hypertrophie au poids de corps.', 1, '2026-05-27 13:48:35'),
(4, 'Le repaire des Devs Web', 'React, PHP, SQL... On debug ensemble vos projets et vos requêtes récalcitrantes.', 1, '2026-05-27 13:48:35'),
(5, 'Les petits pains de france', 'la boulangerie est un patrimoine de la france', 1, '2026-05-29 13:44:04'),
(6, 'dealers de france ', 'un 10 balles ?', 6, '2026-05-30 15:42:35'),
(7, 'aled', 'aled', 2, '2026-05-30 16:07:43');

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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `discussions_communaute`
--

INSERT INTO `discussions_communaute` (`ID`, `Communaute_ID`, `Auteur_ID`, `Titre`, `Contenu`, `Score`, `Date_Creation`) VALUES
(1, 1, 1, 'Muscle-up strict : mes conseils de progression', 'Pour passer le muscle-up strict, arrêtez le kipping. Concentrez-vous d abord sur des tractions explosives au torse et des transitions aux anneaux. Vous validez ?', 15, '2026-05-27 15:48:35'),
(2, 1, 1, 'Programme push/pull/legs sans matériel ?', 'Hello, comment vous organisez votre PPL avec juste une barre de traction et des barres parallèles pour les dips ? Je cherche à prendre en masse.', 4, '2026-05-27 15:48:35'),
(3, 2, 1, 'Un useState qui boucle à l infini...', 'Aidez-moi s il vous plaît, j ai mis un tableau de dépendances vide dans mon useEffect mais ça re-render en boucle, je ne comprends plus rien !', 8, '2026-05-27 15:48:35'),
(4, 3, 2, 'Progresser aux bibs', 'Est-ce que vous avez des conseils pour progresser au dibs ?', 0, '2026-05-28 14:43:29'),
(5, 5, 1, 'en vrai la calvas de zemmour...', 'poulet ou pas ?', 0, '2026-05-29 15:48:03'),
(6, 5, 2, 'en vrai le petit cul d\'erwan ', 'poulet ou pas ? ', 0, '2026-05-29 15:49:30'),
(7, 5, 2, 'en vraaaaai', 'le pain', 0, '2026-05-29 15:59:13');

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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `evenements`
--

INSERT INTO `evenements` (`ID`, `Titre`, `Description`, `Date_Evenement`, `Lieu`, `Createur_ID`, `Date_Creation`) VALUES
(1, 'Rassemblement Street Workout', 'Grosse session freestyle au parc. Débutants acceptés, ramenez votre magnésie et votre motivation ! 💪', '2026-06-15 14:00:00', 'Parc de la Villette, Paris', 1, '2026-05-25 20:41:45'),
(2, 'BabyFoot', 'Tournois à double élimination.', '2000-02-10 12:00:00', 'Café de la plage', 0, '2026-05-28 12:47:54'),
(3, 'Initiation au Muscle-Up', 'Atelier dédié à la technique du muscle-up strict. Apprenez la fausse prise et la transition. Débutants ayant déjà 10 tractions acceptés !', '2026-06-10 14:00:00', 'Parc de la Villette, Paris', 2, '2026-05-28 20:41:19'),
(4, 'Run 15km - Allure Souple', 'Sortie longue du dimanche pour préparer la saison. Allure visée autour de 5:30/km. Pensez à prendre de l\'eau.', '2026-06-05 09:30:00', 'Bois de Vincennes, Paris', 3, '2026-05-28 20:41:19'),
(5, 'Compétition Street Lifting (Amicale)', 'Rencontre amicale autour du 1RM en tractions et dips lestés. Inscription gratuite sur place, pesée à 9h tapantes.', '2026-07-20 10:00:00', 'Salle associative, Lyon', 1, '2026-05-28 20:41:19'),
(6, 'Session Mobilité & Étirements', 'Séance de récupération active de 45 minutes axée sur la souplesse des épaules (overhead) et l\'ouverture des hanches.', '2026-06-18 18:30:00', 'Quais de Seine (côté Louvre)', 2, '2026-05-28 20:41:19'),
(7, 'Entraînement Front Lever', 'Travail spécifique sur le Front Lever : tuck, adv tuck, straddle et full. Élastiques fournis, mais ramenez de la magnésie.', '2026-06-25 17:00:00', 'Parc de la Tête d\'Or, Lyon', 1, '2026-05-28 20:41:19');

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
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `likes`
--

INSERT INTO `likes` (`ID`, `Publication_ID`, `Utilisateur_ID`, `Date_Like`) VALUES
(3, 1, 1, '2026-05-25 15:01:55'),
(9, 2, 2, '2026-05-28 12:46:46'),
(6, 2, 1, '2026-05-26 19:50:47'),
(11, 10, 2, '2026-05-29 13:34:26'),
(32, 13, 6, '2026-05-30 15:41:25'),
(31, 12, 6, '2026-05-30 15:41:22'),
(33, 15, 5, '2026-05-30 16:02:55'),
(34, 13, 5, '2026-05-30 16:02:56');

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
(6, 5, 'Moderateur', 'Accepte', '2026-05-30 17:49:07'),
(1, 1, 'Moderateur', 'Accepte', '2026-05-27 21:30:49'),
(1, 2, 'Moderateur', 'Accepte', '2026-05-27 21:30:49'),
(1, 3, 'Moderateur', 'Accepte', '2026-05-27 21:30:49'),
(1, 4, 'Moderateur', 'Accepte', '2026-05-27 21:30:49'),
(2, 2, 'Membre', 'En_Attente', '2026-05-28 14:42:36'),
(6, 4, 'Membre', 'En_Attente', '2026-05-30 17:49:05'),
(2, 5, 'Membre', 'Accepte', '2026-05-29 15:46:56'),
(2, 7, 'Moderateur', 'Accepte', '2026-05-30 18:07:43');

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
(1, 2),
(2, 4),
(2, 5),
(2, 6),
(3, 2),
(3, 4),
(3, 5),
(3, 6),
(4, 2),
(4, 4),
(4, 5),
(4, 6);

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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `messages_evenements`
--

INSERT INTO `messages_evenements` (`ID`, `Evenement_ID`, `Expediteur_ID`, `Contenu`, `Date_Envoi`) VALUES
(1, 1, 2, 'comment ils vont les gars', '2026-05-29 16:03:49');

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
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(12, 2, 1, '\n\n--- Performance partagée ---\nDe : Sophie D.\n&quot;Nouvelle progression aux dips aujourd&#039;hui ! L&#039;objectif d&#039;hypertrophie commence vraiment à payer, la prise de masse est propre. Je vise les +20kg lests le mois prochain. 💪&quot;\n--------------------------', '2026-05-27 20:59:07', 'En_Attente'),
(13, 1, 2, 'Salut Sophie ! J\'ai vu ta dernière vidéo sur le Muscle-Up, c\'est super propre ! Tu as mis combien de temps à le passer ?', '2026-05-26 13:38:11', 'Accepte'),
(14, 2, 1, 'Coucou Thomas ! Merci beaucoup 💪 Ça m\'a pris environ 3 mois d\'entraînement spécifique, surtout avec des tractions explosives et des dips.', '2026-05-26 14:38:11', 'Accepte'),
(15, 1, 2, 'Ah ouais, c\'est du solide. J\'essaie de l\'intégrer dans mon programme Full Body en ce moment, mais la transition au-dessus de la barre me bloque toujours...', '2026-05-26 16:38:11', 'Accepte'),
(16, 2, 1, 'C\'est normal, c\'est la partie la plus technique ! Essaie d\'utiliser une bande élastique au début pour bien comprendre le timing et l\'engagement du bassin.', '2026-05-27 13:38:11', 'Accepte'),
(17, 2, 1, 'Je peux te montrer la technique de bascule demain si tu vas t\'entraîner ?', '2026-05-27 14:38:11', 'Accepte'),
(18, 1, 2, 'Carrément, ça m\'aiderait énormément ! Je serai au parc de street workout vers 18h aujourd\'hui.', '2026-05-28 10:38:11', 'Accepte'),
(19, 2, 1, 'Parfait, on se dit à 18h là-bas alors ! Garde de l\'énergie pour la séance 🚀', '2026-05-28 11:38:11', 'Accepte'),
(20, 1, 2, 'C\'est noté, à toute ! 🔥', '2026-05-28 12:38:11', 'Accepte'),
(21, 1, 2, '\n\n--- Performance partagée ---\nDe : Sophie D.\n&quot;ta grand mère la chouin : \r\nhttps://www.youtube.com/watch?v=MuoK7Q0Txj4&quot;\n--------------------------', '2026-05-29 13:40:33', 'Accepte'),
(22, 2, 1, 'je t&#039;aime', '2026-05-29 14:03:59', 'Accepte'),
(23, 2, 1, 't&#039;as', '2026-05-29 14:04:11', 'Accepte'),
(24, 6, 4, '\n\n--- Performance partagée ---\nDe : Sophie D.\n&quot;ta grand mère la chouin : \r\nhttps://www.youtube.com/watch?v=MuoK7Q0Txj4&quot;\n--------------------------', '2026-05-30 15:38:33', 'En_Attente'),
(25, 2, 6, 'comment il va &#039;&quot;(', '2026-05-30 15:52:25', 'En_Attente');

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
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `messages_salons`
--

INSERT INTO `messages_salons` (`ID`, `Salon_ID`, `Expediteur_ID`, `Contenu`, `Date_Envoi`) VALUES
(1, 1, 2, 'hello', '2026-05-27 23:04:57'),
(2, 1, 2, 'Je voulais qui est dispo dimanche pro pour aller courir un peu', '2026-05-28 14:45:42'),
(3, 1, 2, 'jrjeje', '2026-05-29 16:03:54'),
(4, 2, 5, 'aaaaa', '2026-05-29 20:26:10'),
(5, 2, 5, 'pas cool ', '2026-05-29 20:31:48'),
(6, 2, 5, 'raoul', '2026-05-29 20:31:50'),
(7, 2, 6, 'babababa', '2026-05-29 20:32:11'),
(8, 1, 2, 'alors ? ', '2026-05-30 17:53:02'),
(9, 1, 2, 'ça met des vus heinnnn', '2026-05-30 17:53:07'),
(10, 3, 2, 'ok les gars', '2026-05-30 17:58:08'),
(11, 4, 2, 'ouais', '2026-05-30 18:00:19'),
(12, 4, 5, 'ok en bien', '2026-05-30 18:00:37');

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
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `notifications`
--

INSERT INTO `notifications` (`ID`, `Utilisateur_ID`, `Acteur_ID`, `Type_Action`, `Cible_ID`, `Lu`, `Date_Notification`) VALUES
(3, 1, 2, 'Like', 2, 1, '2026-05-28 12:46:45'),
(4, 1, 2, 'Like', 2, 1, '2026-05-28 12:46:46'),
(5, 1, 2, 'Like', 3, 1, '2026-05-28 12:46:47'),
(27, 1, 6, 'Like', 13, 1, '2026-05-30 15:36:53'),
(25, 6, 5, 'Abonnement', NULL, 0, '2026-05-29 18:20:47'),
(9, 1, 2, 'Abonnement', NULL, 1, '2026-05-28 22:06:24'),
(10, 1, 2, 'Abonnement', NULL, 1, '2026-05-28 22:06:24'),
(28, 1, 6, 'Like', 12, 1, '2026-05-30 15:37:21'),
(29, 1, 6, 'Like', 12, 1, '2026-05-30 15:37:22'),
(30, 1, 6, 'Like', 13, 1, '2026-05-30 15:37:26'),
(15, 1, 2, 'Abonnement', NULL, 1, '2026-05-29 11:57:19'),
(16, 1, 2, 'Abonnement', NULL, 1, '2026-05-29 11:57:20'),
(17, 1, 2, 'Abonnement', NULL, 1, '2026-05-29 12:02:16'),
(18, 1, 2, 'Abonnement', NULL, 1, '2026-05-29 12:02:20'),
(19, 1, 2, 'Abonnement', NULL, 1, '2026-05-29 12:02:23'),
(20, 1, 2, 'Abonnement', NULL, 1, '2026-05-29 12:02:29'),
(21, 1, 2, 'Like', 10, 1, '2026-05-29 13:34:26'),
(22, 1, 2, 'Abonnement', NULL, 1, '2026-05-29 13:35:40'),
(26, 4, 5, 'Abonnement', NULL, 0, '2026-05-29 18:20:54'),
(23, 4, 6, 'Abonnement', NULL, 0, '2026-05-29 18:07:11'),
(50, 6, 5, 'Like', 15, 0, '2026-05-30 16:02:55'),
(31, 1, 6, 'Like', 12, 1, '2026-05-30 15:37:28'),
(32, 1, 6, 'Like', 13, 1, '2026-05-30 15:37:30'),
(33, 1, 6, 'Like', 12, 1, '2026-05-30 15:37:33'),
(34, 1, 6, 'Like', 12, 1, '2026-05-30 15:37:36'),
(35, 1, 6, 'Like', 12, 1, '2026-05-30 15:37:41'),
(36, 1, 6, 'Like', 12, 1, '2026-05-30 15:37:44'),
(37, 1, 6, 'Like', 13, 1, '2026-05-30 15:37:53'),
(38, 1, 6, 'Like', 13, 1, '2026-05-30 15:37:59'),
(39, 1, 6, 'Like', 13, 1, '2026-05-30 15:38:05'),
(40, 1, 6, 'Like', 12, 1, '2026-05-30 15:38:08'),
(41, 1, 6, 'Like', 12, 1, '2026-05-30 15:38:09'),
(43, 1, 6, 'Abonnement', NULL, 1, '2026-05-30 15:38:57'),
(44, 1, 6, 'Abonnement', NULL, 1, '2026-05-30 15:38:59');

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
  `Est_Epingle` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `Auteur_ID` (`Auteur_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `publications`
--

INSERT INTO `publications` (`ID`, `Auteur_ID`, `Contenu`, `Media_URL`, `Date_Publication`, `Est_Epingle`) VALUES
(13, 1, 'ta grand mère la chouin : \r\nhttps://www.youtube.com/watch?v=MuoK7Q0Txj4', NULL, '2026-05-29 14:14:14', 0),
(15, 6, 'énorme sauciflard', NULL, '2026-05-30 15:34:03', 0),
(3, 1, '10km validés ce matin sous la pluie 🌧️ Rien de tel pour forger le mental !', NULL, '2026-05-25 15:14:27', 0),
(16, 2, 'énorme sauciflard', NULL, '2026-05-30 16:06:22', 0),
(17, 2, 'énorme sauciflard', NULL, '2026-05-30 16:06:36', 0),
(5, 2, 'Séance Full Body aujourd\'hui ! Focus sur les tractions, les dips et relevés de jambes. N\'oubliez pas de bien vous échauffer les épaules avant de charger sur les anneaux. 🔥', 'uploads/sophie_fullbody.jpg', '2026-05-25 17:45:29', 1),
(6, 2, 'Petite session stretching et mobilité au parc. C\'est essentiel pour la récupération et pour éviter les blessures après une grosse semaine d\'entraînement en force. 🌳🧘‍♀️', 'uploads/sophie_stretching.jpg', '2026-05-23 17:45:29', 0),
(7, 2, 'Test d\'équilibre du jour : le Handstand ! Ça commence enfin à tenir plus de 10 secondes sans le mur. La persévérance et le gainage finissent toujours par payer 🤸‍♀️', 'uploads/sophie_handstand.mp4', '2026-05-21 17:45:29', 0),
(8, 2, 'Rien de tel qu\'une grosse séance de street workout pour bien terminer la semaine. La régularité, c\'est la clé de la progression !', NULL, '2026-05-18 17:45:29', 1),
(10, 1, 'runnign', 'uploads/media_6a188aba3288c.jpg', '2026-05-28 18:34:34', 0),
(12, 1, 'ta grand mère la chouin : \r\nhttps://www.youtube.com/watch?v=MuoK7Q0Txj4', NULL, '2026-05-29 13:39:11', 0);

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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `salons_prives`
--

INSERT INTO `salons_prives` (`ID`, `Nom`, `Createur_ID`) VALUES
(1, 'Running dimanche ', 2),
(2, 'aaaa', 5),
(3, 'le chienneté', 2),
(4, 'nojaer', 2);

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `signalements`
--

INSERT INTO `signalements` (`ID`, `Publication_ID`, `Signaleur_ID`, `Motif`, `Statut`, `Date_Signalement`, `Utilisateur_Cible_ID`) VALUES
(1, 2, 2, 'Racisme', 'En_Attente', '2026-05-27 13:56:59', NULL),
(2, 4, 1, 'trop gros biceps', 'En_Attente', '2026-05-30 16:05:05', NULL);

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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`ID`, `Nom`, `Email`, `MotDePasse`, `Role`, `Created_at`, `Photo_Profil`) VALUES
(2, 'Thomas', 'thomas@sport.com', '$2y$10$MDEFUIF2kzVPZG3QitruM./esxmbCE6ru0jz7GNb8daZZsZ/aNy/m', 'Moderateur', '2026-05-25 16:24:02', NULL),
(1, 'Sophie D.', 'sophie@connecthub.com', '$2y$10$FAA.5f5ztibNvcsdy987mOGZPmBBq5z6wbNR17RJ3ShI56aDAqTkC', 'Membre', '2026-05-25 17:06:27', NULL),
(4, 'Noe', 'noe@connecthub.com', '$2y$10$AIk1iqVf3rqC82pri9WTCO01B2S.fAi3xwluIAZy6LY6mADBgzYCW', 'Membre', '2026-05-29 18:05:38', NULL),
(5, 'Jade', 'jade@connecthub.com', '$2y$10$wr864q2OEuHApDNUEs7Qru5Jwyf2lKufatcYySiKdl4m2sQEv5chK', 'Membre', '2026-05-29 18:06:12', NULL),
(6, 'Erwann', 'erwan@connecthub.com', '$2y$10$I8Dk5xZ4fPQPc7.rDRkJE.d29w3ExOo6RapQ3h/3kHbXPQT0Zi1eS', 'Membre', '2026-05-29 18:06:39', NULL);

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

--
-- Déchargement des données de la table `votes_discussions`
--

INSERT INTO `votes_discussions` (`Utilisateur_ID`, `Discussion_ID`, `Valeur`) VALUES
(2, 5, 1),
(2, 6, -1),
(2, 7, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
