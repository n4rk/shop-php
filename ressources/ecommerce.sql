-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  sam. 22 fév. 2020 à 10:38
-- Version du serveur :  10.3.16-MariaDB
-- Version de PHP :  7.1.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `ecommerce`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `idArticle` int(11) NOT NULL,
  `libelle` varchar(100) NOT NULL,
  `prix` float NOT NULL,
  `quantiteStock` int(11) NOT NULL,
  `vignette` varchar(100) NOT NULL,
  `dateMiseVente` timestamp NOT NULL DEFAULT current_timestamp(),
  `idCategorie` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`idArticle`, `libelle`, `prix`, `quantiteStock`, `vignette`, `dateMiseVente`, `idCategorie`) VALUES
(1, 'Dell G7 7000', 15000, 10, '1.jpg', '2020-01-14 19:54:25', 1),
(2, 'HP Omen 15', 18000, 11, '2.jpg', '2020-02-17 16:00:30', 1),
(3, 'HyperX Pulsefire Pro', 500, 20, '3.jpg', '2020-02-10 04:21:39', 3),
(4, 'Logitech G203 Prodigy', 350, 19, '4.jpg', '2020-02-13 00:10:02', 3),
(5, 'Steelseries Sensei 310', 550, 10, '5.jpg', '2020-01-28 19:49:45', 3),
(6, 'Acer Predator Helios 300', 11000, 15, '6.jpg', '2020-02-10 04:21:09', 1),
(7, 'HP Pavillion 15', 7500, 26, '7.jpg', '2020-02-14 22:35:51', 1),
(8, 'HyperX Cloud Mix', 2100, 10, '8.jpg', '2020-02-13 00:27:53', 2),
(9, 'Huawei P30 Pro', 9500, 10, '9.jpg', '2020-02-16 16:00:40', 4),
(10, 'HyperX Cloud Flight', 1600, 14, '10.jpg', '2020-02-10 04:21:31', 2),
(11, 'Steelseries Arctis 7', 1500, 7, '11.jpg', '2020-01-30 03:26:32', 2),
(12, 'MSI GF63 Gaming', 10500, 9, '12.jpg', '2020-02-13 00:10:02', 1),
(13, 'Asus ROG G531GT', 12000, 10, '13.jpg', '2020-01-27 12:54:03', 1),
(14, 'Razer Nari Ultimate', 2000, 7, '14.jpg', '2020-02-13 00:10:02', 2),
(16, 'Asus ROG Scar III', 16500, 15, '15.jpg', '2020-02-08 22:44:11', 1),
(17, 'Razer Blade 15', 22000, 20, '16.jpg', '2020-02-16 22:03:06', 1),
(21, 'Xiaomi Mi Note 10', 5200, 10, '19.jpg', '2020-02-14 23:40:50', 4),
(22, 'Apple iPhone XR', 10000, 9, '17.jpg', '2020-02-14 23:40:17', 4),
(23, 'Samsung Galaxy S10+', 11000, 9, '18.jpg', '2020-02-20 01:12:12', 4);

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `idCategorie` int(11) NOT NULL,
  `titreCategorie` varchar(100) NOT NULL,
  `descriptionCategorie` varchar(1000) NOT NULL,
  `dateCategorie` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`idCategorie`, `titreCategorie`, `descriptionCategorie`, `dateCategorie`) VALUES
(1, 'Laptop', 'High Quality Gaming Laptops', '2020-02-18 10:40:49'),
(2, 'Headphone', 'High Quality Headphones/Earphones', '2020-02-18 10:40:54'),
(3, 'Mouse', 'High Quality Gaming Mouses', '2020-02-18 10:40:59'),
(4, 'Phone', 'Best High Quality Phones', '2020-02-18 10:41:04');

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `idClient` int(11) NOT NULL,
  `nomClient` varchar(100) NOT NULL,
  `prenomClient` varchar(100) NOT NULL,
  `sexe` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `adresse` varchar(500) NOT NULL,
  `pays` varchar(50) NOT NULL,
  `avatar` varchar(100) NOT NULL DEFAULT '0.png',
  `dateInscription` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `qualite` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`idClient`, `nomClient`, `prenomClient`, `sexe`, `email`, `password`, `adresse`, `pays`, `avatar`, `dateInscription`, `qualite`) VALUES
