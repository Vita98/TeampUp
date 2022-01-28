-- phpMyAdmin SQL Dump
-- version 4.1.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Giu 17, 2020 alle 21:31
-- Versione del server: 5.6.33-log
-- PHP Version: 5.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `my_teamup2020`
--
CREATE DATABASE IF NOT EXISTS `my_teamup2020` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `my_teamup2020`;

-- --------------------------------------------------------

--
-- Struttura della tabella `ability`
--

DROP TABLE IF EXISTS `ability`;
CREATE TABLE IF NOT EXISTS `ability` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dump dei dati per la tabella `ability`
--

INSERT INTO `ability` (`id`, `description`) VALUES
(5, 'Programmatore'),
(6, 'Idraulico'),
(7, 'Elettricista'),
(8, 'Fotografo');

-- --------------------------------------------------------

--
-- Struttura della tabella `feedback`
--

DROP TABLE IF EXISTS `feedback`;
CREATE TABLE IF NOT EXISTS `feedback` (
  `users_id` int(11) NOT NULL,
  `idea_id` int(11) NOT NULL,
  `innovativityVote` float NOT NULL,
  `creativityVote` float NOT NULL,
  PRIMARY KEY (`users_id`,`idea_id`),
  KEY `fk_users_has_idea_idea1_idx` (`idea_id`),
  KEY `fk_users_has_idea_users1_idx` (`users_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `feedback`
--

INSERT INTO `feedback` (`users_id`, `idea_id`, `innovativityVote`, `creativityVote`) VALUES
(8, 9, 5, 5),
(10, 9, 0.5, 0.5),
(10, 10, 5, 4),
(11, 10, 5, 5),
(11, 11, 5, 5);

-- --------------------------------------------------------

--
-- Struttura della tabella `idea`
--

DROP TABLE IF EXISTS `idea`;
CREATE TABLE IF NOT EXISTS `idea` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `ownerId` int(11) NOT NULL,
  `description` text NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sponsorEndDate` date DEFAULT NULL,
  `sponsorCategoryid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_idea_users_idx` (`ownerId`),
  KEY `fk_idea_sponsorCategoryModel1_idx` (`sponsorCategoryid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dump dei dati per la tabella `idea`
--

INSERT INTO `idea` (`id`, `title`, `ownerId`, `description`, `creationDate`, `sponsorEndDate`, `sponsorCategoryid`) VALUES
(9, 'Sviluppo hardware di un computer quantistico', 8, 'Salve, cerchiamo di assemblare un computer quantistico! \r\nSe sei interessato a darci una mano non esitare ad unirti a questa idea!', '2020-06-15 09:12:03', '2020-06-25', 3),
(10, 'Lorem Ipsum dolor amet', 10, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2020-06-15 20:29:26', '2020-06-26', 1),
(11, 'IdeaVR', 11, 'Questa Ã¨ l&#39;Idea VR', '2020-06-17 07:31:51', '2020-06-30', 3),
(13, 'Wow! Idea del secolo!', 10, 'Questa Ã¨ la descrizione dell&#39;idea del Secolo!', '2020-06-17 18:42:53', NULL, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `ideaCategory`
--

DROP TABLE IF EXISTS `ideaCategory`;
CREATE TABLE IF NOT EXISTS `ideaCategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dump dei dati per la tabella `ideaCategory`
--

INSERT INTO `ideaCategory` (`id`, `description`) VALUES
(6, 'Sviluppo Software'),
(7, 'Progettazione Hardware'),
(8, 'Fotografia'),
(9, 'Editing Video');

-- --------------------------------------------------------

--
-- Struttura della tabella `ideaCategoryAssociation`
--

DROP TABLE IF EXISTS `ideaCategoryAssociation`;
CREATE TABLE IF NOT EXISTS `ideaCategoryAssociation` (
  `idea_id` int(11) NOT NULL,
  `ideaCategoryModel_id` int(11) NOT NULL,
  PRIMARY KEY (`idea_id`,`ideaCategoryModel_id`),
  KEY `fk_idea_has_ideaCategoryModel_ideaCategoryModel1_idx` (`ideaCategoryModel_id`),
  KEY `fk_idea_has_ideaCategoryModel_idea1_idx` (`idea_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `ideaCategoryAssociation`
--

INSERT INTO `ideaCategoryAssociation` (`idea_id`, `ideaCategoryModel_id`) VALUES
(11, 6),
(9, 7),
(10, 7),
(13, 9);

-- --------------------------------------------------------

--
-- Struttura della tabella `member`
--

DROP TABLE IF EXISTS `member`;
CREATE TABLE IF NOT EXISTS `member` (
  `partecipationRequestId` int(11) NOT NULL,
  `teamId` int(11) NOT NULL,
  PRIMARY KEY (`partecipationRequestId`,`teamId`),
  KEY `fk_partecipationRequest_has_team_team1_idx` (`teamId`),
  KEY `fk_partecipationRequest_has_team_partecipationRequest1_idx` (`partecipationRequestId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `member`
--

INSERT INTO `member` (`partecipationRequestId`, `teamId`) VALUES
(15, 3),
(21, 5);

-- --------------------------------------------------------

--
-- Struttura della tabella `partecipationRequest`
--

DROP TABLE IF EXISTS `partecipationRequest`;
CREATE TABLE IF NOT EXISTS `partecipationRequest` (
  `partecipationRequestId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `ideaId` int(11) NOT NULL,
  `isPending` tinyint(4) DEFAULT '1',
  `isUserRequesting` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`partecipationRequestId`),
  KEY `fk_users_has_idea_idea2_idx` (`ideaId`),
  KEY `fk_users_has_idea_users2_idx` (`userId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Dump dei dati per la tabella `partecipationRequest`
--

INSERT INTO `partecipationRequest` (`partecipationRequestId`, `userId`, `ideaId`, `isPending`, `isUserRequesting`) VALUES
(15, 9, 9, 0, 0),
(17, 8, 10, 1, 0),
(19, 11, 10, 1, 0),
(20, 10, 11, 1, 0),
(21, 9, 10, 0, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `realizationPhase`
--

DROP TABLE IF EXISTS `realizationPhase`;
CREATE TABLE IF NOT EXISTS `realizationPhase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `ideaId` int(11) NOT NULL,
  `teamId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_realizationPhase_idea1_idx` (`ideaId`),
  KEY `fk_realizationPhase_team1_idx` (`teamId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dump dei dati per la tabella `realizationPhase`
--

INSERT INTO `realizationPhase` (`id`, `name`, `ideaId`, `teamId`) VALUES
(5, 'Fase di test', 10, NULL),
(6, 'Fase1', 11, 6),
(7, 'Fase2', 11, 7),
(8, 'Fase3', 11, 7),
(9, 'Fase4', 11, 8);

-- --------------------------------------------------------

--
-- Struttura della tabella `realizationPhaseAbilities`
--

DROP TABLE IF EXISTS `realizationPhaseAbilities`;
CREATE TABLE IF NOT EXISTS `realizationPhaseAbilities` (
  `ability_id` int(11) NOT NULL,
  `realizationPhase_id` int(11) NOT NULL,
  PRIMARY KEY (`ability_id`,`realizationPhase_id`),
  KEY `fk_ability_has_realizationPhase_realizationPhase1_idx` (`realizationPhase_id`),
  KEY `fk_ability_has_realizationPhase_ability1_idx` (`ability_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `realizationPhaseAbilities`
--

INSERT INTO `realizationPhaseAbilities` (`ability_id`, `realizationPhase_id`) VALUES
(5, 5),
(5, 6),
(6, 7),
(7, 8),
(8, 9);

-- --------------------------------------------------------

--
-- Struttura della tabella `sponsorCategory`
--

DROP TABLE IF EXISTS `sponsorCategory`;
CREATE TABLE IF NOT EXISTS `sponsorCategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dump dei dati per la tabella `sponsorCategory`
--

INSERT INTO `sponsorCategory` (`id`, `description`) VALUES
(1, 'Interna'),
(2, 'Esterna'),
(3, 'Interna/Esterna');

-- --------------------------------------------------------

--
-- Struttura della tabella `team`
--

DROP TABLE IF EXISTS `team`;
CREATE TABLE IF NOT EXISTS `team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `ideaId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_team_idea1_idx` (`ideaId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dump dei dati per la tabella `team`
--

INSERT INTO `team` (`id`, `name`, `ideaId`) VALUES
(3, '400 Bad Request', 9),
(5, 'Team Lorem Ipsum', 10),
(6, 'Team1', 11),
(7, 'Team2', 11),
(8, 'Team3', 11);

-- --------------------------------------------------------

--
-- Struttura della tabella `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(30) NOT NULL,
  `lastName` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `psw` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dump dei dati per la tabella `user`
--

INSERT INTO `user` (`id`, `firstName`, `lastName`, `email`, `psw`) VALUES
(8, 'Luigi', 'Tomassetti', 'luigitomassetti14@gmail.com', '$2y$10$SBi/Bd8FhMuG8MG4hBy1a.VVSgj/c7n0J6YNkbyE1TEK5LoOQWGfu'),
(9, 'VItandrea', 'Sorino', 'vitandrea98@live.it', '$2y$10$2leMlt6fCiHbgyvWtZzBdOk7AdQkamqsfvz8OI94OWsWVK.vWct.q'),
(10, 'Vito', 'Rescina', 'v.rescina@outlook.it', '$2y$10$9JP89/8zERL5aTQLJGdFZ.a23MpmbESKN53TBvRfAUw2zVpOYTz5.'),
(11, 'Vito', 'Romito', 'v@romito.it', '$2y$10$Sacl04oQfoUNJ6yTT0Vjg.YRPDTm.EbtwM1D73f/fsc/U21.pONDW');

-- --------------------------------------------------------

--
-- Struttura della tabella `userAbilities`
--

DROP TABLE IF EXISTS `userAbilities`;
CREATE TABLE IF NOT EXISTS `userAbilities` (
  `userId` int(11) NOT NULL,
  `abilityId` int(11) NOT NULL,
  PRIMARY KEY (`userId`,`abilityId`),
  KEY `fk_user_has_ability_ability1_idx` (`abilityId`),
  KEY `fk_user_has_ability_user1_idx` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `userAbilities`
--

INSERT INTO `userAbilities` (`userId`, `abilityId`) VALUES
(8, 5),
(9, 5),
(10, 6),
(8, 7),
(9, 7),
(11, 7),
(10, 8);

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `fk_users_has_idea_idea1` FOREIGN KEY (`idea_id`) REFERENCES `idea` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_has_idea_users1` FOREIGN KEY (`users_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limiti per la tabella `idea`
--
ALTER TABLE `idea`
  ADD CONSTRAINT `fk_idea_sponsorCategoryModel1` FOREIGN KEY (`sponsorCategoryid`) REFERENCES `sponsorCategory` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_idea_users` FOREIGN KEY (`ownerId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limiti per la tabella `ideaCategoryAssociation`
--
ALTER TABLE `ideaCategoryAssociation`
  ADD CONSTRAINT `fk_idea_has_ideaCategoryModel_idea1` FOREIGN KEY (`idea_id`) REFERENCES `idea` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_idea_has_ideaCategoryModel_ideaCategoryModel1` FOREIGN KEY (`ideaCategoryModel_id`) REFERENCES `ideaCategory` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limiti per la tabella `member`
--
ALTER TABLE `member`
  ADD CONSTRAINT `fk_partecipationRequest_has_team_partecipationRequest1` FOREIGN KEY (`partecipationRequestId`) REFERENCES `partecipationRequest` (`partecipationRequestId`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_partecipationRequest_has_team_team1` FOREIGN KEY (`teamId`) REFERENCES `team` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limiti per la tabella `partecipationRequest`
--
ALTER TABLE `partecipationRequest`
  ADD CONSTRAINT `fk_users_has_idea_idea2` FOREIGN KEY (`ideaId`) REFERENCES `idea` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_has_idea_users2` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limiti per la tabella `realizationPhase`
--
ALTER TABLE `realizationPhase`
  ADD CONSTRAINT `fk_realizationPhase_idea1` FOREIGN KEY (`ideaId`) REFERENCES `idea` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_realizationPhase_team1` FOREIGN KEY (`teamId`) REFERENCES `team` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limiti per la tabella `realizationPhaseAbilities`
--
ALTER TABLE `realizationPhaseAbilities`
  ADD CONSTRAINT `fk_ability_has_realizationPhase_ability1` FOREIGN KEY (`ability_id`) REFERENCES `ability` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ability_has_realizationPhase_realizationPhase1` FOREIGN KEY (`realizationPhase_id`) REFERENCES `realizationPhase` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limiti per la tabella `team`
--
ALTER TABLE `team`
  ADD CONSTRAINT `fk_team_idea1` FOREIGN KEY (`ideaId`) REFERENCES `idea` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limiti per la tabella `userAbilities`
--
ALTER TABLE `userAbilities`
  ADD CONSTRAINT `fk_user_has_ability_ability1` FOREIGN KEY (`abilityId`) REFERENCES `ability` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_has_ability_user1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
