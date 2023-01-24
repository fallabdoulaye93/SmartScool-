-- phpMyAdmin SQL Dump
-- version 4.9.6
-- https://www.phpmyadmin.net/
--
-- Hôte : h2mysql11
-- Généré le :  jeu. 07 jan. 2021 à 12:43
-- Version du serveur :  5.6.49-log
-- Version de PHP :  7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `fhbs_samaecolelabscom230`
--

-- --------------------------------------------------------

--
-- Structure de la table `ACTION`
--

CREATE TABLE `ACTION` (
  `idAction` int(11) NOT NULL,
  `label` varchar(250) NOT NULL,
  `module` int(11) NOT NULL,
  `idEtablissement` int(11) NOT NULL,
  `dateCreation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `userCreation` int(11) NOT NULL,
  `dateModification` datetime NOT NULL,
  `userModification` int(11) NOT NULL,
  `etat` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ACTION`
--

INSERT INTO `ACTION` (`idAction`, `label`, `module`, `idEtablissement`, `dateCreation`, `userCreation`, `dateModification`, `userModification`, `etat`) VALUES
(1, 'Gestion profil', 8, 3, '2016-03-24 10:08:09', 1, '2016-03-24 03:11:11', 1, 1),
(2, 'Gestion utilisateur', 8, 3, '2016-03-24 10:14:04', 1, '2016-03-24 03:11:11', 1, 1),
(3, 'Information etablissement', 8, 3, '2016-04-19 15:29:39', 1, '2016-03-24 03:11:11', 1, 1),
(4, 'Gestion des filieres', 8, 3, '2016-03-24 10:14:04', 1, '2016-03-24 03:11:11', 1, 1),
(5, 'Gestion des modules', 8, 3, '2016-03-24 10:14:04', 1, '2016-03-24 03:11:11', 1, 1),
(6, 'Gestion des unites d\'enseignement', 8, 3, '2016-03-24 10:14:04', 1, '2016-03-24 03:11:11', 1, 1),
(7, 'Gestion des frais d\'inscription', 8, 3, '2016-03-24 10:14:04', 1, '2016-03-24 03:11:11', 1, 1),
(8, 'Gestion des salles de cours', 8, 3, '2016-03-24 10:14:04', 1, '2016-03-24 03:11:11', 1, 1),
(9, 'Gestion des vacances', 8, 3, '2016-03-24 10:14:04', 1, '2016-03-24 03:11:11', 1, 1),
(10, 'Reglement interieur de l\'ecole', 8, 3, '2016-03-24 10:14:04', 1, '2016-03-24 03:11:11', 1, 1),
(11, 'Gestion des annees scolaires', 8, 3, '2016-03-24 10:14:04', 1, '2016-03-24 03:11:11', 1, 1),
(12, 'Gestion des periodes scolaires', 8, 3, '2016-03-24 10:14:04', 1, '2016-03-24 03:11:11', 1, 1),
(13, 'Historique des sanctions', 7, 3, '2016-03-24 09:08:09', 1, '2016-03-24 03:11:11', 1, 1),
(14, 'Categorie équipement', 6, 3, '2016-03-24 09:08:09', 1, '2016-03-24 03:11:11', 1, 1),
(15, 'Inventaire équipement', 6, 3, '2016-03-24 09:14:04', 1, '2016-03-24 03:11:11', 1, 1),
(16, 'Sortie équipement', 6, 3, '2016-03-24 09:14:04', 1, '2016-03-24 03:11:11', 1, 1),
(17, 'Type de documents', 5, 3, '2016-03-24 09:08:09', 1, '2016-03-24 03:11:11', 1, 1),
(18, 'Liste de documents', 5, 3, '2016-03-24 09:14:04', 1, '2016-03-24 03:11:11', 1, 1),
(19, 'Type de controle', 4, 3, '2016-03-24 09:08:09', 1, '2016-03-24 03:11:11', 1, 1),
(20, 'Gestion controle', 4, 3, '2016-03-24 09:14:04', 1, '2016-03-24 03:11:11', 1, 1),
(21, 'Bulletin de notes', 4, 3, '2016-03-24 09:14:04', 1, '2016-03-24 03:11:11', 1, 1),
(22, 'Emplois du temps', 3, 3, '2016-03-24 09:08:09', 1, '2016-03-24 03:11:11', 1, 1),
(23, 'Mise à jour des cours', 3, 3, '2016-03-24 09:14:04', 1, '2016-03-24 03:11:11', 1, 1),
(24, 'Liste des factures', 2, 3, '2016-03-24 09:08:09', 1, '2016-03-24 03:11:11', 1, 1),
(25, 'Génération de factures', 2, 3, '2016-03-24 09:14:04', 1, '2016-03-24 03:11:11', 1, 1),
(26, 'Mensualités', 2, 3, '2016-03-24 09:14:04', 1, '2016-03-24 03:11:11', 1, 1),
(27, 'Modifier mensualites', 2, 3, '2016-04-28 09:27:39', 1, '2016-03-24 03:11:11', 1, 1),
(28, 'Réglement mensualité', 2, 3, '2016-03-24 09:14:04', 1, '2016-03-24 03:11:11', 1, 1),
(29, 'Paiement des professeurs', 2, 3, '2016-03-24 09:14:04', 1, '2016-03-24 03:11:11', 1, 1),
(30, 'Prévision Budgetaire', 2, 3, '2016-03-24 09:14:04', 1, '2016-03-24 03:11:11', 1, 1),
(31, 'Situation financière', 2, 3, '2016-03-24 09:14:04', 1, '2016-03-24 03:11:11', 1, 1),
(32, 'Historique journalier', 2, 3, '2016-03-24 09:14:04', 1, '2016-03-24 03:11:11', 1, 1),
(33, 'Paiement du personnel', 2, 3, '2016-03-24 09:14:04', 1, '2016-03-24 03:11:11', 1, 1),
(34, 'Dépenses', 2, 3, '2016-03-24 09:14:04', 1, '2016-03-24 03:11:11', 1, 1),
(35, 'Liste des individus', 1, 3, '2016-03-24 09:08:09', 1, '2016-03-24 03:11:11', 1, 1),
(36, 'Inscriptions', 1, 3, '2016-03-24 09:14:04', 1, '2016-03-24 03:11:11', 1, 1),
(37, 'Historique des inscriptions', 1, 3, '2016-03-24 09:14:04', 1, '2016-03-24 03:11:11', 1, 1),
(38, 'Liste des étudiants', 1, 3, '2016-03-24 09:14:04', 1, '2016-03-24 03:11:11', 1, 1),
(39, 'Liste des étudiants par classe', 1, 3, '2016-03-24 09:14:04', 1, '2016-03-24 03:11:11', 1, 1),
(40, 'Liste des professeurs', 1, 3, '2016-03-24 09:14:04', 1, '2016-03-24 03:11:11', 1, 1),
(41, 'Liste des professeurs recrutés', 1, 3, '2016-03-24 09:14:04', 1, '2016-03-24 03:11:11', 1, 1),
(42, 'Personnels administratifs', 1, 3, '2016-03-24 09:14:04', 1, '2016-03-24 03:11:11', 1, 1),
(43, 'Liste des tuteurs', 1, 3, '2016-03-24 09:14:04', 1, '2016-03-24 03:11:11', 1, 1),
(44, 'Impression', 1, 3, '2016-03-24 09:14:04', 1, '2016-03-24 03:11:11', 1, 1),
(45, 'Ajouter une nouvelle sanction', 7, 3, '2016-04-28 10:49:21', 1, '2016-04-28 00:00:00', 1, 1),
(46, 'Supprimer une sanction', 7, 3, '2016-04-28 10:49:54', 1, '2016-04-28 00:00:00', 1, 1),
(47, 'Tableau de bord', 9, 3, '2016-04-28 10:54:30', 1, '2016-04-28 00:00:00', 1, 1),
(48, 'Gestion des classes', 8, 3, '2016-04-28 15:33:13', 1, '2016-04-28 00:00:00', 1, 1),
(49, 'Gestion des niveaux', 8, 3, '2016-04-28 15:33:36', 1, '2016-04-28 00:00:00', 1, 1),
(50, 'Exonération', 1, 3, '2019-10-02 15:08:14', 1, '0000-00-00 00:00:00', 1, 1),
(51, 'Liste des banques', 8, 3, '2019-10-04 11:45:30', 1, '0000-00-00 00:00:00', 1, 1),
(52, 'Réinscription ', 1, 3, '2019-10-04 11:47:38', 1, '0000-00-00 00:00:00', 1, 1),
(53, 'Gestion uniformes / trousseau', 8, 3, '2020-02-25 13:22:04', 1, '0000-00-00 00:00:00', 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `ACTUALITES`
--

CREATE TABLE `ACTUALITES` (
  `IDACTUALITES` int(11) NOT NULL,
  `DATE_ACTUALITE` date DEFAULT NULL,
  `TITRE_ACTU` varchar(100) DEFAULT NULL,
  `DESCRIPTION_ACTU` text,
  `IDCLASSROOM` int(11) DEFAULT '0',
  `IDETABLISSEMENT` int(11) DEFAULT '0',
  `IDANNEESSCOLAIRE` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `affectationDroit`
--

CREATE TABLE `affectationDroit` (
  `idAffectation` int(11) NOT NULL,
  `action` int(11) NOT NULL,
  `profil` int(11) NOT NULL,
  `valide` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `affectationDroit`
--

INSERT INTO `affectationDroit` (`idAffectation`, `action`, `profil`, `valide`) VALUES
(167, 3, 2, 1),
(168, 4, 2, 1),
(169, 5, 2, 1),
(170, 6, 2, 1),
(171, 7, 2, 1),
(172, 8, 2, 1),
(173, 9, 2, 1),
(174, 10, 2, 1),
(175, 11, 2, 1),
(176, 12, 2, 1),
(177, 48, 2, 1),
(178, 49, 2, 1),
(228, 35, 1, 1),
(229, 36, 1, 1),
(230, 37, 1, 1),
(231, 38, 1, 1),
(232, 39, 1, 1),
(233, 40, 1, 1),
(234, 41, 1, 1),
(235, 42, 1, 1),
(236, 43, 1, 1),
(237, 44, 1, 1),
(238, 50, 1, 1),
(239, 52, 1, 1),
(240, 24, 1, 1),
(241, 25, 1, 1),
(242, 26, 1, 1),
(243, 27, 1, 1),
(244, 28, 1, 1),
(245, 29, 1, 1),
(246, 30, 1, 1),
(247, 31, 1, 1),
(248, 32, 1, 1),
(249, 33, 1, 1),
(250, 34, 1, 1),
(251, 22, 1, 1),
(252, 23, 1, 1),
(253, 19, 1, 1),
(254, 20, 1, 1),
(255, 21, 1, 1),
(256, 17, 1, 1),
(257, 18, 1, 1),
(258, 14, 1, 1),
(259, 15, 1, 1),
(260, 16, 1, 1),
(261, 13, 1, 1),
(262, 45, 1, 1),
(263, 46, 1, 1),
(264, 1, 1, 1),
(265, 2, 1, 1),
(266, 3, 1, 1),
(267, 4, 1, 1),
(268, 5, 1, 1),
(269, 6, 1, 1),
(270, 7, 1, 1),
(271, 8, 1, 1),
(272, 9, 1, 1),
(273, 10, 1, 1),
(274, 11, 1, 1),
(275, 12, 1, 1),
(276, 48, 1, 1),
(277, 49, 1, 1),
(278, 51, 1, 1),
(279, 53, 1, 1),
(280, 47, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `AFFECTATION_DROIT`
--

CREATE TABLE `AFFECTATION_DROIT` (
  `IDAFFECTATION_DROIT` int(11) NOT NULL,
  `IDDICTIONNAIRE` int(11) DEFAULT '0',
  `IDDROIT` int(11) DEFAULT '0',
  `AUTORISE` tinyint(4) DEFAULT '0',
  `ETABLISSEMENT` int(11) DEFAULT NULL,
  `IDTYPEINDIVIDU` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `AFFECTATION_ELEVE_CLASSE`
--

CREATE TABLE `AFFECTATION_ELEVE_CLASSE` (
  `IDAFFECTATTION_ELEVE_CLASSE` int(11) NOT NULL,
  `IDCLASSROOM` int(11) NOT NULL,
  `IDINDIVIDU` int(11) NOT NULL,
  `IDANNEESSCOLAIRE` int(11) NOT NULL,
  `IDETABLISSEMENT` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `AFFECTATION_ELEVE_CLASSE`
--

INSERT INTO `AFFECTATION_ELEVE_CLASSE` (`IDAFFECTATTION_ELEVE_CLASSE`, `IDCLASSROOM`, `IDINDIVIDU`, `IDANNEESSCOLAIRE`, `IDETABLISSEMENT`) VALUES
(2, 12, 7, 1, 3),
(3, 6, 8, 1, 3),
(4, 6, 9, 1, 3),
(5, 6, 12, 1, 3),
(6, 16, 13, 1, 3),
(7, 4, 14, 1, 3),
(8, 7, 15, 1, 3),
(9, 4, 17, 1, 3),
(10, 8, 16, 1, 3),
(11, 7, 18, 1, 3),
(12, 3, 19, 1, 3),
(13, 2, 19, 1, 3),
(15, 3, 22, 1, 3),
(16, 3, 24, 1, 3),
(19, 5, 25, 1, 3),
(22, 15, 5, 1, 3),
(24, 3, 26, 1, 3),
(26, 3, 27, 1, 3),
(27, 3, 32, 1, 3),
(28, 4, 33, 1, 3),
(29, 8, 34, 1, 3),
(30, 3, 35, 1, 3),
(31, 4, 36, 1, 3),
(32, 5, 37, 1, 3),
(33, 4, 38, 1, 3),
(34, 8, 39, 1, 3),
(35, 10, 39, 1, 3),
(36, 5, 40, 1, 3),
(37, 4, 41, 1, 3),
(38, 3, 42, 1, 3),
(39, 4, 43, 1, 3),
(42, 3, 44, 1, 3),
(43, 12, 45, 1, 3);

-- --------------------------------------------------------

--
-- Structure de la table `affecter_doc`
--

CREATE TABLE `affecter_doc` (
  `idaff` int(11) NOT NULL,
  `iddoc` int(11) NOT NULL,
  `idclasse` int(11) NOT NULL,
  `idetab` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `AFFECTER_DOC_ETU`
--

CREATE TABLE `AFFECTER_DOC_ETU` (
  `IDAFFDOCETU` int(11) NOT NULL,
  `IDINDIVIDU` int(11) NOT NULL,
  `IDDOCETU` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ANNEESSCOLAIRE`
--

CREATE TABLE `ANNEESSCOLAIRE` (
  `IDANNEESSCOLAIRE` int(11) NOT NULL,
  `LIBELLE_ANNEESSOCLAIRE` varchar(100) DEFAULT NULL,
  `DATE_DEBUT` date DEFAULT NULL,
  `DATE_FIN` date DEFAULT NULL,
  `ETAT` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 :encours; 1:terminé',
  `IDETABLISSEMENT` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ANNEESSCOLAIRE`
--

INSERT INTO `ANNEESSCOLAIRE` (`IDANNEESSCOLAIRE`, `LIBELLE_ANNEESSOCLAIRE`, `DATE_DEBUT`, `DATE_FIN`, `ETAT`, `IDETABLISSEMENT`) VALUES
(1, '2019/2020', '2019-10-01', '2020-07-31', 0, 3),
(2, '2018/2019', '2019-10-07', '2020-07-31', 1, 3);

-- --------------------------------------------------------

--
-- Structure de la table `BANQUE`
--

CREATE TABLE `BANQUE` (
  `ROWID` int(11) NOT NULL,
  `LABEL` varchar(70) DEFAULT NULL,
  `TEL` varchar(20) DEFAULT NULL,
  `ADRESSE` varchar(75) DEFAULT NULL,
  `ETAT` tinyint(1) NOT NULL DEFAULT '1',
  `IDETABLISSEMENT` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `BANQUE`
--

INSERT INTO `BANQUE` (`ROWID`, `LABEL`, `TEL`, `ADRESSE`, `ETAT`, `IDETABLISSEMENT`) VALUES
(1, 'BICIS', '00221339876', 'Diamniadio DAKAR', 1, 3),
(2, 'SGBS', '00221774567', 'Nord Foire pres du rond point yoff', 1, 3),
(4, 'ECOBANK', '00221765432', 'Point E DAKAR', 1, 3),
(5, 'BOA', '00221339876', 'Dakar centre ville', 1, 3),
(6, 'PosteCash', '777141470', 'Diamniadio', 1, 3);

-- --------------------------------------------------------

--
-- Structure de la table `BULLETIN`
--

CREATE TABLE `BULLETIN` (
  `ROWID` int(11) NOT NULL,
  `TOTAL_COEF` double NOT NULL,
  `TOTAL_POINT` double NOT NULL,
  `MOYENNE_SEM` double NOT NULL,
  `RANG` int(11) NOT NULL,
  `IDINDIVIDU` int(11) NOT NULL,
  `IDCLASSROOM` int(11) NOT NULL,
  `IDPERIODE` int(11) DEFAULT '0',
  `MOIS` varchar(50) DEFAULT NULL,
  `IDANNEE` int(11) NOT NULL,
  `IDETABLISSEMENT` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `calendar`
--

CREATE TABLE `calendar` (
  `id` int(11) NOT NULL,
  `idPeriode` int(11) NOT NULL,
  `idClasse` int(11) NOT NULL,
  `idMatiere` int(11) NOT NULL,
  `idProfesseur` int(11) NOT NULL,
  `idSalle` int(11) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `allDay` varchar(5) DEFAULT NULL,
  `color` varchar(7) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `category` varchar(200) DEFAULT NULL,
  `repeat_type` varchar(20) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `repeat_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `CATEGEQUIP`
--

CREATE TABLE `CATEGEQUIP` (
  `IDCATEGEQUIP` int(11) NOT NULL,
  `LIBELLE` varchar(150) DEFAULT NULL,
  `IDETABLISSEMENT` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `CATEGEQUIP`
--

INSERT INTO `CATEGEQUIP` (`IDCATEGEQUIP`, `LIBELLE`, `IDETABLISSEMENT`) VALUES
(1, 'INFORMATIQUE', 1),
(2, 'TELECOM', 1),
(3, 'DOCUMENT', 1),
(10, 'ACCESSOIRES', 2),
(14, 'IMPRIMANTE', 3),
(15, 'MATERIEL DE BUREAU', 7),
(16, 'LOGISTIQUES', 3),
(17, 'BUREAUTIQUE', 8),
(19, 'DIDACTIQUE', 8),
(20, 'CONSOMMABLE', 9),
(21, 'ORDINATEUR', 11),
(22, 'ELECTRONIQUE', 3),
(25, 'MATERIEL DE BUREAU', 9),
(34, 'MATERIEL DE NETTOYAGE', 3),
(35, 'MOYEN DE TRANSPORT', 3),
(37, 'TEST', 3);

-- --------------------------------------------------------

--
-- Structure de la table `CLASSE_ENSEIGNE`
--

CREATE TABLE `CLASSE_ENSEIGNE` (
  `IDCLASSROM` int(11) NOT NULL,
  `IDRECRUTE_PROF` int(11) NOT NULL,
  `IDANNESCOLAIRE` int(11) NOT NULL,
  `IDETABLISSEMENT` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `CLASSE_ENSEIGNE`
--

INSERT INTO `CLASSE_ENSEIGNE` (`IDCLASSROM`, `IDRECRUTE_PROF`, `IDANNESCOLAIRE`, `IDETABLISSEMENT`) VALUES
(6, 4, 1, 3),
(7, 3, 1, 3),
(7, 5, 1, 3),
(8, 3, 1, 3),
(8, 5, 1, 3),
(9, 3, 1, 3),
(9, 5, 1, 3),
(10, 1, 1, 3),
(10, 2, 1, 3),
(10, 3, 1, 3),
(11, 1, 1, 3),
(11, 2, 1, 3),
(11, 3, 1, 3),
(12, 1, 1, 3),
(12, 2, 1, 3),
(12, 3, 1, 3),
(13, 1, 1, 3),
(13, 2, 1, 3),
(13, 3, 1, 3),
(14, 3, 1, 3);

-- --------------------------------------------------------

--
-- Structure de la table `CLASSROOM`
--

CREATE TABLE `CLASSROOM` (
  `IDCLASSROOM` int(11) NOT NULL,
  `LIBELLE` varchar(100) DEFAULT NULL,
  `IDNIVEAU` int(11) DEFAULT '0',
  `IDETABLISSEMENT` int(11) DEFAULT '0',
  `IDSERIE` int(11) DEFAULT NULL,
  `NBRE_ELEVE` int(11) DEFAULT NULL,
  `EXAMEN` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 : classe examen; 0 : non',
  `IDNIV` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `CLASSROOM`
--

INSERT INTO `CLASSROOM` (`IDCLASSROOM`, `LIBELLE`, `IDNIVEAU`, `IDETABLISSEMENT`, `IDSERIE`, `NBRE_ELEVE`, `EXAMEN`, `IDNIV`) VALUES
(1, 'PETITE SECTION YAROU', 1, 3, 3, 40, 0, 1),
(2, 'CI A', 2, 3, 4, 50, 0, 4),
(3, 'CP A', 2, 3, 4, 50, 0, 5),
(4, 'CE1 A', 2, 3, 4, 60, 0, 6),
(5, 'CM1 A', 2, 3, 4, 55, 0, 7),
(6, 'CM2 A', 2, 3, 4, 60, 1, 8),
(7, 'Seconde S2', 3, 3, 2, 45, 0, 13),
(8, 'Premiére S1', 3, 3, 2, 45, 0, 15),
(9, 'Terminal S1', 3, 3, 2, 45, 1, 16),
(10, '5eme A', 3, 3, 1, 50, 0, 10),
(11, '6eme A', 3, 3, 1, 55, 0, 9),
(12, '4eme A', 3, 3, 5, 60, 0, 11),
(13, '3éme A', 3, 3, 5, 25, 1, 12),
(14, 'Terminale L2', 3, 3, 1, 45, 1, 16),
(15, '3éme C', 3, 3, 5, 34, 1, 12),
(16, 'CE1B', 2, 3, 4, 30, 0, 6);

-- --------------------------------------------------------

--
-- Structure de la table `COEFFICIENT`
--

CREATE TABLE `COEFFICIENT` (
  `IDCOEFFICIENT` int(11) NOT NULL,
  `COEFFICIENT` tinyint(1) UNSIGNED DEFAULT '0',
  `IDSERIE` int(11) DEFAULT '0',
  `IDMATIERE` int(11) DEFAULT '0',
  `IDNIVEAU` int(11) NOT NULL DEFAULT '0',
  `IDETABLISSEMENT` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `COEFFICIENT`
--

INSERT INTO `COEFFICIENT` (`IDCOEFFICIENT`, `COEFFICIENT`, `IDSERIE`, `IDMATIERE`, `IDNIVEAU`, `IDETABLISSEMENT`) VALUES
(1, 2, 1, 1, 3, 3),
(2, 5, 2, 1, 3, 3),
(3, 4, 5, 1, 3, 3),
(4, 6, 1, 2, 3, 3),
(5, 2, 2, 2, 3, 3),
(6, 5, 5, 2, 3, 3),
(7, 2, 1, 3, 3, 3),
(8, 6, 2, 3, 3, 3),
(9, 3, 5, 3, 3, 3),
(15, 2, 1, 6, 3, 3),
(16, 6, 2, 6, 3, 3),
(17, 2, 5, 6, 3, 3),
(18, 1, 4, 7, 2, 3),
(19, 1, 4, 8, 2, 3),
(20, 1, 4, 9, 2, 3);

-- --------------------------------------------------------

--
-- Structure de la table `CONTROLE`
--

CREATE TABLE `CONTROLE` (
  `IDCONTROLE` int(11) NOT NULL,
  `LIBELLE_CONTROLE` varchar(100) DEFAULT NULL,
  `DATEDEBUT` datetime DEFAULT NULL,
  `DATEFIN` datetime DEFAULT NULL,
  `IDCLASSROOM` int(11) DEFAULT '0',
  `FK_NIVEAU` int(11) NOT NULL,
  `IDMATIERE` int(11) DEFAULT '0',
  `IDETABLISSEMENT` int(11) DEFAULT '0',
  `IDINDIVIDU` int(11) DEFAULT '0',
  `IDTYP_CONTROL` int(11) DEFAULT '0',
  `NOTER` tinyint(1) NOT NULL DEFAULT '0',
  `IDPERIODE` int(11) DEFAULT '0',
  `HEUREDEBUT` time DEFAULT NULL,
  `HEUREFIN` time DEFAULT NULL,
  `VALIDER` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=Valide, 0=Non Valide',
  `IDANNEE` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `CURRENCIES`
--

CREATE TABLE `CURRENCIES` (
  `CODE` varchar(2) COLLATE latin1_german1_ci NOT NULL,
  `CODE_ISO` varchar(3) COLLATE latin1_german1_ci NOT NULL,
  `LABEL` varchar(64) COLLATE latin1_german1_ci DEFAULT NULL,
  `LABELSING` varchar(64) COLLATE latin1_german1_ci DEFAULT NULL,
  `ACTIVE` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

--
-- Déchargement des données de la table `CURRENCIES`
--

INSERT INTO `CURRENCIES` (`CODE`, `CODE_ISO`, `LABEL`, `LABELSING`, `ACTIVE`) VALUES
('AD', 'AUD', 'Dollars australiens', NULL, 0),
('AE', 'AED', 'Arabes emirats dirham', NULL, 0),
('BD', 'BBD', 'Barbadian or Bajan Dollar', NULL, 0),
('BT', 'THB', 'Bath thailandais', NULL, 0),
('CD', 'DKK', 'Couronnes dannoises', NULL, 0),
('CF', 'XOF', 'Francs CFA BCEAO', NULL, 1),
('CN', 'NOK', 'Couronnes norvegiennes', NULL, 0),
('CS', 'SEK', 'Couronnes suedoises', NULL, 0),
('CZ', 'CZK', 'Couronnes tcheques', NULL, 0),
('DA', 'DZD', 'Dinar algérien', NULL, 0),
('DC', 'CAD', 'Dollars canadiens', NULL, 0),
('DH', 'MAD', 'Dirham', NULL, 0),
('DR', 'GRD', 'Drachme (grece)', NULL, 0),
('DS', 'SGD', 'Dollars singapour', NULL, 0),
('DU', 'USD', 'Dollars us', NULL, 0),
('EC', 'XEU', 'Ecus', NULL, 0),
('EG', 'EGP', 'Livre egyptienne', NULL, 0),
('ES', 'PTE', 'Escudos', NULL, 0),
('EU', 'EUR', 'Euros', NULL, 0),
('FB', 'BEF', 'Francs belges', NULL, 0),
('FF', 'FRF', 'Francs francais', NULL, 0),
('FH', 'HUF', 'Forint hongrois', NULL, 0),
('FL', 'LUF', 'Francs luxembourgeois', NULL, 0),
('FO', 'NLG', 'Florins', NULL, 0),
('FS', 'CHF', 'Francs suisses', NULL, 0),
('HK', 'HKD', 'Dollars hong kong', NULL, 0),
('ID', 'IDR', 'Rupiahs d\'indonesie', NULL, 0),
('IN', 'INR', 'Roupie indienne', NULL, 0),
('KR', 'KRW', 'Won coree du sud', NULL, 0),
('LH', 'HNL', 'Lempiras', NULL, 0),
('LI', 'IEP', 'Livres irlandaises', NULL, 0),
('LK', 'LKR', 'Roupies sri lanka', NULL, 0),
('LR', 'ITL', 'Lires', NULL, 0),
('LS', 'GBP', 'Livres sterling', NULL, 0),
('LT', 'LTL', 'Litas', NULL, 0),
('MA', 'DEM', 'Deutsch mark', NULL, 0),
('MF', 'FIM', 'Mark finlandais', NULL, 0),
('MR', 'MRO', 'Ouguiya Mauritanien', NULL, 0),
('MU', 'MUR', 'Roupies mauritiennes', NULL, 0),
('MX', 'MXP', 'Pesos Mexicans', NULL, 0),
('NZ', 'NZD', 'Dollar neo-zelandais', NULL, 0),
('PA', 'ARP', 'Pesos argentins', NULL, 0),
('PC', 'CLP', 'Pesos chilien', NULL, 0),
('PE', 'ESP', 'Pesete', NULL, 0),
('PL', 'PLN', 'Zlotys polonais', NULL, 0),
('RB', 'BRL', 'Real bresilien', NULL, 0),
('RU', 'SUR', 'Rouble', NULL, 0),
('SA', 'ATS', 'Shiliing autrichiens', NULL, 0),
('SK', 'SKK', 'Couronnes slovaques', NULL, 0),
('SR', 'SAR', 'Saudi riyal', NULL, 0),
('TD', 'TND', 'Dinar tunisien', NULL, 0),
('TR', 'TRL', 'Livre turque', NULL, 0),
('TW', 'TWD', 'Dollar taiwanais', NULL, 0),
('YC', 'CNY', 'Yuang chinois', NULL, 0),
('YE', 'JPY', 'Yens', NULL, 0),
('ZA', 'ZAR', 'Rand africa', NULL, 0);

-- --------------------------------------------------------

--
-- Structure de la table `CV`
--

CREATE TABLE `CV` (
  `IDCV` int(11) NOT NULL,
  `FICHIER` varchar(50) DEFAULT NULL,
  `IDETABLISSEMNT` int(11) NOT NULL,
  `IDINDIVIDU` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `DEPENSE`
--

CREATE TABLE `DEPENSE` (
  `IDREGLEMENT` int(11) NOT NULL,
  `DATE_REGLEMENT` date DEFAULT NULL,
  `MONTANT` int(11) DEFAULT NULL,
  `MOTIF` varchar(100) DEFAULT NULL,
  `IDTYPEPAIEMENT` int(11) NOT NULL,
  `IDETABLISSEMENT` int(11) NOT NULL,
  `IDANNEESCOLAIRE` int(11) NOT NULL,
  `REFERENCE` varchar(75) DEFAULT NULL,
  `NUM_CHEQUE` varchar(75) DEFAULT NULL,
  `FK_BANQUE` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `DESTINATAIRE`
--

CREATE TABLE `DESTINATAIRE` (
  `IDDESTINATAIRE` int(11) NOT NULL,
  `IDINDIVIDU` int(11) DEFAULT '0',
  `IDMESSAGERIE` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `DETAIL_BULLETIN`
--

CREATE TABLE `DETAIL_BULLETIN` (
  `ID` int(11) NOT NULL,
  `FK_BULLETIN` int(11) NOT NULL,
  `MATIERE` int(11) NOT NULL,
  `COEF` int(11) NOT NULL,
  `MOY_CONTROLE` double DEFAULT NULL,
  `COMPOSITION` double DEFAULT NULL,
  `MOYENNE_SEM` double DEFAULT NULL,
  `COMPO1` double DEFAULT NULL,
  `COMPO2` double DEFAULT NULL,
  `COMPO3` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `DETAIL_TIMETABLE`
--

CREATE TABLE `DETAIL_TIMETABLE` (
  `IDDETAIL_TIMETABLE` int(11) NOT NULL,
  `DATEDEBUT` time NOT NULL,
  `DATEFIN` time NOT NULL,
  `JOUR_SEMAINE` varchar(25) NOT NULL,
  `IDEMPLOIEDUTEMPS` int(11) NOT NULL DEFAULT '0',
  `IDMATIERE` int(11) NOT NULL DEFAULT '0',
  `IDSALL_DE_CLASSE` int(11) NOT NULL DEFAULT '0',
  `IDETABLISSEMENT` int(11) NOT NULL DEFAULT '0',
  `IDINDIVIDU` int(11) NOT NULL,
  `REPETITION` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `DETAIL_TIMETABLE`
--

INSERT INTO `DETAIL_TIMETABLE` (`IDDETAIL_TIMETABLE`, `DATEDEBUT`, `DATEFIN`, `JOUR_SEMAINE`, `IDEMPLOIEDUTEMPS`, `IDMATIERE`, `IDSALL_DE_CLASSE`, `IDETABLISSEMENT`, `IDINDIVIDU`, `REPETITION`) VALUES
(1, '08:30:00', '09:30:00', 'LUN', 1, 2, 3, 3, 2, 0),
(2, '09:30:00', '10:30:00', 'LUN', 1, 2, 3, 3, 2, 0),
(3, '11:00:00', '12:00:00', 'MAR', 1, 2, 3, 3, 2, 0),
(4, '12:00:00', '13:00:00', 'MAR', 1, 2, 3, 3, 2, 0),
(5, '09:30:00', '10:30:00', 'VEN', 1, 2, 3, 3, 2, 0),
(6, '11:00:00', '12:00:00', 'VEN', 1, 2, 3, 3, 2, 0),
(7, '11:00:00', '12:00:00', 'LUN', 1, 1, 3, 3, 1, 0),
(8, '12:00:00', '13:00:00', 'LUN', 1, 1, 3, 3, 1, 0),
(9, '08:30:00', '09:30:00', 'MER', 1, 1, 3, 3, 1, 0),
(10, '09:30:00', '10:30:00', 'MER', 1, 1, 3, 3, 1, 0),
(11, '08:30:00', '09:30:00', 'MAR', 1, 3, 3, 3, 3, 0),
(12, '09:30:00', '10:30:00', 'MAR', 1, 3, 3, 3, 3, 0),
(13, '08:30:00', '09:30:00', 'JEU', 1, 6, 3, 3, 3, 0),
(14, '09:30:00', '10:30:00', 'JEU', 1, 6, 3, 3, 3, 0),
(15, '11:00:00', '12:00:00', 'SAM', 1, 6, 3, 3, 3, 0),
(16, '09:30:00', '10:30:00', 'SAM', 1, 3, 3, 3, 3, 0);

-- --------------------------------------------------------

--
-- Structure de la table `DISPENSER_COURS`
--

CREATE TABLE `DISPENSER_COURS` (
  `IDDISPENSER_COURS` int(11) NOT NULL,
  `IDCLASSROOM` int(11) DEFAULT '0',
  `IDINDIVIDU` int(11) DEFAULT '0',
  `DATE` date DEFAULT NULL,
  `HEUREDEBUTCOURS` time DEFAULT NULL,
  `HEUREFINCOURS` time DEFAULT NULL,
  `TITRE_COURS` varchar(100) DEFAULT NULL,
  `CONTENUCOURS` text,
  `IDSALL_DE_CLASSE` int(11) DEFAULT '0',
  `IDETABLISSEMENT` int(11) DEFAULT '0',
  `IDMATIERE` int(11) DEFAULT NULL,
  `ANNEESCOLAIRE` int(11) NOT NULL,
  `MOIS` varchar(15) DEFAULT NULL,
  `ETAT` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0 = Non validé ; 1 = Validé'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `DOCADMIN`
--

CREATE TABLE `DOCADMIN` (
  `IDDOCADMIN` int(11) NOT NULL,
  `LIBELLE` varchar(100) DEFAULT NULL,
  `NOM` varchar(75) DEFAULT NULL,
  `MOTIF` varchar(100) DEFAULT NULL,
  `DATEDELIVRANCE` date DEFAULT NULL,
  `IDTYPEDOCADMIN` int(11) DEFAULT '0',
  `IDETABLISSEMENT` int(11) DEFAULT '0',
  `IDINDIVIDU` int(11) DEFAULT '0',
  `IDANNEESSCOLAIRE` int(11) DEFAULT '0',
  `ID_AUTHORITE` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `document_prof`
--

CREATE TABLE `document_prof` (
  `iddoc` int(11) NOT NULL,
  `nomdoc` varchar(100) NOT NULL DEFAULT 'inconnu',
  `libelle` varchar(100) DEFAULT NULL,
  `nom_fichier` varchar(50) NOT NULL,
  `idprof` int(11) NOT NULL,
  `idetab` int(11) NOT NULL,
  `datedoc` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `DOC_DIDACTIQUE`
--

CREATE TABLE `DOC_DIDACTIQUE` (
  `IDDOC_DIDACTIQUE` int(11) NOT NULL,
  `TITRE_DOC` varchar(50) DEFAULT '',
  `PATH` varchar(50) DEFAULT '',
  `DATE_POSTE` date DEFAULT NULL,
  `DISPONIBILITE` tinyint(4) DEFAULT '0',
  `IDETABLISSEMENT` int(11) DEFAULT '0',
  `IDCONTROLE` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `DOC_ETUDIANT`
--

CREATE TABLE `DOC_ETUDIANT` (
  `IDDOCETU` int(11) NOT NULL,
  `LIBELLE` varchar(50) NOT NULL,
  `NOM` varchar(100) NOT NULL,
  `DATE` date NOT NULL,
  `DESCRIPTION` text NOT NULL,
  `IDTYPEDOCETU` int(11) NOT NULL,
  `ANNEESCOLAIRE` int(11) NOT NULL,
  `ETABLISSEMENT` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `DROIT`
--

CREATE TABLE `DROIT` (
  `IDdroit` int(11) NOT NULL,
  `lib_droit` varchar(50) DEFAULT NULL,
  `IDclient` int(11) DEFAULT NULL,
  `user_creation` int(11) DEFAULT '0',
  `date_creation` date DEFAULT NULL,
  `user_modif` int(11) DEFAULT '0',
  `date_modif` date DEFAULT NULL,
  `user_supprime` int(11) DEFAULT '0',
  `date_supprime` date DEFAULT NULL,
  `corbeille` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ELEMENT_TROUSSEAU`
--

CREATE TABLE `ELEMENT_TROUSSEAU` (
  `FK_TROUSSEAU` int(11) NOT NULL,
  `FK_UNIFORME` int(11) NOT NULL,
  `NOMBRE` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ELEMENT_TROUSSEAU`
--

INSERT INTO `ELEMENT_TROUSSEAU` (`FK_TROUSSEAU`, `FK_UNIFORME`, `NOMBRE`) VALUES
(1, 1, 2),
(2, 1, 2),
(3, 2, 2),
(3, 7, 1),
(3, 9, 1),
(3, 11, 0),
(3, 13, 1),
(4, 2, 2),
(4, 7, 1),
(4, 9, 1),
(4, 11, 1),
(4, 13, 1),
(5, 4, 1),
(5, 6, 1),
(5, 8, 3),
(5, 10, 1),
(5, 12, 1),
(6, 4, 0),
(6, 6, 1),
(6, 8, 3),
(6, 10, 1),
(6, 12, 1),
(7, 4, 1),
(7, 6, 1),
(7, 8, 4),
(7, 10, 1),
(7, 12, 2),
(8, 4, 0),
(8, 6, 1),
(8, 8, 4),
(8, 10, 1),
(8, 12, 3),
(9, 14, 50),
(11, 14, 45);

-- --------------------------------------------------------

--
-- Structure de la table `EMPLOIEDUTEMPS`
--

CREATE TABLE `EMPLOIEDUTEMPS` (
  `IDEMPLOIEDUTEMPS` int(11) NOT NULL,
  `IDPERIODE` int(11) DEFAULT '0',
  `IDETABLISSEMENT` int(11) DEFAULT '0',
  `IDCLASSROOM` int(11) DEFAULT '0',
  `IDANNEE` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `EMPLOIEDUTEMPS`
--

INSERT INTO `EMPLOIEDUTEMPS` (`IDEMPLOIEDUTEMPS`, `IDPERIODE`, `IDETABLISSEMENT`, `IDCLASSROOM`, `IDANNEE`) VALUES
(1, 4, 3, 13, 1);

-- --------------------------------------------------------

--
-- Structure de la table `EQUIPEMENT`
--

CREATE TABLE `EQUIPEMENT` (
  `IDEQUIPEMENT` int(11) NOT NULL,
  `FACTURE` varchar(25) DEFAULT NULL,
  `MONTANT` int(11) DEFAULT NULL,
  `DATE` date DEFAULT NULL,
  `NOMEQUIPEMENT` varchar(100) DEFAULT NULL,
  `IDCATEGEQUIP` int(11) DEFAULT '0',
  `IDETABLISSEMENT` int(11) DEFAULT '0',
  `QTE` int(11) DEFAULT NULL,
  `ANNEESSCOLAIRE` int(11) DEFAULT NULL,
  `QTE_RESTANTE` int(11) DEFAULT '0',
  `REFERENCE` varchar(100) DEFAULT NULL,
  `MODELE` varchar(100) DEFAULT NULL,
  `MARQUE` varchar(100) DEFAULT NULL,
  `DATE_ACQUISITION` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ETABLISSEMENT`
--

CREATE TABLE `ETABLISSEMENT` (
  `IDETABLISSEMENT` int(11) NOT NULL,
  `NOMETABLISSEMENT_` varchar(100) DEFAULT NULL,
  `SIGLE` varchar(50) DEFAULT NULL,
  `ADRESSE` varchar(100) DEFAULT NULL,
  `TELEPHONE` varchar(50) DEFAULT '',
  `REGLEMENTINTERIEUR` text,
  `VILLE` varchar(150) DEFAULT NULL,
  `PAYS` varchar(150) DEFAULT NULL,
  `DEVISE` varchar(50) DEFAULT '',
  `FAX` varchar(50) DEFAULT '',
  `MAIL` varchar(100) DEFAULT NULL,
  `SITEWEB` varchar(100) DEFAULT NULL,
  `LOGO` varchar(100) DEFAULT NULL,
  `CAPITAL` varchar(50) DEFAULT '',
  `FORM_JURIDIQUE` varchar(50) DEFAULT '',
  `RC` varchar(50) DEFAULT '',
  `NINEA` varchar(50) DEFAULT '',
  `NUM_TV` int(11) DEFAULT NULL,
  `PREFIXE` varchar(5) DEFAULT NULL,
  `BP` varchar(20) DEFAULT NULL,
  `TABLEAUHONNEUR` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ETABLISSEMENT`
--

INSERT INTO `ETABLISSEMENT` (`IDETABLISSEMENT`, `NOMETABLISSEMENT_`, `SIGLE`, `ADRESSE`, `TELEPHONE`, `REGLEMENTINTERIEUR`, `VILLE`, `PAYS`, `DEVISE`, `FAX`, `MAIL`, `SITEWEB`, `LOGO`, `CAPITAL`, `FORM_JURIDIQUE`, `RC`, `NINEA`, `NUM_TV`, `PREFIXE`, `BP`, `TABLEAUHONNEUR`) VALUES
(3, 'Complexe Educatif Mamelles Aviation Denango', 'CEMAD', 'Ouakam Mamelles Aviation, Dakar-Senegal', '+221338602718', '<p><span style=\"text-decoration: underline;\">REGLEMENT INT&Eacute;RIEUR DE L\'ECOLE:</span></p>\r\n<p>D&eacute;finition (<strong>Ordinateur</strong>) Machine &eacute;lectronique programmable capable de r&eacute;aliser des calculs logiques sur des nombres binaires.</p>\r\n<p>C&rsquo;est une machine Hardware Le fonctionnement d&rsquo;un ordinateur est bas&eacute; sur une architecture mat&eacute;rielle (<strong>processeur</strong>, support de stockage, interfaces utilisateurs, <strong>connexion</strong>, . . .) dont le fonctionnement est soumis aux lois de la physique.</p>\r\n<p>C&rsquo;est une machine programmable Software Cette machine est capable de remplir des t&acirc;ches diff&eacute;rentes selon les instructions qui lui sont adress&eacute;es.</p>\r\n<p>Ces instructions, r&eacute;dig&eacute;es sous forme de programmes par les informaticiens, sont trait&eacute;es en fin de course par le mat&eacute;riel de l&rsquo;ordinateur.</p>\r\n<p>Interaction Hardware/Software La plupart du temps, l&rsquo;informaticien n&rsquo;a pas a interagir directement avec le mat&eacute;riel.</p>\r\n<p>Pour traiter avec les composants, tous les ordinateurs disposent d&rsquo;une couche logicielle appel&eacute;e syst&egrave;me d&rsquo;exploitation.</p>\r\n<p>Cette couche est en charge de faire la passerelle entre l&rsquo;informaticien, ses outils, les programmes qu&rsquo;il d&eacute;veloppe et, les composants et leur fonctionnement.</p>\r\n<p>`HGFGHFHHFFH</p>', 'DAKAR', 'SENEGAL', 'XOF', '', 'cemad@cemadsn.com', 'http://cemadsn.com', '3user-ecole.jpg', '6 000 000', 'SARL', 'SN DKR 2011 B 9888 ', '44388512 R 233', 0, 'CEMAD', '1512222', 13);

-- --------------------------------------------------------

--
-- Structure de la table `evenement`
--

CREATE TABLE `evenement` (
  `id` int(11) NOT NULL,
  `title` varchar(1000) COLLATE latin1_german1_ci NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `allDay` varchar(25) COLLATE latin1_german1_ci NOT NULL DEFAULT 'false'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- --------------------------------------------------------

--
-- Structure de la table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `color` varchar(7) NOT NULL DEFAULT '#3a87ad',
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `EXERCICE`
--

CREATE TABLE `EXERCICE` (
  `IDEXERCICE` int(11) NOT NULL,
  `LIBELLE` varchar(100) DEFAULT NULL,
  `DATEEXO` varchar(50) DEFAULT '',
  `DATERETOUR` varchar(50) DEFAULT '',
  `TYPEEXO` smallint(6) DEFAULT '0',
  `IDCLASSROOM` int(11) DEFAULT '0',
  `IDMATIERE` int(11) DEFAULT '0',
  `IDETABLISSEMENT` int(11) DEFAULT '0',
  `IDANNEE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `FACTURE`
--

CREATE TABLE `FACTURE` (
  `IDFACTURE` int(11) NOT NULL,
  `NUMFACTURE` varchar(25) NOT NULL,
  `MOIS` varchar(25) DEFAULT NULL,
  `MONTANT` int(11) DEFAULT NULL,
  `DATEREGLMT` date DEFAULT NULL,
  `IDINSCRIPTION` int(11) DEFAULT '0',
  `IDETABLISSEMENT` int(11) DEFAULT '0',
  `MT_VERSE` int(11) DEFAULT NULL,
  `MT_RELIQUAT` int(11) DEFAULT NULL,
  `ETAT` tinyint(1) DEFAULT NULL COMMENT '0:non payé; 1:payé; 2:restant',
  `IDANNEESCOLAIRE` int(11) NOT NULL,
  `USER_MODIFICATION` int(11) DEFAULT NULL,
  `DATE_MODIFICATION` datetime DEFAULT NULL,
  `AVANCE` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `FACTURE`
--

INSERT INTO `FACTURE` (`IDFACTURE`, `NUMFACTURE`, `MOIS`, `MONTANT`, `DATEREGLMT`, `IDINSCRIPTION`, `IDETABLISSEMENT`, `MT_VERSE`, `MT_RELIQUAT`, `ETAT`, `IDANNEESCOLAIRE`, `USER_MODIFICATION`, `DATE_MODIFICATION`, `AVANCE`) VALUES
(1, 'FACT8808843', '10-2019', 20000, '2020-12-30', 23, 3, 0, 20000, 0, 1, NULL, NULL, 0),
(2, 'FACT5141293', '10-2019', 20000, '2020-12-30', 26, 3, 0, 20000, 0, 1, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Structure de la table `FORFAIT_PROFESSEUR`
--

CREATE TABLE `FORFAIT_PROFESSEUR` (
  `ROWID` int(11) NOT NULL,
  `LIBELLE` varchar(75) NOT NULL,
  `NBRE_JOUR` int(11) NOT NULL,
  `MONTANT` int(11) NOT NULL,
  `IDETABLISSEMENT` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `FORFAIT_PROFESSEUR`
--

INSERT INTO `FORFAIT_PROFESSEUR` (`ROWID`, `LIBELLE`, `NBRE_JOUR`, `MONTANT`, `IDETABLISSEMENT`) VALUES
(1, 'Forfait1', 50, 150000, 3),
(2, 'Forfait3', 100, 300000, 3),
(3, 'Forfait Prof', 30, 300000, 3);

-- --------------------------------------------------------

--
-- Structure de la table `INDIVIDU`
--

CREATE TABLE `INDIVIDU` (
  `IDINDIVIDU` int(11) NOT NULL,
  `MATRICULE` varchar(50) DEFAULT '',
  `NOM` varchar(75) DEFAULT '',
  `PRENOMS` varchar(100) DEFAULT NULL,
  `DATNAISSANCE` date DEFAULT NULL,
  `ADRES` varchar(100) DEFAULT NULL,
  `TELMOBILE` varchar(50) DEFAULT NULL,
  `TELDOM` varchar(50) DEFAULT NULL,
  `COURRIEL` varchar(100) DEFAULT NULL,
  `LOGIN` varchar(50) DEFAULT NULL,
  `MP` varchar(32) DEFAULT NULL,
  `CODE` varchar(50) DEFAULT NULL,
  `BIOGRAPHIE` varchar(50) DEFAULT NULL,
  `PHOTO_FACE` varchar(50) DEFAULT NULL,
  `IDETABLISSEMENT` int(11) DEFAULT '0',
  `IDTYPEINDIVIDU` int(11) DEFAULT '0',
  `SEXE` tinyint(1) DEFAULT '0' COMMENT '1:masculin;0:feminin',
  `IDTUTEUR` int(11) DEFAULT NULL,
  `LIEN_PARENTE` tinyint(1) DEFAULT NULL COMMENT '1:PERE, 2:MERE,3:TUTEUR',
  `ANNEEBAC` smallint(6) DEFAULT NULL,
  `NATIONNALITE` smallint(6) DEFAULT NULL,
  `SIT_MATRIMONIAL` varchar(25) DEFAULT NULL,
  `NUMID` varchar(50) DEFAULT NULL,
  `IDSECTEUR` int(11) DEFAULT NULL,
  `LIEU_TRAVAIL` varchar(75) DEFAULT NULL,
  `PATHOLOGIE` varchar(100) DEFAULT NULL,
  `ALLERGIE` varchar(100) DEFAULT NULL,
  `MEDECIN_TRAITANT` varchar(100) DEFAULT NULL,
  `FICHE_RECTO` varchar(50) DEFAULT NULL,
  `FICHE_VERSO` varchar(50) DEFAULT NULL,
  `DIPLOMES` varchar(200) DEFAULT NULL,
  `DISCIPLINE` varchar(200) DEFAULT NULL,
  `ANNEE` varchar(200) DEFAULT NULL,
  `DATE_ARRIVE_CEMAD` date DEFAULT NULL,
  `FILIERE_ENSEIGNE` varchar(250) DEFAULT NULL,
  `ID_NIVEAU` int(11) DEFAULT NULL,
  `DUREE_ENSEIGNEMENT` int(11) DEFAULT NULL,
  `ENGAGEMENT` tinyint(1) DEFAULT '0',
  `RAISON_ENGAGEMENT` varchar(255) DEFAULT NULL,
  `PERE` varchar(75) DEFAULT NULL,
  `MERE` varchar(75) DEFAULT NULL,
  `LIEU_NAISSANCE` varchar(75) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `INDIVIDU`
--

INSERT INTO `INDIVIDU` (`IDINDIVIDU`, `MATRICULE`, `NOM`, `PRENOMS`, `DATNAISSANCE`, `ADRES`, `TELMOBILE`, `TELDOM`, `COURRIEL`, `LOGIN`, `MP`, `CODE`, `BIOGRAPHIE`, `PHOTO_FACE`, `IDETABLISSEMENT`, `IDTYPEINDIVIDU`, `SEXE`, `IDTUTEUR`, `LIEN_PARENTE`, `ANNEEBAC`, `NATIONNALITE`, `SIT_MATRIMONIAL`, `NUMID`, `IDSECTEUR`, `LIEU_TRAVAIL`, `PATHOLOGIE`, `ALLERGIE`, `MEDECIN_TRAITANT`, `FICHE_RECTO`, `FICHE_VERSO`, `DIPLOMES`, `DISCIPLINE`, `ANNEE`, `DATE_ARRIVE_CEMAD`, `FILIERE_ENSEIGNE`, `ID_NIVEAU`, `DUREE_ENSEIGNEMENT`, `ENGAGEMENT`, `RAISON_ENGAGEMENT`, `PERE`, `MERE`, `LIEU_NAISSANCE`) VALUES
(1, 'CEMADP0001', 'GUEYE', 'Samba', '1986-03-11', 'Keur massar', '00221775783476', '', 'younaby@gmail.com', 'younaby@gmail.com', '33090b72a79885dbcafb03ddd0e7411f', '7748905852451', '&lt;p&gt;OK&lt;/p&gt;', 'user-ecole.jpg', 3, 7, 1, NULL, NULL, 2008, 22, 'Marié(e) sans enfant', '128828282828288289', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '&lt;p&gt;BAC&lt;/p&gt;\r\n&lt;p&gt;LICENCE&lt;/p&gt;', '&lt;p&gt;LANGUES&lt;/p&gt;\r\n&lt;p&gt;LANGUES&lt;/p&gt;', '&lt;p&gt;2008&lt;/p&gt;\r\n&lt;p&gt;2011&lt;/p&gt;', '2019-09-22', 'Anglais', 3, 4, 1, '&lt;p&gt;OK&lt;/p&gt;', NULL, NULL, 'Saint Louis'),
(2, 'CEMADP0002', 'SENE', 'Mansour', '1989-04-05', 'Hersent', '0022176564646', '', 'ibrahima.fall@samaecole.sn', 'ibrahima.fall@samaecole.sn', '7e3fd221439b291d0b0f581b658c9398', '7841803045121', '&lt;p&gt;OK&lt;/p&gt;', 'imgDefaultIndividu.jpg', 3, 7, 1, NULL, NULL, 2005, 22, 'Celibataire avec enfant', '128828282828288289', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '&lt;p&gt;test&lt;/p&gt;', '&lt;p&gt;test&lt;/p&gt;', '&lt;p&gt;test&lt;/p&gt;', '2020-04-22', 'Français', 3, 3, 1, '&lt;p&gt;OK&lt;/p&gt;', NULL, NULL, 'Thies'),
(3, 'CEMADP0003', 'GUEYE', 'Madiop', '1985-03-06', 'Keur massar', '0022176564646', '', 'ibrahima.fall@samaecole.com', 'ibrahima.fall@samaecole.com', '3f9d882fd8f75dccf4c84cc7cda35aba', '7714881430509', '&lt;p&gt;ok&lt;/p&gt;', 'imgDefaultIndividu.jpg', 3, 7, 0, NULL, NULL, 2009, 22, 'Marié(e) avec enfant', '102992288383883838', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '&lt;p&gt;OKL&lt;/p&gt;', '&lt;p&gt;OKL&lt;/p&gt;', '&lt;p&gt;OKL&lt;/p&gt;', '2019-08-22', 'SVT', 0, 0, 1, '&lt;p&gt;OKLM&lt;/p&gt;', NULL, NULL, 'Saint Louis'),
(4, 'CEMAD0001', 'DIALLO', 'Moussa', NULL, NULL, '00221774119645', '', 'ibrahima.fall@samaecole.com', 'ibrahima.fall@samaecole.com', 'fd4962bbb501a9b1316f156fb6cf47a7', '7652048809406', NULL, 'imgDefaultIndividu.jpg', 3, 9, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, 'DIAMNIADIO PI2D', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(6, 'CEMAD0002', 'BOYE', 'Mariama', NULL, NULL, '00221774119645', '', 'ibrahima.fall@samaecole.com', 'ibrahima.fall@samaecole.com', 'e9613d9987f8ed3d296b10dffe49622d', '7381455027378', NULL, 'imgDefaultIndividu.jpg', 3, 9, 0, NULL, 2, NULL, NULL, NULL, NULL, NULL, 'DIAMNIADIO PI2D', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(7, '0002', 'NDIAYE', 'Cheikh', '2010-04-22', 'Nord foire', '00221774119865', '', 'younaby@gmail.co', 'younaby@gmail.co', '8739a52ba3dd7858962e4bcb70bc2413', '7788300549705', '', 'imgDefaultIndividu.jpg', 3, 8, 1, 6, NULL, 0, 22, 'Celibataire sans enfant', '', NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Malick NDIAYE', 'Mariama BOYE', 'Dakar'),
(8, '0003', 'THIEMA', 'Mouhamed', '2010-01-23', 'Keur massar', '00221774119865', '', 'mouhamed.thiema@numh.com', 'mouhamed.thiema@numh.com', '2670a16feb39eb4039779f56c726cae5', '7145283025041', '', 'imgDefaultIndividu.jpg', 3, 8, 1, NULL, NULL, 0, 22, '', '', NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Abdoulaye THIEMA', 'Ndeye Maguette DIAGNE', 'BAOL'),
(9, '0004', 'FALLY', 'Abdallah', '2015-04-23', 'Keur massar', '221774119645', '', 'younaby@gmail.com', 'younaby1@gmail.com', 'e259d6956c5c4a6caf6cf7b08cce3290', '7420814893699', '', 'imgDefaultIndividu.jpg', 3, 8, 0, NULL, NULL, 0, 22, 'Celibataire sans enfant', '128828282828288289', NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Ibrahima FALL', 'Sina GUEYE', 'Saint Louis'),
(10, 'CEMADP0004', 'GUEYE', 'Sina', '1988-02-04', 'Keur massar', '00221776569876', '', 'sina.gueye@mns.sn', 'sina.gueye@mns.sn', '2f88b81644750cf318fa1254084ca72b', '7281300946495', '&lt;p&gt;OK&lt;/p&gt;', 'imgDefaultIndividu.jpg', 3, 7, 0, NULL, NULL, 2008, 22, 'Marié(e) avec enfant', '128828282828288282', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '&lt;p&gt;- BAC&lt;/p&gt;\r\n&lt;p style=&quot;text-align: left;&quot;&gt;- LICENCE&amp;nbsp;&lt;/p&gt;', '&lt;p&gt;- Langues&lt;/p&gt;\r\n&lt;p&gt;- Langues&lt;/p&gt;', '&lt;p&gt;- 2008&lt;/p&gt;\r\n&lt;p&gt;- 2012&lt;/p&gt;', '2019-11-04', 'Primaire', 2, 2, 1, '&lt;p&gt;OKKK&lt;/p&gt;', NULL, NULL, 'Saint Louis'),
(11, 'CEMAD0005', 'DIOP', 'Ibrahima', NULL, NULL, '', '00221775579214', 'ibrahima.diop@samaecole.co', 'ibrahima.diop@samaecole.co', '3000b26ef52b000214ff8307149554d9', '7835710287273', NULL, 'imgDefaultIndividu.jpg', 3, 9, 0, NULL, 3, NULL, NULL, NULL, NULL, NULL, 'COLOBBANE/ANSD', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(12, '0005', 'DIOP', 'Code', '2017-04-22', 'Pikine Dakar', '0022176564646', '', 'younaby@gmail.cos', 'younaby@gmail.cos', '98eec8089e29dbab8c4b8d76eb2389f9', '7723841611510', '', 'imgDefaultIndividu.jpg', 3, 8, 1, 11, NULL, 0, 22, '', '', NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Malick DIOP', 'Awa SALL', 'Thies'),
(13, '0006', 'DIALLO', 'Mouhamed', '2020-10-13', 'Keur massar', '00221774119865', '00221339619876', 'ndickou.diop@samaecole.com', 'ndickou.diop@samaecole.com', 'be6027033bf151368e2c7f92213945db', '7863375810588', '&lt;p&gt;ok&lt;/p&gt;', 'imgDefaultIndividu.jpg', 3, 8, 1, NULL, NULL, 0, 22, 'Celibataire sans enfant', '', NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Malick NDIAYE', 'Mariama BOYE', 'Saint Louis'),
(14, '0007', 'Thiema', 'Max', '2010-01-10', 'test', '221776668989', '3388709767', 'maguette.diagne@samaecole.com', 'maguette.diagne@samaecole.com', '8ea1bfed3c9497b25bfebf43027b2952', '7201914513864', '&lt;p&gt;hffghfhf&lt;/p&gt;', 'imgDefaultIndividu.jpg', 3, 8, 0, NULL, NULL, 0, 22, 'Marié(e) avec enfant', '7575757575757', NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'M', 'F', 'Diourbel'),
(15, '0008', 'Thiema', 'Magou', '2010-09-05', 'test', '2219888877', '768788668', 'maxthiema@gmail.com', 'maxthiema@gmail.com', '04821adb4a653f9aeb94f74cbfceee1c', '7652089204246', '&lt;p&gt;tytytytt&lt;/p&gt;', 'imgDefaultIndividu.jpg', 3, 8, 0, NULL, NULL, 0, 22, 'Marié(e) avec enfant', '767677676767676', NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'L', 'G', 'Diourbel'),
(16, '0009', 'Ndiaye', 'Fatou', '2011-06-05', 'test', '22177788888', '66787878', 'maxdiagne2002@yahoo.fr', 'maxdiagne2002@yahoo.fr', '967ccad3eefd3fbae3be6849f5926803', '7804743566431', '&lt;p&gt;gghhghgg&lt;/p&gt;', 'imgDefaultIndividu.jpg', 3, 8, 0, NULL, NULL, 0, 22, 'Marié(e) avec enfant', '78787887', NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Pape', 'Ndeye', 'kaolack'),
(17, '0010', 'Ndiaye', 'Mouhamed', '2017-10-01', 'eww', '688676868', '9789789', 'maxthiema@gmail.com', 'maxthiema@gmail.com', '3f68f173794855e81e3050d7ad65c092', '7051150021393', '&lt;p&gt;jhhk&lt;/p&gt;', 'imgDefaultIndividu.jpg', 3, 8, 1, NULL, NULL, 0, 22, '', '', NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Youssoupha', 'eww', 'KL'),
(18, '0011', 'GUEYE', 'Sina', '2020-10-15', 'Ouest Foire', '00221774119865', '00221339619876', 'ibrahima.fall@samaecole.com', 'ibrahima.fall@samaecole.com', '9ec9bc9604f8a9714dfffbad831b85c1', '7056177980393', '&lt;p&gt;ok&lt;/p&gt;', 'imgDefaultIndividu.jpg', 3, 8, 0, NULL, NULL, 0, 22, 'Marié(e) avec enfant', '128828282828288289', NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Malick NDIAYE', 'Ndeye Maguette DIAGNE', 'Saint Louis'),
(20, 'CEMADP0005', 'Fall', 'Modou', '2020-10-04', 'ttyyeytyt', '2217887766776', '788778787878', 'maxthiema@gmail.com', 'maxthiema@gmail.com', '95a1375d5a0862db7252c9ee8ba76927', '7657461581086', '', 'imgDefaultIndividu.jpg', 3, 7, 1, NULL, NULL, 0, 22, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', '0000-00-00', '', 0, 0, 0, '', NULL, NULL, 'test'),
(21, 'CEMAD0013', 'Faye', 'Modou', NULL, NULL, '221877787', '878787878', 'maxthiema@gmail.com', 'maxthiema@gmail.com', 'bb7e51fc1876afaf8983a68059c2c539', '7269522436501', NULL, 'imgDefaultIndividu.jpg', 3, 9, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, 'test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(22, '0013', 'faye', 'yoro', '2020-09-27', 'bhj', '768787878', '98989889898', 'maxdiagne2002@yahoo.fr', 'maxdiagne2002@yahoo.fr', '8ff7dee4f755ec5dab770a2e95ae815f', '7221508009884', '&lt;p&gt;jhhjhjjh&lt;/p&gt;', 'imgDefaultIndividu.jpg', 3, 8, 0, 21, NULL, 0, 22, '', '', NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'hhjhkj', 'nbh', 'hgh'),
(23, 'CEMAD0014', 'THIEMA', 'Ibrahima ', NULL, NULL, '00221774119645', '', 'ibrahima.fall@samaecole.com', 'ibrahima.fall@samaecole.com', 'deea7891168019ec3190409dd59b52ce', '7676583422217', NULL, 'imgDefaultIndividu.jpg', 3, 9, 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, 'COLOBBANE/ANSD', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(24, '0015', 'DIALLO', 'Sina', '2019-06-12', 'Keur massar', '00221774119865', '00221339619876', 'younaby@gmail.com', 'younaby@gmail.com', 'd48dd48b2af0ae24acf9741d2d90955f', '7562519314855', '&lt;p&gt;ok&lt;/p&gt;', 'imgDefaultIndividu.jpg', 3, 8, 0, 23, NULL, 0, 22, '', '', NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Malick NDIAYE', 'Ndeye Maguette DIAGNE', 'BAOL'),
(25, '0016', 'Diallo', 'Amadou', '2010-01-10', 'testadresse', '22198888', '565665656', 'maxthiema@gmail.com', 'maxthiema@gmail.com', 'be7297071933bbf2df91d9c9c719e1a7', '7981931387947', '', 'imgDefaultIndividu.jpg', 3, 8, 1, NULL, NULL, 0, 22, 'Celibataire avec enfant', '', NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'testpere', 'testmere', 'kaolack'),
(26, '0020', 'Ndiaye', 'Tapha', '2019-06-02', 'testadresse', '22197798787', '75567787878', 'maxthiema@gmail.com', 'maxthiema@gmail.com', 'de63279ae6acbca0ef363607a186e65b', '7570393537762', '', 'imgDefaultIndividu.jpg', 3, 8, 0, NULL, NULL, 0, 22, '', '', NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Modou', 'Mareme', 'Diourbel'),
(27, '0021', 'Fall', 'Ibra', '2020-10-04', 'testadresse', '7708989898', '89978778788', 'maguette.diagne@samaecole.com', 'maguette.diagne@samaecole.com', '0e3bca329b403d60c1f70ea50eb3cfc4', '7861827947176', '', 'imgDefaultIndividu.jpg', 3, 8, 0, NULL, NULL, 0, 22, '', '', NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Modou', 'Mareme', 'Diourbel'),
(32, '0022', 'Sarr', 'Yande', '2019-01-06', 'testadresse', '22178878778', '33877688778', '', '', 'a360fc05ee4ae58fc99ac505debb69b4', '7751095474001', '', 'imgDefaultIndividu.jpg', 3, 8, 0, NULL, NULL, 0, 22, 'Celibataire sans enfant', '65237253752q375', NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Mamadou', 'Fatou', 'kaolack'),
(33, '0023', 'Faye', 'Yacine', '2017-10-29', 'testadresse', '2218768778788787', '766787887', 'maxthiema@gmail.com', 'maxthiema@gmail.com', '102248072b52c7543c24454ce55cf645', '7174143494066', '', 'imgDefaultIndividu.jpg', 3, 8, 0, NULL, NULL, 0, 22, 'Celibataire sans enfant', '65237253752q375', NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Mbaye', 'Fatou', 'kaolack'),
(34, '0024', 'Fall', 'Marie', '2008-04-06', 'testadresse', '22177899898', '97788787', 'maxthiema@gmail.com', 'maxthiema@gmail.com', 'f6175748ddd54b2740a5fcdde39b79c3', '7177492299457', '', 'imgDefaultIndividu.jpg', 3, 8, 0, NULL, NULL, 0, 22, 'Celibataire sans enfant', '9797080808090800', NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Adama', 'Awa', 'Diourbel'),
(35, '0025', 'Diagne', 'Mouhamed', '2014-10-05', 'test', '221686667897', '78676686', '', '', '115e858a7cae12ba2e945b455ebecb76', '7715786787796', '', 'imgDefaultIndividu.jpg', 3, 8, 0, NULL, NULL, 0, 22, 'Celibataire avec enfant', '', NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Bassirou', 'Fatou', 'dakar'),
(36, '0026', 'Mbaye', 'Leila', '2015-04-06', 'test', '22188788787', '6666767', '', '', 'b0e6cb35a7ee9c133eabb97df4e965df', '7507956747735', '', 'imgDefaultIndividu.jpg', 3, 8, 0, NULL, NULL, 0, 22, 'Celibataire sans enfant', '', NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Adama', 'Awa', 'dakar'),
(37, '0027', 'Fall', 'Ndeye', '2016-10-02', 'test', '22177789090', '33878879', 'maxthiema@gmail.com', 'maxthiema@gmail.com', 'f21e1d19a3eddf048d412f0cfaedf034', '7314727176729', '', 'imgDefaultIndividu.jpg', 3, 8, 0, NULL, NULL, 0, 22, 'Celibataire sans enfant', '', NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Adama', 'Mareme', 'dakar'),
(38, '0028', 'Faye', 'Amath', '2012-12-02', 'test', '2217789987657575', '33654656776', 'maxthiema@gmail.com', 'maxthiema@gmail.com', '8ec9fda615d602d95ec884522c3916eb', '7532875535973', '', 'imgDefaultIndividu.jpg', 3, 8, 1, NULL, NULL, 0, 22, 'Celibataire sans enfant', '', NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Mbaye', 'Ndeye', 'dakar'),
(39, '0030', 'Diallo', 'Amath', '2014-11-02', 'test', '221677868878', '786876786', 'maxthiema@gmail.com', 'maxthiema@gmail.com', '29cc89aa554f5a78e5fff7abcf8d42e0', '7909085467637', '', 'imgDefaultIndividu.jpg', 3, 8, 1, NULL, NULL, 0, 22, 'Celibataire sans enfant', '', NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Adama', 'Awa', 'dakar'),
(40, '0031', 'GUEYE', 'Mouhamed', '2020-09-12', 'Keur massar', '00221774119865', '00221339619876', 'younaby@gmail.com', 'younaby@gmail.com', '4257801dbc1af8ba0828e7e55a09a231', '7245012707657', '&lt;p&gt;lslsos&lt;/p&gt;', 'imgDefaultIndividu.jpg', 3, 8, 1, NULL, NULL, 0, 22, 'Celibataire sans enfant', '', NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Malick NDIAYE', 'Mariama BOYE', 'Saint Louis'),
(41, '0032', 'Ndiaye', 'Ibra', '2008-08-31', 'testadresse', '2217575777', '77798980990099', 'maxthiema@gmail.com', 'maxthiema@gmail.com', '7518ff8021f8cac12d839438c5f8dd16', '7212257909401', '', 'imgDefaultIndividu.jpg', 3, 8, 1, NULL, NULL, 0, 22, 'Celibataire sans enfant', '', NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Mamadou', 'Ndeye', 'Diourbel'),
(42, '0033', 'CEMAD', 'Wilfried', '2011-07-03', 'Keur massar', '00221774119865', '', '', '', '62ef1b5f6c95db4ef0dad14d82d30b12', '7761147871352', '', 'imgDefaultIndividu.jpg', 3, 8, 0, NULL, NULL, 0, 22, '', '', NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'TEST', 'Ndeye Maguette DIAGNE', 'BAOL'),
(43, '0034', 'Diouf', 'Cheikh', '2016-03-13', 'testadresse', '2217666677', '67677676766776', 'maxthiema@gmail.com', 'maxthiema@gmail.com', '35b0c1f22e99dd2e4cb83eefea1ebfdd', '7501271443762', '', 'imgDefaultIndividu.jpg', 3, 8, 1, NULL, NULL, 0, 22, 'Celibataire sans enfant', '', NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Adama', 'Mareme', 'dakar'),
(44, '0037', 'GUEYE', 'TEST', '2020-11-03', 'Keur massar', '00221774119865', '', 'maguette.diagne@samaecole.com', '', '75f7b31103dad19af5b02814a4396373', '7319221731085', '', 'imgDefaultIndividu.jpg', 3, 8, 0, NULL, NULL, 0, 22, 'Celibataire sans enfant', '', NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Malick NDIAYE', 'Mariama BOYE', 'Saint Louis'),
(45, '0039', 'Diallo', 'Mouhamed', '2009-07-05', 'testadresse', '2217888768667', '57657657576', 'maxthiema@gmail.com', 'maxthiema@gmail.com', '340c985817bdc6d4265694ac2b054a58', '7448846123014', '', 'imgDefaultIndividu.jpg', 3, 8, 1, NULL, NULL, 0, 22, 'Celibataire sans enfant', '', NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Mamadou', 'Awa', 'dakar');

-- --------------------------------------------------------

--
-- Structure de la table `INSCRIPTION`
--

CREATE TABLE `INSCRIPTION` (
  `IDINSCRIPTION` int(11) NOT NULL,
  `DATEINSCRIPT` date DEFAULT NULL,
  `FRAIS_INSCRIPTION` int(11) NOT NULL,
  `MONTANT` int(11) DEFAULT '0',
  `ACCOMPTE_VERSE` int(11) DEFAULT NULL,
  `STATUT` tinyint(4) DEFAULT '0',
  `IDNIVEAU` int(11) DEFAULT '0',
  `IDINDIVIDU` int(11) DEFAULT '0',
  `IDETABLISSEMENT` int(11) DEFAULT '0',
  `IDANNEESSCOLAIRE` int(11) DEFAULT '0',
  `IDSERIE` int(11) DEFAULT '0',
  `DERNIER_ETAB` varchar(100) DEFAULT '',
  `VALIDETUDE` smallint(6) DEFAULT '0',
  `FRAIS_DOSSIER` int(11) DEFAULT NULL,
  `FRAIS_EXAMEN` int(11) NOT NULL DEFAULT '0',
  `UNIFORME` int(11) DEFAULT NULL,
  `VACCINATION` int(11) DEFAULT NULL,
  `ASSURANCE` int(11) DEFAULT NULL,
  `FRAIS_SOUTENANCE` int(11) DEFAULT NULL,
  `TRANSPORT` tinyint(1) DEFAULT '0' COMMENT '0:non; 1:oui',
  `MONTANT_TRANSPORT` int(11) DEFAULT NULL,
  `MONTANT_DOSSIER` int(11) DEFAULT '0',
  `MONTANT_EXAMEN` int(11) DEFAULT '0',
  `MONTANT_UNIFORME` int(11) DEFAULT '0',
  `MONTANT_VACCINATION` int(11) DEFAULT '0',
  `MONTANT_ASSURANCE` int(11) DEFAULT '0',
  `MONTANT_SOUTENANCE` int(11) DEFAULT '0',
  `RESULTAT_ANNUEL` int(11) DEFAULT '0',
  `ACCORD_MENSUELITE` int(11) DEFAULT NULL,
  `FK_SECTION` int(11) NOT NULL DEFAULT '0',
  `ETAT` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Valide, 0=Annulé',
  `MOTIF_ANNULATION` varchar(200) DEFAULT NULL,
  `NBRE_EXONORE` int(11) NOT NULL DEFAULT '0',
  `FK_TYPE_EXONERATION` int(11) NOT NULL DEFAULT '0',
  `DATE_AB_TRANSPORT` datetime DEFAULT NULL,
  `DATE_DESAB_TRANSPORT` datetime DEFAULT NULL,
  `FIRST_LAST_MONTH` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 : oui paye; 0:non payé',
  `TROUSSEAU` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:non complet; 1:complet',
  `FK_MOYENPAIEMENT` int(11) NOT NULL DEFAULT '1',
  `NUM_CHEQUE` varchar(100) DEFAULT NULL,
  `FK_BANQUE` int(11) DEFAULT NULL,
  `AVANCE` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:non; 1:oui',
  `NBRE_MOIS` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `INSCRIPTION`
--

INSERT INTO `INSCRIPTION` (`IDINSCRIPTION`, `DATEINSCRIPT`, `FRAIS_INSCRIPTION`, `MONTANT`, `ACCOMPTE_VERSE`, `STATUT`, `IDNIVEAU`, `IDINDIVIDU`, `IDETABLISSEMENT`, `IDANNEESSCOLAIRE`, `IDSERIE`, `DERNIER_ETAB`, `VALIDETUDE`, `FRAIS_DOSSIER`, `FRAIS_EXAMEN`, `UNIFORME`, `VACCINATION`, `ASSURANCE`, `FRAIS_SOUTENANCE`, `TRANSPORT`, `MONTANT_TRANSPORT`, `MONTANT_DOSSIER`, `MONTANT_EXAMEN`, `MONTANT_UNIFORME`, `MONTANT_VACCINATION`, `MONTANT_ASSURANCE`, `MONTANT_SOUTENANCE`, `RESULTAT_ANNUEL`, `ACCORD_MENSUELITE`, `FK_SECTION`, `ETAT`, `MOTIF_ANNULATION`, `NBRE_EXONORE`, `FK_TYPE_EXONERATION`, `DATE_AB_TRANSPORT`, `DATE_DESAB_TRANSPORT`, `FIRST_LAST_MONTH`, `TROUSSEAU`, `FK_MOYENPAIEMENT`, `NUM_CHEQUE`, `FK_BANQUE`, `AVANCE`, `NBRE_MOIS`) VALUES
(2, '2020-11-12', 50000, 25000, 0, 0, 3, 7, 3, 1, 5, '\'\'\'NULL\'\'\'', 0, 2000, 3000, 0, 0, 0, 0, 1, 21000, 0, 0, 0, 0, 0, 0, 0, 25000, 2, 1, NULL, 3, 5, NULL, NULL, 1, 0, 1, '0', 0, 1, 2),
(3, '2020-04-24', 1000, 15000, 0, 0, 2, 8, 3, 1, 4, '\'AMA SCHOOL\'', 0, 0, 2000, 35000, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 15000, 0, 0, '', 0, 0, NULL, NULL, 1, 1, 1, NULL, NULL, 0, 0),
(4, '2020-11-12', 1000, 15000, 0, 0, 2, 9, 3, 1, 4, '\'\'LA SAGESSE\'\'', 0, 0, 2000, 0, 0, 0, 0, 1, 18000, 0, 0, 0, 0, 0, 0, 0, 15000, 1, 1, NULL, 0, 0, NULL, NULL, 1, 0, 1, 'NULL', 0, 1, 1),
(5, '2020-04-24', 1000, 15000, 0, 0, 2, 12, 3, 1, 4, 'NULL', 0, 0, 2000, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 15000, 0, 1, NULL, 0, 0, NULL, NULL, 1, 0, 1, NULL, NULL, 0, 0),
(6, '2020-10-13', 1000, 15000, 0, 0, 2, 13, 3, 1, 4, '\'LA SAGESSE\'', 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 15000, 0, 1, NULL, 0, 0, NULL, NULL, 1, 0, 1, NULL, NULL, 0, 0),
(7, '2020-10-13', 1000, 15000, 0, 0, 2, 14, 3, 1, 4, 'NULL', 0, 10000, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 15000, 0, 1, NULL, 0, 0, NULL, NULL, 1, 0, 1, NULL, NULL, 0, 0),
(8, '2020-11-12', 50000, 25000, 0, 0, 3, 15, 3, 1, 5, '\'NULL\'', 0, 2000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 25000, 0, 1, NULL, 0, 0, NULL, NULL, 1, 0, 2, '5656565657578', 5, 1, 3),
(9, '2020-10-14', 1000, 15000, 0, 0, 2, 17, 3, 1, 4, 'NULL', 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 15000, 0, 1, NULL, 0, 0, NULL, NULL, 1, 0, 1, NULL, NULL, 0, 0),
(10, '2020-10-15', 20000, 30000, 0, 0, 3, 16, 3, 1, 2, 'NULL', 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 30000, 0, 1, NULL, 0, 0, NULL, NULL, 1, 0, 1, NULL, NULL, 0, 0),
(11, '2020-10-15', 20000, 30000, 0, 0, 3, 18, 3, 1, 1, 'NULL', 0, 0, 0, 55000, 0, 0, NULL, 1, 21000, 0, 0, 0, 0, 0, 0, 0, 30000, 2, 1, NULL, 0, 0, NULL, NULL, 1, 1, 1, NULL, NULL, 0, 0),
(23, '2020-10-15', 15000, 20000, 0, 0, 2, 22, 3, 1, 4, 'NULL', 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 20000, 0, 1, NULL, 0, 0, NULL, NULL, 1, 0, 1, NULL, NULL, 0, 0),
(26, '2020-10-20', 15000, 20000, 0, 0, 2, 24, 3, 1, 4, 'NULL', 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 20000, 0, 1, NULL, 0, 0, NULL, NULL, 1, 0, 1, NULL, NULL, 0, 0),
(28, '2020-10-20', 15000, 20000, 0, 0, 2, 25, 3, 2, 4, 'NULL', 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 20000, 0, 1, NULL, 0, 0, NULL, NULL, 1, 0, 1, NULL, NULL, 0, 0),
(29, '2020-10-22', 15000, 20000, 0, 0, 2, 25, 3, 1, 4, 'NULL', 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 20000, 0, 0, '', 0, 0, NULL, NULL, 1, 0, 1, NULL, NULL, 0, 0),
(35, '2020-10-27', 15000, 20000, 0, 0, 2, 26, 3, 1, 4, 'NULL', 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 20000, 0, 1, NULL, 0, 0, NULL, NULL, 1, 0, 2, '78676778', NULL, 0, 0),
(36, '2020-10-27', 15000, 20000, 0, 0, 2, 27, 3, 1, 4, 'NULL', 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 20000, 0, 1, NULL, 0, 0, NULL, NULL, 1, 0, 2, '7676677887778878', NULL, 0, 0),
(38, '2020-10-27', 15000, 20000, 0, 0, 2, 32, 3, 1, 4, 'NULL', 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 20000, 0, 1, NULL, 0, 0, NULL, NULL, 1, 0, 1, 'NULL', NULL, 0, 0),
(39, '2020-10-27', 15000, 20000, 0, 0, 2, 33, 3, 1, 4, 'NULL', 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 20000, 0, 1, NULL, 0, 0, NULL, NULL, 1, 0, 2, '887867876', NULL, 0, 0),
(40, '2020-10-27', 20000, 30000, 0, 0, 3, 34, 3, 1, 2, 'NULL', 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 30000, 0, 1, NULL, 0, 0, NULL, NULL, 1, 0, 1, 'NULL', NULL, 0, 0),
(41, '2020-10-27', 15000, 20000, 0, 0, 2, 35, 3, 1, 4, 'NULL', 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 20000, 0, 1, NULL, 0, 0, NULL, NULL, 1, 0, 1, 'NULL', NULL, 0, 0),
(42, '2020-10-27', 15000, 20000, 0, 0, 2, 36, 3, 1, 4, 'NULL', 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 20000, 0, 1, NULL, 0, 0, NULL, NULL, 1, 0, 1, 'NULL', NULL, 0, 0),
(43, '2020-10-27', 15000, 20000, 0, 0, 2, 37, 3, 1, 4, 'NULL', 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 20000, 0, 1, NULL, 0, 0, NULL, NULL, 1, 0, 1, 'NULL', NULL, 0, 0),
(44, '2020-10-27', 15000, 20000, 0, 0, 2, 38, 3, 1, 4, 'NULL', 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 20000, 0, 1, NULL, 0, 0, NULL, NULL, 1, 0, 1, 'NULL', NULL, 0, 0),
(46, '2020-11-12', 20000, 30000, 0, 0, 3, 39, 3, 1, 2, '\'\'\'NULL\'\'\'', 0, 0, 0, 40000, 0, 0, 0, 1, 18000, 0, 0, 20000, 0, 0, 0, 0, 30000, 1, 1, NULL, 0, 0, NULL, NULL, 1, 0, 2, '100190299292', 2, 1, 2),
(47, '2020-11-03', 15000, 20000, 0, 0, 2, 40, 3, 1, 4, 'NULL', 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 20000, 0, 1, NULL, 0, 0, NULL, NULL, 1, 0, 1, 'NULL', NULL, 0, 0),
(48, '2020-11-03', 15000, 20000, 0, 0, 2, 41, 3, 1, 4, 'NULL', 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 20000, 0, 1, NULL, 0, 0, NULL, NULL, 1, 0, 1, 'NULL', NULL, 0, 0),
(49, '2020-11-03', 15000, 20000, 0, 0, 2, 42, 3, 1, 4, 'NULL', 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 20000, 0, 1, NULL, 0, 0, NULL, NULL, 1, 0, 1, 'NULL', NULL, 0, 0),
(50, '2020-11-03', 15000, 20000, 0, 0, 2, 43, 3, 1, 4, 'NULL', 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 20000, 0, 1, NULL, 0, 0, NULL, NULL, 1, 0, 1, 'NULL', NULL, 0, 0),
(53, '2020-11-03', 15000, 20000, 0, 0, 2, 44, 3, 1, 4, 'NULL', 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 20000, 0, 1, NULL, 0, 0, NULL, NULL, 1, 0, 2, '100190299292', 4, 0, 0),
(55, '2020-11-27', 0, 0, 0, 0, 3, 45, 3, 1, 2, '\'\'\'LA SAGESSE\'\'\'', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 30000, 0, 1, NULL, 0, 0, NULL, NULL, 1, 0, 2, '100190299292', 4, 1, 8);

-- --------------------------------------------------------

--
-- Structure de la table `MATIERE`
--

CREATE TABLE `MATIERE` (
  `IDMATIERE` int(11) NOT NULL,
  `LIBELLE` varchar(100) DEFAULT NULL,
  `BASE_NOTES` int(2) NOT NULL DEFAULT '0',
  `IDNIVEAU` int(11) NOT NULL,
  `IDETABLISSEMENT` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `MATIERE`
--

INSERT INTO `MATIERE` (`IDMATIERE`, `LIBELLE`, `BASE_NOTES`, `IDNIVEAU`, `IDETABLISSEMENT`) VALUES
(1, 'MATHEMATIQUE', 20, 3, 3),
(2, 'FRANCAIS', 20, 3, 3),
(3, 'SVT', 20, 3, 3),
(6, 'PHYSIQUE CHIMIE', 20, 3, 3),
(7, 'ORTHOGRAPHE', 10, 2, 3),
(8, 'CONJUGAISON', 10, 2, 3),
(9, 'ACTIVITE NUMERIQUE', 20, 2, 3);

-- --------------------------------------------------------

--
-- Structure de la table `MATIERE_ENSEIGNE`
--

CREATE TABLE `MATIERE_ENSEIGNE` (
  `ID` int(11) NOT NULL,
  `ID_INDIVIDU` int(11) NOT NULL,
  `ID_MATIERE` int(11) NOT NULL,
  `IDETABLISSEMENT` int(11) NOT NULL,
  `IDANNESCOLAIRE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `MATIERE_ENSEIGNE`
--

INSERT INTO `MATIERE_ENSEIGNE` (`ID`, `ID_INDIVIDU`, `ID_MATIERE`, `IDETABLISSEMENT`, `IDANNESCOLAIRE`) VALUES
(1, 1, 1, 3, 1),
(2, 2, 2, 3, 1),
(3, 3, 3, 3, 1),
(4, 3, 6, 3, 1),
(5, 10, 7, 3, 1),
(6, 10, 8, 3, 1),
(7, 10, 9, 3, 1),
(8, 20, 1, 3, 1),
(9, 20, 2, 3, 1),
(10, 20, 3, 3, 1);

-- --------------------------------------------------------

--
-- Structure de la table `MATIERE_UE`
--

CREATE TABLE `MATIERE_UE` (
  `iduematiere` int(11) NOT NULL,
  `IDUE` int(11) DEFAULT '0',
  `IDMATIERE` int(11) DEFAULT '0',
  `nbcredit` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `MENSUALITE`
--

CREATE TABLE `MENSUALITE` (
  `IDMENSUALITE` int(11) NOT NULL,
  `MOIS` varchar(25) DEFAULT NULL,
  `MONTANT` decimal(10,0) DEFAULT '0',
  `DATEREGLMT` date DEFAULT NULL,
  `IDINSCRIPTION` int(11) DEFAULT '0',
  `IDETABLISSEMENT` int(11) DEFAULT '0',
  `MT_VERSE` decimal(10,0) DEFAULT '0',
  `MT_RELIQUAT` decimal(10,0) DEFAULT '0',
  `id_type_paiment` int(11) DEFAULT NULL,
  `NUMFACT` varchar(25) NOT NULL,
  `NUM_CHEQUE` varchar(25) DEFAULT NULL,
  `FK_BANQUE` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `MENSUALITE`
--

INSERT INTO `MENSUALITE` (`IDMENSUALITE`, `MOIS`, `MONTANT`, `DATEREGLMT`, `IDINSCRIPTION`, `IDETABLISSEMENT`, `MT_VERSE`, `MT_RELIQUAT`, `id_type_paiment`, `NUMFACT`, `NUM_CHEQUE`, `FK_BANQUE`) VALUES
(3, 'OCTOBRE / 2019', '25000', '2020-04-24', 2, 3, '25000', '0', 2, 'FACT6144023', NULL, NULL),
(4, 'JUILLET / 2020', '25000', '2020-04-24', 2, 3, '25000', '0', 2, 'FACT5582533', NULL, NULL),
(5, 'OCTOBRE / 2019', '15000', '2020-04-24', 3, 3, '15000', '0', 2, 'FACT5721843', NULL, NULL),
(6, 'JUILLET / 2020', '15000', '2020-04-24', 3, 3, '15000', '0', 2, 'FACT9006913', NULL, NULL),
(7, 'OCTOBRE / 2019', '15000', '2020-04-24', 4, 3, '15000', '0', 2, 'FACT4548363', NULL, NULL),
(8, 'JUILLET / 2020', '15000', '2020-04-24', 4, 3, '15000', '0', 2, 'FACT4641203', NULL, NULL),
(9, 'OCTOBRE / 2019', '15000', '2020-04-24', 5, 3, '15000', '0', 2, 'FACT6524933', NULL, NULL),
(10, 'JUILLET / 2020', '15000', '2020-04-24', 5, 3, '15000', '0', 2, 'FACT8084273', NULL, NULL),
(11, 'OCTOBRE / 2019', '15000', '2020-10-13', 6, 3, '15000', '0', 2, 'FACT8343223', NULL, NULL),
(12, 'JUILLET / 2020', '15000', '2020-10-13', 6, 3, '15000', '0', 2, 'FACT6706033', NULL, NULL),
(13, 'OCTOBRE / 2019', '15000', '2020-10-13', 7, 3, '15000', '0', 2, 'FACT2622453', NULL, NULL),
(14, 'JUILLET / 2020', '15000', '2020-10-13', 7, 3, '15000', '0', 2, 'FACT8159883', NULL, NULL),
(15, 'OCTOBRE / 2019', '25000', '2020-10-13', 8, 3, '25000', '0', 2, 'FACT5036223', NULL, NULL),
(16, 'JUILLET / 2020', '25000', '2020-10-13', 8, 3, '25000', '0', 2, 'FACT8325813', NULL, NULL),
(17, 'OCTOBRE / 2019', '15000', '2020-10-14', 9, 3, '15000', '0', 2, 'FACT7175853', NULL, NULL),
(18, 'JUILLET / 2020', '15000', '2020-10-14', 9, 3, '15000', '0', 2, 'FACT8204343', NULL, NULL),
(19, 'OCTOBRE / 2019', '30000', '2020-10-15', 10, 3, '30000', '0', 2, 'FACT7821153', NULL, NULL),
(20, 'JUILLET / 2020', '30000', '2020-10-15', 10, 3, '30000', '0', 2, 'FACT8615873', NULL, NULL),
(21, 'OCTOBRE / 2019', '30000', '2020-10-15', 11, 3, '30000', '0', 2, 'FACT4212603', NULL, NULL),
(22, 'JUILLET / 2020', '30000', '2020-10-15', 11, 3, '30000', '0', 2, 'FACT9721603', NULL, NULL),
(27, 'OCTOBRE / 2019', '20000', '2020-10-15', 23, 3, '20000', '0', 2, 'FACT4121923', NULL, NULL),
(28, 'JUILLET / 2020', '20000', '2020-10-15', 23, 3, '20000', '0', 2, 'FACT3080553', NULL, NULL),
(31, 'OCTOBRE / 2019', '20000', '2020-10-20', 28, 3, '20000', '0', 2, 'FACT8075493', NULL, NULL),
(32, 'JUILLET / 2020', '20000', '2020-10-20', 28, 3, '20000', '0', 2, 'FACT8752693', NULL, NULL),
(33, 'OCTOBRE / 2019', '20000', '2020-10-22', 29, 3, '20000', '0', 2, 'FACT4625763', NULL, NULL),
(34, 'JUILLET / 2020', '20000', '2020-10-22', 29, 3, '20000', '0', 2, 'FACT8544513', NULL, NULL),
(43, 'OCTOBRE / 2019', '20000', '2020-10-27', 36, 3, '20000', '0', 2, 'FACT7319583', NULL, NULL),
(44, 'JUILLET / 2020', '20000', '2020-10-27', 36, 3, '20000', '0', 2, 'FACT7166933', NULL, NULL),
(45, 'OCTOBRE / 2019', '20000', '2020-10-27', 38, 3, '20000', '0', 2, 'FACT0642863', NULL, NULL),
(46, 'JUILLET / 2020', '20000', '2020-10-27', 38, 3, '20000', '0', 2, 'FACT1364613', NULL, NULL),
(47, 'NOVEMBRE / 2019', '20000', '2020-10-27', 38, 3, '20000', '0', 2, 'FACT8806383', NULL, NULL),
(48, '1- / 020', '20000', '2020-10-27', 38, 3, '20000', '0', 2, 'FACT9211793', NULL, NULL),
(49, 'OCTOBRE / 2019', '20000', '2020-10-27', 39, 3, '20000', '0', 2, 'FACT6670563', NULL, NULL),
(50, 'JUILLET / 2020', '20000', '2020-10-27', 39, 3, '20000', '0', 2, 'FACT2675713', NULL, NULL),
(51, 'NOVEMBRE / 2019', '20000', '2020-10-27', 39, 3, '20000', '0', 2, 'FACT6549253', NULL, NULL),
(52, '1- / 020', '20000', '2020-10-27', 39, 3, '20000', '0', 2, 'FACT6976273', NULL, NULL),
(53, '4- / 020', '20000', '2020-10-27', 39, 3, '20000', '0', 2, 'FACT6997953', NULL, NULL),
(54, 'OCTOBRE / 2019', '30000', '2020-10-27', 40, 3, '30000', '0', 2, 'FACT1558883', NULL, NULL),
(55, 'JUILLET / 2020', '30000', '2020-10-27', 40, 3, '30000', '0', 2, 'FACT2474793', NULL, NULL),
(56, 'NOVEMBRE / 2019', '30000', '2020-10-27', 40, 3, '30000', '0', 2, 'FACT7960613', NULL, NULL),
(57, '1- / 019', '30000', '2020-10-27', 40, 3, '30000', '0', 2, 'FACT6870193', NULL, NULL),
(58, '4- / 020', '30000', '2020-10-27', 40, 3, '30000', '0', 2, 'FACT6281163', NULL, NULL),
(59, '5- / 020', '30000', '2020-10-27', 40, 3, '30000', '0', 2, 'FACT1882363', NULL, NULL),
(60, 'OCTOBRE / 2019', '20000', '2020-10-27', 41, 3, '20000', '0', 2, 'FACT4988193', NULL, NULL),
(61, 'JUILLET / 2020', '20000', '2020-10-27', 41, 3, '20000', '0', 2, 'FACT5956393', NULL, NULL),
(62, 'JANVIER / -201', '20000', '2020-10-27', 41, 3, '20000', '0', 2, 'FACT3280273', NULL, NULL),
(63, 'JANVIER / -201', '20000', '2020-10-27', 41, 3, '20000', '0', 2, 'FACT2258183', NULL, NULL),
(64, 'JANVIER / -202', '20000', '2020-10-27', 41, 3, '20000', '0', 2, 'FACT5229513', NULL, NULL),
(65, 'OCTOBRE / 2019', '20000', '2020-10-27', 42, 3, '20000', '0', 2, 'FACT1085553', NULL, NULL),
(66, 'JUILLET / 2020', '20000', '2020-10-27', 42, 3, '20000', '0', 2, 'FACT4549183', NULL, NULL),
(67, 'JANVIER / -201', '20000', '2020-10-27', 42, 3, '20000', '0', 2, 'FACT9387353', NULL, NULL),
(68, 'OCTOBRE / 2019', '20000', '2020-10-27', 43, 3, '20000', '0', 2, 'FACT3172373', NULL, NULL),
(69, 'JUILLET / 2020', '20000', '2020-10-27', 43, 3, '20000', '0', 2, 'FACT7801453', NULL, NULL),
(70, 'JANVIER / -201', '20000', '2020-10-27', 43, 3, '20000', '0', 2, 'FACT5188313', NULL, NULL),
(71, 'JANVIER / -201', '20000', '2020-10-27', 43, 3, '20000', '0', 2, 'FACT0385163', NULL, NULL),
(72, 'JANVIER / 2020', '20000', '2020-10-27', 43, 3, '20000', '0', 2, 'FACT2293603', NULL, NULL),
(73, 'MAI / 2020', '20000', '2020-10-27', 43, 3, '20000', '0', 2, 'FACT7335003', NULL, NULL),
(74, 'JUIN / 2020', '20000', '2020-10-27', 43, 3, '20000', '0', 2, 'FACT2939613', NULL, NULL),
(75, 'OCTOBRE / 2019', '20000', '2020-10-27', 44, 3, '20000', '0', 2, 'FACT4865123', NULL, NULL),
(76, 'JUILLET / 2020', '20000', '2020-10-27', 44, 3, '20000', '0', 2, 'FACT3731423', NULL, NULL),
(77, 'NOVEMBRE / 2019', '20000', '2020-10-27', 44, 3, '20000', '0', 2, 'FACT7418233', NULL, NULL),
(78, 'DECEMBRE / 2019', '20000', '2020-10-27', 44, 3, '20000', '0', 2, 'FACT3289563', NULL, NULL),
(79, 'JANVIER / 2020', '20000', '2020-10-27', 44, 3, '20000', '0', 2, 'FACT4053403', NULL, NULL),
(80, 'FEVRIER / 2020', '20000', '2020-10-27', 44, 3, '20000', '0', 2, 'FACT8146703', NULL, NULL),
(81, 'MARS / 2020', '20000', '2020-10-27', 44, 3, '20000', '0', 2, 'FACT1311103', NULL, NULL),
(84, 'OCTOBRE / 2019', '30000', '2020-10-29', 46, 3, '30000', '0', 2, 'FACT0804903', NULL, NULL),
(85, 'JUILLET / 2020', '30000', '2020-10-29', 46, 3, '30000', '0', 2, 'FACT2953183', NULL, NULL),
(86, 'NOVEMBRE / 2019', '30000', '2020-10-29', 46, 3, '30000', '0', 2, 'FACT2308423', NULL, NULL),
(87, 'DECEMBRE / 2019', '30000', '2020-10-29', 46, 3, '30000', '0', 2, 'FACT4027133', NULL, NULL),
(88, 'JANVIER / 2020', '30000', '2020-10-29', 46, 3, '30000', '0', 2, 'FACT7910253', NULL, NULL),
(89, 'OCTOBRE / 2019', '20000', '2020-11-03', 47, 3, '20000', '0', 2, 'FACT5245653', NULL, NULL),
(90, 'JUILLET / 2020', '20000', '2020-11-03', 47, 3, '20000', '0', 2, 'FACT0746643', NULL, NULL),
(91, 'OCTOBRE / 2019', '20000', '2020-11-03', 48, 3, '20000', '0', 2, 'FACT5193193', NULL, NULL),
(92, 'JUILLET / 2020', '20000', '2020-11-03', 48, 3, '20000', '0', 2, 'FACT1518433', NULL, NULL),
(93, 'NOVEMBRE / 2019', '20000', '2020-11-03', 48, 3, '20000', '0', 2, 'FACT1985513', NULL, NULL),
(94, 'DECEMBRE / 2019', '20000', '2020-11-03', 48, 3, '20000', '0', 2, 'FACT3217773', NULL, NULL),
(95, 'OCTOBRE / 2019', '20000', '2020-11-03', 49, 3, '20000', '0', 2, 'FACT6916163', NULL, NULL),
(96, 'JUILLET / 2020', '20000', '2020-11-03', 49, 3, '20000', '0', 2, 'FACT7700893', NULL, NULL),
(97, 'OCTOBRE / 2019', '20000', '2020-11-03', 50, 3, '20000', '0', 2, 'FACT8871433', NULL, NULL),
(98, 'JUILLET / 2020', '20000', '2020-11-03', 50, 3, '20000', '0', 2, 'FACT8239443', NULL, NULL),
(99, 'NOVEMBRE / 2019', '20000', '2020-11-03', 50, 3, '20000', '0', 2, 'FACT8192023', NULL, NULL),
(100, 'DECEMBRE / 2019', '20000', '2020-11-03', 50, 3, '20000', '0', 2, 'FACT9380893', NULL, NULL),
(101, 'JANVIER / 2020', '20000', '2020-11-03', 50, 3, '20000', '0', 2, 'FACT5855133', NULL, NULL),
(104, 'OCTOBRE / 2019', '20000', '2020-11-03', 53, 3, '20000', '0', 2, 'FACT4725063', NULL, NULL),
(105, 'JUILLET / 2020', '20000', '2020-11-03', 53, 3, '20000', '0', 2, 'FACT8244193', NULL, NULL),
(106, 'NOVEMBRE / 2019', '20000', '2020-11-03', 53, 3, '20000', '0', 2, 'FACT9050803', NULL, NULL),
(107, 'DECEMBRE / 2019', '20000', '2020-11-03', 53, 3, '20000', '0', 2, 'FACT5852893', NULL, NULL),
(108, 'JANVIER / 2020', '20000', '2020-11-03', 53, 3, '20000', '0', 2, 'FACT0139403', NULL, NULL),
(111, 'NOVEMBRE / 2019', '0', '2020-11-12', 8, 3, '0', '0', 2, 'FACT5767353', NULL, NULL),
(112, 'DECEMBRE / 2019', '0', '2020-11-12', 8, 3, '0', '0', 2, 'FACT0325893', NULL, NULL),
(113, 'JANVIER / 2020', '0', '2020-11-12', 8, 3, '0', '0', 2, 'FACT7034673', NULL, NULL),
(114, 'NOVEMBRE / 2019', '21000', '2020-11-12', 2, 3, '21000', '0', 2, 'FACT1395593', NULL, NULL),
(115, 'DECEMBRE / 2019', '25000', '2020-11-12', 2, 3, '25000', '0', 2, 'FACT4036333', NULL, NULL),
(116, 'NOVEMBRE / 2019', '15000', '2020-11-12', 4, 3, '15000', '0', 2, 'FACT1413943', NULL, NULL),
(117, 'OCTOBRE / 2019', '30000', '2020-11-27', 55, 3, '30000', '0', 2, 'FACT5652393', NULL, NULL),
(118, 'JUILLET / 2020', '30000', '2020-11-27', 55, 3, '30000', '0', 2, 'FACT5058493', NULL, NULL),
(119, 'NOVEMBRE / 2019', '30000', '2020-11-27', 55, 3, '30000', '0', 2, 'FACT0758293', NULL, NULL),
(120, 'DECEMBRE / 2019', '30000', '2020-11-27', 55, 3, '30000', '0', 2, 'FACT2954123', NULL, NULL),
(121, 'JANVIER / 2020', '30000', '2020-11-27', 55, 3, '30000', '0', 2, 'FACT5467323', NULL, NULL),
(122, 'FEVRIER / 2020', '30000', '2020-11-27', 55, 3, '30000', '0', 2, 'FACT2395903', NULL, NULL),
(123, 'MARS / 2020', '30000', '2020-11-27', 55, 3, '30000', '0', 2, 'FACT9215743', NULL, NULL),
(124, 'AVRIL / 2020', '30000', '2020-11-27', 55, 3, '30000', '0', 2, 'FACT7007063', NULL, NULL),
(125, 'MAI / 2020', '30000', '2020-11-27', 55, 3, '30000', '0', 2, 'FACT8780213', NULL, NULL),
(126, '18 / 2019', '30000', '2020-11-27', 55, 3, '30000', '0', 2, 'FACT2483233', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `MESSAGERIE`
--

CREATE TABLE `MESSAGERIE` (
  `IDMESSAGERIE` int(11) NOT NULL,
  `DATE_MESSAGE` datetime DEFAULT NULL,
  `MESSAGE` text NOT NULL,
  `OBJET_MSG` varchar(100) NOT NULL,
  `IDETABLISSEMENT` int(11) NOT NULL,
  `IDINDIVIDU` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `MESSAGE_DESTINATAIRE`
--

CREATE TABLE `MESSAGE_DESTINATAIRE` (
  `ID` int(11) NOT NULL,
  `IDDEST` int(11) NOT NULL,
  `IDMESSAGERIE` int(11) NOT NULL,
  `LECTURE` tinyint(4) DEFAULT '0',
  `IDETABLISSEMENT` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `MODE_PAIEMENT`
--

CREATE TABLE `MODE_PAIEMENT` (
  `ROWID` int(11) NOT NULL,
  `LIBELLE` varchar(45) DEFAULT NULL,
  `NBRE_MOIS` int(11) NOT NULL DEFAULT '1',
  `ETAT` tinyint(1) NOT NULL DEFAULT '1',
  `IDETABLISSEMENT` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `MODE_PAIEMENT`
--

INSERT INTO `MODE_PAIEMENT` (`ROWID`, `LIBELLE`, `NBRE_MOIS`, `ETAT`, `IDETABLISSEMENT`) VALUES
(2, 'Mensuel', 1, 1, 3),
(3, 'Trimestrielle', 3, 1, 3),
(4, 'Semestrielle', 6, 1, 3),
(5, 'Annuel', 9, 1, 3);

-- --------------------------------------------------------

--
-- Structure de la table `MODULE`
--

CREATE TABLE `MODULE` (
  `idModule` int(11) NOT NULL,
  `nomModule` varchar(500) NOT NULL,
  `userCreation` int(11) NOT NULL,
  `dateCreation` datetime NOT NULL,
  `dateModification` datetime NOT NULL,
  `userModification` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `MODULE`
--

INSERT INTO `MODULE` (`idModule`, `nomModule`, `userCreation`, `dateCreation`, `dateModification`, `userModification`) VALUES
(1, 'TIERS', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(2, 'TRESORERIE', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(3, 'EMPLOIS DU TEMPS', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(4, 'EVALUATION', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(5, 'GED', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(6, 'EQUIPEMENTS', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(7, 'SANCTIONS', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(8, 'PARAMETRAGE', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(9, 'REPORTING', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Structure de la table `MOIS_EXONORE`
--

CREATE TABLE `MOIS_EXONORE` (
  `ROWID` int(11) NOT NULL,
  `IDINSCRIPTION` int(11) NOT NULL,
  `MOIS` varchar(75) NOT NULL,
  `VALIDE` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `MOIS_EXONORE`
--

INSERT INTO `MOIS_EXONORE` (`ROWID`, `IDINSCRIPTION`, `MOIS`, `VALIDE`) VALUES
(4, 6, '10-2019', 1),
(10, 2, '04-2020', 1),
(11, 2, '05-2020', 1),
(12, 2, '06-2020', 1);

-- --------------------------------------------------------

--
-- Structure de la table `MOYENNE_PERIODE`
--

CREATE TABLE `MOYENNE_PERIODE` (
  `ID` int(11) NOT NULL,
  `MOY` double NOT NULL,
  `IDINDIVIDU` int(11) NOT NULL,
  `IDCLASSROOM` int(11) NOT NULL,
  `IDPERIODE` int(11) NOT NULL,
  `IDANNEE` int(11) NOT NULL,
  `IDETABLISSEMENT` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `MOYENNE_PERIODE`
--

INSERT INTO `MOYENNE_PERIODE` (`ID`, `MOY`, `IDINDIVIDU`, `IDCLASSROOM`, `IDPERIODE`, `IDANNEE`, `IDETABLISSEMENT`) VALUES
(1, 0, 15, 7, 4, 1, 3),
(2, 0, 18, 7, 4, 1, 3);

-- --------------------------------------------------------

--
-- Structure de la table `MOYEN_PAIEMENT`
--

CREATE TABLE `MOYEN_PAIEMENT` (
  `IDMOYEN_PAIEMENT` int(11) NOT NULL,
  `LIB_MOYEN_PAIEMENT` varchar(50) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `MOYEN_PAIEMENT`
--

INSERT INTO `MOYEN_PAIEMENT` (`IDMOYEN_PAIEMENT`, `LIB_MOYEN_PAIEMENT`) VALUES
(2, 'CHEQUES'),
(1, 'ESPECES');

-- --------------------------------------------------------

--
-- Structure de la table `NIVEAU`
--

CREATE TABLE `NIVEAU` (
  `IDNIVEAU` int(11) NOT NULL,
  `LIBELLE` varchar(100) DEFAULT NULL,
  `IDETABLISSEMENT` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `NIVEAU`
--

INSERT INTO `NIVEAU` (`IDNIVEAU`, `LIBELLE`, `IDETABLISSEMENT`) VALUES
(1, 'PRESCOLAIRE', 3),
(2, 'ELEMENTAIRE', 3),
(3, 'MOYEN / SECONDAIRE', 3);

-- --------------------------------------------------------

--
-- Structure de la table `NIVEAU_SERIE`
--

CREATE TABLE `NIVEAU_SERIE` (
  `ID_NIV_SER` int(11) NOT NULL,
  `IDSERIE` int(11) DEFAULT NULL,
  `IDNIVEAU` int(11) NOT NULL,
  `MT_MENSUALITE` int(11) NOT NULL,
  `FRAIS_INSCRIPTION` int(11) DEFAULT NULL,
  `FRAIS_DOSSIER` int(11) DEFAULT NULL,
  `VACCINATION` int(11) DEFAULT NULL,
  `UNIFORME` int(11) DEFAULT NULL,
  `ASSURANCE` int(11) DEFAULT NULL,
  `FRAIS_EXAMEN` int(11) DEFAULT NULL,
  `FRAIS_SOUTENANCE` int(11) DEFAULT NULL,
  `FOURNITURE` int(11) DEFAULT NULL,
  `dure` int(11) DEFAULT NULL,
  `montant_total` decimal(18,6) DEFAULT NULL,
  `IDETABLISSEMENT` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `NIVEAU_SERIE`
--

INSERT INTO `NIVEAU_SERIE` (`ID_NIV_SER`, `IDSERIE`, `IDNIVEAU`, `MT_MENSUALITE`, `FRAIS_INSCRIPTION`, `FRAIS_DOSSIER`, `VACCINATION`, `UNIFORME`, `ASSURANCE`, `FRAIS_EXAMEN`, `FRAIS_SOUTENANCE`, `FOURNITURE`, `dure`, `montant_total`, `IDETABLISSEMENT`) VALUES
(1, NULL, 2, 20000, 15000, 0, 0, NULL, 0, NULL, NULL, 0, 9, '195000.000000', 3),
(2, NULL, 3, 30000, 20000, 0, 0, NULL, 0, NULL, NULL, 0, 9, '290000.000000', 3);

-- --------------------------------------------------------

--
-- Structure de la table `NIV_CLASSE`
--

CREATE TABLE `NIV_CLASSE` (
  `ID` int(11) NOT NULL,
  `LIBELLE` varchar(75) NOT NULL,
  `IDNIVEAU` int(11) NOT NULL,
  `IDETABLISSEMENT` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `NIV_CLASSE`
--

INSERT INTO `NIV_CLASSE` (`ID`, `LIBELLE`, `IDNIVEAU`, `IDETABLISSEMENT`) VALUES
(1, 'PETITE SECTION', 1, 3),
(2, 'MOYENNE SECTION', 1, 3),
(3, 'GRANDE SECTION', 1, 3),
(4, 'CI', 2, 3),
(5, 'CP', 2, 3),
(6, 'CE', 2, 3),
(7, 'CM1', 2, 3),
(8, 'CM2', 2, 3),
(9, '6eme', 3, 3),
(10, '5eme', 3, 3),
(11, '4eme', 3, 3),
(12, '3eme', 3, 3),
(13, 'SECONDE', 3, 3),
(15, 'PREMIERE', 3, 3),
(16, 'TERMINAL', 3, 3);

-- --------------------------------------------------------

--
-- Structure de la table `NOTE`
--

CREATE TABLE `NOTE` (
  `IDNOTE` int(11) NOT NULL,
  `NOTE` float DEFAULT '0',
  `IDCONTROLE` int(11) DEFAULT '0',
  `IDINDIVIDU` int(11) DEFAULT '0',
  `IDETABLISSEMENT` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `operateur`
--

CREATE TABLE `operateur` (
  `rowid` int(11) NOT NULL,
  `label` varchar(20) NOT NULL,
  `statut` int(11) NOT NULL,
  `token` varchar(100) DEFAULT NULL,
  `date_fin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `operateur`
--

INSERT INTO `operateur` (`rowid`, `label`, `statut`, `token`, `date_fin`) VALUES
(1, 'Orange', 1, 'mb1HrK3vri1jb8JIcQifsde6Hvp1', '2021-02-14');

-- --------------------------------------------------------

--
-- Structure de la table `PARENT`
--

CREATE TABLE `PARENT` (
  `idParent` int(11) NOT NULL DEFAULT '0',
  `ideleve` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

--
-- Déchargement des données de la table `PARENT`
--

INSERT INTO `PARENT` (`idParent`, `ideleve`) VALUES
(4, 5),
(4, 9),
(4, 13),
(4, 14),
(4, 16),
(4, 17),
(4, 19),
(4, 40),
(4, 42),
(4, 44),
(6, 7),
(6, 8),
(6, 25),
(6, 27),
(6, 36),
(6, 39),
(6, 45),
(11, 12),
(11, 15),
(11, 18),
(11, 33),
(11, 35),
(11, 37),
(21, 22),
(21, 26),
(21, 38),
(21, 41),
(21, 43),
(23, 24),
(23, 32),
(23, 34);

-- --------------------------------------------------------

--
-- Structure de la table `PAYS`
--

CREATE TABLE `PAYS` (
  `ROWID` int(11) NOT NULL,
  `CODE` varchar(2) COLLATE latin1_german1_ci NOT NULL,
  `CODE_ISO` varchar(3) COLLATE latin1_german1_ci DEFAULT NULL,
  `LIBELLE` varchar(50) COLLATE latin1_german1_ci NOT NULL,
  `ACTIVE` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

--
-- Déchargement des données de la table `PAYS`
--

INSERT INTO `PAYS` (`ROWID`, `CODE`, `CODE_ISO`, `LIBELLE`, `ACTIVE`) VALUES
(1, 'FR', NULL, 'France', 1),
(2, 'BE', NULL, 'Belgium', 1),
(3, 'IT', NULL, 'Italy', 1),
(4, 'ES', NULL, 'Spain', 1),
(5, 'DE', NULL, 'Germany', 1),
(6, 'CH', NULL, 'Suisse', 1),
(7, 'GB', NULL, 'United Kingdom', 1),
(8, 'IE', NULL, 'Irland', 1),
(9, 'CN', NULL, 'China', 1),
(10, 'TN', NULL, 'Tunisie', 1),
(11, 'US', NULL, 'United States', 1),
(12, 'MA', NULL, 'Maroc', 1),
(13, 'DZ', NULL, 'Algérie', 1),
(14, 'CA', NULL, 'Canada', 1),
(15, 'TG', NULL, 'Togo', 1),
(16, 'GA', NULL, 'Gabon', 1),
(17, 'NL', NULL, 'Nerderland', 1),
(18, 'HU', NULL, 'Hongrie', 1),
(19, 'RU', NULL, 'Russia', 1),
(20, 'SE', NULL, 'Sweden', 1),
(21, 'CI', NULL, 'Côte d\'Ivoire', 1),
(22, 'SN', NULL, 'SENEGAL', 1),
(23, 'AR', NULL, 'Argentine', 1),
(24, 'CM', NULL, 'Cameroun', 1),
(25, 'PT', NULL, 'Portugal', 1),
(26, 'SA', NULL, 'Arabie Saoudite', 1),
(27, 'MC', NULL, 'Monaco', 1),
(28, 'AU', NULL, 'Australia', 1),
(29, 'SG', NULL, 'Singapour', 1),
(35, 'AO', NULL, 'Angola', 1),
(49, 'BJ', NULL, 'Bénin', 1),
(56, 'BR', NULL, 'Brésil', 1),
(57, 'IO', NULL, 'Territoire britannique de l\'Océan Indien', 1),
(60, 'BF', NULL, 'Burkina Faso', 1),
(61, 'BI', NULL, 'Burundi', 1),
(63, 'CV', NULL, 'Cap-Vert', 1),
(65, 'CF', NULL, 'République centrafricaine', 1),
(66, 'TD', NULL, 'Tchad', 1),
(71, 'KM', NULL, 'Comores', 1),
(72, 'CG', NULL, 'Congo', 1),
(73, 'CD', NULL, 'République démocratique du Congo', 1),
(81, 'DJ', NULL, 'Djibouti', 1),
(82, 'DM', NULL, 'Dominique', 1),
(83, 'DO', NULL, 'République Dominicaine', 1),
(84, 'EC', NULL, 'Equateur', 1),
(85, 'EG', NULL, 'Egypte', 1),
(87, 'GQ', NULL, 'Guinée Equatoriale', 1),
(88, 'ER', NULL, 'Erythrée', 1),
(90, 'ET', NULL, 'Ethiopie', 1),
(95, 'GF', NULL, 'Guyane française', 1),
(96, 'PF', NULL, 'Polynésie française', 1),
(97, 'TF', NULL, 'Terres australes françaises', 1),
(98, 'GM', NULL, 'Gambie', 1),
(100, 'GH', NULL, 'Ghana', 1),
(108, 'GN', NULL, 'Guinée', 1),
(109, 'GW', NULL, 'Guinée-Bissao', 1),
(126, 'KE', NULL, 'Kenya', 1),
(134, 'LB', NULL, 'Liban', 1),
(136, 'LR', NULL, 'Liberia', 1),
(137, 'LY', NULL, 'Libye', 1),
(143, 'MG', NULL, 'Madagascar', 1),
(147, 'ML', NULL, 'Mali', 1),
(151, 'MR', NULL, 'Mauritanie', 1),
(152, 'MU', NULL, 'Maurice', 1),
(159, 'MZ', NULL, 'Mozambique', 1),
(161, 'NA', NULL, 'Namibie', 1),
(164, 'AN', NULL, 'Antilles néerlandaises', 1),
(168, 'NE', NULL, 'Niger', 1),
(169, 'NG', NULL, 'Nigeria', 1),
(189, 'RW', NULL, 'Rwanda', 1),
(204, 'SO', NULL, 'Somalie', 1),
(205, 'ZA', NULL, 'Afrique du Sud', 1),
(215, 'TZ', NULL, 'Tanzanie', 1),
(227, 'AE', NULL, 'Émirats arabes unis', 1),
(237, 'EH', NULL, 'Sahara occidental', 1),
(239, 'ZM', NULL, 'Zambie', 1),
(240, 'ZW', NULL, 'Zimbabwe', 1);

-- --------------------------------------------------------

--
-- Structure de la table `PERIODE`
--

CREATE TABLE `PERIODE` (
  `IDPERIODE` int(11) NOT NULL,
  `NOM_PERIODE` varchar(100) DEFAULT NULL,
  `DEBUT_PERIODE` datetime DEFAULT NULL,
  `FIN_FPERIODE` datetime DEFAULT NULL,
  `IDANNEESSCOLAIRE` int(11) DEFAULT '0',
  `IDETABLISSEMENT` int(11) DEFAULT '0',
  `IDNIVEAU` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `PERIODE`
--

INSERT INTO `PERIODE` (`IDPERIODE`, `NOM_PERIODE`, `DEBUT_PERIODE`, `FIN_FPERIODE`, `IDANNEESSCOLAIRE`, `IDETABLISSEMENT`, `IDNIVEAU`) VALUES
(1, 'Premier Trimestre ', '2019-10-03 08:00:00', '2019-12-03 08:00:00', 1, 3, 2),
(2, 'Deuxième  Trimestre ', '2020-01-01 08:00:00', '2020-03-31 08:00:00', 1, 3, 2),
(3, 'Troisième Trimestre ', '2020-04-01 08:00:00', '2020-06-03 08:00:00', 1, 3, 2),
(4, 'SEMESTRE 1', '2019-10-01 08:00:00', '2020-02-29 08:00:00', 1, 3, 3),
(5, 'SEMESTRE 2', '2020-03-31 08:00:00', '2020-06-25 08:00:00', 1, 3, 3),
(6, 'Première Période ', '2020-03-09 08:00:00', '2020-04-09 08:00:00', 1, 3, 4),
(7, 'Première Période 2', '2020-03-09 08:00:00', '2020-04-18 08:00:00', 1, 3, 4);

-- --------------------------------------------------------

--
-- Structure de la table `PHAR`
--

CREATE TABLE `PHAR` (
  `ROWID` int(11) NOT NULL,
  `LIBELLE` varchar(100) DEFAULT NULL,
  `DESCRIPTION` text,
  `FK_MATIERE` int(11) NOT NULL,
  `FK_NIVEAU` int(11) NOT NULL,
  `FK_CYCLE` int(11) NOT NULL,
  `IDETABLISSEMENT` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `PIECE_JOINTE`
--

CREATE TABLE `PIECE_JOINTE` (
  `IDPIECE_JOINTE` int(11) NOT NULL,
  `IDMESSAGERIE` int(11) DEFAULT '0',
  `IDETABLISSEMENT` int(11) DEFAULT '0',
  `LIB_PIECESJOINTE` varchar(100) DEFAULT NULL,
  `PATH_PIECEJOINTE` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `PRESENCE_ELEVES`
--

CREATE TABLE `PRESENCE_ELEVES` (
  `IDPRESENCE_ELEVES` int(11) NOT NULL,
  `ETAT_PRESENCE` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:présent; 1:absent',
  `RETARD` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1:retard; 0:non retard',
  `IDETABLISSEMENT` int(11) DEFAULT '0',
  `IDDISPENSER_COURS` int(11) DEFAULT '0',
  `IDINDIVIDU` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `profil`
--

CREATE TABLE `profil` (
  `idProfil` int(11) NOT NULL,
  `profil` varchar(250) NOT NULL,
  `idEtablissement` int(11) NOT NULL,
  `dateCreation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `userCreation` int(11) NOT NULL,
  `dateModification` datetime NOT NULL,
  `userModification` int(11) NOT NULL,
  `etat` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `profil`
--

INSERT INTO `profil` (`idProfil`, `profil`, `idEtablissement`, `dateCreation`, `userCreation`, `dateModification`, `userModification`, `etat`) VALUES
(1, 'ADMINISTRATEUR', 0, '2020-03-09 10:10:27', 1, '2016-03-16 10:22:22', 1, 1),
(2, 'PERSONNEL ADMINISTRATIF', 0, '2016-03-16 10:22:22', 1, '2016-03-16 10:22:22', 1, 1),
(3, 'DIRECTEUR GENERAL', 0, '2016-03-16 10:22:22', 1, '2016-03-16 10:22:22', 1, 1),
(4, 'DIRECTEUR FINANCIER', 0, '2020-04-15 11:10:18', 1, '2016-03-16 10:22:22', 1, 1),
(5, 'SURVEILLANT GENERAL', 0, '2019-09-17 08:36:52', 1, '2016-03-16 10:22:22', 1, 1),
(6, 'SURVEILLANT', 0, '2016-03-16 10:22:22', 1, '2016-03-16 10:22:22', 1, 1),
(7, 'PROFESSEUR', 0, '2019-10-23 10:05:55', 1, '2016-03-16 10:22:22', 1, 1),
(8, 'ELEVE', 0, '2019-10-23 10:05:51', 1, '2016-03-16 10:22:22', 1, 1),
(9, 'PARENT', 3, '2019-10-23 10:05:48', 1, '2016-03-30 00:00:00', 1, 1),
(10, 'Chef de projet', 0, '2020-03-09 10:20:06', 1, '2019-10-23 11:28:36', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `RECRUTE_PROF`
--

CREATE TABLE `RECRUTE_PROF` (
  `IDRECRUTE_PROF` int(11) NOT NULL,
  `TARIF_HORAIRE` decimal(18,2) DEFAULT '0.00',
  `VOLUME_HORAIRE` int(11) DEFAULT NULL,
  `IDETABLISSEMENT` int(11) DEFAULT '0',
  `IDINDIVIDU` int(11) DEFAULT '0',
  `IDANNEESSCOLAIRE` int(11) DEFAULT '0',
  `TYPES` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:taux horaire, 1:forfait',
  `FK_FORFAIT` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `RECRUTE_PROF`
--

INSERT INTO `RECRUTE_PROF` (`IDRECRUTE_PROF`, `TARIF_HORAIRE`, `VOLUME_HORAIRE`, `IDETABLISSEMENT`, `IDINDIVIDU`, `IDANNEESSCOLAIRE`, `TYPES`, `FK_FORFAIT`) VALUES
(1, '0.00', 0, 3, 1, 1, 1, 3),
(2, '2000.00', 20, 3, 2, 1, 0, 0),
(3, '0.00', 0, 3, 3, 1, 1, 3),
(4, '0.00', 0, 3, 10, 1, 1, 1),
(5, '0.00', 0, 3, 20, 1, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `REGLEMENT`
--

CREATE TABLE `REGLEMENT` (
  `IDREGLEMENT` int(11) NOT NULL,
  `DATE_REGLMT` date DEFAULT NULL,
  `MT_REGLE` decimal(18,6) DEFAULT '0.000000',
  `NUM_PIECE` varchar(50) DEFAULT '',
  `IDMENSUALITE` int(11) DEFAULT '0',
  `IDMOYEN_PAIEMENT` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `REGLEMENT_PERSO`
--

CREATE TABLE `REGLEMENT_PERSO` (
  `IDREGLEMENT` int(11) NOT NULL,
  `DATE_REGLEMENT` date DEFAULT NULL,
  `MOIS` varchar(55) NOT NULL,
  `MONTANT` int(11) NOT NULL,
  `INDIVIDU` int(11) NOT NULL,
  `MOTIF` varchar(100) DEFAULT NULL,
  `IDTYPEPAIEMENT` int(11) NOT NULL,
  `recu` varchar(100) DEFAULT NULL,
  `IDANNEESCOLAIRE` int(11) NOT NULL,
  `NUM_CHEQUE` varchar(25) DEFAULT NULL,
  `FK_BANQUE` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `REGLEMENT_PROF`
--

CREATE TABLE `REGLEMENT_PROF` (
  `IDREGLEMENT` int(11) NOT NULL,
  `DATE_REGLEMENT` date DEFAULT NULL,
  `MOIS` varchar(55) DEFAULT NULL,
  `MONTANT` int(11) DEFAULT NULL,
  `INDIVIDU` int(11) DEFAULT NULL,
  `MOTIF` varchar(100) DEFAULT NULL,
  `IDTYPEPAIEMENT` int(11) NOT NULL,
  `recu` varchar(100) DEFAULT NULL,
  `IDANNEESCOLAIRE` int(11) NOT NULL,
  `MONTANT_VERSE` double NOT NULL DEFAULT '0',
  `RELIQUAT` double NOT NULL DEFAULT '0',
  `NUM_CHEQUE` varchar(45) DEFAULT NULL,
  `FK_BANQUE` int(11) DEFAULT NULL,
  `IDETABLISSEMENT` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `SALL_DE_CLASSE`
--

CREATE TABLE `SALL_DE_CLASSE` (
  `IDSALL_DE_CLASSE` int(11) NOT NULL,
  `NOM_SALLE` varchar(100) DEFAULT NULL,
  `IDTYPE_SALLE` int(11) DEFAULT '0',
  `IDETABLISSEMENT` int(11) DEFAULT '0',
  `NBR_PLACES` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `SALL_DE_CLASSE`
--

INSERT INTO `SALL_DE_CLASSE` (`IDSALL_DE_CLASSE`, `NOM_SALLE`, `IDTYPE_SALLE`, `IDETABLISSEMENT`, `NBR_PLACES`) VALUES
(1, 'SALLE1', 1, 3, 50),
(2, 'SALLE2', 2, 3, 55),
(3, 'SAlle Cheikh ANTA', 5, 3, 45),
(5, 'SAlle Cheikh ', 5, 3, 50);

-- --------------------------------------------------------

--
-- Structure de la table `SANCTION`
--

CREATE TABLE `SANCTION` (
  `IDSANCTION` int(11) NOT NULL,
  `DATE` date DEFAULT NULL,
  `MOTIF` varchar(100) DEFAULT NULL,
  `DATEDEBUT` datetime DEFAULT NULL,
  `DATEFIN` datetime DEFAULT NULL,
  `IDINDIVIDU` int(11) DEFAULT '0',
  `IDETABLISSEMENT` int(11) DEFAULT '0',
  `ID_AUTHORITE` int(11) DEFAULT NULL,
  `IDANNEE` int(11) NOT NULL,
  `IDTYPE_SANCTION` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `secteur_activite`
--

CREATE TABLE `secteur_activite` (
  `IDSECTEUR` int(11) NOT NULL,
  `LIBELLE` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `secteur_activite`
--

INSERT INTO `secteur_activite` (`IDSECTEUR`, `LIBELLE`) VALUES
(1, 'Abatteur(euse) manuel(le)'),
(2, 'Accessoiriste'),
(3, 'Accompagnateur(trice)'),
(4, 'Actuaire'),
(5, 'Adjoint(e) a la direction  a la coordination'),
(6, 'Adjoint(e) administratif'),
(7, 'Administrateur(trice) de reseaux informatiques'),
(8, 'Agent de recherche de financement'),
(9, 'Agent(e) d\'affectation'),
(10, 'Agent(e) d\'information'),
(11, 'Agent(e) d\'integration'),
(12, 'Agent(e) de bureau'),
(13, 'Agent(e) de communication  Responsable des communications'),
(14, 'Agent(e) de conformite'),
(15, 'Agent(e) de developpement'),
(16, 'Agent(e) de francisation'),
(17, 'Agent(e) de jumelage'),
(18, 'Agent(e) de liaison'),
(19, 'Agent(e) de programmation'),
(20, 'Agent(e) de promotion'),
(21, 'Agent(e) de recherche'),
(22, 'Agent(e) de relations publiques'),
(23, 'Agent(e) de sensibilisation'),
(24, 'Agent(e) de voyage'),
(25, 'Agent(e)-conseil en soutien pedagogique et technique'),
(26, 'Aide-cuisinier(ere)'),
(27, 'Analyste financier'),
(28, 'Animateur(trice)'),
(29, 'Animateur(trice) en radiotelediffusion'),
(30, 'Architecte'),
(31, 'Architecte paysagiste'),
(32, 'Artisan(e) recuperateur(trice)'),
(33, 'Assistante perinatale'),
(34, 'Auteur(e)'),
(35, 'Avocat(e)'),
(36, 'Biologiste'),
(37, 'Brasseur'),
(38, 'Caissier(ere)'),
(39, 'Cameraman'),
(40, 'Camionneur(euse)'),
(41, 'Charge(e) de programmes'),
(42, 'Charge(e) de projets'),
(43, 'Chauffeur(euse)'),
(44, 'Chef cuisinier(ere)'),
(45, 'Chef de camp'),
(46, 'Chef de service'),
(47, 'Chef machiniste'),
(48, 'Comedien(ne)'),
(49, 'Commis comptable'),
(50, 'Commis de magasin'),
(51, 'Commis expeditionreception'),
(52, 'Comptable'),
(53, 'Concepteur(trice) costumes'),
(54, 'Concepteur(trice) de decor'),
(55, 'Concepteur(trice) musical'),
(56, 'Concepteur(trice) publicitaire'),
(57, 'Concierge'),
(58, 'Conseiller(ere) aux familles - services funeraires'),
(59, 'Conseiller(ere) budgetaire'),
(60, 'Conseiller(ere) d\'orientation'),
(61, 'Conseiller(ere) en defense des droits'),
(62, 'Conseiller(ere) en efficacite energetique'),
(63, 'Conseiller(ere) en evaluation'),
(64, 'Conseiller(ere) en formation'),
(65, 'Conseiller(ere) en insertion'),
(66, 'Conseiller(ere) en main-d\'oeuvre'),
(67, 'Conseiller(ere) en readaptation'),
(68, 'Conseiller(ere) en ressources humaines'),
(69, 'Conseiller(ere) en sports et loisirs'),
(70, 'Conseiller(ere) marketing'),
(71, 'Contremaitre'),
(72, 'Coordonnateur(rice) a la vie politique'),
(73, 'Coordonnateur(trice) a la formation'),
(74, 'Coordonnateur(trice) a la mobilisation'),
(75, 'Coordonnateur(trice) a la vie associative'),
(76, 'Coordonnateur(trice) de funerailles'),
(77, 'Coordonnateur(trice) de services sociaux et communautaires'),
(78, 'Coordonnateur(trice) des benevoles'),
(79, 'Coordonnateur(trice) des services a la petite enfance'),
(80, 'Cuisinier(ere)'),
(81, 'Danseur(se)'),
(82, 'Directeur(trice)  Coordonnateur(trice) a l\'animation'),
(83, 'Directeur(trice)  Coordonnateur(trice) administratif(ve)'),
(84, 'Directeur(trice)  Coordonnateur(trice) artistique'),
(85, 'Directeur(trice)  Coordonnateur(trice) au developpement'),
(86, 'Directeur(trice)  Coordonnateur(trice) aux evenements'),
(87, 'Directeur(trice)  Coordonnateur(trice) de l\'intervention'),
(88, 'Directeur(trice)  Coordonnateur(trice) de la programmation'),
(89, 'Directeur(trice)  Coordonnateur(trice) de programmes'),
(90, 'Directeur(trice)  Coordonnateur(trice) de projet etou de dossiers'),
(91, 'Directeur(trice)  Coordonnateur(trice) de services'),
(92, 'Directeur(trice)  Coordonnateur(trice) des communications'),
(93, 'Directeur(trice)  Coordonnateur(trice) des loisirs'),
(94, 'Directeur(trice)  Coordonnateur(trice) des relations publiques'),
(95, 'Directeur(trice)  Coordonnateur(trice) des ressources humaines'),
(96, 'Directeur(trice)  Coordonnateur(trice) du financement'),
(97, 'Directeur(trice)  Coordonnateur(trice) du service a la clientele'),
(98, 'Directeur(trice)  Coordonnateur(trice) informatique'),
(99, 'Directeur(trice)  Coordonnateur(trice) marketing'),
(100, 'Directeur(trice)  Coordonnateur(trice) technique'),
(101, 'Directeur(trice) de departement'),
(102, 'Directeur(trice) de l\'entretien menager'),
(103, 'Directeur(trice) de l\'information'),
(104, 'Directeur(trice) de production'),
(105, 'Directeur(trice) des finances'),
(106, 'Directeur(trice) des operations'),
(107, 'Directeur(trice) general  Coordonnateur (trice)'),
(108, 'Directeur(trice) Coordonnateur(trice) clinique'),
(109, 'Direction adjointe Coordonnateur(trice) adjoint(e)'),
(110, 'Eco-conseiller(ere)'),
(111, 'Educateur(trice) en CPE'),
(112, 'Educateur(trice) en halte-garderie communautaire'),
(113, 'Educateur(trice) specialise(e)'),
(114, 'Formateur(trice)'),
(115, 'Geographe'),
(116, 'Gerant(e)'),
(117, 'Gestionnaire immobilier'),
(118, 'Graphiste'),
(119, 'Guide-animateur'),
(120, 'Illustrateur(trice)'),
(121, 'Infirmier(eres)'),
(122, 'Infographiste'),
(123, 'Ingenieur(e) forestier(ere)'),
(124, 'Intervenant(e)'),
(125, 'Intervenant(e) en loisir'),
(126, 'Intervenant(e) perinatale'),
(127, 'Jardinier(ere)'),
(128, 'Journaliste'),
(129, 'Libraire'),
(130, 'Magasinier(ere)'),
(131, 'Manoeuvre'),
(132, 'Manutentionnaire'),
(133, 'Marionnettiste'),
(134, 'Marteleur(euse)'),
(135, 'Medecin'),
(136, 'Meneur de jeu'),
(137, 'Mesureur(euse)'),
(138, 'Metteur en onde'),
(139, 'Metteur(e) en scene'),
(140, 'Moniteur(trice) de camps'),
(141, 'Musicien(ne)'),
(142, 'Nutritionniste'),
(143, 'Operateur(trice)'),
(144, 'Operateur(trice) de debardeur'),
(145, 'Operateur(trice) de machinerie d\'abattage mecanise'),
(146, 'Operateur(trice) de machinerie lourde en voirie forestiere'),
(147, 'Organisateur(trice) communautaire'),
(148, 'Orthopedagogue'),
(149, 'Ouvrier(ere) sylvicole'),
(150, 'Paramedical'),
(151, 'Patissiers'),
(152, 'Porteur - services funeraires'),
(153, 'Prepose(e) a l\'amenagement du territoire'),
(154, 'Prepose(e) au service a la clientele'),
(155, 'Prepose(e) d\'aide a domicile'),
(156, 'Pressier(ere) en imprimerie serigraphique'),
(157, 'Producteur(trice) multimedia'),
(158, 'Professeur de musique'),
(159, 'Programmeur(e) analyste'),
(160, 'Projectionniste'),
(161, 'Psycho-educateur(trice)'),
(162, 'Psychologue'),
(163, 'Psychotherapeute'),
(164, 'Realisateur(trice)'),
(165, 'Redacteur(trice)'),
(166, 'Redacteur(trice) en chef'),
(167, 'Regisseur'),
(168, 'Repartiteur(trice)'),
(169, 'Representant(e) des ventes'),
(170, 'Representant(e) publicitaire'),
(171, 'Responsable de l?animation'),
(172, 'Responsable de service de garde'),
(173, 'Sauveteur(e)'),
(174, 'Secretaire'),
(175, 'Secretaire-receptionniste'),
(176, 'Serveur(euse)'),
(177, 'Superviseur(e)'),
(178, 'Surveillant(e)'),
(179, 'Technicien(ne)'),
(180, 'Technicien(ne) cameraman - monteur'),
(181, 'Technicien(ne) comptable'),
(182, 'Technicien(ne) d\'atelier'),
(183, 'Technicien(ne) de scene'),
(184, 'Technicien(ne) de son'),
(185, 'Technicien(ne) eclairagiste'),
(186, 'Technicien(ne) en cablodistribution'),
(187, 'Technicien(ne) en dietetique'),
(188, 'Technicien(ne) en documentation'),
(189, 'Technicien(ne) en informatique'),
(190, 'Technicien(ne) en radiodiffusion'),
(191, 'Technicien(ne) en travail social'),
(192, 'Technicien(ne) forestier(ere)'),
(193, 'Thanatopracteur'),
(194, 'Traducteur(trice)'),
(195, 'Travailleur(se) de milieu'),
(196, 'Travailleur(se) de rue'),
(197, 'Travailleur(se) social(e)'),
(198, 'Trieur(se)'),
(199, 'Valoriste'),
(200, 'Vendeur(euse)'),
(201, 'Webmestre'),
(203, 'test 2');

-- --------------------------------------------------------

--
-- Structure de la table `SECTION_TRANSPORT`
--

CREATE TABLE `SECTION_TRANSPORT` (
  `ID_SECTION` int(11) NOT NULL,
  `LIBELLE` varchar(100) NOT NULL,
  `MONTANT` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `SECTION_TRANSPORT`
--

INSERT INTO `SECTION_TRANSPORT` (`ID_SECTION`, `LIBELLE`, `MONTANT`) VALUES
(1, 'SECTION1', 18000),
(2, 'SECTION2', 21000);

-- --------------------------------------------------------

--
-- Structure de la table `SERIE`
--

CREATE TABLE `SERIE` (
  `IDSERIE` int(11) NOT NULL,
  `LIBSERIE` varchar(100) DEFAULT NULL,
  `IDNIVEAU` int(11) NOT NULL DEFAULT '0',
  `IDETABLISSEMENT` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `SERIE`
--

INSERT INTO `SERIE` (`IDSERIE`, `LIBSERIE`, `IDNIVEAU`, `IDETABLISSEMENT`) VALUES
(1, 'LITTERAIRE', 3, 3),
(2, 'SCIENTIFIQUE', 3, 3),
(3, 'TRON COMMUN PRESCOLAIRE', 1, 3),
(4, 'TRON COMMUN', 2, 3),
(5, 'TRONC COMMUN COLLEGE', 3, 3);

-- --------------------------------------------------------

--
-- Structure de la table `SORTI_EQUIPEMENT`
--

CREATE TABLE `SORTI_EQUIPEMENT` (
  `ID_SORTI_EQUIPEMENT` int(11) NOT NULL,
  `ID_EQUIPEMENT` int(11) NOT NULL,
  `NOMBRE_SORTI` int(11) NOT NULL,
  `DATE_SORTI` date NOT NULL,
  `AFFECTAIRE` int(11) NOT NULL,
  `IDETABLISSEMENT` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `TABLEAU_DHONNEUR`
--

CREATE TABLE `TABLEAU_DHONNEUR` (
  `ROWID` int(11) NOT NULL,
  `MOYENNE` double NOT NULL DEFAULT '0',
  `IDETABLISSEMENT` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `TABLEAU_DHONNEUR`
--

INSERT INTO `TABLEAU_DHONNEUR` (`ROWID`, `MOYENNE`, `IDETABLISSEMENT`) VALUES
(1, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `TIMETABLE`
--

CREATE TABLE `TIMETABLE` (
  `id` int(11) NOT NULL,
  `idPeriode` int(11) DEFAULT NULL,
  `idEtablissement` int(11) DEFAULT NULL,
  `idClasse` int(11) DEFAULT NULL,
  `dateDebut` datetime NOT NULL,
  `dateFin` datetime NOT NULL,
  `idMatiere` int(11) NOT NULL,
  `idSalle` int(11) NOT NULL,
  `idIndividu` int(11) NOT NULL,
  `color` varchar(7) COLLATE latin1_german1_ci DEFAULT NULL,
  `repeat_type` varchar(20) COLLATE latin1_german1_ci DEFAULT NULL,
  `repeat_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- --------------------------------------------------------

--
-- Structure de la table `TRANSPORT_MENSUALITE`
--

CREATE TABLE `TRANSPORT_MENSUALITE` (
  `ROWID` int(11) NOT NULL,
  `MOIS` varchar(45) NOT NULL,
  `MONTANT` double NOT NULL,
  `DATEREGLEMENT` datetime NOT NULL,
  `IDINSCRIPTION` int(11) NOT NULL,
  `IDETABLISSEMENT` int(11) NOT NULL,
  `MT_VERSE` double NOT NULL DEFAULT '0',
  `MT_RELIQUAT` double NOT NULL DEFAULT '0',
  `NUM_FACTURE` varchar(25) NOT NULL,
  `ETAT` tinyint(11) DEFAULT NULL COMMENT '0:payé; 1:restant'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `TRANSPORT_MENSUALITE`
--

INSERT INTO `TRANSPORT_MENSUALITE` (`ROWID`, `MOIS`, `MONTANT`, `DATEREGLEMENT`, `IDINSCRIPTION`, `IDETABLISSEMENT`, `MT_VERSE`, `MT_RELIQUAT`, `NUM_FACTURE`, `ETAT`) VALUES
(1, 'OCTOBRE / 2019', 21000, '2020-04-24 00:00:00', 2, 3, 21000, 0, 'FACT6144023', 0),
(2, 'JUILLET / 2020', 21000, '2020-04-24 00:00:00', 2, 3, 21000, 0, 'FACT5582533', 0),
(3, 'OCTOBRE / 2019', 18000, '2020-04-24 00:00:00', 4, 3, 18000, 0, 'FACT4548363', 0),
(4, 'JUILLET / 2020', 18000, '2020-04-24 00:00:00', 4, 3, 18000, 0, 'FACT4641203', 0),
(5, 'OCTOBRE / 2019', 21000, '2020-10-15 00:00:00', 11, 3, 21000, 0, 'FACT4212603', 0),
(6, 'JUILLET / 2020', 21000, '2020-10-15 00:00:00', 11, 3, 21000, 0, 'FACT9721603', 0),
(7, 'DECEMBRE / 2019', 21000, '2020-11-12 00:00:00', 2, 3, 21000, 0, 'FACT4036333', 0),
(8, 'NOVEMBRE / 2019', 18000, '2020-11-12 00:00:00', 4, 3, 18000, 0, 'FACT1413943', 0);

-- --------------------------------------------------------

--
-- Structure de la table `TROUSSEAU`
--

CREATE TABLE `TROUSSEAU` (
  `ROWID` int(11) NOT NULL,
  `LIBELLE` varchar(75) NOT NULL,
  `MONTANT` int(11) NOT NULL,
  `FK_NIVEAU` int(11) NOT NULL,
  `CYCLE` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:autres;1:premier cycle, 2:second cycle',
  `SEXE` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:homme;0:femme',
  `IDETABLISSEMENT` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `TROUSSEAU`
--

INSERT INTO `TROUSSEAU` (`ROWID`, `LIBELLE`, `MONTANT`, `FK_NIVEAU`, `CYCLE`, `SEXE`, `IDETABLISSEMENT`) VALUES
(1, 'Trousseau prescolaire pour  Garçon', 6000, 1, 0, 1, 3),
(2, 'Trousseau prescolaire pour  Fille', 6000, 1, 0, 0, 3),
(3, 'Trousseau elementaire pour  Garçon', 35000, 2, 0, 1, 3),
(4, 'Trousseau elementaire pour  Fille', 35000, 2, 0, 0, 3),
(5, 'Trousseau moyen / secondaire pour  Fille', 40000, 3, 1, 0, 3),
(6, 'Trousseau moyen / secondaire pour  Garçon', 40000, 3, 1, 1, 3),
(7, 'Trousseau moyen / secondaire pour  Fille', 55000, 3, 2, 0, 3),
(8, 'Trousseau moyen / secondaire pour  Garçon', 55000, 3, 2, 1, 3),
(9, 'Trousseau test pour  Fille', 10000, 4, 0, 0, 3),
(11, 'Trousseau test pour  Garçon', 10000, 4, 0, 1, 3);

-- --------------------------------------------------------

--
-- Structure de la table `TYPEDOCADMIN`
--

CREATE TABLE `TYPEDOCADMIN` (
  `IDTYPEDOCADMIN` int(11) NOT NULL,
  `LIBELLE` varchar(100) DEFAULT NULL,
  `CONTENU` text NOT NULL,
  `IDETABLISSEMENT` int(11) DEFAULT '0',
  `IDMODELE_DOC` int(11) DEFAULT '0',
  `IDTYPEINDIVIDU` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `TYPEDOCADMIN`
--

INSERT INTO `TYPEDOCADMIN` (`IDTYPEDOCADMIN`, `LIBELLE`, `CONTENU`, `IDETABLISSEMENT`, `IDMODELE_DOC`, `IDTYPEINDIVIDU`) VALUES
(3, 'CERTIFICAT DE SCOLARITE', '<p style=\"text-align: center;\">*************************************</p>\r\n<p style=\"text-align: left;\">Je soussign&eacute;, Directeur du&nbsp;<span style=\"color: #22262e; font-family: \'Open Sans\', sans-serif; font-size: 12px; background-color: #f5f5f5;\">[ETABLISSEMENT]</span>&nbsp;atteste que l\'&eacute;l&egrave;ve&nbsp;<span style=\"background-color: #f5f5f5; color: #22262e; font-family: \'Open Sans\', sans-serif; font-size: 12px;\">[IDENTITE_ELEVE] n&eacute;(e) le </span><span style=\"background-color: #f5f5f5; color: #22262e; font-family: \'Open Sans\', sans-serif; font-size: 12px;\">[DATENAISSANCE] &agrave;&nbsp;</span><span style=\"background-color: #f5f5f5; color: #22262e; font-family: \'Open Sans\', sans-serif; font-size: 12px;\">[VILLE_NAISSANCE]</span><span style=\"background-color: #f5f5f5; color: #22262e; font-family: \'Open Sans\', sans-serif; font-size: 12px;\"> [GENRE_ELEVE] de [PERE_ELEVE] et de [MERE_ELEVE]&nbsp;est inscrit(e) dans mon &eacute;tablissement en classe de [CLASSE]&nbsp; Ann&eacute;e Scolaire [ANNEE_SCOLAIRE].</span></p>\r\n<p style=\"text-align: left;\"><span style=\"background-color: #f5f5f5; color: #22262e; font-family: \'Open Sans\', sans-serif; font-size: 12px;\"><code></code></span><span style=\"background-color: #f5f5f5; color: #22262e; font-family: \'Open Sans\', sans-serif; font-size: 12px;\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Ce certificat est d&eacute;livr&eacute; pour servir et valoir ce que de droit.</span></p>\r\n<p style=\"text-align: left;\"><span style=\"background-color: #f5f5f5; color: #22262e; font-family: \'Open Sans\', sans-serif; font-size: 12px;\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Dakar, le&nbsp;</span><span style=\"color: #22262e; font-family: \'Open Sans\', sans-serif; font-size: 12px;\">[DATE_AUJOURDHUI]</span></p>\r\n<p style=\"text-align: left;\"><span style=\"background-color: #f5f5f5; color: #22262e; font-family: \'Open Sans\', sans-serif; font-size: 12px;\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; LE DIRECTEUR&nbsp;</span></p>', 3, 0, 8),
(6, 'CERTIFICAT DE RADIATION', '<p style=\"text-align: center;\">*************************************</p>\r\n<p style=\"text-align: left;\">Je soussign&eacute;, Directeur du&nbsp;<span style=\"color: #22262e; font-family: \'Open Sans\', sans-serif; font-size: 12px;\">[ETABLISSEMENT] atteste que&nbsp;</span><strong><span style=\"color: #22262e; font-family: \'Open Sans\', sans-serif; font-size: 12px;\">[IDENTITE_ELEVE] </span></strong><span style=\"color: #22262e; font-family: \'Open Sans\', sans-serif; font-size: 12px;\">n&eacute;(e) le&nbsp;</span><span style=\"color: #22262e; font-family: \'Open Sans\', sans-serif; font-size: 12px;\"><strong>[DATENAISSANCE]</strong> &agrave; </span><strong><span style=\"background-color: #f5f5f5; color: #22262e; font-family: \'Open Sans\', sans-serif; font-size: 12px;\">[VILLE_NAISSANCE]</span></strong></p>\r\n<p style=\"text-align: left;\"><span style=\"background-color: #f5f5f5; color: #22262e; font-family: \'Open Sans\', sans-serif; font-size: 12px;\">&nbsp;</span><span style=\"background-color: #f5f5f5; color: #22262e; font-family: \'Open Sans\', sans-serif; font-size: 12px;\">[GENRE_ELEVE] de&nbsp;</span><span style=\"background-color: #f5f5f5; color: #22262e; font-family: \'Open Sans\', sans-serif; font-size: 12px;\"><strong>[PERE_ELEVE]</strong> et de&nbsp;</span><span style=\"background-color: #f5f5f5; color: #22262e; font-family: \'Open Sans\', sans-serif; font-size: 12px;\"><strong>[MERE_ELEVE]</strong> a frequent&eacute; mon &eacute;tablissement durant l\'ann&eacute;e scolaire&nbsp;</span><strong><span style=\"background-color: #f5f5f5; color: #22262e; font-family: \'Open Sans\', sans-serif; font-size: 12px;\">[ANNEE_SCOLAIRE]</span></strong></p>\r\n<p style=\"text-align: left;\">&nbsp;</p>\r\n<p style=\"text-align: left;\"><span style=\"background-color: #f5f5f5; color: #22262e; font-family: \'Open Sans\', sans-serif; font-size: 12px;\">A cette date, [PRONOM_ELEVE]&nbsp;fr&eacute;quentait la classe de&nbsp;</span><span style=\"background-color: #f5f5f5; color: #22262e; font-family: \'Open Sans\', sans-serif; font-size: 12px;\"><strong>[CLASSE]</strong>. [PRONOM_ELEVE] est radi&eacute;(e) des registres &agrave; compter du </span><span style=\"background-color: #f5f5f5; color: #22262e; font-family: \'Open Sans\', sans-serif; font-size: 12px;\"><strong>[DATE_AUJOURDHUI]</strong>.</span></p>\r\n<p style=\"text-align: left;\">&nbsp;</p>\r\n<p style=\"text-align: left;\"><span style=\"background-color: #f5f5f5; color: #22262e; font-family: \'Open Sans\', sans-serif; font-size: 12px;\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Le Directeur</span></p>', 3, 0, 8),
(9, 'ATTESTATION DE SERVICE', '<p style=\"text-align: center;\">*************************************</p>\r\n<p>Je soussign&eacute;, Directeur du&nbsp;<span style=\"color: #22262e; font-family: \'Open Sans\', sans-serif; font-size: 12px;\">[ETABLISSEMENT] Atteste par la pr&eacute;sente que [PRENOM_PROFESSEUR], est en service dans mon &eacute;tablissement depuis </span><span style=\"color: #22262e; font-family: \'Open Sans\', sans-serif; font-size: 12px;\">[Date_ARRIVEE_PROF]</span></p>\r\n<p>&nbsp;</p>\r\n<p><span style=\"color: #22262e; font-family: \'Open Sans\', sans-serif; font-size: 12px;\">En foi de quoi la pr&eacute;sente attestation lui est d&eacute;livr&eacute;e pour servir et valoir ce que de droit.&nbsp;</span></p>\r\n<p>&nbsp;</p>\r\n<p><span style=\"color: #22262e; font-family: \'Open Sans\', sans-serif; font-size: 12px;\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Fait &agrave;&nbsp;</span><span style=\"color: #22262e; font-family: \'Open Sans\', sans-serif; font-size: 12px;\">[VILLE] le&nbsp;</span><span style=\"color: #22262e; font-family: \'Open Sans\', sans-serif; font-size: 12px;\">[DATE_AUJOURDHUI]</span></p>', 3, 0, 7);

-- --------------------------------------------------------

--
-- Structure de la table `TYPEINDIVIDU`
--

CREATE TABLE `TYPEINDIVIDU` (
  `IDTYPEINDIVIDU` int(11) NOT NULL,
  `LIBELLE` varchar(100) DEFAULT NULL,
  `IDETABLISSEMENT` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `TYPEINDIVIDU`
--

INSERT INTO `TYPEINDIVIDU` (`IDTYPEINDIVIDU`, `LIBELLE`, `IDETABLISSEMENT`) VALUES
(1, 'ADMINISTRATEUR', 3),
(2, 'PERSONNEL ADMINISTRATIF', 3),
(3, 'DIRECTEUR GENERAL', 3),
(4, 'DIRECTEUR FINANCIER', 3),
(5, 'SURVEILLANT GENERAL', 3),
(6, 'SURVEILLANT', 3),
(7, 'PROFESSEUR', 3),
(8, 'ELEVE', 3),
(9, 'PARENT', 3);

-- --------------------------------------------------------

--
-- Structure de la table `TYPE_DOC_ETU`
--

CREATE TABLE `TYPE_DOC_ETU` (
  `IDTYPEDOCETU` int(11) NOT NULL,
  `LIBELLE` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `TYPE_EXONERATION`
--

CREATE TABLE `TYPE_EXONERATION` (
  `ROWID` int(11) NOT NULL,
  `LABEL` varchar(100) NOT NULL,
  `ETAT` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `TYPE_EXONERATION`
--

INSERT INTO `TYPE_EXONERATION` (`ROWID`, `LABEL`, `ETAT`) VALUES
(1, 'Excellence', 1),
(2, 'Personnel', 1),
(3, 'Responsable Moral', 1),
(4, 'Famille nombreuse', 1);

-- --------------------------------------------------------

--
-- Structure de la table `TYPE_PAIEMENT`
--

CREATE TABLE `TYPE_PAIEMENT` (
  `id_type_paiment` int(11) NOT NULL,
  `libelle_paiement` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `TYPE_PAIEMENT`
--

INSERT INTO `TYPE_PAIEMENT` (`id_type_paiment`, `libelle_paiement`) VALUES
(1, 'CHEQUES'),
(2, 'ESPECES'),
(3, 'VIREMENT');

-- --------------------------------------------------------

--
-- Structure de la table `TYPE_SALLE`
--

CREATE TABLE `TYPE_SALLE` (
  `IDTYPE_SALLE` int(11) NOT NULL,
  `TYPE_SALLE` varchar(100) DEFAULT NULL,
  `IDETABLISSEMENT` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `TYPE_SALLE`
--

INSERT INTO `TYPE_SALLE` (`IDTYPE_SALLE`, `TYPE_SALLE`, `IDETABLISSEMENT`) VALUES
(1, 'INFORMATIQUE', 3),
(2, 'BIBLIOTEQUE', 3),
(4, 'SALLE', 3),
(5, 'SALLE 1', 3);

-- --------------------------------------------------------

--
-- Structure de la table `TYPE_SANCTION`
--

CREATE TABLE `TYPE_SANCTION` (
  `ID` int(11) NOT NULL,
  `LIBELLE` varchar(75) NOT NULL,
  `IDETABLISSEMENT` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `TYPE_SANCTION`
--

INSERT INTO `TYPE_SANCTION` (`ID`, `LIBELLE`, `IDETABLISSEMENT`) VALUES
(1, 'Type Sanction 1', 3),
(2, 'Type Sanction 2', 3);

-- --------------------------------------------------------

--
-- Structure de la table `TYP_CONTROL`
--

CREATE TABLE `TYP_CONTROL` (
  `IDTYP_CONTROL` int(11) NOT NULL,
  `LIB_TYPCONTROL` varchar(100) DEFAULT NULL,
  `POIDS` tinyint(3) UNSIGNED DEFAULT '0',
  `IDETABLISSEMENT` int(11) NOT NULL,
  `COULEUR` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `TYP_CONTROL`
--

INSERT INTO `TYP_CONTROL` (`IDTYP_CONTROL`, `LIB_TYPCONTROL`, `POIDS`, `IDETABLISSEMENT`, `COULEUR`) VALUES
(1, 'Contrôle', 0, 3, ''),
(2, 'Composition', 0, 3, '');

-- --------------------------------------------------------

--
-- Structure de la table `UE`
--

CREATE TABLE `UE` (
  `IDUE` int(11) NOT NULL,
  `LIBELLE` varchar(250) DEFAULT '',
  `IDNIVEAU` int(11) DEFAULT '0',
  `IDSERIE` int(11) DEFAULT '0',
  `SEMESTRES` int(11) DEFAULT NULL,
  `IDETABLISSEMENT` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `UNIFORME`
--

CREATE TABLE `UNIFORME` (
  `ROWID` int(11) NOT NULL,
  `LIBELLE` varchar(100) NOT NULL,
  `MONTANT` int(11) NOT NULL,
  `IDNIVEAU` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `UNIFORME`
--

INSERT INTO `UNIFORME` (`ROWID`, `LIBELLE`, `MONTANT`, `IDNIVEAU`) VALUES
(1, 'Blouse', 6000, 1),
(2, 'Polo', 5000, 2),
(4, 'Jupe', 5000, 3),
(6, 'Tenue de sport', 15000, 3),
(7, 'Tenue de sport', 6000, 2),
(8, 'Polo', 5000, 3),
(9, 'Pull', 6500, 2),
(10, 'Pull', 6500, 3),
(11, 'Jupe', 5000, 2),
(12, 'Pantalon', 5000, 3),
(13, 'Pantalon', 5000, 2),
(14, 'Robe', 10000, 4);

-- --------------------------------------------------------

--
-- Structure de la table `UTILISATEURS`
--

CREATE TABLE `UTILISATEURS` (
  `idUtilisateur` int(11) NOT NULL,
  `matriculeUtilisateur` varchar(50) NOT NULL,
  `codeUtilisateur` varchar(50) NOT NULL,
  `prenomUtilisateur` varchar(250) CHARACTER SET latin1 NOT NULL,
  `nomUtilisateur` varchar(250) CHARACTER SET latin1 NOT NULL,
  `telephone` bigint(20) NOT NULL,
  `adresse` varchar(100) NOT NULL,
  `email` varchar(50) CHARACTER SET latin1 NOT NULL,
  `login` varchar(50) CHARACTER SET latin1 NOT NULL,
  `password` varchar(50) CHARACTER SET latin1 NOT NULL,
  `idEtablissement` int(11) NOT NULL,
  `idProfil` int(11) NOT NULL,
  `dateCreation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `userCreation` int(11) NOT NULL,
  `dateModification` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `userModification` int(11) NOT NULL,
  `ETAT` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `UTILISATEURS`
--

INSERT INTO `UTILISATEURS` (`idUtilisateur`, `matriculeUtilisateur`, `codeUtilisateur`, `prenomUtilisateur`, `nomUtilisateur`, `telephone`, `adresse`, `email`, `login`, `password`, `idEtablissement`, `idProfil`, `dateCreation`, `userCreation`, `dateModification`, `userModification`, `ETAT`) VALUES
(1, 'CESQ3582', '7695799383582', 'Moussa', 'Diallo', 221775513064, '', 'moussa.diallo@samaecole.com', 'moussa.diallo', '25b7c071dc5281769b6fe45ce78e8624', 3, 1, '2016-09-27 13:35:30', 30, '2019-09-19 12:22:07', 1, 1),
(2, 'CESQ2559', '7430658782559', 'Ndéye Maguette', 'Diagne', 221775783476, 'ouest foire', 'maxthiema@gmail.com', 'maxthiema', 'e7247759c1633c0f9f1485f3690294a9', 3, 1, '2019-09-12 11:25:13', 51, '2019-09-27 17:29:02', 1, 1),
(3, 'CEMAD7184', '7758257177184', 'Samuel', 'BAGUIDI', 221774119645, 'Rufisque', 'sam@samaecole.com', 'sam', '896b84f14bb3c632f5de158cabed839a', 3, 1, '2019-09-27 14:12:38', 1, '2019-09-27 14:12:38', 1, 1),
(4, 'CEMAD0407', '7014324320407', 'Adama', 'Boye', 221777141470, 'Diamniadio Lake City', 'adama.boye@samaecole.com', 'adama', '3b6dd01b3ef4bbee5a7d59d372aa07a4', 3, 1, '2020-02-28 10:26:02', 1, '2020-03-05 11:47:10', 1, 1),
(5, 'CEMAD8148', '7772871418148', 'Ibrahima', 'FALL', 221774119645, 'Dakar SENEGAL', 'ibrahima.fall@samaecole.com', 'fall', '738dd2ff38bcce841948ad0f17b8b7a0', 3, 1, '2020-06-10 14:46:50', 1, '2020-06-10 14:46:50', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `VACANCES`
--

CREATE TABLE `VACANCES` (
  `IDJOUR_FERIES` int(11) NOT NULL,
  `LIB_VACANCES` varchar(100) DEFAULT NULL,
  `DATE_DEBUT` datetime DEFAULT NULL,
  `DATE_FIN` datetime DEFAULT NULL,
  `IDETABLISSEMENT` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `ACTION`
--
ALTER TABLE `ACTION`
  ADD PRIMARY KEY (`idAction`),
  ADD KEY `module` (`module`) USING BTREE,
  ADD KEY `etablissement` (`idEtablissement`) USING BTREE;

--
-- Index pour la table `ACTUALITES`
--
ALTER TABLE `ACTUALITES`
  ADD PRIMARY KEY (`IDACTUALITES`),
  ADD KEY `DATE_ACTUALITE` (`DATE_ACTUALITE`),
  ADD KEY `TITRE_ACTU` (`TITRE_ACTU`),
  ADD KEY `IDCLASSROOM` (`IDCLASSROOM`),
  ADD KEY `IDETABLISSEMENT` (`IDETABLISSEMENT`);

--
-- Index pour la table `affectationDroit`
--
ALTER TABLE `affectationDroit`
  ADD PRIMARY KEY (`idAffectation`),
  ADD KEY `action` (`action`) USING BTREE,
  ADD KEY `profil` (`profil`) USING BTREE;

--
-- Index pour la table `AFFECTATION_DROIT`
--
ALTER TABLE `AFFECTATION_DROIT`
  ADD PRIMARY KEY (`IDAFFECTATION_DROIT`),
  ADD KEY `IDDROIT_DICTIONNAIRE` (`IDDICTIONNAIRE`,`IDDROIT`,`IDTYPEINDIVIDU`),
  ADD KEY `IDDICTIONNAIRE` (`IDDICTIONNAIRE`),
  ADD KEY `IDdroit` (`IDDROIT`),
  ADD KEY `autorise` (`AUTORISE`),
  ADD KEY `IDclient` (`ETABLISSEMENT`),
  ADD KEY `IDutilisateur` (`IDTYPEINDIVIDU`);

--
-- Index pour la table `AFFECTATION_ELEVE_CLASSE`
--
ALTER TABLE `AFFECTATION_ELEVE_CLASSE`
  ADD PRIMARY KEY (`IDAFFECTATTION_ELEVE_CLASSE`),
  ADD UNIQUE KEY `IDAFFECT_ELEV_CLE` (`IDCLASSROOM`,`IDINDIVIDU`,`IDANNEESSCOLAIRE`),
  ADD KEY `IDCLASSROOM` (`IDCLASSROOM`),
  ADD KEY `IDINDIVIDU` (`IDINDIVIDU`),
  ADD KEY `IDANNEESSCOLAIRE` (`IDANNEESSCOLAIRE`),
  ADD KEY `IDETABLISSEMENT` (`IDETABLISSEMENT`);

--
-- Index pour la table `affecter_doc`
--
ALTER TABLE `affecter_doc`
  ADD PRIMARY KEY (`idaff`);

--
-- Index pour la table `AFFECTER_DOC_ETU`
--
ALTER TABLE `AFFECTER_DOC_ETU`
  ADD PRIMARY KEY (`IDAFFDOCETU`);

--
-- Index pour la table `ANNEESSCOLAIRE`
--
ALTER TABLE `ANNEESSCOLAIRE`
  ADD PRIMARY KEY (`IDANNEESSCOLAIRE`),
  ADD KEY `LIBELLE_ANNEESSOCLAIRE` (`LIBELLE_ANNEESSOCLAIRE`),
  ADD KEY `DATE_DEBUT` (`DATE_DEBUT`),
  ADD KEY `DATE_FIN` (`DATE_FIN`),
  ADD KEY `IDETABLISSEMENT` (`IDETABLISSEMENT`);

--
-- Index pour la table `BANQUE`
--
ALTER TABLE `BANQUE`
  ADD PRIMARY KEY (`ROWID`);

--
-- Index pour la table `BULLETIN`
--
ALTER TABLE `BULLETIN`
  ADD PRIMARY KEY (`ROWID`),
  ADD KEY `fk_bulletin_annee` (`IDANNEE`),
  ADD KEY `fk_bulletin_classrom` (`IDCLASSROOM`),
  ADD KEY `fk_bulletin_etablissement` (`IDETABLISSEMENT`),
  ADD KEY `fk_bulletin_individu` (`IDINDIVIDU`),
  ADD KEY `fk_bulletin_periode` (`IDPERIODE`);

--
-- Index pour la table `calendar`
--
ALTER TABLE `calendar`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `CATEGEQUIP`
--
ALTER TABLE `CATEGEQUIP`
  ADD PRIMARY KEY (`IDCATEGEQUIP`),
  ADD KEY `LIBELLE` (`LIBELLE`),
  ADD KEY `IDETABLISSEMENT` (`IDETABLISSEMENT`);

--
-- Index pour la table `CLASSE_ENSEIGNE`
--
ALTER TABLE `CLASSE_ENSEIGNE`
  ADD PRIMARY KEY (`IDCLASSROM`,`IDRECRUTE_PROF`,`IDANNESCOLAIRE`,`IDETABLISSEMENT`);

--
-- Index pour la table `CLASSROOM`
--
ALTER TABLE `CLASSROOM`
  ADD PRIMARY KEY (`IDCLASSROOM`),
  ADD KEY `LIBELLE` (`LIBELLE`),
  ADD KEY `IDNIVEAU` (`IDNIVEAU`),
  ADD KEY `IDETABLISSEMENT` (`IDETABLISSEMENT`),
  ADD KEY `IDSERIE` (`IDSERIE`),
  ADD KEY `fk_classe_niveau` (`IDNIV`);

--
-- Index pour la table `COEFFICIENT`
--
ALTER TABLE `COEFFICIENT`
  ADD PRIMARY KEY (`IDCOEFFICIENT`),
  ADD KEY `IDSERIEIDNIVEAUIDMATIERE` (`IDSERIE`,`IDMATIERE`),
  ADD KEY `COEFFICIENT` (`COEFFICIENT`),
  ADD KEY `IDSERIE` (`IDSERIE`),
  ADD KEY `IDMATIERE` (`IDMATIERE`),
  ADD KEY `IDETABLISSEMENT` (`IDETABLISSEMENT`),
  ADD KEY `fk_coef_cycle` (`IDNIVEAU`);

--
-- Index pour la table `CONTROLE`
--
ALTER TABLE `CONTROLE`
  ADD PRIMARY KEY (`IDCONTROLE`),
  ADD KEY `LIBELLE` (`LIBELLE_CONTROLE`),
  ADD KEY `DATEDEBUT` (`DATEDEBUT`),
  ADD KEY `DATEFIN` (`DATEFIN`),
  ADD KEY `IDCLASSROOM` (`IDCLASSROOM`),
  ADD KEY `IDMATIERE` (`IDMATIERE`),
  ADD KEY `IDETABLISSEMENT` (`IDETABLISSEMENT`),
  ADD KEY `IDINDIVIDU` (`IDINDIVIDU`),
  ADD KEY `IDTYP_CONTROL` (`IDTYP_CONTROL`),
  ADD KEY `NOTER` (`NOTER`),
  ADD KEY `IDPERIODE` (`IDPERIODE`),
  ADD KEY `HEUREDEBUT` (`HEUREDEBUT`),
  ADD KEY `HEUREFIN` (`HEUREFIN`),
  ADD KEY `fk_controle_annee` (`IDANNEE`);

--
-- Index pour la table `CURRENCIES`
--
ALTER TABLE `CURRENCIES`
  ADD PRIMARY KEY (`CODE`),
  ADD UNIQUE KEY `uk_c_currencies_code_iso` (`CODE_ISO`);

--
-- Index pour la table `CV`
--
ALTER TABLE `CV`
  ADD PRIMARY KEY (`IDCV`);

--
-- Index pour la table `DEPENSE`
--
ALTER TABLE `DEPENSE`
  ADD PRIMARY KEY (`IDREGLEMENT`);

--
-- Index pour la table `DESTINATAIRE`
--
ALTER TABLE `DESTINATAIRE`
  ADD PRIMARY KEY (`IDDESTINATAIRE`),
  ADD KEY `IDINDIVIDU` (`IDINDIVIDU`),
  ADD KEY `IDMESSAGERIE` (`IDMESSAGERIE`);

--
-- Index pour la table `DETAIL_BULLETIN`
--
ALTER TABLE `DETAIL_BULLETIN`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_detail_bulletin` (`FK_BULLETIN`);

--
-- Index pour la table `DETAIL_TIMETABLE`
--
ALTER TABLE `DETAIL_TIMETABLE`
  ADD PRIMARY KEY (`IDDETAIL_TIMETABLE`),
  ADD KEY `HEUREDEBUT` (`DATEDEBUT`),
  ADD KEY `HEUREFIN` (`DATEFIN`),
  ADD KEY `JOUR_SEMAINE` (`JOUR_SEMAINE`),
  ADD KEY `IDEMPLOIEDUTEMPS` (`IDEMPLOIEDUTEMPS`),
  ADD KEY `IDMATIERE` (`IDMATIERE`),
  ADD KEY `IDSALL_DE_CLASSE` (`IDSALL_DE_CLASSE`),
  ADD KEY `IDETABLISSEMENT` (`IDETABLISSEMENT`),
  ADD KEY `IDINDIVIDU` (`IDINDIVIDU`),
  ADD KEY `REPETITION` (`REPETITION`);

--
-- Index pour la table `DISPENSER_COURS`
--
ALTER TABLE `DISPENSER_COURS`
  ADD PRIMARY KEY (`IDDISPENSER_COURS`),
  ADD KEY `IDCLASSROOM` (`IDCLASSROOM`),
  ADD KEY `IDINDIVIDU` (`IDINDIVIDU`),
  ADD KEY `DATECOURS` (`DATE`),
  ADD KEY `IDSALL_DE_CLASSE` (`IDSALL_DE_CLASSE`),
  ADD KEY `IDETABLISSEMENT` (`IDETABLISSEMENT`),
  ADD KEY `HEUREDEBUT` (`HEUREFINCOURS`),
  ADD KEY `TITRE_COURS` (`TITRE_COURS`),
  ADD KEY `IDMATIERE` (`IDMATIERE`),
  ADD KEY `ANNEESCOLAIRE` (`ANNEESCOLAIRE`);

--
-- Index pour la table `DOCADMIN`
--
ALTER TABLE `DOCADMIN`
  ADD PRIMARY KEY (`IDDOCADMIN`),
  ADD KEY `LIBELLE` (`LIBELLE`),
  ADD KEY `MOTIF` (`MOTIF`),
  ADD KEY `DATEDELIVRANCE` (`DATEDELIVRANCE`),
  ADD KEY `IDTYPEDOCADMIN` (`IDTYPEDOCADMIN`),
  ADD KEY `IDETABLISSEMENT` (`IDETABLISSEMENT`),
  ADD KEY `IDINDIVIDU` (`IDINDIVIDU`),
  ADD KEY `IDANNEESSCOLAIRE` (`IDANNEESSCOLAIRE`),
  ADD KEY `ID_AUTHORITE` (`ID_AUTHORITE`);

--
-- Index pour la table `document_prof`
--
ALTER TABLE `document_prof`
  ADD PRIMARY KEY (`iddoc`);

--
-- Index pour la table `DOC_DIDACTIQUE`
--
ALTER TABLE `DOC_DIDACTIQUE`
  ADD PRIMARY KEY (`IDDOC_DIDACTIQUE`),
  ADD KEY `TITRE_DOC` (`TITRE_DOC`),
  ADD KEY `PATH` (`PATH`),
  ADD KEY `DATE_POSTE` (`DATE_POSTE`),
  ADD KEY `DISPONIBILITE` (`DISPONIBILITE`),
  ADD KEY `IDETABLISSEMENT` (`IDETABLISSEMENT`),
  ADD KEY `IDCONTROLE` (`IDCONTROLE`);

--
-- Index pour la table `DOC_ETUDIANT`
--
ALTER TABLE `DOC_ETUDIANT`
  ADD PRIMARY KEY (`IDDOCETU`);

--
-- Index pour la table `DROIT`
--
ALTER TABLE `DROIT`
  ADD PRIMARY KEY (`IDdroit`),
  ADD KEY `lib_droit` (`lib_droit`),
  ADD KEY `IDclient` (`IDclient`),
  ADD KEY `user_creation` (`user_creation`),
  ADD KEY `date_creation` (`date_creation`),
  ADD KEY `user_modif` (`user_modif`),
  ADD KEY `date_modif` (`date_modif`),
  ADD KEY `user_supprime` (`user_supprime`),
  ADD KEY `date_supprime` (`date_supprime`),
  ADD KEY `corbeille` (`corbeille`);

--
-- Index pour la table `ELEMENT_TROUSSEAU`
--
ALTER TABLE `ELEMENT_TROUSSEAU`
  ADD PRIMARY KEY (`FK_TROUSSEAU`,`FK_UNIFORME`);

--
-- Index pour la table `EMPLOIEDUTEMPS`
--
ALTER TABLE `EMPLOIEDUTEMPS`
  ADD PRIMARY KEY (`IDEMPLOIEDUTEMPS`),
  ADD KEY `IDETABLISSEMENT` (`IDETABLISSEMENT`),
  ADD KEY `fk_emploitemps_classroom` (`IDCLASSROOM`),
  ADD KEY `fk_emploitemps_periode` (`IDPERIODE`);

--
-- Index pour la table `EQUIPEMENT`
--
ALTER TABLE `EQUIPEMENT`
  ADD PRIMARY KEY (`IDEQUIPEMENT`),
  ADD KEY `NOMEQUIPEMENT` (`NOMEQUIPEMENT`),
  ADD KEY `IDCATEGEQUIP` (`IDCATEGEQUIP`),
  ADD KEY `IDETABLISSEMENT` (`IDETABLISSEMENT`),
  ADD KEY `QTE` (`QTE`);

--
-- Index pour la table `ETABLISSEMENT`
--
ALTER TABLE `ETABLISSEMENT`
  ADD PRIMARY KEY (`IDETABLISSEMENT`),
  ADD KEY `NOMETABLISSEMENT_` (`NOMETABLISSEMENT_`),
  ADD KEY `ADRESSE` (`ADRESSE`),
  ADD KEY `TELEPHONE` (`TELEPHONE`),
  ADD KEY `VILLE` (`VILLE`),
  ADD KEY `PAYS` (`PAYS`),
  ADD KEY `DEVISE` (`DEVISE`),
  ADD KEY `FAX` (`FAX`),
  ADD KEY `MAIL` (`MAIL`),
  ADD KEY `SITEWEB` (`SITEWEB`),
  ADD KEY `RC` (`RC`),
  ADD KEY `NINEA` (`NINEA`),
  ADD KEY `NUM_TV` (`NUM_TV`),
  ADD KEY `PREFIXE` (`PREFIXE`),
  ADD KEY `SIGLE` (`SIGLE`);

--
-- Index pour la table `evenement`
--
ALTER TABLE `evenement`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `EXERCICE`
--
ALTER TABLE `EXERCICE`
  ADD PRIMARY KEY (`IDEXERCICE`),
  ADD UNIQUE KEY `IDEXERCICE1` (`IDMATIERE`,`IDCLASSROOM`),
  ADD KEY `LIBELLE` (`LIBELLE`),
  ADD KEY `DATEEXO` (`DATEEXO`),
  ADD KEY `DATERETOUR` (`DATERETOUR`),
  ADD KEY `TYPEEXO` (`TYPEEXO`),
  ADD KEY `IDCLASSROOM` (`IDCLASSROOM`),
  ADD KEY `IDMATIERE` (`IDMATIERE`),
  ADD KEY `IDETABLISSEMENT` (`IDETABLISSEMENT`);

--
-- Index pour la table `FACTURE`
--
ALTER TABLE `FACTURE`
  ADD PRIMARY KEY (`IDFACTURE`),
  ADD KEY `MOIS` (`MOIS`),
  ADD KEY `MONTANT` (`MONTANT`),
  ADD KEY `DATEREGLMT` (`DATEREGLMT`),
  ADD KEY `IDINSCRIPTION` (`IDINSCRIPTION`),
  ADD KEY `IDETABLISSEMENT` (`IDETABLISSEMENT`),
  ADD KEY `MT_VERSE` (`MT_VERSE`),
  ADD KEY `MT_RELIQUAT` (`MT_RELIQUAT`);

--
-- Index pour la table `FORFAIT_PROFESSEUR`
--
ALTER TABLE `FORFAIT_PROFESSEUR`
  ADD PRIMARY KEY (`ROWID`);

--
-- Index pour la table `INDIVIDU`
--
ALTER TABLE `INDIVIDU`
  ADD PRIMARY KEY (`IDINDIVIDU`),
  ADD UNIQUE KEY `CODE` (`CODE`),
  ADD KEY `NOM` (`NOM`),
  ADD KEY `PRENOMS` (`PRENOMS`),
  ADD KEY `TELMOBILE` (`TELMOBILE`),
  ADD KEY `TELDOM` (`TELDOM`),
  ADD KEY `LOGIN` (`LOGIN`),
  ADD KEY `MP` (`MP`),
  ADD KEY `IDETABLISSEMENT` (`IDETABLISSEMENT`),
  ADD KEY `IDTYPEINDIVIDU` (`IDTYPEINDIVIDU`),
  ADD KEY `SEXE` (`SEXE`),
  ADD KEY `DATNAISSANCE` (`DATNAISSANCE`),
  ADD KEY `IDPERE` (`IDTUTEUR`),
  ADD KEY `ANNEEBAC` (`ANNEEBAC`,`NATIONNALITE`,`SIT_MATRIMONIAL`),
  ADD KEY `NUMID` (`NUMID`),
  ADD KEY `COURRIEL` (`COURRIEL`),
  ADD KEY `MATRICULE` (`MATRICULE`) USING BTREE;

--
-- Index pour la table `INSCRIPTION`
--
ALTER TABLE `INSCRIPTION`
  ADD PRIMARY KEY (`IDINSCRIPTION`),
  ADD UNIQUE KEY `IDINSCRIPTION1` (`IDINDIVIDU`,`IDNIVEAU`,`IDANNEESSCOLAIRE`,`IDSERIE`),
  ADD KEY `DATEINSCRIPT` (`DATEINSCRIPT`),
  ADD KEY `MONTANT` (`MONTANT`),
  ADD KEY `STATUT` (`STATUT`),
  ADD KEY `IDNIVEAU` (`IDNIVEAU`),
  ADD KEY `IDINDIVIDU` (`IDINDIVIDU`),
  ADD KEY `IDETABLISSEMENT` (`IDETABLISSEMENT`),
  ADD KEY `IDANNEESSCOLAIRE` (`IDANNEESSCOLAIRE`),
  ADD KEY `IDSERIE` (`IDSERIE`),
  ADD KEY `DERNIER_ETAB` (`DERNIER_ETAB`),
  ADD KEY `VALIDETUDE` (`VALIDETUDE`),
  ADD KEY `FRAIS_DOSSIER` (`FRAIS_DOSSIER`),
  ADD KEY `FRAIS_EXAMEN` (`FRAIS_EXAMEN`),
  ADD KEY `UNIFORME` (`UNIFORME`),
  ADD KEY `VACCINATION` (`VACCINATION`),
  ADD KEY `ASSURANCE` (`ASSURANCE`),
  ADD KEY `FRAIS_SOUTENANCE` (`FRAIS_SOUTENANCE`),
  ADD KEY `RESULTAT_ANNUEL` (`RESULTAT_ANNUEL`),
  ADD KEY `ACCORD_MENSUELITE` (`ACCORD_MENSUELITE`);

--
-- Index pour la table `MATIERE`
--
ALTER TABLE `MATIERE`
  ADD PRIMARY KEY (`IDMATIERE`),
  ADD KEY `LIBELLE` (`LIBELLE`),
  ADD KEY `IDETABLISSEMENT` (`IDETABLISSEMENT`),
  ADD KEY `IDNIVEAU` (`IDNIVEAU`);

--
-- Index pour la table `MATIERE_ENSEIGNE`
--
ALTER TABLE `MATIERE_ENSEIGNE`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_matiere_enseigne_individu` (`ID_INDIVIDU`),
  ADD KEY `fk_matiere_enseigne_matiere` (`ID_MATIERE`);

--
-- Index pour la table `MATIERE_UE`
--
ALTER TABLE `MATIERE_UE`
  ADD PRIMARY KEY (`iduematiere`),
  ADD KEY `IDUEIDMATIERE` (`IDUE`,`IDMATIERE`),
  ADD KEY `IDUE` (`IDUE`),
  ADD KEY `IDMATIERE` (`IDMATIERE`),
  ADD KEY `nbcredit` (`nbcredit`);

--
-- Index pour la table `MENSUALITE`
--
ALTER TABLE `MENSUALITE`
  ADD PRIMARY KEY (`IDMENSUALITE`),
  ADD KEY `MOIS` (`MOIS`),
  ADD KEY `MONTANT` (`MONTANT`),
  ADD KEY `DATEREGLMT` (`DATEREGLMT`),
  ADD KEY `IDINSCRIPTION` (`IDINSCRIPTION`),
  ADD KEY `IDETABLISSEMENT` (`IDETABLISSEMENT`),
  ADD KEY `MT_VERSE` (`MT_VERSE`),
  ADD KEY `MT_RELIQUAT` (`MT_RELIQUAT`);

--
-- Index pour la table `MESSAGERIE`
--
ALTER TABLE `MESSAGERIE`
  ADD PRIMARY KEY (`IDMESSAGERIE`);

--
-- Index pour la table `MESSAGE_DESTINATAIRE`
--
ALTER TABLE `MESSAGE_DESTINATAIRE`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `MODE_PAIEMENT`
--
ALTER TABLE `MODE_PAIEMENT`
  ADD PRIMARY KEY (`ROWID`);

--
-- Index pour la table `MODULE`
--
ALTER TABLE `MODULE`
  ADD PRIMARY KEY (`idModule`),
  ADD KEY `Nomtable` (`nomModule`(255)),
  ADD KEY `user_creation` (`userCreation`),
  ADD KEY `date_creation` (`dateCreation`);

--
-- Index pour la table `MOIS_EXONORE`
--
ALTER TABLE `MOIS_EXONORE`
  ADD PRIMARY KEY (`ROWID`);

--
-- Index pour la table `MOYENNE_PERIODE`
--
ALTER TABLE `MOYENNE_PERIODE`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `MOYEN_PAIEMENT`
--
ALTER TABLE `MOYEN_PAIEMENT`
  ADD PRIMARY KEY (`IDMOYEN_PAIEMENT`),
  ADD KEY `LIB_MOYEN_PAIEMENT` (`LIB_MOYEN_PAIEMENT`);

--
-- Index pour la table `NIVEAU`
--
ALTER TABLE `NIVEAU`
  ADD PRIMARY KEY (`IDNIVEAU`),
  ADD KEY `LIBELLE` (`LIBELLE`),
  ADD KEY `IDETABLISSEMENT` (`IDETABLISSEMENT`);

--
-- Index pour la table `NIVEAU_SERIE`
--
ALTER TABLE `NIVEAU_SERIE`
  ADD PRIMARY KEY (`ID_NIV_SER`),
  ADD UNIQUE KEY `IDNIVEAU_SERIE` (`IDNIVEAU`,`IDSERIE`),
  ADD KEY `IDSERIE` (`IDSERIE`),
  ADD KEY `IDNIVEAU` (`IDNIVEAU`),
  ADD KEY `MT_MENSUALITE` (`MT_MENSUALITE`),
  ADD KEY `FRAIS_INSCRIPTION` (`FRAIS_INSCRIPTION`),
  ADD KEY `IDETABLISSEMENT` (`IDETABLISSEMENT`);

--
-- Index pour la table `NIV_CLASSE`
--
ALTER TABLE `NIV_CLASSE`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `NOTE`
--
ALTER TABLE `NOTE`
  ADD PRIMARY KEY (`IDNOTE`),
  ADD UNIQUE KEY `IDNOTE1` (`IDINDIVIDU`,`IDCONTROLE`),
  ADD KEY `NOTE` (`NOTE`),
  ADD KEY `IDCONTROLE` (`IDCONTROLE`),
  ADD KEY `IDINDIVIDU` (`IDINDIVIDU`),
  ADD KEY `IDETABLISSEMENT` (`IDETABLISSEMENT`);

--
-- Index pour la table `operateur`
--
ALTER TABLE `operateur`
  ADD PRIMARY KEY (`rowid`);

--
-- Index pour la table `PARENT`
--
ALTER TABLE `PARENT`
  ADD PRIMARY KEY (`idParent`,`ideleve`);

--
-- Index pour la table `PAYS`
--
ALTER TABLE `PAYS`
  ADD PRIMARY KEY (`ROWID`),
  ADD UNIQUE KEY `idx_c_pays_code` (`CODE`),
  ADD UNIQUE KEY `idx_c_pays_libelle` (`LIBELLE`),
  ADD UNIQUE KEY `idx_c_pays_code_iso` (`CODE_ISO`);

--
-- Index pour la table `PERIODE`
--
ALTER TABLE `PERIODE`
  ADD PRIMARY KEY (`IDPERIODE`),
  ADD KEY `NOM_PERIODE` (`NOM_PERIODE`),
  ADD KEY `DEBUT_PERIODE` (`DEBUT_PERIODE`),
  ADD KEY `FIN_FPERIODE` (`FIN_FPERIODE`),
  ADD KEY `IDANNEESSCOLAIRE` (`IDANNEESSCOLAIRE`),
  ADD KEY `IDETABLISSEMENT` (`IDETABLISSEMENT`);

--
-- Index pour la table `PHAR`
--
ALTER TABLE `PHAR`
  ADD PRIMARY KEY (`ROWID`);

--
-- Index pour la table `PIECE_JOINTE`
--
ALTER TABLE `PIECE_JOINTE`
  ADD PRIMARY KEY (`IDPIECE_JOINTE`),
  ADD KEY `IDMESSAGERIE` (`IDMESSAGERIE`),
  ADD KEY `IDETABLISSEMENT` (`IDETABLISSEMENT`),
  ADD KEY `LIB_PIECESJOINTE` (`LIB_PIECESJOINTE`),
  ADD KEY `PATH_PIECEJOINTE` (`PATH_PIECEJOINTE`);

--
-- Index pour la table `PRESENCE_ELEVES`
--
ALTER TABLE `PRESENCE_ELEVES`
  ADD PRIMARY KEY (`IDPRESENCE_ELEVES`),
  ADD UNIQUE KEY `IDDISPENSER_COURSIDINDIVIDU` (`IDDISPENSER_COURS`,`IDINDIVIDU`),
  ADD KEY `ETAT_PRESENCE` (`ETAT_PRESENCE`),
  ADD KEY `IDETABLISSEMENT` (`IDETABLISSEMENT`),
  ADD KEY `IDDISPENSER_COURS` (`IDDISPENSER_COURS`),
  ADD KEY `IDINDIVIDU` (`IDINDIVIDU`);

--
-- Index pour la table `profil`
--
ALTER TABLE `profil`
  ADD PRIMARY KEY (`idProfil`),
  ADD KEY `idEtablissement` (`idEtablissement`);

--
-- Index pour la table `RECRUTE_PROF`
--
ALTER TABLE `RECRUTE_PROF`
  ADD PRIMARY KEY (`IDRECRUTE_PROF`),
  ADD KEY `TARIF_HORAIRE` (`TARIF_HORAIRE`),
  ADD KEY `IDETABLISSEMENT` (`IDETABLISSEMENT`),
  ADD KEY `IDINDIVIDU` (`IDINDIVIDU`),
  ADD KEY `IDANNEESSCOLAIRE` (`IDANNEESSCOLAIRE`);

--
-- Index pour la table `REGLEMENT`
--
ALTER TABLE `REGLEMENT`
  ADD PRIMARY KEY (`IDREGLEMENT`),
  ADD KEY `DATE_REGLMT` (`DATE_REGLMT`),
  ADD KEY `MT_REGLE` (`MT_REGLE`),
  ADD KEY `NUM_PIECE` (`NUM_PIECE`),
  ADD KEY `IDMENSUALITE` (`IDMENSUALITE`),
  ADD KEY `IDMOYEN_PAIEMENT` (`IDMOYEN_PAIEMENT`);

--
-- Index pour la table `REGLEMENT_PERSO`
--
ALTER TABLE `REGLEMENT_PERSO`
  ADD PRIMARY KEY (`IDREGLEMENT`),
  ADD KEY `fk_reglem_individu` (`INDIVIDU`);

--
-- Index pour la table `REGLEMENT_PROF`
--
ALTER TABLE `REGLEMENT_PROF`
  ADD PRIMARY KEY (`IDREGLEMENT`);

--
-- Index pour la table `SALL_DE_CLASSE`
--
ALTER TABLE `SALL_DE_CLASSE`
  ADD PRIMARY KEY (`IDSALL_DE_CLASSE`),
  ADD KEY `NOM_SALLE` (`NOM_SALLE`),
  ADD KEY `IDTYPE_SALLE` (`IDTYPE_SALLE`),
  ADD KEY `IDETABLISSEMENT` (`IDETABLISSEMENT`);

--
-- Index pour la table `SANCTION`
--
ALTER TABLE `SANCTION`
  ADD PRIMARY KEY (`IDSANCTION`),
  ADD KEY `DATE` (`DATE`),
  ADD KEY `MOTIF` (`MOTIF`),
  ADD KEY `DATEDEBUT` (`DATEDEBUT`),
  ADD KEY `DATEFIN` (`DATEFIN`),
  ADD KEY `IDINDIVIDU` (`IDINDIVIDU`),
  ADD KEY `IDETABLISSEMENT` (`IDETABLISSEMENT`),
  ADD KEY `ID_AUTHORITE` (`ID_AUTHORITE`);

--
-- Index pour la table `secteur_activite`
--
ALTER TABLE `secteur_activite`
  ADD PRIMARY KEY (`IDSECTEUR`);

--
-- Index pour la table `SECTION_TRANSPORT`
--
ALTER TABLE `SECTION_TRANSPORT`
  ADD PRIMARY KEY (`ID_SECTION`);

--
-- Index pour la table `SERIE`
--
ALTER TABLE `SERIE`
  ADD PRIMARY KEY (`IDSERIE`),
  ADD KEY `LIBSERIE` (`LIBSERIE`),
  ADD KEY `IDETABLISSEMENT` (`IDETABLISSEMENT`);

--
-- Index pour la table `SORTI_EQUIPEMENT`
--
ALTER TABLE `SORTI_EQUIPEMENT`
  ADD PRIMARY KEY (`ID_SORTI_EQUIPEMENT`);

--
-- Index pour la table `TABLEAU_DHONNEUR`
--
ALTER TABLE `TABLEAU_DHONNEUR`
  ADD PRIMARY KEY (`ROWID`);

--
-- Index pour la table `TIMETABLE`
--
ALTER TABLE `TIMETABLE`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `TRANSPORT_MENSUALITE`
--
ALTER TABLE `TRANSPORT_MENSUALITE`
  ADD PRIMARY KEY (`ROWID`);

--
-- Index pour la table `TROUSSEAU`
--
ALTER TABLE `TROUSSEAU`
  ADD PRIMARY KEY (`ROWID`);

--
-- Index pour la table `TYPEDOCADMIN`
--
ALTER TABLE `TYPEDOCADMIN`
  ADD PRIMARY KEY (`IDTYPEDOCADMIN`),
  ADD KEY `LIBELLE` (`LIBELLE`),
  ADD KEY `IDETABLISSEMENT` (`IDETABLISSEMENT`),
  ADD KEY `IDMODELE_DOC` (`IDMODELE_DOC`);

--
-- Index pour la table `TYPEINDIVIDU`
--
ALTER TABLE `TYPEINDIVIDU`
  ADD PRIMARY KEY (`IDTYPEINDIVIDU`),
  ADD KEY `LIBELLE` (`LIBELLE`),
  ADD KEY `IDETABLISSEMENT` (`IDETABLISSEMENT`);

--
-- Index pour la table `TYPE_DOC_ETU`
--
ALTER TABLE `TYPE_DOC_ETU`
  ADD PRIMARY KEY (`IDTYPEDOCETU`);

--
-- Index pour la table `TYPE_EXONERATION`
--
ALTER TABLE `TYPE_EXONERATION`
  ADD PRIMARY KEY (`ROWID`);

--
-- Index pour la table `TYPE_PAIEMENT`
--
ALTER TABLE `TYPE_PAIEMENT`
  ADD PRIMARY KEY (`id_type_paiment`);

--
-- Index pour la table `TYPE_SALLE`
--
ALTER TABLE `TYPE_SALLE`
  ADD PRIMARY KEY (`IDTYPE_SALLE`),
  ADD KEY `TYPE_SALLE` (`TYPE_SALLE`),
  ADD KEY `IDETABLISSEMENT` (`IDETABLISSEMENT`);

--
-- Index pour la table `TYPE_SANCTION`
--
ALTER TABLE `TYPE_SANCTION`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `TYP_CONTROL`
--
ALTER TABLE `TYP_CONTROL`
  ADD PRIMARY KEY (`IDTYP_CONTROL`),
  ADD KEY `LIB_TYPCONTROL` (`LIB_TYPCONTROL`),
  ADD KEY `POIDS` (`POIDS`),
  ADD KEY `IDETABLISSEMENT` (`IDETABLISSEMENT`),
  ADD KEY `COULEUR` (`COULEUR`);

--
-- Index pour la table `UE`
--
ALTER TABLE `UE`
  ADD PRIMARY KEY (`IDUE`),
  ADD KEY `LIBELLE` (`LIBELLE`),
  ADD KEY `IDNIVEAU` (`IDNIVEAU`),
  ADD KEY `IDSERIE` (`IDSERIE`),
  ADD KEY `IDETABLISSEMENT` (`IDETABLISSEMENT`);

--
-- Index pour la table `UNIFORME`
--
ALTER TABLE `UNIFORME`
  ADD PRIMARY KEY (`ROWID`);

--
-- Index pour la table `UTILISATEURS`
--
ALTER TABLE `UTILISATEURS`
  ADD PRIMARY KEY (`idUtilisateur`),
  ADD UNIQUE KEY `login` (`login`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idEtablissement` (`idEtablissement`) USING BTREE,
  ADD KEY `idProfil` (`idProfil`) USING BTREE;

--
-- Index pour la table `VACANCES`
--
ALTER TABLE `VACANCES`
  ADD PRIMARY KEY (`IDJOUR_FERIES`),
  ADD KEY `LIB_VACANCES` (`LIB_VACANCES`),
  ADD KEY `DATE_DEBUT` (`DATE_DEBUT`),
  ADD KEY `DATE_FIN` (`DATE_FIN`),
  ADD KEY `IDETABLISSEMENT` (`IDETABLISSEMENT`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `ACTION`
--
ALTER TABLE `ACTION`
  MODIFY `idAction` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT pour la table `ACTUALITES`
--
ALTER TABLE `ACTUALITES`
  MODIFY `IDACTUALITES` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `affectationDroit`
--
ALTER TABLE `affectationDroit`
  MODIFY `idAffectation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=281;

--
-- AUTO_INCREMENT pour la table `AFFECTATION_DROIT`
--
ALTER TABLE `AFFECTATION_DROIT`
  MODIFY `IDAFFECTATION_DROIT` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `AFFECTATION_ELEVE_CLASSE`
--
ALTER TABLE `AFFECTATION_ELEVE_CLASSE`
  MODIFY `IDAFFECTATTION_ELEVE_CLASSE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT pour la table `affecter_doc`
--
ALTER TABLE `affecter_doc`
  MODIFY `idaff` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `AFFECTER_DOC_ETU`
--
ALTER TABLE `AFFECTER_DOC_ETU`
  MODIFY `IDAFFDOCETU` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `ANNEESSCOLAIRE`
--
ALTER TABLE `ANNEESSCOLAIRE`
  MODIFY `IDANNEESSCOLAIRE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `BANQUE`
--
ALTER TABLE `BANQUE`
  MODIFY `ROWID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `BULLETIN`
--
ALTER TABLE `BULLETIN`
  MODIFY `ROWID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `calendar`
--
ALTER TABLE `calendar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `CATEGEQUIP`
--
ALTER TABLE `CATEGEQUIP`
  MODIFY `IDCATEGEQUIP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT pour la table `CLASSROOM`
--
ALTER TABLE `CLASSROOM`
  MODIFY `IDCLASSROOM` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `COEFFICIENT`
--
ALTER TABLE `COEFFICIENT`
  MODIFY `IDCOEFFICIENT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `CONTROLE`
--
ALTER TABLE `CONTROLE`
  MODIFY `IDCONTROLE` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `CV`
--
ALTER TABLE `CV`
  MODIFY `IDCV` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `DEPENSE`
--
ALTER TABLE `DEPENSE`
  MODIFY `IDREGLEMENT` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `DESTINATAIRE`
--
ALTER TABLE `DESTINATAIRE`
  MODIFY `IDDESTINATAIRE` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `DETAIL_BULLETIN`
--
ALTER TABLE `DETAIL_BULLETIN`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `DETAIL_TIMETABLE`
--
ALTER TABLE `DETAIL_TIMETABLE`
  MODIFY `IDDETAIL_TIMETABLE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `DISPENSER_COURS`
--
ALTER TABLE `DISPENSER_COURS`
  MODIFY `IDDISPENSER_COURS` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `DOCADMIN`
--
ALTER TABLE `DOCADMIN`
  MODIFY `IDDOCADMIN` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `document_prof`
--
ALTER TABLE `document_prof`
  MODIFY `iddoc` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `DOC_DIDACTIQUE`
--
ALTER TABLE `DOC_DIDACTIQUE`
  MODIFY `IDDOC_DIDACTIQUE` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `DOC_ETUDIANT`
--
ALTER TABLE `DOC_ETUDIANT`
  MODIFY `IDDOCETU` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `DROIT`
--
ALTER TABLE `DROIT`
  MODIFY `IDdroit` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `EMPLOIEDUTEMPS`
--
ALTER TABLE `EMPLOIEDUTEMPS`
  MODIFY `IDEMPLOIEDUTEMPS` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `EQUIPEMENT`
--
ALTER TABLE `EQUIPEMENT`
  MODIFY `IDEQUIPEMENT` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `ETABLISSEMENT`
--
ALTER TABLE `ETABLISSEMENT`
  MODIFY `IDETABLISSEMENT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `evenement`
--
ALTER TABLE `evenement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `EXERCICE`
--
ALTER TABLE `EXERCICE`
  MODIFY `IDEXERCICE` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `FACTURE`
--
ALTER TABLE `FACTURE`
  MODIFY `IDFACTURE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `FORFAIT_PROFESSEUR`
--
ALTER TABLE `FORFAIT_PROFESSEUR`
  MODIFY `ROWID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `INDIVIDU`
--
ALTER TABLE `INDIVIDU`
  MODIFY `IDINDIVIDU` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT pour la table `INSCRIPTION`
--
ALTER TABLE `INSCRIPTION`
  MODIFY `IDINSCRIPTION` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT pour la table `MATIERE`
--
ALTER TABLE `MATIERE`
  MODIFY `IDMATIERE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `MATIERE_ENSEIGNE`
--
ALTER TABLE `MATIERE_ENSEIGNE`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `MATIERE_UE`
--
ALTER TABLE `MATIERE_UE`
  MODIFY `iduematiere` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `MENSUALITE`
--
ALTER TABLE `MENSUALITE`
  MODIFY `IDMENSUALITE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT pour la table `MESSAGERIE`
--
ALTER TABLE `MESSAGERIE`
  MODIFY `IDMESSAGERIE` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `MESSAGE_DESTINATAIRE`
--
ALTER TABLE `MESSAGE_DESTINATAIRE`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `MODE_PAIEMENT`
--
ALTER TABLE `MODE_PAIEMENT`
  MODIFY `ROWID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `MODULE`
--
ALTER TABLE `MODULE`
  MODIFY `idModule` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `MOIS_EXONORE`
--
ALTER TABLE `MOIS_EXONORE`
  MODIFY `ROWID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `MOYENNE_PERIODE`
--
ALTER TABLE `MOYENNE_PERIODE`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `MOYEN_PAIEMENT`
--
ALTER TABLE `MOYEN_PAIEMENT`
  MODIFY `IDMOYEN_PAIEMENT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `NIVEAU`
--
ALTER TABLE `NIVEAU`
  MODIFY `IDNIVEAU` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `NIVEAU_SERIE`
--
ALTER TABLE `NIVEAU_SERIE`
  MODIFY `ID_NIV_SER` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `NIV_CLASSE`
--
ALTER TABLE `NIV_CLASSE`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `NOTE`
--
ALTER TABLE `NOTE`
  MODIFY `IDNOTE` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `operateur`
--
ALTER TABLE `operateur`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `PERIODE`
--
ALTER TABLE `PERIODE`
  MODIFY `IDPERIODE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `PHAR`
--
ALTER TABLE `PHAR`
  MODIFY `ROWID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `PIECE_JOINTE`
--
ALTER TABLE `PIECE_JOINTE`
  MODIFY `IDPIECE_JOINTE` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `PRESENCE_ELEVES`
--
ALTER TABLE `PRESENCE_ELEVES`
  MODIFY `IDPRESENCE_ELEVES` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `profil`
--
ALTER TABLE `profil`
  MODIFY `idProfil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `RECRUTE_PROF`
--
ALTER TABLE `RECRUTE_PROF`
  MODIFY `IDRECRUTE_PROF` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `REGLEMENT`
--
ALTER TABLE `REGLEMENT`
  MODIFY `IDREGLEMENT` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `REGLEMENT_PERSO`
--
ALTER TABLE `REGLEMENT_PERSO`
  MODIFY `IDREGLEMENT` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `REGLEMENT_PROF`
--
ALTER TABLE `REGLEMENT_PROF`
  MODIFY `IDREGLEMENT` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `SALL_DE_CLASSE`
--
ALTER TABLE `SALL_DE_CLASSE`
  MODIFY `IDSALL_DE_CLASSE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `SANCTION`
--
ALTER TABLE `SANCTION`
  MODIFY `IDSANCTION` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `secteur_activite`
--
ALTER TABLE `secteur_activite`
  MODIFY `IDSECTEUR` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=204;

--
-- AUTO_INCREMENT pour la table `SECTION_TRANSPORT`
--
ALTER TABLE `SECTION_TRANSPORT`
  MODIFY `ID_SECTION` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `SERIE`
--
ALTER TABLE `SERIE`
  MODIFY `IDSERIE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `SORTI_EQUIPEMENT`
--
ALTER TABLE `SORTI_EQUIPEMENT`
  MODIFY `ID_SORTI_EQUIPEMENT` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `TABLEAU_DHONNEUR`
--
ALTER TABLE `TABLEAU_DHONNEUR`
  MODIFY `ROWID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `TIMETABLE`
--
ALTER TABLE `TIMETABLE`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `TRANSPORT_MENSUALITE`
--
ALTER TABLE `TRANSPORT_MENSUALITE`
  MODIFY `ROWID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `TROUSSEAU`
--
ALTER TABLE `TROUSSEAU`
  MODIFY `ROWID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `TYPEDOCADMIN`
--
ALTER TABLE `TYPEDOCADMIN`
  MODIFY `IDTYPEDOCADMIN` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `TYPEINDIVIDU`
--
ALTER TABLE `TYPEINDIVIDU`
  MODIFY `IDTYPEINDIVIDU` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `TYPE_DOC_ETU`
--
ALTER TABLE `TYPE_DOC_ETU`
  MODIFY `IDTYPEDOCETU` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `TYPE_EXONERATION`
--
ALTER TABLE `TYPE_EXONERATION`
  MODIFY `ROWID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `TYPE_PAIEMENT`
--
ALTER TABLE `TYPE_PAIEMENT`
  MODIFY `id_type_paiment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `TYPE_SALLE`
--
ALTER TABLE `TYPE_SALLE`
  MODIFY `IDTYPE_SALLE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `TYPE_SANCTION`
--
ALTER TABLE `TYPE_SANCTION`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `TYP_CONTROL`
--
ALTER TABLE `TYP_CONTROL`
  MODIFY `IDTYP_CONTROL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `UE`
--
ALTER TABLE `UE`
  MODIFY `IDUE` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `UNIFORME`
--
ALTER TABLE `UNIFORME`
  MODIFY `ROWID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `UTILISATEURS`
--
ALTER TABLE `UTILISATEURS`
  MODIFY `idUtilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `VACANCES`
--
ALTER TABLE `VACANCES`
  MODIFY `IDJOUR_FERIES` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `ACTION`
--
ALTER TABLE `ACTION`
  ADD CONSTRAINT `etablissement` FOREIGN KEY (`idEtablissement`) REFERENCES `ETABLISSEMENT` (`IDETABLISSEMENT`),
  ADD CONSTRAINT `fk_module` FOREIGN KEY (`module`) REFERENCES `MODULE` (`idModule`);

--
-- Contraintes pour la table `affectationDroit`
--
ALTER TABLE `affectationDroit`
  ADD CONSTRAINT `fk_action` FOREIGN KEY (`action`) REFERENCES `ACTION` (`idAction`),
  ADD CONSTRAINT `fk_profil` FOREIGN KEY (`profil`) REFERENCES `profil` (`idProfil`);

--
-- Contraintes pour la table `BULLETIN`
--
ALTER TABLE `BULLETIN`
  ADD CONSTRAINT `fk_bulletin_annee` FOREIGN KEY (`IDANNEE`) REFERENCES `ANNEESSCOLAIRE` (`IDANNEESSCOLAIRE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_bulletin_classrom` FOREIGN KEY (`IDCLASSROOM`) REFERENCES `CLASSROOM` (`IDCLASSROOM`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_bulletin_etablissement` FOREIGN KEY (`IDETABLISSEMENT`) REFERENCES `ETABLISSEMENT` (`IDETABLISSEMENT`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_bulletin_individu` FOREIGN KEY (`IDINDIVIDU`) REFERENCES `INDIVIDU` (`IDINDIVIDU`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `CLASSROOM`
--
ALTER TABLE `CLASSROOM`
  ADD CONSTRAINT `fk_classe_cycle` FOREIGN KEY (`IDNIVEAU`) REFERENCES `NIVEAU` (`IDNIVEAU`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_classe_niveau` FOREIGN KEY (`IDNIV`) REFERENCES `NIV_CLASSE` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_classe_serie` FOREIGN KEY (`IDSERIE`) REFERENCES `SERIE` (`IDSERIE`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `COEFFICIENT`
--
ALTER TABLE `COEFFICIENT`
  ADD CONSTRAINT `fk_coef_cycle` FOREIGN KEY (`IDNIVEAU`) REFERENCES `NIVEAU` (`IDNIVEAU`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_coef_etablissement` FOREIGN KEY (`IDETABLISSEMENT`) REFERENCES `ETABLISSEMENT` (`IDETABLISSEMENT`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_coef_matiere` FOREIGN KEY (`IDMATIERE`) REFERENCES `MATIERE` (`IDMATIERE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_coef_serie` FOREIGN KEY (`IDSERIE`) REFERENCES `SERIE` (`IDSERIE`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `CONTROLE`
--
ALTER TABLE `CONTROLE`
  ADD CONSTRAINT `fk_controle_annee` FOREIGN KEY (`IDANNEE`) REFERENCES `ANNEESSCOLAIRE` (`IDANNEESSCOLAIRE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_controle_classroom` FOREIGN KEY (`IDCLASSROOM`) REFERENCES `CLASSROOM` (`IDCLASSROOM`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_controle_etablissement` FOREIGN KEY (`IDETABLISSEMENT`) REFERENCES `ETABLISSEMENT` (`IDETABLISSEMENT`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_controle_individu` FOREIGN KEY (`IDINDIVIDU`) REFERENCES `INDIVIDU` (`IDINDIVIDU`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_controle_matiere` FOREIGN KEY (`IDMATIERE`) REFERENCES `MATIERE` (`IDMATIERE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_controle_periode` FOREIGN KEY (`IDPERIODE`) REFERENCES `PERIODE` (`IDPERIODE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_controle_typecontrole` FOREIGN KEY (`IDTYP_CONTROL`) REFERENCES `TYP_CONTROL` (`IDTYP_CONTROL`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `DETAIL_BULLETIN`
--
ALTER TABLE `DETAIL_BULLETIN`
  ADD CONSTRAINT `fk_detail_bulletin` FOREIGN KEY (`FK_BULLETIN`) REFERENCES `BULLETIN` (`ROWID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `DETAIL_TIMETABLE`
--
ALTER TABLE `DETAIL_TIMETABLE`
  ADD CONSTRAINT `fk_timetabble_matiere` FOREIGN KEY (`IDMATIERE`) REFERENCES `MATIERE` (`IDMATIERE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_timetable_emploitemps` FOREIGN KEY (`IDEMPLOIEDUTEMPS`) REFERENCES `EMPLOIEDUTEMPS` (`IDEMPLOIEDUTEMPS`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_timetable_individu` FOREIGN KEY (`IDINDIVIDU`) REFERENCES `INDIVIDU` (`IDINDIVIDU`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `DISPENSER_COURS`
--
ALTER TABLE `DISPENSER_COURS`
  ADD CONSTRAINT `fk_dispense_classroom` FOREIGN KEY (`IDCLASSROOM`) REFERENCES `CLASSROOM` (`IDCLASSROOM`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_dispense_individu` FOREIGN KEY (`IDINDIVIDU`) REFERENCES `INDIVIDU` (`IDINDIVIDU`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_dispense_matiere` FOREIGN KEY (`IDMATIERE`) REFERENCES `MATIERE` (`IDMATIERE`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `DOCADMIN`
--
ALTER TABLE `DOCADMIN`
  ADD CONSTRAINT `fk_docadmin_individu` FOREIGN KEY (`IDINDIVIDU`) REFERENCES `INDIVIDU` (`IDINDIVIDU`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_docadmin_type` FOREIGN KEY (`IDTYPEDOCADMIN`) REFERENCES `TYPEDOCADMIN` (`IDTYPEDOCADMIN`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `EMPLOIEDUTEMPS`
--
ALTER TABLE `EMPLOIEDUTEMPS`
  ADD CONSTRAINT `fk_emploitemps_classroom` FOREIGN KEY (`IDCLASSROOM`) REFERENCES `CLASSROOM` (`IDCLASSROOM`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_emploitemps_periode` FOREIGN KEY (`IDPERIODE`) REFERENCES `PERIODE` (`IDPERIODE`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `EQUIPEMENT`
--
ALTER TABLE `EQUIPEMENT`
  ADD CONSTRAINT `fk_categ_equip` FOREIGN KEY (`IDCATEGEQUIP`) REFERENCES `CATEGEQUIP` (`IDCATEGEQUIP`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `FACTURE`
--
ALTER TABLE `FACTURE`
  ADD CONSTRAINT `fk_facture_inscription` FOREIGN KEY (`IDINSCRIPTION`) REFERENCES `INSCRIPTION` (`IDINSCRIPTION`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `INSCRIPTION`
--
ALTER TABLE `INSCRIPTION`
  ADD CONSTRAINT `fk_inscrire_annee` FOREIGN KEY (`IDANNEESSCOLAIRE`) REFERENCES `ANNEESSCOLAIRE` (`IDANNEESSCOLAIRE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_inscrire_individu` FOREIGN KEY (`IDINDIVIDU`) REFERENCES `INDIVIDU` (`IDINDIVIDU`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_inscrire_niveau` FOREIGN KEY (`IDNIVEAU`) REFERENCES `NIVEAU` (`IDNIVEAU`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `MATIERE`
--
ALTER TABLE `MATIERE`
  ADD CONSTRAINT `IDNIVEAU` FOREIGN KEY (`IDNIVEAU`) REFERENCES `NIVEAU` (`IDNIVEAU`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `MATIERE_ENSEIGNE`
--
ALTER TABLE `MATIERE_ENSEIGNE`
  ADD CONSTRAINT `fk_matiere_enseigne_individu` FOREIGN KEY (`ID_INDIVIDU`) REFERENCES `INDIVIDU` (`IDINDIVIDU`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_matiere_enseigne_matiere` FOREIGN KEY (`ID_MATIERE`) REFERENCES `MATIERE` (`IDMATIERE`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `MENSUALITE`
--
ALTER TABLE `MENSUALITE`
  ADD CONSTRAINT `fk_mensualite_inscription` FOREIGN KEY (`IDINSCRIPTION`) REFERENCES `INSCRIPTION` (`IDINSCRIPTION`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `REGLEMENT_PERSO`
--
ALTER TABLE `REGLEMENT_PERSO`
  ADD CONSTRAINT `fk_reglem_individu` FOREIGN KEY (`INDIVIDU`) REFERENCES `INDIVIDU` (`IDINDIVIDU`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `UTILISATEURS`
--
ALTER TABLE `UTILISATEURS`
  ADD CONSTRAINT `fk_idEtablissement` FOREIGN KEY (`idEtablissement`) REFERENCES `ETABLISSEMENT` (`IDETABLISSEMENT`),
  ADD CONSTRAINT `fk_idProfil` FOREIGN KEY (`idProfil`) REFERENCES `profil` (`idProfil`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