(1, 'Admin', 'Biougnach', 'Femme', 'admin@biougnach.ma', 'YWRtaW4xMjNiaW91Z25hY2g=', 'LOT 46 SIDI BOUZEKRI, MEKNES', 'MOROCCO', '0.png', '2020-02-16 17:24:30', 1),
(2, 'Hachmi', 'Mohamed Amine', 'Homme', 'amine@test.com', 'dGVzdA==', 'N 33 Lotissement Sijilmassa, Errachidia', 'GERMANY', '36.png', '2020-02-16 17:51:04', 0),
(3, 'Moussaoui', 'Moussa', 'Homme', 'moussa@test.com', 'dGVzdA==', 'N 19 Lotissement El Waha, Errachidia', 'Morocco', '24.png', '2020-02-16 17:51:42', 0),
(4, 'Abidi', 'Morad', 'Homme', 'morad@test.com', 'dGVzdA==', 'N 106 Rue Ibnou Majat, Casablanca', 'Morocco', '35.png', '2020-02-16 17:51:42', 0),
(5, 'Bouziane', 'Wadii', 'Homme', 'wadii@test.com', 'dGVzdA==', 'N 16 KHAWARIZMI, AGADIR', 'Morocco', '1.png', '2020-02-16 17:51:42', 0),
(6, 'Bassalem', 'Younes', 'Homme', 'younes@test.com', 'dGVzdA==', 'N 20 AVENUE FARABI, Rabat', 'Morocco', '17.png', '2020-02-17 00:31:47', 0),
(7, 'Ajana', 'Hamza', 'Homme', 'hamza@test.com', 'dGVzdA==', 'N 123 LOT. JIRARI, TANGER', 'FRANCE', '16.png', '2020-02-16 17:51:42', 0),
(8, 'Belmoubarik', 'Merouane', 'Homme', 'merouane@test.com', 'dGVzdA==', 'N 97 AIN ATTI 1, ERRACHIDIA', 'SOUTH KOREA', '0.png', '2020-02-16 17:51:42', 0),
(9, 'Hachmi', 'Houssine', 'Homme', 'houssine@test.com', 'dGVzdA==', 'N 129 RUE MUSEE ART, NOVGOROD', 'RUSSIA', '0.png', '2020-02-16 17:51:42', 0),
(11, 'Belmoubarik', 'Mustapha', 'Homme', 'must@test.com', 'dGVzdA==', 'N 97 AIN ATTI 1, ERRACHIDIA', 'MOROCCO', '0.png', '2020-02-22 02:06:05', 0),
(12, 'Tester', 'Hamid', 'Homme', 'hamid@test.com', 'dGVzdA==', 'N 99 LOTISSEMENT TARGA, ERRACHIDIA', 'MAROC', '0.png', '2020-02-22 02:11:28', 0);

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

CREATE TABLE `commandes` (
  `idCommande` int(11) NOT NULL,
  `dateCommande` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `adresseLivraison` varchar(500) NOT NULL,
  `totalCommande` int(11) NOT NULL,
  `etatCommande` int(1) NOT NULL DEFAULT 0,
  `idClient` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`idCommande`, `dateCommande`, `adresseLivraison`, `totalCommande`, `etatCommande`, `idClient`) VALUES
