-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 27, 2025 at 12:32 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quize_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `answer`
--

CREATE TABLE `answer` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer_text` varchar(255) NOT NULL,
  `is_correct` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `answer`
--

INSERT INTO `answer` (`id`, `question_id`, `answer_text`, `is_correct`) VALUES
(1, 1, 'Yaounde\'\r\n', 0),
(2, 1, 'Douala', 0),
(3, 1, 'Buea', 1),
(4, 1, 'Garoua', 0),
(9, 2, 'Pre\'venir', 0),
(10, 2, 'gue\'rir', 0),
(11, 2, 'soigner', 1),
(12, 2, 'traiter', 0),
(13, 3, '1960', 0),
(14, 3, '1958', 0),
(15, 3, '1972', 0),
(16, 3, '1961', 1),
(17, 4, '4100m', 0),
(18, 4, '390m', 0),
(21, 4, '510m', 1),
(22, 4, '585m', 0),
(23, 5, '38', 0),
(24, 5, '37', 1),
(25, 5, '40', 0),
(26, 5, '35', 0),
(27, 6, 'Ethiopia', 0),
(28, 6, 'Afrique du sud ', 0),
(29, 6, 'Cameroon', 1),
(30, 6, 'Nige\'ria', 0),
(47, 67, 'Au', 0),
(48, 67, 'a\' la', 0),
(49, 67, 'a\' l\'', 1),
(50, 67, 'l\'', 0),
(51, 68, 'Des', 0),
(52, 68, 'du', 1),
(53, 68, 'de le', 0),
(54, 68, 'le', 0),
(55, 69, 'professeur', 0),
(56, 69, 'journaliste', 0),
(57, 69, 'chirurgien', 1),
(58, 69, 'boucher', 0),
(59, 70, 'Te\'lespectateurs', 1),
(60, 70, 'Te\'lespectatrices', 0),
(61, 70, 'te\'le\'spectateur', 0),
(62, 70, 'te\'le\'spectacles', 0),
(63, 71, 'Infirme', 0),
(64, 71, 'Infirmier', 0),
(65, 71, 'infirmie\'re', 1),
(66, 71, 'infirmerie', 0),
(67, 72, 'Qui', 0),
(68, 72, 'que', 0),
(69, 72, 'dont', 1),
(70, 72, 'ou\'', 0),
(71, 73, 'Toutes', 0),
(72, 73, 'tout', 0),
(73, 73, 'tous', 1),
(74, 73, 'toute', 0),
(75, 74, 'Sous', 0),
(76, 74, 'dans', 0),
(77, 74, 'sur', 0),
(78, 74, 'en', 1),
(79, 75, 'Nouveau', 0),
(80, 75, 'nouvel', 1),
(81, 75, 'nouvelle', 0),
(82, 75, 'nouveaux', 0),
(83, 76, 'le notre', 0),
(84, 76, 'la mienne', 1),
(85, 76, 'le mien', 0),
(86, 76, 'le sien', 0),
(87, 77, 'Tokyo', 1),
(88, 77, 'Yaounde', 0),
(89, 77, 'Buea', 0),
(90, 77, 'Chirapunji', 0),
(91, 78, 'Christiano Ronaldo', 1),
(92, 78, 'Lionel Messi', 0),
(93, 78, 'Ndip Tambe', 0),
(94, 78, 'Ngoa Elton', 0),
(95, 79, 'Sergio Ramous', 0),
(96, 79, 'Acraf Hakimi', 0),
(97, 79, 'Takwi Stephen', 1),
(98, 79, 'Harry Maguire', 0),
(99, 80, '1', 0),
(100, 80, '2', 0),
(101, 80, '3', 0),
(102, 80, '4', 0),
(103, 81, 'fine', 0),
(104, 81, 'sick', 0),
(105, 81, 'tired', 0),
(106, 81, 'restless', 0),
(107, 81, 'broken hearted', 0),
(108, 81, 'sleepy', 0),
(109, 81, 'happy', 0),
(110, 81, 'sad', 0),
(111, 82, 'Rice and Beans', 0),
(112, 82, 'Koki and plantain', 0),
(113, 82, 'Garri and Eru', 0),
(114, 82, 'Fufu corn and vegetable', 0),
(115, 82, 'waterfufu and soup', 1),
(116, 83, 'Douala', 0),
(117, 83, 'Buea', 0),
(118, 83, 'Yaounde', 1);

-- --------------------------------------------------------

--
-- Table structure for table `answer1`
--

CREATE TABLE `answer1` (
  `id` int(100) NOT NULL,
  `answer_text` varchar(255) NOT NULL,
  `qeustion1_id` int(100) NOT NULL,
  `is_correct` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `answer1`
--

INSERT INTO `answer1` (`id`, `answer_text`, `qeustion1_id`, `is_correct`) VALUES
(1, 'It is a natural resource.', 1, 0),
(2, 'It is fixed in supply.', 1, 0),
(3, 'It is mobile and easily moved.', 1, 1),
(4, 'It can be improved through investment', 1, 0),
(5, 'Increase efficiency.', 2, 0),
(6, 'Reduce training costs.', 2, 0),
(7, 'Increased worker satisfaction.', 2, 0),
(8, 'Worker boredom and monotony.', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `qeustion1`
--

CREATE TABLE `qeustion1` (
  `id` int(100) NOT NULL,
  `question_text` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `qeustion1`
--

INSERT INTO `qeustion1` (`id`, `question_text`) VALUES
(1, 'Which of the following is a NOT characteristic of land as a factor of \r\nproduction?'),
(2, 'which of the following is a limitation of the division of labour?');

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `id` int(100) NOT NULL,
  `question_text` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`id`, `question_text`) VALUES
(1, 'Quelle est la premiere capitale du Cameroun Allemand?'),
(2, 'Un vaccin sert a\'____________ une maladie? '),
(3, 'En quelle anne\'e a eu lieu re\'unification au Cameroun?'),
(4, 'Quelle est la hauteur du Mont Cameroon?'),
(5, 'La tempe\'rature normale du Mont Cameroon?'),
(6, 'Quel pays abrite le sie\'ge de l\'union Africaine(UA)'),
(67, 'Nous allons__________ agence le voyage'),
(68, 'Les e\'le\'ves sont venus remettre le  de___________professeur.'),
(69, 'voici le____________qui a ope\'re\'mon pe\'re'),
(70, 'Mes chers__________bonsoir!'),
(71, 'Ma mere est_________elle soigne les malades'),
(72, 'je n\'aime pas la facon__________tu me regardes.'),
(73, 'je vais au cinema____________les samedis'),
(74, 'Le grand-pe\'re de Boni est assis__________son fauteuil en osier'),
(75, 'Mon pe\'re aconstruit un _______ immeuble'),
(76, 'Donne-moi ta gomme; j\'ai perdu__________'),
(77, 'what is the capital of japan'),
(78, 'Who is the geatest player in the world'),
(79, 'Who is the greatest defender of all time'),
(80, 'how'),
(81, 'how are u'),
(82, 'what did I eat today'),
(83, 'What is the capital of Cameroon?');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `answer1`
--
ALTER TABLE `answer1`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questions_id` (`qeustion1_id`);

--
-- Indexes for table `qeustion1`
--
ALTER TABLE `qeustion1`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answer`
--
ALTER TABLE `answer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `answer1`
--
ALTER TABLE `answer1`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `qeustion1`
--
ALTER TABLE `qeustion1`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `answer_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
