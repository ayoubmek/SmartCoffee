-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 27 sep. 2025 à 18:47
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `golf`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `icone` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id`, `nom`, `icone`) VALUES
(1, 'Café', 'assets/media/ch/Gemini-Generated-Image-shu7yishu7yishu7-68d6827307847.webp'),
(3, 'Milkshakes', 'assets/media/ch/Gemini-Generated-Image-4ouw2r4ouw2r4ouw-68d66fd6e9bc2.webp'),
(6, 'Boissons', 'assets/media/ch/Gemini-Generated-Image-olxfibolxfibolxf-68d67093f2465.webp'),
(18, 'Smoothies', 'assets/media/ch/Gemini-Generated-Image-nfkx24nfkx24nfkx-copy-68d67008c015d.webp'),
(19, 'Pizza', 'assets/media/ch/Gemini-Generated-Image-gnfj0agnfj0agnfj-68d66e7130f7b.webp'),
(20, 'Thé', 'assets/media/ch/Gemini-Generated-Image-vo62hkvo62hkvo62-68d67b37ce16f.webp'),
(37, 'Ice Cream', 'assets/media/ch/Gemini-Generated-Image-3rsgji3rsgji3rsg-68d66e1662e3d.webp'),
(38, 'Crêpes', 'assets/media/ch/Image-fx-2025-09-24T142650-786-68d66e9280a0a.webp'),
(39, 'Gauffre', 'assets/media/ch/Image-fx-2025-09-24T173725-462-68d66ebb585de.webp'),
(40, 'Pancake', 'assets/media/ch/Image-fx-2025-09-24T175331-917-68d66e3aed571.webp'),
(41, 'Omelette', 'assets/media/ch/Image-fx-2025-09-24T180228-511-68d66efc3e803.webp'),
(42, 'Mojito', 'assets/media/ch/Gemini-Generated-Image-cbs6w3cbs6w3cbs6-68d66f30ec791.webp'),
(43, 'Petit Dejeuner', 'assets/media/ch/Gemini-Generated-Image-pltkk0pltkk0pltk-68d66fb5eca84.webp'),
(44, 'Menu Enfant', 'assets/media/ch/Gemini-Generated-Image-n6me8ln6me8ln6me-68d66f5ba8c7b.webp'),
(45, 'Frappuccino', 'assets/media/ch/Gemini-Generated-Image-22gjoe22gjoe22gj-copy-68d66f899896d.webp'),
(46, 'Jus', 'assets/media/ch/Gemini-Generated-Image-8no34y8no34y8no3-68d66f7003413.webp');

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20250905133841', '2025-09-05 15:38:47', 1138),
('DoctrineMigrations\\Version20250910103657', '2025-09-10 12:37:14', 151),
('DoctrineMigrations\\Version20250917221145', '2025-09-18 00:11:56', 46),
('DoctrineMigrations\\Version20250918081355', '2025-09-18 10:14:11', 104),
('DoctrineMigrations\\Version20250918091813', '2025-09-18 11:18:26', 31);

-- --------------------------------------------------------

--
-- Structure de la table `history`
--

CREATE TABLE `history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `contenu` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `invoice`
--

CREATE TABLE `invoice` (
  `id` int(11) NOT NULL,
  `client_name` varchar(100) NOT NULL,
  `client_phone` varchar(20) DEFAULT NULL,
  `date` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `total_amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `invoice_item`
--

CREATE TABLE `invoice_item` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `barber_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `offer`
--

CREATE TABLE `offer` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `offer`
--

INSERT INTO `offer` (`id`, `name`, `image`) VALUES
(8, 'offer', 'assets/media/ch/Gemini_Generated_Image_igcpuligcpuligcp.webp'),
(10, 'Petit dejeuner Classique', 'assets/media/ch/Gemini_Generated_Image_4f6kx34f6kx34f6k.webp'),
(11, 'Petit dejeuner Classique', 'assets/media/ch/Gemini_Generated_Image_4f6kx34f6kx34f6k.webp'),
(12, 'Petit dejeuner Matinale', 'assets/media/ch/Gemini_Generated_Image_10yx5910yx5910yx.webp'),
(13, 'Petit dejeuner Arabesque', 'assets/media/ch/Gemini_Generated_Image_ua021vua021vua02.webp'),
(14, 'Petit dejeuner Healthy', 'assets/media/ch/Gemini_Generated_Image_plc5biplc5biplc5.webp');

-- --------------------------------------------------------

--
-- Structure de la table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `payment_type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `id` int(11) NOT NULL,
  `categorie_id` int(11) NOT NULL,
  `nom` varchar(150) NOT NULL,
  `image` varchar(255) NOT NULL,
  `prix` double NOT NULL,
  `prix_ancien` double DEFAULT NULL,
  `reduction` int(11) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `position` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id`, `categorie_id`, `nom`, `image`, `prix`, `prix_ancien`, `reduction`, `description`, `position`) VALUES
