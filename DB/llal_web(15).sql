-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Sam 09 Avril 2016 à 22:02
-- Version du serveur :  10.1.10-MariaDB
-- Version de PHP :  7.0.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `llal_web`
--
CREATE DATABASE IF NOT EXISTS `llal_web` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `llal_web`;

-- --------------------------------------------------------

--
-- Structure de la table `administrer`
--

CREATE TABLE `administrer` (
  `_Id_enseignant` int(11) NOT NULL,
  `_Id_module` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `administrer`
--

INSERT INTO `administrer` (`_Id_enseignant`, `_Id_module`) VALUES
(1, 1),
(2, 3),
(3, 5),
(3, 6),
(4, 4),
(5, 7),
(6, 5),
(6, 8),
(7, 9),
(8, 11),
(9, 10),
(9, 11),
(10, 12),
(11, 3),
(12, 7),
(13, 11),
(14, 10),
(15, 12),
(16, 15),
(87, 36);

-- --------------------------------------------------------

--
-- Structure de la table `appartenir`
--

CREATE TABLE `appartenir` (
  `_Id_eleve` int(11) NOT NULL,
  `_Id_groupe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `appartenir`
--

INSERT INTO `appartenir` (`_Id_eleve`, `_Id_groupe`) VALUES
(1, 1),
(1, 5),
(1, 7),
(1, 9),
(1, 10),
(1, 12),
(3, 5),
(6, 5),
(6, 13),
(7, 15),
(12, 11),
(12, 16),
(13, 12),
(15, 7),
(16, 14),
(16, 18),
(17, 12),
(18, 5),
(18, 10),
(19, 10),
(24, 10),
(31, 8),
(31, 11),
(31, 17),
(36, 8),
(36, 11),
(36, 17),
(37, 1),
(37, 5),
(43, 9),
(46, 11),
(52, 5),
(53, 5),
(55, 1),
(55, 5),
(56, 12),
(61, 5),
(61, 18),
(65, 12),
(66, 12),
(67, 12),
(68, 12);

-- --------------------------------------------------------

--
-- Structure de la table `candidater`
--

CREATE TABLE `candidater` (
  `_Id_eleve` int(11) NOT NULL,
  `_Id_groupe` int(11) NOT NULL,
  `Message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `candidater`
--

INSERT INTO `candidater` (`_Id_eleve`, `_Id_groupe`, `Message`) VALUES
(1, 13, ''),
(1, 14, ''),
(1, 15, ''),
(1, 16, '');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `Id_client` int(11) NOT NULL,
  `Societe` text NOT NULL,
  `Adresse` text NOT NULL,
  `_Id_utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `client`
--

INSERT INTO `client` (`Id_client`, `Societe`, `Adresse`, `_Id_utilisateur`) VALUES
(1, 'Labri', '', 86),
(2, '', '', 87),
(3, '', '', 77);

-- --------------------------------------------------------

--
-- Structure de la table `commander`
--

CREATE TABLE `commander` (
  `_Id_client` int(11) NOT NULL,
  `_Id_groupe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `commander`
--

INSERT INTO `commander` (`_Id_client`, `_Id_groupe`) VALUES
(1, 10),
(2, 1),
(3, 9),
(3, 17),
(3, 18);

-- --------------------------------------------------------

--
-- Structure de la table `eleve`
--

CREATE TABLE `eleve` (
  `Id_eleve` int(11) NOT NULL,
  `Promo` year(4) NOT NULL,
  `Num_TD` int(11) NOT NULL,
  `Redoublant` varchar(1) NOT NULL,
  `_Id_utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `eleve`
--

INSERT INTO `eleve` (`Id_eleve`, `Promo`, `Num_TD`, `Redoublant`, `_Id_utilisateur`) VALUES
(1, 2018, 1, 'N', 2),
(2, 2018, 1, 'N', 3),
(3, 2018, 1, 'N', 4),
(4, 2018, 2, 'N', 5),
(5, 2018, 1, 'N', 6),
(6, 2018, 1, 'N', 7),
(7, 2018, 3, 'N', 8),
(8, 2018, 1, 'N', 9),
(9, 2018, 3, 'N', 10),
(10, 2018, 3, 'N', 11),
(11, 2018, 3, 'N', 12),
(12, 2018, 3, 'N', 13),
(13, 2018, 2, 'N', 14),
(14, 2018, 2, 'N', 15),
(15, 2018, 2, 'N', 16),
(16, 2018, 2, 'N', 17),
(17, 2018, 2, 'N', 18),
(18, 2018, 2, 'N', 19),
(19, 2018, 2, 'N', 20),
(20, 2018, 3, 'N', 21),
(21, 2018, 3, 'N', 22),
(22, 2018, 3, 'N', 23),
(23, 2018, 3, 'N', 24),
(24, 2018, 3, 'N', 25),
(25, 2018, 3, 'N', 26),
(26, 2018, 3, 'N', 27),
(27, 2018, 3, 'N', 28),
(28, 2018, 3, 'N', 29),
(29, 2018, 3, 'N', 30),
(30, 2018, 1, 'N', 31),
(31, 2018, 1, 'N', 32),
(32, 2018, 1, 'N', 33),
(33, 2018, 1, 'N', 34),
(34, 2018, 1, 'N', 35),
(35, 2018, 1, 'N', 36),
(36, 2018, 1, 'N', 37),
(37, 2018, 1, 'N', 38),
(38, 2018, 1, 'N', 39),
(39, 2018, 1, 'N', 40),
(40, 2018, 1, 'N', 41),
(41, 2018, 1, 'N', 42),
(42, 2018, 1, 'N', 43),
(43, 2018, 1, 'N', 44),
(44, 2018, 1, 'N', 45),
(45, 2018, 3, 'N', 46),
(46, 2018, 1, 'N', 47),
(47, 2018, 1, 'N', 48),
(48, 2018, 2, 'N', 49),
(49, 2018, 2, 'N', 50),
(50, 2018, 2, 'N', 51),
(51, 2018, 2, 'N', 52),
(52, 2018, 2, 'N', 53),
(53, 2018, 2, 'O', 54),
(54, 2018, 2, 'N', 55),
(55, 2018, 2, 'N', 56),
(56, 2018, 3, 'N', 57),
(57, 2018, 2, 'N', 58),
(58, 2018, 2, 'N', 59),
(59, 2018, 2, 'N', 60),
(60, 2018, 1, 'N', 61),
(61, 2018, 2, 'N', 62),
(62, 2018, 2, 'N', 63),
(63, 2018, 2, 'N', 64),
(64, 2018, 2, 'N', 65),
(65, 2018, 2, 'N', 66),
(66, 2017, 1, 'N', 83),
(67, 2017, 2, 'N', 84),
(68, 2016, 1, 'N', 85);

-- --------------------------------------------------------

--
-- Structure de la table `enseignant`
--

CREATE TABLE `enseignant` (
  `Id_enseignant` int(11) NOT NULL,
  `Matiere` text NOT NULL,
  `_Id_utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `enseignant`
--

INSERT INTO `enseignant` (`Id_enseignant`, `Matiere`, `_Id_utilisateur`) VALUES
(1, 'Anglais', 67),
(2, 'Anglais', 68),
(3, 'Gestion projet', 69),
(4, '', 70),
(5, 'Ergonomie', 71),
(6, '', 72),
(7, 'Cognitique', 73),
(8, 'Ergonomie', 74),
(9, 'Biologie', 75),
(10, 'Informatique', 76),
(11, 'Informatique', 77),
(12, 'Math?matiques', 78),
(13, 'Connaissances et représentations', 79),
(14, 'Connaissances et représentations', 80),
(15, 'Signal', 81),
(16, 'BIA', 82),
(87, 'GCCO', 87);

-- --------------------------------------------------------

--
-- Structure de la table `etre_client`
--

CREATE TABLE `etre_client` (
  `_Id_enseignant` int(11) NOT NULL,
  `_Id_client` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `etre_client`
--

INSERT INTO `etre_client` (`_Id_enseignant`, `_Id_client`) VALUES
(11, 3),
(87, 2);

-- --------------------------------------------------------

--
-- Structure de la table `etre_tuteur`
--

CREATE TABLE `etre_tuteur` (
  `_Id_enseignant` int(11) NOT NULL,
  `_Id_tuteur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `etre_tuteur`
--

INSERT INTO `etre_tuteur` (`_Id_enseignant`, `_Id_tuteur`) VALUES
(4, 1);

-- --------------------------------------------------------

--
-- Structure de la table `gerer`
--

CREATE TABLE `gerer` (
  `_Id_eleve` int(11) NOT NULL,
  `_Id_groupe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `gestionnaire`
--

CREATE TABLE `gestionnaire` (
  `Id_gestionnaire` int(11) NOT NULL,
  `Date_poste` date NOT NULL,
  `_Id_utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `gestionnaire`
--

INSERT INTO `gestionnaire` (`Id_gestionnaire`, `Date_poste`, `_Id_utilisateur`) VALUES
(1, '1950-01-01', 1);

-- --------------------------------------------------------

--
-- Structure de la table `groupe`
--

CREATE TABLE `groupe` (
  `Id_groupe` int(11) NOT NULL,
  `Num_groupe` int(11) NOT NULL,
  `Specialisation_sujet` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `groupe`
--

INSERT INTO `groupe` (`Id_groupe`, `Num_groupe`, `Specialisation_sujet`) VALUES
(1, 1, 'Faire un avion en papier qui vole'),
(2, 1, ''),
(3, 2, ''),
(4, 3, ''),
(5, 1, 'Mauve'),
(6, 1, ''),
(7, 1, ''),
(8, 2, ''),
(9, 1, ''),
(10, 1, 'Displayce'),
(11, 2, 'emindmachine'),
(12, 1, 'Application de suivi de santé'),
(13, 1, 'Le Figaro'),
(14, 2, 'Valeurs actuelles'),
(15, 1, 'TV'),
(16, 2, 'Newspapers'),
(17, 2, ''),
(18, 3, ''),
(19, 0, '');

-- --------------------------------------------------------

--
-- Structure de la table `module`
--

CREATE TABLE `module` (
  `Id_module` int(11) NOT NULL,
  `Nom_mod` text NOT NULL,
  `Type` text NOT NULL,
  `Annee` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `module`
--

INSERT INTO `module` (`Id_module`, `Nom_mod`, `Type`, `Annee`) VALUES
(1, 'Anglais', 'Interne', '1A'),
(2, 'Elements d''orientation', 'Interne', '1A'),
(3, 'Transpromotion', 'Interne', '1A'),
(4, 'Transdisciplinaire', 'Interne', '1A'),
(5, 'Cognitique', 'Interne', '1A'),
(6, 'Facteurs Humains', 'Interne', '1A'),
(7, 'Neurobiologie / Biologie', 'Interne', '1A'),
(8, 'Base de donnees', 'Interne', '1A'),
(9, 'Programmation', 'Interne', '1A'),
(10, 'Probabilites / Statistique', 'Externe', '1A'),
(11, 'Gestion de projet', 'Externe', '1A'),
(12, 'Connaissances et representation', 'Interne', '1A'),
(13, 'Communication web', 'Interne', '1A'),
(14, 'Programmation avancee', 'Interne', '1A'),
(15, 'Statistique inferentielle et analyse de donnees', 'Interne', '1A'),
(16, 'Signaux et systemes', 'Interne', '1A'),
(17, 'Transpromotion', 'Externe', '2A'),
(18, 'AENT', 'Interne', '2A'),
(19, 'Ingenierie', 'Interne', '2A'),
(20, 'IHS', 'Interne', '2A'),
(21, 'Genie logiciel', 'Interne', '2A'),
(22, 'Anglais', 'Interne', '2A'),
(23, 'Mathematiques', 'Interne', '2A'),
(24, 'Signal', 'Interne', '2A'),
(25, 'Automatique', 'Interne', '2A'),
(26, 'Facteurs humains', 'Interne', '2A'),
(27, 'IART', 'Interne', '2A'),
(28, 'Informatique', 'Interne', '2A'),
(29, 'Enjeux entreprise', 'Interne', '2A'),
(30, 'SASU', 'Interne', '2A'),
(31, 'Intervention', 'Interne', '3A'),
(32, 'Intelligence collective', 'Interne', '3A'),
(33, 'Informatique', 'Interne', '3A'),
(34, 'Anglais', 'Interne', '3A'),
(35, 'NTIC', 'Interne', '3A'),
(36, 'GCCO', 'Interne', '1A');

-- --------------------------------------------------------

--
-- Structure de la table `projet`
--

CREATE TABLE `projet` (
  `Id_projet` int(11) NOT NULL,
  `Sujet` text NOT NULL,
  `Description` text NOT NULL,
  `Fichier_entree` text NOT NULL,
  `Documents` text NOT NULL,
  `Lien_moodle` text NOT NULL,
  `Date_debut` date NOT NULL,
  `Date_candidature` date NOT NULL,
  `Date_fin` date NOT NULL,
  `Date_soutenance` date NOT NULL,
  `Nb_eleves_min` int(11) NOT NULL,
  `Nb_eleves_max` int(11) NOT NULL,
  `Eleve_gere_grpe` tinyint(1) NOT NULL,
  `_Id_module` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `projet`
--

INSERT INTO `projet` (`Id_projet`, `Sujet`, `Description`, `Fichier_entree`, `Documents`, `Lien_moodle`, `Date_debut`, `Date_candidature`, `Date_fin`, `Date_soutenance`, `Nb_eleves_min`, `Nb_eleves_max`, `Eleve_gere_grpe`, `_Id_module`) VALUES
(1, 'RAO', 'Réaliser une réponse à appel d''offre pour la mairie de Lacanau', 'Cahier des charges V0', '', 'RAO-gesp-moodle.com', '2016-03-14', '2016-03-14', '2016-05-09', '0000-00-00', 7, 9, 0, 11),
(2, 'Codage T9', 'Codage T9 avec le langage C# ', 'Sujet.pdf', '', '', '2016-01-04', '2016-01-08', '2016-01-22', '0000-00-00', 2, 3, 1, 9),
(3, 'Projet Web', 'Realiser un site web pour gerer les projets de l''ENSC', 'Document papier du sujet', '', '', '2016-02-12', '2016-02-06', '2016-04-05', '2016-04-04', 2, 3, 1, 13),
(4, 'Mind Map', 'Realiser une Mind Map sur le sujet de votre choix', '', '', '', '2016-03-04', '0000-00-00', '2016-05-20', '0000-00-00', 1, 4, 1, 36),
(5, 'Info objet', '', '', '', '', '2016-04-01', '2016-04-08', '2016-04-30', '0000-00-00', 2, 2, 1, 9),
(6, 'Projet Transdisci', 'Réaliser un projet pour un client extérieur pendant 1 an', 'Fiche client', 'A voir avec le client', 'transdi-1A-moodle.com', '2015-10-01', '2016-11-15', '2016-05-20', '0000-00-00', 4, 5, 1, 4),
(7, 'Projet Transpromo', 'Réaliser un projet entre 1A et 2A', '', '', '', '2015-10-15', '2015-11-01', '2016-05-05', '0000-00-00', 8, 9, 1, 3),
(8, 'Taxonomie', 'Réaliser une taxonomie d''un site de culture', '', '', '', '2016-04-01', '2016-04-15', '2016-04-29', '0000-00-00', 3, 3, 1, 5),
(9, 'Who still reads the news?', '', '', '', '', '2016-03-30', '2016-04-07', '2016-05-16', '0000-00-00', 4, 5, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `realiser`
--

CREATE TABLE `realiser` (
  `_Id_groupe` int(11) NOT NULL,
  `_Id_projet` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `realiser`
--

INSERT INTO `realiser` (`_Id_groupe`, `_Id_projet`) VALUES
(1, 4),
(5, 1),
(7, 2),
(8, 2),
(9, 3),
(10, 6),
(11, 6),
(12, 7),
(13, 8),
(14, 8),
(15, 9),
(16, 9),
(17, 3),
(18, 3);

-- --------------------------------------------------------

--
-- Structure de la table `soutenir`
--

CREATE TABLE `soutenir` (
  `_Id_tuteur` int(11) NOT NULL,
  `_Id_groupe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `soutenir`
--

INSERT INTO `soutenir` (`_Id_tuteur`, `_Id_groupe`) VALUES
(1, 10);

-- --------------------------------------------------------

--
-- Structure de la table `superviser`
--

CREATE TABLE `superviser` (
  `_Id_enseignant` int(11) NOT NULL,
  `_Id_groupe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `tuteur`
--

CREATE TABLE `tuteur` (
  `Id_tuteur` int(11) NOT NULL,
  `Lieu_travail` text NOT NULL,
  `_Id_utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `tuteur`
--

INSERT INTO `tuteur` (`Id_tuteur`, `Lieu_travail`, `_Id_utilisateur`) VALUES
(1, 'ENSC', 70),
(2, 'Cabinet d''hypnothérapeutes', 88);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `Id_utilisateur` int(11) NOT NULL,
  `Nom` text NOT NULL,
  `Prenom` text NOT NULL,
  `Ddn` date NOT NULL,
  `Mail` text NOT NULL,
  `Mdp` text NOT NULL,
  `Tel` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`Id_utilisateur`, `Nom`, `Prenom`, `Ddn`, `Mail`, `Mdp`, `Tel`) VALUES
(1, 'BIDON', 'Monsieur', '1900-01-01', 'mbidon@ensc.fr', '0000', '0'),
(2, 'AUBIN', 'Arthur', '1995-01-01', 'aaubin@ensc.fr', '1741757', '655354150'),
(3, 'BAHMANI', 'Camille', '1995-01-02', 'cbahmani@ensc.fr', '9328626', '632115334'),
(4, 'BARBAT', 'Hadrien', '1995-01-03', 'hbarbat@ensc.fr', '8247134', '664320627'),
(5, 'BASSET', 'Jean', '1995-01-04', 'jbasset@ensc.fr', '3246736', '697089805'),
(6, 'BEGOUT', 'Pierre', '1995-01-05', 'pbegout@ensc.fr', '6638866', '602034153'),
(7, 'BERNARD', 'Emeline', '1995-01-06', 'ebernard@ensc.fr', '3592182', '659684679'),
(8, 'BEZEMAN', 'Bryan', '1995-01-07', 'bbezem800e@ensc.fr', '1514053', '634736896'),
(9, 'BIENASSIS', 'Corentin', '1995-01-08', 'corbienassis@ensc.fr', '7385394', '661014614'),
(10, 'BONNET-SAVE', 'Manon', '1995-01-09', 'mbonnets@ensc.fr', '0867068', '658874185'),
(11, 'BORDEAU', 'Camille', '1995-01-10', 'cbordeau@ensc.fr', '9122923', '659818719'),
(12, 'BOUMLID', 'Anissa', '1995-01-11', 'aboumlid@ensc.fr', '8213486', '622686062'),
(13, 'BRUNISHOLZ', 'Aubin', '1995-01-12', 'abrunisholz@ensc.fr', '7266356', '651990681'),
(14, 'CAILLEAU', 'Florian', '1995-01-13', 'fcailleau@ensc.fr', '8363980', '648122386'),
(15, 'CAROFF', 'Emeline', '1995-01-14', 'ecaroff@ensc.fr', '7889999', '698898298'),
(16, 'CASADO', 'Thomas', '1995-01-15', 'tcasado@ensc.fr', '8039947', '682325372'),
(17, 'CATELLA', 'Solene', '1995-01-16', 'scatella@ensc.fr', '6177653', '663040515'),
(18, 'CHALARD', 'Patrick', '1995-01-17', 'pchalard@ensc.fr', '1717564', '691229233'),
(19, 'CHAPRON', 'Axelle', '1995-01-18', 'achapron@ensc.fr', '9110074', '693525246'),
(20, 'CHATELLET', 'Raphael', '1995-01-19', 'rchatellet@ensc.fr', '2383452', '659713155'),
(21, 'DA SILVA', 'Maxime', '1995-01-20', 'mda silva@ensc.fr', '7923897', '610286582'),
(22, 'DAUVILLAIRE', 'Leo', '1995-01-21', 'ldauvillaire@ensc.fr', '1411612', '631348872'),
(23, 'DUBRESSON', 'Antoine', '1995-01-22', 'adubresson@ensc.fr', '2626594', '666383003'),
(24, 'DUMONT', 'Julie', '1995-01-23', 'jdumont@ensc.fr', '3130595', '630309802'),
(25, 'GAUBERT', 'Mickael', '1995-01-24', 'mgaubert@ensc.fr', '9409724', '670513421'),
(26, 'GUIDICELLI', 'Scheryna', '1995-01-25', 'sguidicelli@ensc.fr', '7842848', '660519570'),
(27, 'GUIRAUTE', 'Marie', '1995-01-26', 'mguiraute@ensc.fr', '9555024', '606598722'),
(28, 'HARDOUMI', 'Zaid', '1995-01-27', 'zhardoumi@ensc.fr', '5765026', '674973436'),
(29, 'KARKA JOULIN', 'Aratim maxime', '1995-01-28', 'akarka joulin@ensc.fr', '7369798', '613287155'),
(30, 'LAURENT', 'Thibaud', '1995-01-29', 'tlaurent@ensc.fr', '0658921', '671105913'),
(31, 'LAURENT', 'Paul', '1995-01-30', 'plaurent@ensc.fr', '3729886', '619504090'),
(32, 'LE MAIRE DE MIL', 'Arthur', '1995-01-31', 'alemairedem@ensc.fr', '9905684', '613020184'),
(33, 'LE MORVAN', 'Fanny', '1995-02-01', 'flemorvan@ensc.fr', '9340575', '674782910'),
(34, 'LEMAIRE', 'Pierre', '1995-02-02', 'plemaire@ensc.fr', '0764627', '625769420'),
(35, 'LEPAGNOT', 'Marc', '1995-02-03', 'mlepagnot@ensc.fr', '7590140', '660747561'),
(36, 'LEVI ALVARES', 'Josias', '1995-02-04', 'jlevialvares@ensc.fr', '6846052', '688022338'),
(37, 'LILLE', 'Laura', '1995-02-05', 'llille@ensc.fr', '9914736', '630533952'),
(38, 'LIM', 'Melanie', '1995-02-06', 'mlim@ensc.fr', '4888420', '642462705'),
(39, 'MATHLOUTHI', 'Marwa', '1995-02-07', 'mmathlouthi@ensc.fr', '5650270', '634982857'),
(40, 'MECHAIN', 'Marie-Eugenie', '1995-02-08', 'mmechain@ensc.fr', '9110430', '691104301'),
(41, 'MERCIOL', 'Margaux', '1995-02-09', 'mmerciol@ensc.fr', '0330119', '671542491'),
(42, 'MORTIER', 'Floriane', '1995-02-10', 'fmortier@ensc.fr', '9886181', '654544767'),
(43, 'MOUNAIX', 'Marion', '1995-02-11', 'mmounaix@ensc.fr', '9577438', '603244134'),
(44, 'NETTER', 'Emile', '1995-02-12', 'enetter@ensc.fr', '6924253', '621529991'),
(45, 'NEYRON', 'Noemie', '1995-02-13', 'nneyron@ensc.fr', '3800984', '642234703'),
(46, 'NIEL', 'Flora', '1995-02-14', 'fniel@ensc.fr', '8038630', '668650045'),
(47, 'NOUMRI', 'Eric', '1995-02-15', 'enoumri@ensc.fr', '3579234', '646798272'),
(48, 'PARISSIS', 'Ariane', '1995-02-16', 'aparissis@ensc.fr', '3937083', '665130100'),
(49, 'PELLETIER', 'Juliette', '1995-02-17', 'jpelletier@ensc.fr', '7824648', '684402808'),
(50, 'RENAULT', 'Loic', '1995-02-18', 'lrenault@ensc.fr', '6535403', '685779841'),
(51, 'ROC', 'Aline', '1995-02-19', 'aroc@ensc.fr', '0383512', '681443373'),
(52, 'ROGER', 'Emilie', '1995-02-20', 'eroger@ensc.fr', '7177108', '609728140'),
(53, 'ROSALIE', 'Rodolphe', '1995-02-21', 'rrosalie@ensc.fr', '6590755', '652238654'),
(54, 'SAIOUD', 'Sarah', '1995-02-22', 'ssaioud@ensc.fr', '4476871', '649032869'),
(55, 'SALVAN', 'Laura', '1995-02-23', 'lsalvan@ensc.fr', '5634118', '662043584'),
(56, 'SAVREUX', 'Aline', '1995-02-24', 'asavreux@ensc.fr', '6519806', '643491774'),
(57, 'SCHONWALD', 'Alexy', '1995-02-25', 'aschonwald@ensc.fr', '9017533', '623839965'),
(58, 'SCHUMACHER', 'Damien', '1995-02-26', 'dschumacher@ensc.fr', '6843304', '682605493'),
(59, 'SENAUX', 'Alexandre', '1995-02-27', 'asenaux@ensc.fr', '3691231', '624959936'),
(60, 'SERRET', 'Martin', '1995-02-28', 'mserret@ensc.fr', '4785533', '625926481'),
(61, 'TANGUY', 'Jean-Baptiste', '1995-03-01', 'jean-btanguy@ensc.fr', '4245429', '617417574'),
(62, 'TARTARE', 'Camille', '1995-03-02', 'ctartare@ensc.fr', '2934247', '672449422'),
(63, 'TARTAS', 'Alexia', '1995-03-03', 'atartas@ensc.fr', '9443472', '697608793'),
(64, 'TREINSOUTROT', 'Margot', '1995-03-04', 'mtreinsoutrot@ensc.fr', '2822249', '623492477'),
(65, 'WIRTZ', 'Cyril', '1995-03-05', 'cwirtz@ensc.fr', '7282597', '656621293'),
(66, 'WITT', 'Jean', '1995-03-06', 'jwitt@ensc.fr', '8051996', '660966058'),
(67, 'CARMONA', 'Tracy', '1980-01-01', 'tcarmona@ensc.fr', '3621758', '651239008'),
(68, 'SOLOMAS', 'Sophie', '1980-01-02', 'ssolomas@ensc.fr', '5091780', '607452696'),
(69, 'KIJEWSKI', 'Elisabeth', '1980-01-03', 'ekijewski@ensc.fr', '0151183', '623701562'),
(70, 'SEMAL', 'Catherine', '1980-01-04', 'csemal@ensc.fr', '5575831', '682220890'),
(71, 'LE BLANC', 'Benoit', '1980-01-05', 'bleblanc@ensc.fr', '7367960', '681177807'),
(72, 'KIJEWSKI', 'Patrick', '1980-01-06', 'pkijewski@ensc.fr', '9231349', '674721983'),
(73, 'LESPINET-NAJIB', 'Veronique', '1980-01-07', 'vlespinet@ensc.fr', '8553208', '691647737'),
(74, 'LU CONG SANG', 'Raymond', '1980-01-08', 'rlucongsang@ensc.fr', '7506215', '642086329'),
(75, 'ANDRE', 'Jean-Marc', '1980-01-09', 'jmandre@ensc.fr', '3324005', '673148810'),
(76, 'FAVIER', 'Pierre-Alexandre', '1980-01-10', 'pafavier@ensc.fr', '5553982', '623587412'),
(77, 'CLERMONT', 'Edwige', '1980-01-11', 'eclermont@ensc.fr', '4090141', '641513256'),
(78, 'SARACCO', 'Jerome', '1980-01-12', 'jsaracco@ensc.fr', '0885982', '691953757'),
(79, 'ROCHE', 'Amelie', '1980-01-13', 'aroche@ensc.fr', '7691468', '632004349'),
(80, 'PINEDE', 'Nathalie', '1980-01-14', 'npinede@ensc.fr', '6761179', '682444940'),
(81, 'GIOVANNELLI', 'Jean-Francois', '1980-01-15', 'jfgiovannelli@ensc.fr', '6867024', '690379785'),
(82, 'JAUZE', 'Christophe', '1980-01-16', 'cjauze@ensc.fr', '5092236', '664945033'),
(83, 'BARRET', 'Alexandre', '1994-01-01', 'abarret@ensc.fr', '6741279', '675148999'),
(84, 'MARTEL', 'Noemie', '1994-01-02', 'nmartel@ensc.fr', '0070135', '632210379'),
(85, 'SANQUER', 'Clement', '1993-01-01', 'csanquer@ensc.fr', '2166263', '667649082'),
(86, 'VULLIARD', 'Pierre-Henri', '0000-00-00', 'phenri@labri.fr', '4578691', ''),
(87, 'ARIES', 'Serge', '0000-00-00', 'saries@ensc.fr', '4781679', ''),
(88, 'EVEROY', 'Eustache', '0000-00-00', 'everoy@hotmail.fr', '4518729', '');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `administrer`
--
ALTER TABLE `administrer`
  ADD PRIMARY KEY (`_Id_enseignant`,`_Id_module`),
  ADD KEY `Id_enseignant#` (`_Id_enseignant`),
  ADD KEY `Id_module#` (`_Id_module`);

--
-- Index pour la table `appartenir`
--
ALTER TABLE `appartenir`
  ADD PRIMARY KEY (`_Id_eleve`,`_Id_groupe`),
  ADD KEY `Id_eleve#` (`_Id_eleve`),
  ADD KEY `Id_groupe#` (`_Id_groupe`),
  ADD KEY `Id_eleve#_2` (`_Id_eleve`),
  ADD KEY `Id_groupe#_2` (`_Id_groupe`);

--
-- Index pour la table `candidater`
--
ALTER TABLE `candidater`
  ADD PRIMARY KEY (`_Id_eleve`,`_Id_groupe`),
  ADD KEY `Id_eleve#` (`_Id_eleve`),
  ADD KEY `Id_groupe#` (`_Id_groupe`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`Id_client`),
  ADD KEY `Id_utilisateur#` (`_Id_utilisateur`),
  ADD KEY `Id_utilisateur#_2` (`_Id_utilisateur`),
  ADD KEY `Id_utilisateur#_3` (`_Id_utilisateur`);

--
-- Index pour la table `commander`
--
ALTER TABLE `commander`
  ADD PRIMARY KEY (`_Id_client`,`_Id_groupe`),
  ADD KEY `Id_client#` (`_Id_client`),
  ADD KEY `Id_projet#` (`_Id_groupe`);

--
-- Index pour la table `eleve`
--
ALTER TABLE `eleve`
  ADD PRIMARY KEY (`Id_eleve`),
  ADD KEY `Id_utilisateur#` (`_Id_utilisateur`);

--
-- Index pour la table `enseignant`
--
ALTER TABLE `enseignant`
  ADD PRIMARY KEY (`Id_enseignant`),
  ADD KEY `Id_utilisateur#` (`_Id_utilisateur`);

--
-- Index pour la table `etre_client`
--
ALTER TABLE `etre_client`
  ADD PRIMARY KEY (`_Id_enseignant`,`_Id_client`),
  ADD KEY `Id_enseignant#` (`_Id_enseignant`),
  ADD KEY `Id_client#` (`_Id_client`);

--
-- Index pour la table `etre_tuteur`
--
ALTER TABLE `etre_tuteur`
  ADD PRIMARY KEY (`_Id_enseignant`,`_Id_tuteur`),
  ADD KEY `Id_tuteur#` (`_Id_tuteur`);

--
-- Index pour la table `gerer`
--
ALTER TABLE `gerer`
  ADD PRIMARY KEY (`_Id_eleve`,`_Id_groupe`),
  ADD KEY `Id_eleve#` (`_Id_eleve`),
  ADD KEY `Id_groupe#` (`_Id_groupe`);

--
-- Index pour la table `gestionnaire`
--
ALTER TABLE `gestionnaire`
  ADD PRIMARY KEY (`Id_gestionnaire`),
  ADD KEY `Id_utilisateur` (`_Id_utilisateur`),
  ADD KEY `Id_utilisateur#` (`_Id_utilisateur`);

--
-- Index pour la table `groupe`
--
ALTER TABLE `groupe`
  ADD PRIMARY KEY (`Id_groupe`);

--
-- Index pour la table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`Id_module`);

--
-- Index pour la table `projet`
--
ALTER TABLE `projet`
  ADD PRIMARY KEY (`Id_projet`),
  ADD KEY `Id_module#` (`_Id_module`);

--
-- Index pour la table `realiser`
--
ALTER TABLE `realiser`
  ADD PRIMARY KEY (`_Id_groupe`,`_Id_projet`),
  ADD KEY `Id_groupe#` (`_Id_groupe`),
  ADD KEY `Id_projet#` (`_Id_projet`);

--
-- Index pour la table `soutenir`
--
ALTER TABLE `soutenir`
  ADD PRIMARY KEY (`_Id_tuteur`,`_Id_groupe`),
  ADD KEY `Id_tuteur#` (`_Id_tuteur`),
  ADD KEY `Id_projet#` (`_Id_groupe`);

--
-- Index pour la table `superviser`
--
ALTER TABLE `superviser`
  ADD PRIMARY KEY (`_Id_enseignant`,`_Id_groupe`),
  ADD KEY `Id_enseignant#` (`_Id_enseignant`),
  ADD KEY `Id_groupe#` (`_Id_groupe`);

--
-- Index pour la table `tuteur`
--
ALTER TABLE `tuteur`
  ADD PRIMARY KEY (`Id_tuteur`),
  ADD KEY `Id_utilisateur` (`_Id_utilisateur`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`Id_utilisateur`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `Id_client` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `eleve`
--
ALTER TABLE `eleve`
  MODIFY `Id_eleve` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
--
-- AUTO_INCREMENT pour la table `enseignant`
--
ALTER TABLE `enseignant`
  MODIFY `Id_enseignant` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;
--
-- AUTO_INCREMENT pour la table `gestionnaire`
--
ALTER TABLE `gestionnaire`
  MODIFY `Id_gestionnaire` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `groupe`
--
ALTER TABLE `groupe`
  MODIFY `Id_groupe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT pour la table `module`
--
ALTER TABLE `module`
  MODIFY `Id_module` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT pour la table `projet`
--
ALTER TABLE `projet`
  MODIFY `Id_projet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `tuteur`
--
ALTER TABLE `tuteur`
  MODIFY `Id_tuteur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `Id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `administrer`
--
ALTER TABLE `administrer`
  ADD CONSTRAINT `administrer_ibfk_1` FOREIGN KEY (`_Id_enseignant`) REFERENCES `enseignant` (`Id_enseignant`),
  ADD CONSTRAINT `administrer_ibfk_2` FOREIGN KEY (`_Id_module`) REFERENCES `module` (`Id_module`);

--
-- Contraintes pour la table `appartenir`
--
ALTER TABLE `appartenir`
  ADD CONSTRAINT `appartenir_ibfk_1` FOREIGN KEY (`_Id_eleve`) REFERENCES `eleve` (`Id_eleve`),
  ADD CONSTRAINT `appartenir_ibfk_2` FOREIGN KEY (`_Id_groupe`) REFERENCES `groupe` (`Id_groupe`);

--
-- Contraintes pour la table `candidater`
--
ALTER TABLE `candidater`
  ADD CONSTRAINT `candidater_ibfk_1` FOREIGN KEY (`_Id_eleve`) REFERENCES `eleve` (`Id_eleve`),
  ADD CONSTRAINT `candidater_ibfk_2` FOREIGN KEY (`_Id_groupe`) REFERENCES `groupe` (`Id_groupe`);

--
-- Contraintes pour la table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `client_ibfk_1` FOREIGN KEY (`_Id_utilisateur`) REFERENCES `utilisateur` (`Id_utilisateur`);

--
-- Contraintes pour la table `commander`
--
ALTER TABLE `commander`
  ADD CONSTRAINT `commander_ibfk_1` FOREIGN KEY (`_Id_client`) REFERENCES `client` (`Id_client`),
  ADD CONSTRAINT `commander_ibfk_2` FOREIGN KEY (`_Id_groupe`) REFERENCES `groupe` (`Id_groupe`);

--
-- Contraintes pour la table `eleve`
--
ALTER TABLE `eleve`
  ADD CONSTRAINT `eleve_ibfk_1` FOREIGN KEY (`_Id_utilisateur`) REFERENCES `utilisateur` (`Id_utilisateur`);

--
-- Contraintes pour la table `enseignant`
--
ALTER TABLE `enseignant`
  ADD CONSTRAINT `enseignant_ibfk_1` FOREIGN KEY (`_Id_utilisateur`) REFERENCES `utilisateur` (`Id_utilisateur`);

--
-- Contraintes pour la table `etre_client`
--
ALTER TABLE `etre_client`
  ADD CONSTRAINT `etre_client_ibfk_1` FOREIGN KEY (`_Id_client`) REFERENCES `client` (`Id_client`),
  ADD CONSTRAINT `etre_client_ibfk_2` FOREIGN KEY (`_Id_enseignant`) REFERENCES `enseignant` (`Id_enseignant`);

--
-- Contraintes pour la table `etre_tuteur`
--
ALTER TABLE `etre_tuteur`
  ADD CONSTRAINT `etre_tuteur_ibfk_1` FOREIGN KEY (`_Id_tuteur`) REFERENCES `tuteur` (`Id_tuteur`),
  ADD CONSTRAINT `etre_tuteur_ibfk_2` FOREIGN KEY (`_Id_enseignant`) REFERENCES `enseignant` (`Id_enseignant`);

--
-- Contraintes pour la table `gerer`
--
ALTER TABLE `gerer`
  ADD CONSTRAINT `gerer_ibfk_1` FOREIGN KEY (`_Id_eleve`) REFERENCES `eleve` (`Id_eleve`),
  ADD CONSTRAINT `gerer_ibfk_2` FOREIGN KEY (`_Id_groupe`) REFERENCES `groupe` (`Id_groupe`);

--
-- Contraintes pour la table `gestionnaire`
--
ALTER TABLE `gestionnaire`
  ADD CONSTRAINT `gestionnaire_ibfk_1` FOREIGN KEY (`_Id_utilisateur`) REFERENCES `utilisateur` (`Id_utilisateur`);

--
-- Contraintes pour la table `projet`
--
ALTER TABLE `projet`
  ADD CONSTRAINT `projet_ibfk_1` FOREIGN KEY (`_Id_module`) REFERENCES `module` (`Id_module`);

--
-- Contraintes pour la table `realiser`
--
ALTER TABLE `realiser`
  ADD CONSTRAINT `realiser_ibfk_1` FOREIGN KEY (`_Id_groupe`) REFERENCES `groupe` (`Id_groupe`),
  ADD CONSTRAINT `realiser_ibfk_2` FOREIGN KEY (`_Id_projet`) REFERENCES `projet` (`Id_projet`);

--
-- Contraintes pour la table `soutenir`
--
ALTER TABLE `soutenir`
  ADD CONSTRAINT `soutenir_ibfk_1` FOREIGN KEY (`_Id_tuteur`) REFERENCES `tuteur` (`Id_tuteur`),
  ADD CONSTRAINT `soutenir_ibfk_2` FOREIGN KEY (`_Id_groupe`) REFERENCES `groupe` (`Id_groupe`);

--
-- Contraintes pour la table `superviser`
--
ALTER TABLE `superviser`
  ADD CONSTRAINT `superviser_ibfk_1` FOREIGN KEY (`_Id_enseignant`) REFERENCES `enseignant` (`Id_enseignant`),
  ADD CONSTRAINT `superviser_ibfk_2` FOREIGN KEY (`_Id_groupe`) REFERENCES `groupe` (`Id_groupe`);

--
-- Contraintes pour la table `tuteur`
--
ALTER TABLE `tuteur`
  ADD CONSTRAINT `tuteur_ibfk_1` FOREIGN KEY (`_Id_utilisateur`) REFERENCES `utilisateur` (`Id_utilisateur`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