(1, '2020-02-16 18:56:34', 'N 106 Rue Ibnou Majat, Casablanca', 38000, 1, 4),
(2, '2020-02-16 19:20:27', 'N 5 Lotissement Serfa Industriel', 9000, 1, 6),
(3, '2020-02-16 18:56:42', ' N19 Hay Souk Sbaa Ayoune Meknes', 30000, 1, 3),
(4, '2020-02-17 09:25:29', 'N 12, Rue Champigny Casablanca', 7500, 1, 5),
(5, '2020-02-16 18:56:32', 'N 777 Lotissement Somewhere', 5400, 0, 2),
(6, '2020-02-16 18:56:32', 'N 33 Lotissement Sijilmassa, Errachidia', 15000, 0, 2),
(8, '2020-02-20 01:37:37', 'N 19 Lotissement El Waha, Errachidia', 22450, 1, 3),
(9, '2020-02-20 01:39:10', 'N 33 Lotissement Sijilmassa, Errachidia', 99300, 1, 2),
(10, '2020-02-16 18:56:32', 'N 20 Avenue Al Arabi, Rabat', 44000, 0, 6),
(11, '2020-02-16 18:56:32', 'N 16 Avenue Farabi, Agadir', 54500, 0, 5),
(12, '2020-02-16 18:56:32', 'N 33 Lotissement Sijilmassa, Errachidia', 16000, 0, 2),
(13, '2020-02-16 18:56:32', 'N 97 AIN ATTI 1, ERRACHIDIA', 7500, 0, 8),
(14, '2020-02-16 18:56:32', 'N 33 Lotissement Sijilmassa, Errachidia', 9000, 0, 2),
(15, '2020-02-16 18:56:39', 'N 33 Lotissement Sijilmassa, Errachidia', 8000, 1, 2),
(16, '2020-02-16 18:56:32', 'N 129 RUE MUSEE ART, NOVGOROD', 15000, 0, 9),
(17, '2020-02-16 22:03:06', 'N 123 LOT. JIRARI, TANGER', 22000, 0, 7),
(18, '2020-02-20 10:02:12', 'N 16 KHAWARIZMI, AGADIR', 1600, 1, 5),
(19, '2020-02-21 22:27:13', 'N 97 AIN ATTI 1, ERRACHIDIA', 7500, 0, 8),
(20, '2020-02-21 22:29:35', 'N 129 RUE MUSEE ART, NOVGOROD', 10000, 0, 9),
(21, '2020-02-21 23:14:25', 'N 20 AVENUE FARABI, Rabat', 10000, 0, 6),
(22, '2020-02-22 00:56:36', 'N 16 KHAWARIZMI, AGADIR', 10000, 0, 5);

-- --------------------------------------------------------

--
-- Structure de la table `descriptions`
--

