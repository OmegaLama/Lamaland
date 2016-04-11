-- phpMyAdmin SQL Dump
-- version 4.6.0
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mar 29 Mars 2016 à 14:33
-- Version du serveur :  5.5.47-0ubuntu0.14.04.1
-- Version de PHP :  5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `db_youbetterpay`
--

-- --------------------------------------------------------

--
-- Structure de la table `depenses`
--

DROP TABLE IF EXISTS `depenses`;
CREATE TABLE `depenses` (
  `id` int(11) NOT NULL,
  `nom` tinytext COLLATE utf8_bin NOT NULL,
  `prix` decimal(11,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `depenses`
--

INSERT INTO `depenses` (`id`, `nom`, `prix`) VALUES
(1, 'Etagere', 30);

-- --------------------------------------------------------

--
-- Structure de la table `groupe`
--

DROP TABLE IF EXISTS `groupe`;
CREATE TABLE `groupe` (
  `id` int(11) NOT NULL,
  `nom` tinytext COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `groupe`
--

INSERT INTO `groupe` (`id`, `nom`) VALUES
(1, 'Coloc');

-- --------------------------------------------------------

--
-- Structure de la table `participant`
--

DROP TABLE IF EXISTS `participant`;
CREATE TABLE `participant` (
  `id` int(11) NOT NULL,
  `prenom` tinytext COLLATE utf8_bin NOT NULL,
  `nom` tinytext COLLATE utf8_bin NOT NULL,
  `pseudo` tinytext COLLATE utf8_bin,
  `groupe` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `participant`
--

INSERT INTO `participant` (`id`, `prenom`, `nom`, `pseudo`, `groupe`) VALUES
(1, 'Anne-Lise', 'Verger', 'Anneuh', NULL),
(2, 'Benjamin', 'Granger', 'Bennou', NULL),
(3, 'Bryan', 'Clero', NULL, 1),
(4, 'Mathieu', 'Justeau', 'Lama', NULL),
(5, 'Vianney', 'Dermy', 'Viannou', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `relation_depense_participant`
--

DROP TABLE IF EXISTS `relation_depense_participant`;
CREATE TABLE `relation_depense_participant` (
  `id` int(11) NOT NULL,
  `id_depense` int(11) NOT NULL,
  `id_participant` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `relation_depense_participant`
--

INSERT INTO `relation_depense_participant` (`id`, `id_depense`, `id_participant`) VALUES
(2, 1, 1),
(3, 1, 2);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `depenses`
--
ALTER TABLE `depenses`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `groupe`
--
ALTER TABLE `groupe`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `participant`
--
ALTER TABLE `participant`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `relation_depense_participant`
--
ALTER TABLE `relation_depense_participant`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `depenses`
--
ALTER TABLE `depenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `groupe`
--
ALTER TABLE `groupe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `participant`
--
ALTER TABLE `participant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `relation_depense_participant`
--
ALTER TABLE `relation_depense_participant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
