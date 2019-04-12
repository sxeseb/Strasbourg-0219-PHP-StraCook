-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  ven. 12 avr. 2019 à 12:22
-- Version du serveur :  5.7.25
-- Version de PHP :  7.1.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `strascook`
--

-- --------------------------------------------------------

--
-- Structure de la table `email`
--

CREATE TABLE `email` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `img_src` varchar(255) DEFAULT NULL,
  `thumb` tinyint(4) DEFAULT NULL,
  `menus_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `images`
--

INSERT INTO `images` (`id`, `img_src`, `thumb`, `menus_id`) VALUES
(20, '/assets/images/menu1entree', 1, 1),
(21, '/assets/images/menu1plat', 1, 1),
(22, '/assets/images/menu1dessert', 1, 1),
(23, '/assets/images/menu2entree', 1, 2),
(24, '/assets/images/menu2plat', 1, 2),
(25, '/assets/images/menu2dessert', 1, 2),
(26, '/assets/images/menu3entree', 1, 3),
(27, '/assets/images/menu3plat', 1, 3),
(28, '/assets/images/menu3dessert', 1, 3);

-- --------------------------------------------------------

--
-- Structure de la table `menus`
--

CREATE TABLE `menus` (
  `id` int(11) NOT NULL,
  `name` text,
  `starter` text,
  `main_course` text,
  `dessert` text,
  `description` text,
  `price_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `menus`
--

INSERT INTO `menus` (`id`, `name`, `starter`, `main_course`, `dessert`, `description`, `price_id`) VALUES
(1, 'viande rouge', 'Salade de roquette au kaki et aux amandes', 'Magrets de canard à l\'Amarula', 'Tarte flan à la cannelle et aux prunes', 'En entrée une salade sucrée-salée très sympa suivi d\'un savoureux magrets de canard à l\'Amarula, une recette inspirée du restaurant Coopmanhuijs. Tout comme ici, le canard est très populaire en Afrique du Sud.\r\nEnfin en dessert une tarte flan à la cannelle et aux prunes une tarte délicieusement acidulée et croustillante.', 2),
(2, 'viande blanche', 'Salade verte à la poire et à la grenade, croûtons aux épices', 'Poulet « Kung Pao »', 'Croustade aux pommes et à la noix de coco\r\n', 'Une salade fraîche arrosée de vinaigrette est idéale pour accompagner un repas des fêtes. Son amertume et ses ingrédients piquants contrebalancent les riches saveurs présentes dans les plats plus traditionnels.\r\nEn plat le poulet Kung Pao, également appelé poulet impérial, gong bao, kung po ou gōngbǎo jīdīng (宫保鸡丁) dans sa version complète, est un plat sauté délicieusement épicé qui est préparé avec du poulet ainsi que des cacahuètes, et des piments, auxquels des légumes sont parfois ajoutés.\r\nEnfin en dessert le savoureu croustade au pommes et à la noix de coco.', 2),
(3, 'menu vegan', 'Tofu au confit d’oignon en assiette mezze', 'Riz au curry, haricots coco et champignons', 'Céréales chaudes et fruits frais.', 'En entrée une recette préparé à partir de tofu ferme, avocats, concombre libanais.\r\npour le plat principal : Riz au curry, haricots coco et champignons.\r\nEn dessert des céréales chaudes et fruits frais.', 2);

-- --------------------------------------------------------

--
-- Structure de la table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `quantity` varchar(45) DEFAULT NULL,
  `menus_id` int(11) NOT NULL,
  `reservation_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `partenaire`
--

CREATE TABLE `partenaire` (
  `id` int(11) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `title` varchar(45) DEFAULT NULL,
  `description` text,
  `logo_src` varchar(255) DEFAULT NULL,
  `thum_src` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `price`
--

CREATE TABLE `price` (
  `id` int(11) NOT NULL,
  `price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `price`
--

INSERT INTO `price` (`id`, `price`) VALUES
(1, 20),
(2, 30);

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

CREATE TABLE `reservation` (
  `id` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `date_passed` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_booked` datetime DEFAULT NULL,
  `reservationcol` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstname` varchar(80) DEFAULT NULL,
  `adress` varchar(80) DEFAULT NULL,
  `phone` varchar(12) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `lastname` varchar(45) DEFAULT NULL,
  `city` varchar(80) DEFAULT NULL,
  `zip` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `email`
--
ALTER TABLE `email`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_email_user1` (`user_id`);

--
-- Index pour la table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_images_menus1` (`menus_id`);

--
-- Index pour la table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_menus_price` (`price_id`);

--
-- Index pour la table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_menus1` (`menus_id`),
  ADD KEY `fk_order_reservation1` (`reservation_id`);

--
-- Index pour la table `partenaire`
--
ALTER TABLE `partenaire`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `price`
--
ALTER TABLE `price`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_reservation_user1` (`user_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `email`
--
ALTER TABLE `email`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `partenaire`
--
ALTER TABLE `partenaire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `price`
--
ALTER TABLE `price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `email`
--
ALTER TABLE `email`
  ADD CONSTRAINT `fk_email_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `fk_images_menus1` FOREIGN KEY (`menus_id`) REFERENCES `menus` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `fk_menus_price` FOREIGN KEY (`price_id`) REFERENCES `price` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `fk_order_menus1` FOREIGN KEY (`menus_id`) REFERENCES `menus` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_order_reservation1` FOREIGN KEY (`reservation_id`) REFERENCES `reservation` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `fk_reservation_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