CREATE TABLE `descriptions` (
  `idDescription` int(11) NOT NULL,
  `item` varchar(200) NOT NULL,
  `definition` varchar(1000) NOT NULL,
  `idArticle` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `descriptions`
--

INSERT INTO `descriptions` (`idDescription`, `item`, `definition`, `idArticle`) VALUES
(1, 'Processor', 'Intel Core i7-9750H up to 4.5 GHz, 6 cores', 1),
(2, 'GPU', 'NVIDIA GeForce RTX 2060 6GB GDDR6', 1),
(3, 'Storage', '256GB M.2 PCIe NVMe SSD + 1TB HDD', 1),
(4, 'RAM', '16GB RAM DDR4', 1),
(5, 'Slots', 'HDMI | SD Card Reader | SuperSpeed USB 3.1', 1),
(6, 'OS', 'Windows 10 Home x64', 1),
(7, 'Processor', 'Intel Core i7-9750H up to 4.5GHz, 6 cores', 2),
(8, 'GPU', 'NVIDIA GeForce RTX 2070 Max-Q 8GB GDDR6', 2),
(9, 'Display', '15.6\" Diagonal 4K', 2),
(10, 'Storage', '1TB NVMe SSD + 1TB HDD', 2),
(11, 'RAM', '32GB DDR4', 2),
(12, 'Slots', 'HDMI, SD Card Reader, SuperSpeed USB 3.1', 2),
(13, 'OS', 'Windows 10 Home x64', 2),
(14, 'Specifications', 'Couleur Noir | 6 boutons | Eclairage RVB | 16000 dpi', 3),
(15, 'Processeur', 'Kirin 980 Octo-Core (cadence a 2 x 2.6 GHz + 2 x 1.9 GHz + 4 x 1.8 GHz)', 9),
(16, 'Systeme', 'Android 9.0 Pie avec EMUI 9.1', 9),
(17, 'Ecran', 'OLED 6.47\" FullView, resolution Full HD+ 1080 x 2340 pixels, 398 ppi', 9),
(18, 'RAM', '8 Go', 9),
(19, 'APN', 'Triple camera concue avec Leica 40MP f/1.6 + 20MP f/2.2 + 8MP f/3.4 + Huawei TOF, camera avant 32 MP f/2.0\r\n', 9),
(20, 'Stockage', '128 Go (extensible via carte Nano Memory jusqu\'a 256 Go)', 9),
(21, 'Connectivite', 'BT 5.0, GPS, GLONASS, Wi-Fi 2.4 GHz et 5 GHz, Wi-Fi 802.11 ac/a/b/g/n, USB Type C, lecteur d\'empreintes digitales, NFC', 9),
(22, 'Batterie', '4200 mAh avec charge rapide', 9),
(23, 'Dimensions', '158 x 73.4 x 8.41 mm pour 192 g', 9),
(24, 'Processeur', 'Qualcomm Snapdragon 730G Octo-Core 2.2 GHz, GPU Adreno 618', 21),
(25, 'Systeme ', 'Android 9.0 Oreo avec MIUI 11', 21),
(26, 'Ecran ', 'Ecran tactile 3D AMOLED de 6.47\" avec resolution Full HD+ 1080 x 2340 pixels, Corning Gorilla Glass 5, HDR', 21),
(27, 'RAM ', '6 Go', 21),
(28, 'Stockage ', '128 Go', 21),
(29, 'Batterie ', '5260 mAh avec recharge rapide', 21),
(30, 'Dimensions ', '157.8 x 74.2 x 9.67 mm pour 208 g', 21),
(31, 'Processeur ', 'Apple A12 Bionic Hexa-Core, Neural Engine de nouvelle generation', 22),
(32, 'Systeme ', 'iOS 12', 22),
(33, 'Ecran ', 'Ecran LCD Liquid Retina HD 6.1\" (828 x 1792 pixels), OLED, 326 ppp', 22),
(34, 'RAM ', '3 Go', 22),
(35, 'Stockage ', '128 Go', 22),
(36, 'Dimensions ', '150.9 x 75.7 x 8.3 mm pour 194 g', 22),
(37, 'Processeur ', 'Exynos 9820 Octo-Core (a 2 x 2.8 GHz + 2 x 2.4 GHz + 4 x 1.9 GHz)', 23),
(38, 'Systeme ', 'Android 9.0 Pie (surcouche Samsung One UI)', 23),
(39, 'Ecran ', 'Infinity 6.4 pouces, Super AMOLED, Quad HD+, resolution de 1440 x 3040 pixels, norme HDR10+, Gorilla Glass 6, 522 ppp', 23),
(40, 'RAM ', '8 Go', 23),
(41, 'Stockage ', '128 Go (extensible via microSDXC jusqu\'a 512 Go)', 23),
(42, 'Batterie ', '4100 mAh compatible charge rapide', 23),
(43, 'Dimensions ', '157.6 x 74.1 x 7.8 mm (bords incurves avant et arriere) pour 175 g', 23);

-- --------------------------------------------------------

--
-- Structure de la table `details`
--

CREATE TABLE `details` (
  `idDetail` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  `prixArt` float NOT NULL,
  `idCommande` int(11) NOT NULL,
  `idArticle` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `details`
--

INSERT INTO `details` (`idDetail`, `quantite`, `prixArt`, `idCommande`, `idArticle`) VALUES
(1, 2, 19000, 1, 2),
(2, 5, 1800, 2, 14),
(3, 2, 15000, 3, 1),
(4, 1, 7500, 4, 7),
(5, 3, 1800, 5, 14),
(6, 2, 7500, 6, 7),
(7, 1, 9450, 8, 12),
(8, 4, 350, 8, 4),
(9, 2, 1800, 8, 14),
(10, 1, 8000, 8, 22),
(11, 3, 2100, 9, 8),
(12, 3, 9000, 9, 9),
(13, 3, 22000, 9, 17),
(14, 2, 22000, 10, 17),
(15, 2, 22000, 11, 17),
(16, 1, 10500, 11, 23),
(17, 2, 8000, 12, 22),
(18, 1, 7500, 13, 7),
(19, 1, 9000, 14, 9),
(20, 1, 8000, 15, 22),
(21, 2, 7500, 16, 7),
(22, 1, 22000, 17, 17),
(23, 1, 1600, 18, 10),
(24, 1, 7500, 19, 7),
(25, 1, 10000, 20, 22),
(26, 1, 10000, 21, 22),
(27, 1, 10000, 22, 22);

-- --------------------------------------------------------

--
-- Structure de la table `photos`
--

CREATE TABLE `photos` (
  `idPhoto` int(11) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `idArticle` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `photos`
--

INSERT INTO `photos` (`idPhoto`, `photo`, `idArticle`) VALUES
(1, '1.jpg', 1),
(2, '2.jpg', 1),
(3, '3.jpg', 1),
(4, '4.jpg', 1),
(5, '5.jpg', 2),
(6, '6.jpg', 2),
(7, '7.jpg', 2),
(8, '8.jpg', 2),
(9, '9.jpg', 3),
(10, '10.jpg', 3),
(11, '11.jpg', 3),
(12, '12.jpg', 3),
(13, '13.jpg', 4),
(14, '14.jpg', 4),
(15, '15.jpg', 4),
(16, '16.jpg', 4),
(17, '17.jpg', 5),
(18, '18.jpg', 5),
(19, '19.jpg', 5),
(20, '20.jpg', 5),
(21, '21.jpg', 6),
(22, '22.jpg', 6),
(23, '23.jpg', 6),
(24, '24.jpg', 6),
(25, '25.jpg', 7),
(26, '26.jpg', 7),
(27, '27.jpg', 7),
(28, '28.jpg', 7),
(29, '29.jpg', 8),
(30, '30.jpg', 8),
(31, '31.jpg', 8),
(32, '32.jpg', 8),
(33, '33.jpg', 10),
(34, '34.jpg', 10),
(35, '35.jpg', 10),
(36, '36.jpg', 10),
(37, '37.jpg', 11),
(38, '38.jpg', 11),
(39, '39.jpg', 11),
(40, '40.jpg', 11),
(41, '41.jpg', 12),
(42, '42.jpg', 12),
(43, '43.jpg', 12),
(44, '44.jpg', 12),
(45, '45.jpg', 13),
(46, '46.jpg', 13),
(47, '47.jpg', 13),
(48, '48.jpg', 13),
(49, '49.jpg', 14),
(50, '50.jpg', 14),
(51, '51.jpg', 14),
(52, '52.jpg', 14),
(53, '53.jpg', 16),
(54, '54.jpg', 16),
(55, '55.jpg', 16),
(56, '56.jpg', 16),
(57, '57.jpg', 17),
(58, '58.jpg', 17),
(59, '59.jpg', 17),
(60, '60.jpg', 17),
(61, '69.jpg', 9),
(62, '70.jpg', 9),
(63, '71.jpg', 9),
(64, '72.jpg', 9),
(65, '81.jpg', 21),
(66, '82.jpg', 21),
(67, '83.jpg', 21),
(68, '84.jpg', 21),
(69, '73.jpg', 22),
(70, '74.jpg', 22),
(71, '75.jpg', 22),
(72, '76.jpg', 22),
(73, '77.jpg', 23),
(74, '78.jpg', 23),
(75, '79.jpg', 23),
(76, '80.jpg', 23);

-- --------------------------------------------------------

--
-- Structure de la table `promotions`
--

CREATE TABLE `promotions` (
  `idPromo` int(11) NOT NULL,
  `tauxPromo` int(3) NOT NULL,
  `dateDebut` timestamp NOT NULL DEFAULT current_timestamp(),
  `dateFin` timestamp NULL DEFAULT NULL,
  `idArticle` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `promotions`
--

INSERT INTO `promotions` (`idPromo`, `tauxPromo`, `dateDebut`, `dateFin`, `idArticle`) VALUES
(1, 5, '2020-02-19 23:00:00', '2020-04-30 00:00:00', 16),
(2, 15, '2020-02-19 23:00:00', '2020-04-30 00:00:00', 11),
(3, 10, '2020-02-19 23:00:00', '2020-04-30 00:00:00', 12),
(4, 10, '2020-02-19 23:00:00', '2020-04-30 00:00:00', 14);

-- --------------------------------------------------------

--
-- Structure de la table `publicites`
--

CREATE TABLE `publicites` (
  `idPub` int(11) NOT NULL,
  `typePub` varchar(50) NOT NULL,
  `imagePub` varchar(100) NOT NULL,
  `dateCreationPub` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`idArticle`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`idCategorie`);

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`idClient`);

--
-- Index pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`idCommande`);

--
-- Index pour la table `descriptions`
--
ALTER TABLE `descriptions`
  ADD PRIMARY KEY (`idDescription`);

--
-- Index pour la table `details`
--
ALTER TABLE `details`
  ADD PRIMARY KEY (`idDetail`);

--
-- Index pour la table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`idPhoto`);

--
-- Index pour la table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`idPromo`);

--
-- Index pour la table `publicites`
--
ALTER TABLE `publicites`
  ADD PRIMARY KEY (`idPub`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `articles`
--
ALTER TABLE `articles`
  MODIFY `idArticle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `idCategorie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `idClient` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `idCommande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `descriptions`
--
ALTER TABLE `descriptions`
  MODIFY `idDescription` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT pour la table `details`
--
ALTER TABLE `details`
  MODIFY `idDetail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `photos`
--
ALTER TABLE `photos`
  MODIFY `idPhoto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT pour la table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `idPromo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `publicites`
--
ALTER TABLE `publicites`
  MODIFY `idPub` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
