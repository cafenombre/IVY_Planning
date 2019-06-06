-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  jeu. 06 juin 2019 à 20:32
-- Version du serveur :  10.1.37-MariaDB
-- Version de PHP :  7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `room_planner`
--

-- --------------------------------------------------------

--
-- Structure de la table `blocking`
--

CREATE TABLE `blocking` (
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `id_room` int(11) NOT NULL,
  `bed` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `blocking`
--

INSERT INTO `blocking` (`start_date`, `end_date`, `id_room`, `bed`) VALUES
('2018-11-08', '2018-11-12', 9, 5),
('2018-11-08', '2018-11-14', 7, 6),
('2018-11-10', '2018-11-15', 7, 7),
('2018-11-11', '2018-11-12', 9, 2),
('2018-11-12', '2018-11-15', 9, 1),
('2018-11-13', '2018-11-15', 6, 2),
('2018-11-14', '2018-11-15', 7, 1),
('2018-11-14', '2018-11-17', 7, 3),
('2018-11-18', '2018-11-19', 9, 4),
('2018-11-19', '2018-11-20', 9, 8);

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `type` int(11) NOT NULL,
  `is_split` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id`, `name`, `start_date`, `end_date`, `type`, `is_split`) VALUES
(1, 'Alexis', '2019-02-13', '2019-02-19', 0, 0),
(2, 'Paul', '2019-02-13', '2019-02-16', 2, 0),
(3, 'Gaetan', '2019-02-17', '2019-02-23', 3, 0),
(4, 'Patrick', '2019-02-21', '2019-02-26', 1, 0),
(5, 'Gael', '2019-02-20', '2019-02-25', 3, 0),
(6, 'Lea', '2019-02-05', '2019-02-08', 1, 0),
(7, 'Pierrick', '2019-02-21', '2019-02-26', 4, 0),
(8, 'Hava', '2019-02-11', '2019-02-14', 2, 0),
(9, 'Hava', '2019-02-07', '2019-02-09', 1, 0),
(10, 'Josepah', '2019-02-11', '2019-02-16', 4, 0),
(11, 'Patrick', '2019-02-23', '2019-02-28', 4, 0),
(12, 'Pierrick', '2019-02-11', '2019-02-12', 0, 0),
(13, 'Paul', '2019-02-20', '2019-02-24', 4, 0),
(14, 'Audrey', '2019-02-15', '2019-02-17', 2, 0),
(15, 'Gael', '2019-02-05', '2019-02-06', 1, 0),
(16, 'Pierre', '2019-02-14', '2019-02-15', 4, 0),
(17, 'Emmanuel', '2019-02-23', '2019-02-24', 3, 0),
(18, 'Joseph', '2019-02-23', '2019-02-26', 1, 0),
(19, 'Pierre', '2019-02-15', '2019-02-16', 3, 0),
(20, 'Armel', '2019-02-11', '2019-02-13', 4, 0),
(21, 'Jeanne', '2019-02-22', '2019-02-23', 1, 0),
(22, 'Jo-han', '2019-02-19', '2019-02-23', 4, 0),
(23, 'Emmanuel', '2019-02-06', '2019-02-11', 4, 0),
(24, 'Audrey', '2019-02-25', '2019-03-02', 3, 0),
(25, 'Henry', '2019-02-12', '2019-02-16', 1, 0),
(26, 'Sylvie', '2019-02-14', '2019-02-17', 1, 0),
(27, 'Pierre', '2019-02-15', '2019-02-18', 0, 0),
(28, 'Lea', '2019-02-21', '2019-02-24', 0, 0),
(29, 'Jeanne', '2019-02-23', '2019-02-27', 1, 0),
(30, 'Stephanie', '2019-02-16', '2019-02-20', 4, 0),
(31, 'Jo-han', '2019-02-15', '2019-02-19', 0, 0),
(32, 'Hava', '2019-02-20', '2019-02-21', 1, 0),
(33, 'Gleuep', '2019-02-14', '2019-02-16', 2, 0),
(34, 'Jo-han', '2019-02-10', '2019-02-11', 4, 0),
(35, 'Audrey', '2019-02-14', '2019-02-19', 3, 0),
(36, 'Emmanuel', '2019-02-21', '2019-02-26', 3, 0),
(37, 'Pierrick', '2019-02-23', '2019-02-24', 2, 0),
(38, 'Patrick', '2019-02-12', '2019-02-17', 1, 0),
(39, 'Joseph', '2019-02-06', '2019-02-07', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `reservation_types`
--

CREATE TABLE `reservation_types` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `res_room`
--

CREATE TABLE `res_room` (
  `id_room` int(11) NOT NULL,
  `id_res` int(11) NOT NULL,
  `bed` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `room`
--

CREATE TABLE `room` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `type` int(11) NOT NULL,
  `nb_simple_beds` int(11) NOT NULL,
  `nb_double_beds` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `room`
--

INSERT INTO `room` (`id`, `name`, `type`, `nb_simple_beds`, `nb_double_beds`) VALUES
(5, 'Dortoir Homme 1', 7, 8, 0),
(6, 'Dortoir Femme 1', 7, 10, 0),
(7, 'Dortoir Femme 2', 7, 6, 0),
(8, 'Chambre 212', 8, 2, 1),
(9, 'Chambre 213', 8, 4, 0),
(10, 'Chambre 214', 8, 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `room_types`
--

CREATE TABLE `room_types` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `room_types`
--

INSERT INTO `room_types` (`id`, `name`) VALUES
(7, 'Dortoir'),
(8, 'Chambre'),
(9, 'Caravane'),
(10, 'Logement bÃ©nÃ©vole');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `blocking`
--
ALTER TABLE `blocking`
  ADD PRIMARY KEY (`start_date`,`end_date`,`id_room`,`bed`);

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reservation_types`
--
ALTER TABLE `reservation_types`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `res_room`
--
ALTER TABLE `res_room`
  ADD PRIMARY KEY (`id_res`,`start_date`,`end_date`);

--
-- Index pour la table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `room_types`
--
ALTER TABLE `room_types`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `reservation_types`
--
ALTER TABLE `reservation_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `room`
--
ALTER TABLE `room`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `room_types`
--
ALTER TABLE `room_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