(198, 3, 'Milkshake Chocolat', 'assets/media/ch/Gemini_Generated_Image_irupj3irupj3irup.webp', 5000, NULL, NULL, NULL, NULL),
(199, 3, 'Kinder Bueno Milkshake', 'assets/media/products/Gemini_Generated_Image_mqp3vnmqp3vnmqp3.webp', 9500, NULL, NULL, NULL, NULL),
(200, 3, 'Caramel Popcorn Milkshake', 'assets/media/products/Gemini_Generated_Image_bqfj0rbqfj0rbqfj.webp', 9500, NULL, NULL, NULL, NULL),
(201, 3, 'Milkshake Oreo', 'assets/media/products/Gemini_Generated_Image_e7xg6de7xg6de7xg.webp', 9000, NULL, NULL, NULL, NULL),
(202, 3, 'Milkshake Spéculoos', 'assets/media/products/Gemini_Generated_Image_thx2qsthx2qsthx2.webp', 7000, NULL, NULL, NULL, NULL),
(203, 3, 'Milkshake Nutella Banane', 'assets/media/products/Gemini_Generated_Image_lisijwlisijwlisi.webp', 9000, NULL, NULL, NULL, NULL),
(204, 3, 'Milkshake Nutella', 'assets/media/products/Gemini_Generated_Image_j08cssj08cssj08c.webp', 8000, NULL, NULL, NULL, NULL),
(212, 19, 'Pizza Neptune', 'assets/media/products/Gemini_Generated_Image_6jfhut6jfhut6jfh.webp', 12000, NULL, NULL, NULL, NULL),
(213, 19, 'Pizza Pepperoni', 'assets/media/products/Gemini_Generated_Image_uboyeauboyeauboy.webp', 12000, NULL, NULL, NULL, NULL),
(214, 19, 'Pizza La Reine', 'assets/media/products/Gemini_Generated_Image_ssh7jmssh7jmssh7.webp', 12000, NULL, NULL, NULL, NULL),
(215, 19, 'Pizza Végétarienne', 'assets/media/products/Gemini_Generated_Image_gnfj0agnfj0agnfj.webp', 12000, NULL, NULL, NULL, NULL),
(216, 19, 'Pizza Chicken', 'assets/media/products/Gemini_Generated_Image_i5a0oei5a0oei5a0.webp', 12000, NULL, NULL, NULL, NULL),
(217, 19, 'Pizza 5 Fromages', 'assets/media/products/Gemini_Generated_Image_aig8ckaig8ckaig8.webp', 12000, NULL, NULL, NULL, NULL),
(218, 19, 'Pizza 4 Saisons', 'assets/media/products/Gemini_Generated_Image_gk7p91gk7p91gk7p.webp', 15000, NULL, NULL, NULL, NULL),
(219, 19, 'Pizza Mexicaine', 'assets/media/products/Gemini_Generated_Image_men2rmmen2rmmen2.webp', 16000, NULL, NULL, NULL, NULL),
(220, 19, 'Pizza La Bomba', 'assets/media/products/Gemini_Generated_Image_vewwlrvewwlrveww.webp', 20000, NULL, NULL, NULL, NULL),
(221, 6, 'Eau 0.5', 'assets/media/products/Gemini_Generated_Image_goormugoormugoor.png', 1500, NULL, NULL, NULL, NULL),
(223, 6, 'Eau 1L', 'assets/media/products/Gemini_Generated_Image_ekcgpbekcgpbekcg.png', 2000, NULL, NULL, NULL, NULL),
(224, 6, 'Bouteille d\'eau', 'assets/media/products/Gemini_Generated_Image_goormugoormugoor.png', 2500, NULL, NULL, NULL, NULL),
(225, 6, 'Pepsi', 'assets/media/products/Gemini_Generated_Image_k8fmibk8fmibk8fm.png', 3000, NULL, NULL, NULL, NULL),
(226, 6, 'Boisson énergétique', 'assets/media/products/Gemini_Generated_Image_6nmpcs6nmpcs6nmp.png', 10000, NULL, NULL, NULL, NULL),
(227, 6, 'Schweppes gold', 'assets/media/products/Gemini_Generated_Image_1l0ba51l0ba51l0b.png', 4000, NULL, NULL, NULL, NULL),
(228, 6, 'Orangina', 'assets/media/products/Gemini_Generated_Image_olxfibolxfibolxf.png', 3000, NULL, NULL, NULL, NULL),
(229, 20, 'Thé infusion', 'assets/media/products/Gemini_Generated_Image_rpuf6irpuf6irpuf.webp', 3000, NULL, NULL, NULL, NULL),
(230, 37, 'Glaces (3 boules au choix)', 'assets/media/products/Gemini_Generated_Image_69rmz969rmz969rm.webp', 7000, NULL, NULL, NULL, NULL),
(231, 37, 'Glaces (5 boules au choix)', 'assets/media/products/Gemini_Generated_Image_3rsgji3rsgji3rsg.webp', 10000, NULL, NULL, NULL, NULL),
(232, 1, 'Espresso', 'assets/media/products/Gemini_Generated_Image_mlu9pkmlu9pkmlu9.webp', 2500, NULL, NULL, NULL, NULL),
(233, 1, 'Américain', 'assets/media/products/Gemini_Generated_Image_r1k46qr1k46qr1k4.webp', 2700, NULL, NULL, NULL, NULL),
(234, 1, 'Capucin', 'assets/media/products/Gemini_Generated_Image_ocsjm0ocsjm0ocsj.webp', 3000, NULL, NULL, NULL, NULL),
(235, 1, 'Chocolat au lait', 'assets/media/products/Gemini_Generated_Image_m4egzsm4egzsm4eg.webp', 3, NULL, NULL, NULL, NULL),
(236, 1, 'Direct', 'assets/media/products/Gemini_Generated_Image_fsvkxqfsvkxqfsvk.webp', 3500, NULL, NULL, NULL, NULL),
(237, 1, 'Express special', 'assets/media/products/Gemini_Generated_Image_9mktq79mktq79mkt.webp', 3500, NULL, NULL, NULL, NULL),
(238, 1, 'Américain special', 'assets/media/products/Gemini_Generated_Image_r1k46qr1k46qr1k4.webp', 3700, NULL, NULL, NULL, NULL),
(239, 1, 'Capucin special', 'assets/media/products/Gemini_Generated_Image_shu7yishu7yishu7 (1).webp', 4500, NULL, NULL, NULL, NULL),
(240, 1, 'Direct special', 'assets/media/products/Gemini_Generated_Image_fsvkxqfsvkxqfsvk.webp', 4500, NULL, NULL, NULL, NULL),
(241, 1, 'Café turc', 'assets/media/products/Gemini_Generated_Image_xvqj5sxvqj5sxvqj.webp', 4500, NULL, NULL, NULL, NULL),
(242, 1, 'Chocolat chaud', 'assets/media/products/Gemini_Generated_Image_hrrwfehrrwfehrrw.webp', 5000, NULL, NULL, NULL, NULL),
(243, 1, 'Cappuccino', 'assets/media/products/Gemini_Generated_Image_ocsjm0ocsjm0ocsj.webp', 4000, NULL, NULL, NULL, NULL),
(244, 1, 'Café liégeois', 'assets/media/products/Gemini_Generated_Image_wpmpvrwpmpvrwpmp.webp', 5000, NULL, NULL, NULL, NULL),
(245, 1, 'Cappuccino aromatisé chantilly', 'assets/media/products/Gemini_Generated_Image_aaj9kaaj9kaaj9ka.webp', 6000, NULL, NULL, NULL, NULL),
(246, 38, 'Crêpe chocolat', 'assets/media/products/Image_fx - 2025-09-24T142650.786.webp', 6500, NULL, NULL, NULL, NULL),
(247, 38, 'Crêpe chocolat banane', 'assets/media/products/Image_fx - 2025-09-24T142739.086.webp', 8000, NULL, NULL, NULL, NULL),
(248, 38, 'Crêpe chocolat amande', 'assets/media/products/Image_fx - 2025-09-24T142824.591.webp', 7000, NULL, NULL, NULL, NULL),
(249, 38, 'Crêpe chocolat amande banane', 'assets/media/products/Image_fx - 2025-09-24T143106.135.webp', 9000, NULL, NULL, NULL, NULL),
(250, 38, 'Crêpe Nutella banane', 'assets/media/products/Image_fx - 2025-09-24T143239.329.webp', 10000, NULL, NULL, NULL, NULL),
(251, 38, 'Crêpe Nutella', 'assets/media/products/Image_fx - 2025-09-24T143151.113.webp', 9000, NULL, NULL, NULL, NULL),
(252, 38, 'Crêpe Nutella amande', 'assets/media/products/Image_fx - 2025-09-24T143310.638.webp', 10000, NULL, NULL, NULL, NULL),
(253, 38, 'Crêpe Nutella amande banane', 'assets/media/products/Image_fx - 2025-09-24T143344.308.webp', 12000, NULL, NULL, NULL, NULL),
(254, 38, 'Crêpe oreo', 'assets/media/products/Image_fx - 2025-09-24T143415.613.webp', 10000, NULL, NULL, NULL, NULL),
(255, 38, 'Crêpe spéculoos', 'assets/media/products/Image_fx - 2025-09-24T143510.632.webp', 10000, NULL, NULL, NULL, NULL),
(256, 38, 'Crêpe ferrero rocher', 'assets/media/products/Image_fx - 2025-09-24T143547.067.webp', 12000, NULL, NULL, NULL, NULL),
(257, 38, 'Crêpe fromage', 'assets/media/products/Image_fx - 2025-09-24T143636.078.webp', 8000, NULL, NULL, NULL, NULL),
(258, 38, 'Crêpe jambon fromage', 'assets/media/products/Image_fx - 2025-09-24T143704.427.webp', 9000, NULL, NULL, NULL, NULL),
(259, 38, 'Crêpe thon fromage', 'assets/media/products/Image_fx - 2025-09-24T143755.656.webp', 10000, NULL, NULL, NULL, NULL),
(260, 38, 'Crêpe tunisienne', 'assets/media/products/Image_fx - 2025-09-24T143849.996.webp', 11000, NULL, NULL, NULL, NULL),
(261, 38, 'Crêpe spéciale', 'assets/media/products/Image_fx - 2025-09-24T143946.789.webp', 13000, NULL, NULL, NULL, NULL),
(262, 39, 'Gauffre chocolat', 'assets/media/products/Image_fx - 2025-09-24T172812.885.webp', 6500, NULL, NULL, NULL, NULL),
(263, 39, 'Gauffre chocolat banane', 'assets/media/products/Image_fx - 2025-09-24T172840.874.webp', 8000, NULL, NULL, NULL, NULL),
(264, 39, 'Gauffre chocolat amande', 'assets/media/products/Image_fx - 2025-09-24T172917.505.webp', 7000, NULL, NULL, NULL, NULL),
(265, 39, 'Gauffre chocolat amande banane', 'assets/media/products/Image_fx - 2025-09-24T173407.970.webp', 9000, NULL, NULL, NULL, NULL),
(266, 39, 'Gauffre Nutella', 'assets/media/products/Image_fx - 2025-09-24T173523.296.webp', 9000, NULL, NULL, NULL, NULL),
(267, 39, 'Gauffre Nutella banane', 'assets/media/products/Image_fx - 2025-09-24T175432.521.webp', 10000, NULL, NULL, NULL, NULL),
(268, 39, 'Gauffre Nutella amande', 'assets/media/products/Image_fx - 2025-09-24T173725.462.webp', 10000, NULL, NULL, NULL, NULL),
(269, 39, 'Gauffre Nutella amande banane', 'assets/media/products/Image_fx - 2025-09-24T173407.970.webp', 12000, NULL, NULL, NULL, NULL),
(270, 39, 'Gauffre spéculoos', 'assets/media/products/Image_fx - 2025-09-24T173904.252.webp', 10000, NULL, NULL, NULL, NULL),
(271, 39, 'Gauffre ferrero rocher', 'assets/media/products/Image_fx - 2025-09-24T174008.744.webp', 12000, NULL, NULL, NULL, NULL),
(272, 40, 'Pancake chocolat', 'assets/media/products/Image_fx - 2025-09-24T175042.448.webp', 6500, NULL, NULL, NULL, NULL),
(273, 40, 'Pancake chocolat banane', 'assets/media/products/Image_fx - 2025-09-24T175108.023.webp', 8000, NULL, NULL, NULL, NULL),
(274, 40, 'Pancake chocolat amande', 'assets/media/products/Image_fx - 2025-09-24T175224.027.webp', 7000, NULL, NULL, NULL, NULL),
(275, 40, 'Pancake chocolat amande banane', 'assets/media/products/Image_fx - 2025-09-24T175331.917.webp', 9000, NULL, NULL, NULL, NULL),
(276, 40, 'Pancake Nutella', 'assets/media/products/Image_fx - 2025-09-24T175404.432.webp', 9000, NULL, NULL, NULL, NULL),
(277, 40, 'Pancake Nutella banane', 'assets/media/products/Image_fx - 2025-09-24T175432.521.webp', 10000, NULL, NULL, NULL, NULL),
(278, 40, 'Pancake Nutella amande', 'assets/media/products/Image_fx - 2025-09-24T175516.900.webp', 10000, NULL, NULL, NULL, NULL),
(279, 40, 'Pancake Nutella amande banane', 'assets/media/products/Image_fx - 2025-09-24T175555.351.webp', 12000, NULL, NULL, NULL, NULL),
(280, 40, 'Pancake Oreo', 'assets/media/products/Image_fx - 2025-09-24T175624.760.webp', 10000, NULL, NULL, NULL, NULL),
(281, 40, 'Pancake spéculoos', 'assets/media/products/Image_fx - 2025-09-24T175707.588.webp', 10000, NULL, NULL, NULL, NULL),
(282, 40, 'Pancake ferrero rocher', 'assets/media/products/Image_fx - 2025-09-24T175735.586.webp', 12000, NULL, NULL, NULL, NULL),
(283, 41, 'Omelette fromage', 'assets/media/products/Image_fx - 2025-09-24T180228.511.webp', 5000, NULL, NULL, NULL, NULL),
(284, 41, 'Omelette jambon fromage', 'assets/media/products/Image_fx - 2025-09-24T180256.917.webp', 6000, NULL, NULL, NULL, NULL),
(285, 41, 'Omelette thon fromage', 'assets/media/products/Image_fx - 2025-09-24T180324.719.webp', 7000, NULL, NULL, NULL, NULL),
(286, 41, 'Omelette spéciale', 'assets/media/products/Image_fx - 2025-09-24T180536.124.webp', 8000, NULL, NULL, NULL, NULL),
(287, 42, 'Mojito', 'assets/media/products/Gemini_Generated_Image_v9eyccv9eyccv9ey.webp', 6000, NULL, NULL, NULL, NULL),
(288, 42, 'Mojito Bleu', 'assets/media/products/Gemini_Generated_Image_unzi01unzi01unzi.webp', 7000, NULL, NULL, NULL, NULL),
(289, 42, 'Mojito frombo', 'assets/media/products/Gemini_Generated_Image_cbs6w3cbs6w3cbs6.webp', 8000, NULL, NULL, NULL, NULL),
(290, 42, 'Mojito fruit de la passion', 'assets/media/products/Gemini_Generated_Image_l2rjpel2rjpel2rj.webp', 9500, NULL, NULL, NULL, NULL),
(291, 42, 'Pinacolada', 'assets/media/products/Gemini_Generated_Image_xqrbchxqrbchxqrb.webp', 9500, NULL, NULL, NULL, NULL),
(292, 42, 'Boisson énergétique', 'assets/media/products/Gemini_Generated_Image_szs73kszs73kszs7.webp', 10000, NULL, NULL, NULL, NULL),
(293, 43, 'Petit dejeuner Classique', 'assets/media/products/Gemini_Generated_Image_hngy3phngy3phngy.webp', 7500, NULL, NULL, NULL, NULL),
(294, 43, 'Petit dejeuner Matinale', 'assets/media/products/Gemini_Generated_Image_uw92cfuw92cfuw92.webp', 15000, NULL, NULL, NULL, NULL),
(295, 43, 'Petit dejeuner Arabesque', 'assets/media/products/Gemini_Generated_Image_uw92cfuw92cfuw92.webp', 20000, NULL, NULL, NULL, NULL),
(296, 43, 'Petit dejeuner Healthy', 'assets/media/products/Gemini_Generated_Image_pltkk0pltkk0pltk.webp', 15000, NULL, NULL, NULL, NULL),
(297, 44, 'Panini au choix + frite + Boisson', 'assets/media/products/Gemini_Generated_Image_n6me8ln6me8ln6me.webp', 10000, NULL, NULL, NULL, NULL),
(298, 44, 'Soufflé + frites + Boisson gazeuse', 'assets/media/products/Gemini_Generated_Image_9t1l189t1l189t1l.webp', 10000, NULL, NULL, NULL, NULL),
(299, 18, 'Smoothie Pinacolada', 'assets/media/products/Gemini_Generated_Image_pvkkd5pvkkd5pvkk.webp', 9500, NULL, NULL, NULL, NULL),
(300, 18, 'Smoothie Framboise', 'assets/media/products/Gemini_Generated_Image_nfkx24nfkx24nfkx copy.webp', 9500, NULL, NULL, NULL, NULL),
(301, 18, 'Smoothie Fruit de la passion', 'assets/media/products/Gemini_Generated_Image_epwucwepwucwepwu.webp', 9500, NULL, NULL, NULL, NULL),
(302, 18, 'Smoothie Banane kiwi', 'assets/media/products/Gemini_Generated_Image_bytqh3bytqh3bytq copy.webp', 8500, NULL, NULL, NULL, NULL),
(303, 18, 'Smoothie Epinard kiwi', 'assets/media/products/Gemini_Generated_Image_m6lrz1m6lrz1m6lr copy.webp', 9500, NULL, NULL, NULL, NULL),
(304, 45, 'Frappuccino Classique', 'assets/media/products/Gemini_Generated_Image_48dbm748dbm748db.webp', 7000, NULL, NULL, NULL, NULL),
(305, 45, 'Frappuccino vanille', 'assets/media/products/Gemini_Generated_Image_8sxztf8sxztf8sxz.webp', 7000, NULL, NULL, NULL, NULL),
(306, 45, 'Frappuccino noisette', 'assets/media/products/Gemini_Generated_Image_m5jsz0m5jsz0m5js.webp', 7000, NULL, NULL, NULL, NULL),
(307, 45, 'Frappuccino caramel', 'assets/media/products/Gemini_Generated_Image_6aoqi36aoqi36aoq.webp', 7000, NULL, NULL, NULL, NULL),
(308, 45, 'Frappuccino spéculoos', 'assets/media/products/Gemini_Generated_Image_dm6p3ldm6p3ldm6p.webp', 8000, NULL, NULL, NULL, NULL),
(309, 45, 'Frappuccino chocolat', 'assets/media/products/Gemini_Generated_Image_xw8oeuxw8oeuxw8o (1).webp', 8000, NULL, NULL, NULL, NULL),
(310, 45, 'Frappuccino nutella', 'assets/media/products/Gemini_Generated_Image_x2m79zx2m79zx2m7 (1).webp', 8000, NULL, NULL, NULL, NULL),
(311, 45, 'Frappuccino oreo', 'assets/media/products/Gemini_Generated_Image_22gjoe22gjoe22gj copy.webp', 8000, NULL, NULL, NULL, NULL),
(312, 46, 'Orange', 'assets/media/products/Gemini_Generated_Image_vxttlxvxttlxvxtt.webp', 4000, NULL, NULL, NULL, NULL),
(313, 46, 'Fraise', 'assets/media/products/Gemini_Generated_Image_6l8glk6l8glk6l8g.webp', 5000, NULL, NULL, NULL, NULL),
(314, 46, 'Lait de poule', 'assets/media/products/Gemini_Generated_Image_8fk0f88fk0f88fk0.webp', 5000, NULL, NULL, NULL, NULL),
(315, 46, 'Lait de poule fraise', 'assets/media/products/Gemini_Generated_Image_32j0ht32j0ht32j0.webp', 5000, NULL, NULL, NULL, NULL),
(316, 46, 'Citronnade amandes', 'assets/media/products/Gemini_Generated_Image_3gq7uj3gq7uj3gq7.webp', 6000, NULL, NULL, NULL, NULL),
(317, 46, 'Kiwi banane', 'assets/media/products/Gemini_Generated_Image_nm31urnm31urnm31.webp', 7000, NULL, NULL, NULL, NULL),
(318, 46, 'Cocktail de fruit', 'assets/media/products/Gemini_Generated_Image_8no34y8no34y8no3.webp', 9000, NULL, NULL, NULL, NULL),
(319, 46, 'Tropicool', 'assets/media/products/Gemini_Generated_Image_oruvesoruvesoruv.webp', 8000, NULL, NULL, NULL, NULL),
(320, 20, 'Thé Panaché', 'assets/media/products/Gemini_Generated_Image_aekc41aekc41aekc.webp', 7000, NULL, NULL, NULL, NULL),
(321, 20, 'Thé Pignon', 'assets/media/products/Gemini_Generated_Image_axn69saxn69saxn6.webp', 9000, NULL, NULL, NULL, NULL),
(322, 20, 'Thé à la Menthe', 'assets/media/products/Gemini_Generated_Image_fb7qu8fb7qu8fb7q.webp', 2500, NULL, NULL, NULL, NULL),
(323, 20, 'Thé aux Amandes', 'assets/media/products/Gemini_Generated_Image_vo62hkvo62hkvo62.webp', 5500, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `service`
--

CREATE TABLE `service` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `duration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` varchar(10) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_64C19C15E237E06` (`name`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_27BA704BA76ED395` (`user_id`);

--
-- Index pour la table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `invoice_item`
--
ALTER TABLE `invoice_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_1DDE477B2989F1FD` (`invoice_id`),
  ADD KEY `IDX_1DDE477BED5CA9E6` (`service_id`),
  ADD KEY `IDX_1DDE477BBFF2FEF2` (`barber_id`);

--
-- Index pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Index pour la table `offer`
--
ALTER TABLE `offer`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6D28840DA76ED395` (`user_id`),
  ADD KEY `IDX_6D28840D2989F1FD` (`invoice_id`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_29A5EC27BCF5E72D` (`categorie_id`);

--
-- Index pour la table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E19D9AD212469DE2` (`category_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `history`
--
ALTER TABLE `history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `invoice_item`
--
ALTER TABLE `invoice_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `offer`
--
ALTER TABLE `offer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=324;

--
-- AUTO_INCREMENT pour la table `service`
--
ALTER TABLE `service`
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
-- Contraintes pour la table `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `FK_27BA704BA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `invoice_item`
--
ALTER TABLE `invoice_item`
  ADD CONSTRAINT `FK_1DDE477B2989F1FD` FOREIGN KEY (`invoice_id`) REFERENCES `invoice` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_1DDE477BBFF2FEF2` FOREIGN KEY (`barber_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_1DDE477BED5CA9E6` FOREIGN KEY (`service_id`) REFERENCES `service` (`id`);

--
-- Contraintes pour la table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `FK_6D28840D2989F1FD` FOREIGN KEY (`invoice_id`) REFERENCES `invoice` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_6D28840DA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `FK_29A5EC27BCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `service`
--
ALTER TABLE `service`
  ADD CONSTRAINT `FK_E19D9AD212469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
