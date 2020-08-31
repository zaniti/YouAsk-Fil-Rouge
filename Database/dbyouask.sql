-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 31, 2020 at 12:18 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbyouask`
--

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `title` varchar(1000) NOT NULL,
  `content` varchar(2000) NOT NULL,
  `code` varchar(2000) NOT NULL,
  `date` date NOT NULL,
  `report` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `title`, `content`, `code`, `date`, `report`, `user_id`, `topic_id`) VALUES
(3, 'jv jv jv ', 'hi there jv', 'code jv', '2020-07-26', 5, 1, 3),
(5, 'My first question. What do you think?', 'maamaa 3tatnii ghiir ryaaal', 'chrit biiha koora jdiiida', '2020-08-30', 1, 3, 1),
(6, 'Send multiple pdf with node.js', 'Goodmorning the javascirpt code below performs a multiple sending of pdf files via mail, in the attach array the file names and the respective paths are inserted to be sent via the nodemailer package, the code then performs a series of inserts in a db sql before sending attachments by email, when sending attachments, however, I get the following error: /mail-composer/index.js:97 contentTransferEncoding: \'contentTransferEncoding\' in attachment ? attachment.contentTransferEncoding : \'base64\' TypeError: Cannot use \'in\' operator to search for \'contentTransferEncoding\' in Allegato2.pdf What is this due to? I state that the attached files are base64 generated in the filesystem\r\n\r\nNode.js Code:', 'async function invioRapportino(FilePDf, IdRapporto, IdUtente, NumeroDocumento, IdCantiere) {\r\n\r\n    var check = true;\r\n    const EmailClienti = await EmailInvioRapportino(IdCantiere);\r\n    //Fase 1: Genero il file pdf nel filesystem\r\n    // await sql.close();\r\n    var bin = Buffer.from(FilePDf, \'base64\');\r\n    var nomeDocumentoTemporaneo = \"./rapportino.pdf\";\r\n    await fs.writeFile(nomeDocumentoTemporaneo, bin, error => {\r\n        if (error) {\r\n            check = false;\r\n            console.log(\"Rapportino.js Controller: errore generazione file pdf \")\r\n        }\r\n    });', '2020-07-28', 2, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `response`
--

CREATE TABLE `response` (
  `id` int(11) NOT NULL,
  `content` varchar(2000) NOT NULL,
  `code` varchar(2000) NOT NULL,
  `date` date NOT NULL,
  `valid` tinyint(1) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `response`
--

INSERT INTO `response` (`id`, `content`, `code`, `date`, `valid`, `user_id`, `post_id`) VALUES
(4, 'first response in this question', 'first code in this question', '2020-07-28', 1, 1, 6),
(8, 'Khabitha f lmario', 'Daz 3liha kamio', '2020-07-28', 0, 3, 5),
(10, 'I have the solution look bellow !!', 'YOU GOT\r\nPRAAAAAANKED\r\nLUL UWU', '2020-07-28', 0, 3, 6),
(15, 'khabitha fi lapiscine', 'Daz 3liha bograysin', '2020-07-28', 0, 3, 5),
(16, 'Khabitha taht lkorsi', 'Glas 3liha tabozi', '2020-07-28', 0, 3, 5),
(18, 'cs cs cs', 'code cs', '2020-07-28', 1, 3, 3),
(19, 'ksksks', 'ksksks', '2020-07-28', 0, 3, 3),
(20, 'lplplp', 'lplplp', '2020-07-28', 0, 3, 3),
(21, 'sdsdsd', 'sdsdsd', '2020-07-28', 0, 3, 3),
(22, 'qjqjqj', 'qjqjqj', '2020-07-28', 0, 3, 3),
(23, 'wxwxwx', 'wxwxwx', '2020-07-28', 0, 3, 3),
(24, 'lmlmlm', 'lmlmlm', '2020-07-28', 0, 3, 3),
(25, 'I neeeed the solution too pls', 'Help us', '2020-07-28', 0, 3, 6),
(26, 'baraka mn', 'L7MOOODA', '2020-07-28', 0, 3, 5),
(41, 'bla n', 'async function invioRapportino(FilePDf, IdRapporto, IdUtente, NumeroDocumento, IdCantiere) {\r\n    var check = true;\r\n    const EmailClienti = await EmailInvioRapportino(IdCantiere);\r\n    //Fase 1: Genero il file pdf nel filesystem\r\n    // await sql.close();\r\n    var bin = Buffer.from(FilePDf, \'base64\');\r\n    var nomeDocumentoTemporaneo = \"./rapportino.pdf\";\r\n    await fs.writeFile(nomeDocumentoTemporaneo, bin, error => {\r\n        if (error) {\r\n            check = false;\r\n            console.log(\"Rapportino.js Controller: errore generazione file pdf \")\r\n        }\r\n    });', '2020-07-29', 0, 1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `topic`
--

CREATE TABLE `topic` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `topic`
--

INSERT INTO `topic` (`id`, `name`, `img`) VALUES
(1, 'HTML5', '<i class=\"fab fa-html5\"></i>'),
(2, 'CSS3', '<i class=\"fab fa-css3-alt\"></i>'),
(3, 'JavaScript', '<i class=\"fab fa-js-square\"></i>'),
(4, 'System', '<i class=\"fas fa-laptop-code\"></i>'),
(5, 'Backend', '<i class=\"fas fa-cogs\"></i>'),
(6, 'Design', '<i class=\"fab fa-adobe\"></i>'),
(7, 'CMS', '<i class=\"fab fa-wordpress\"></i>'),
(100, 'Other', '<i class=\"fas fa-ellipsis-h\"></i>');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `photo` varchar(1000) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `firstname`, `lastname`, `photo`, `role`) VALUES
(1, 'zniti', 'anasbenziti@gmail.com', '$2y$10$KhGgxhc9SmAQiOM0jRIzkughoMTiRIqtY68EzVdIFNDq/oy0NZRdi', 'anas', 'benziti', 'rbght4w2cfwz.jpg', 'admin'),
(2, 'sketch', 'abdellah@gmail.com', '$2y$10$T6S7XNG4LlLKYSZgK2Yk9.432C02hE/zFTdfOa79T0POveL62LMeG', 'abdellah', 'daif', 'sketch.jpeg', 'user'),
(3, 'bayo', 'bayo@kamayo.com', '$2y$10$6Ab5z7XiZvB6mSgQeTK3L.U1LTFDdyUeQ72BD735QuSohfTppp19.', 'yassine', 'bayoussef', 'bayo.jpg', 'user'),
(4, 'ja3bu9', 'sami@benhababa.com', '$2y$10$KhGgxhc9SmAQiOM0jRIzkughoMTiRIqtY68EzVdIFNDq/oy0NZRdi', 'sami', 'benhababa', 'doggy.png', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `id` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `vote_score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`id`, `id_post`, `id_user`, `vote_score`) VALUES
(88, 2, 1, -1),
(98, 1, 1, 1),
(99, 4, 1, 1),
(100, 6, 1, 1),
(101, 5, 1, -1),
(102, 6, 3, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `topic_id` (`topic_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `response`
--
ALTER TABLE `response`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `topic`
--
ALTER TABLE `topic`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `response`
--
ALTER TABLE `response`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `topic`
--
ALTER TABLE `topic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1005;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id`),
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `response`
--
ALTER TABLE `response`
  ADD CONSTRAINT `response_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`),
  ADD CONSTRAINT `response_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
