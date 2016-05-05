-- phpMyAdmin SQL Dump
-- version 4.6.0
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Jeu 05 Mai 2016 à 14:39
-- Version du serveur :  5.5.47-MariaDB-1ubuntu0.14.04.1
-- Version de PHP :  7.0.5-2+deb.sury.org~trusty+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `db_test`
--

-- --------------------------------------------------------

--
-- Structure de la table `y_depenses`
--

CREATE TABLE `y_depenses` (
  `depense_id` int(11) UNSIGNED NOT NULL,
  `depense_nom` tinytext COLLATE utf8_bin NOT NULL,
  `depense_description` text COLLATE utf8_bin,
  `depense_prix` int(11) UNSIGNED NOT NULL,
  `depense_payeur_id` int(11) UNSIGNED NOT NULL,
  `depense_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `y_depenses`
--

INSERT INTO `y_depenses` (`depense_id`, `depense_nom`, `depense_description`, `depense_prix`, `depense_payeur_id`, `depense_date`) VALUES
(1, 'Contrat d\'entretiens chaudiere', 'Contrat annuel du contrat d\'entretiens de la chaudiere', 180, 2, '2016-04-25'),
(2, 'Camping', 'Camping Download Festival', 20, 1, '2016-04-21');

-- --------------------------------------------------------

--
-- Structure de la table `y_jointure_depenses_utilisateurs`
--

CREATE TABLE `y_jointure_depenses_utilisateurs` (
  `jdu_id` int(11) UNSIGNED NOT NULL,
  `jdu_id_depense` int(11) UNSIGNED NOT NULL,
  `jdu_id_utilisateur` int(11) UNSIGNED NOT NULL,
  `jdu_part_utilisateur` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `y_jointure_depenses_utilisateurs`
--

INSERT INTO `y_jointure_depenses_utilisateurs` (`jdu_id`, `jdu_id_depense`, `jdu_id_utilisateur`, `jdu_part_utilisateur`) VALUES
(5, 1, 2, 36),
(6, 1, 1, 36),
(7, 2, 2, 20),
(8, 1, 3, 36),
(9, 1, 4, 36),
(10, 1, 5, 36);

-- --------------------------------------------------------

--
-- Structure de la table `y_utilisateurs`
--

CREATE TABLE `y_utilisateurs` (
  `utilisateur_id` int(11) UNSIGNED NOT NULL,
  `utilisateur_prenom` tinytext COLLATE utf8_bin NOT NULL,
  `utilisateur_nom` tinytext COLLATE utf8_bin NOT NULL,
  `utilisateur_pseudo` tinytext COLLATE utf8_bin,
  `utilisateur_mail` tinytext COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `y_utilisateurs`
--

INSERT INTO `y_utilisateurs` (`utilisateur_id`, `utilisateur_prenom`, `utilisateur_nom`, `utilisateur_pseudo`, `utilisateur_mail`) VALUES
(1, 'Mathieu', 'Justeau', 'Lama', 'mathieu.justeau@gmail.com'),
(2, 'Benjamin', 'Granger', 'Bennou', 'granger.ben@gmail.com'),
(3, 'Anne-Lise', 'Verger', 'Anneuh', 'anneuh.bobette@gmail.com'),
(4, 'Bryan', 'Clero', NULL, 'bryan.clero@gmail.com'),
(5, 'Vianney', 'Dermy', 'Viannou', 'vianney1.dermy@gmail.com');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `y_depenses`
--
ALTER TABLE `y_depenses`
  ADD PRIMARY KEY (`depense_id`);

--
-- Index pour la table `y_jointure_depenses_utilisateurs`
--
ALTER TABLE `y_jointure_depenses_utilisateurs`
  ADD PRIMARY KEY (`jdu_id`),
  ADD KEY `y_jointure_depenses_utilisateurs_ibfk_1` (`jdu_id_depense`);

--
-- Index pour la table `y_utilisateurs`
--
ALTER TABLE `y_utilisateurs`
  ADD PRIMARY KEY (`utilisateur_id`),
  ADD UNIQUE KEY `Mail` (`utilisateur_mail`(255));

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `y_depenses`
--
ALTER TABLE `y_depenses`
  MODIFY `depense_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `y_jointure_depenses_utilisateurs`
--
ALTER TABLE `y_jointure_depenses_utilisateurs`
  MODIFY `jdu_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `y_utilisateurs`
--
ALTER TABLE `y_utilisateurs`
  MODIFY `utilisateur_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `y_jointure_depenses_utilisateurs`
--
ALTER TABLE `y_jointure_depenses_utilisateurs`
  ADD CONSTRAINT `y_jointure_depenses_utilisateurs_ibfk_1` FOREIGN KEY (`jdu_id_depense`) REFERENCES `y_depenses` (`depense_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
