-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 30, 2018 at 11:33 AM
-- Server version: 10.1.33-MariaDB
-- PHP Version: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shopecommercewebsite`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Ordering` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `Name`, `Description`, `Ordering`) VALUES
(1, 'Electrical Appliances', ' appliance is an electrical/mechanical machine which accomplishes household functions, such as cooking or cleaning. ', 1),
(2, 'Mobile Phone', 'is a portable telephone that can make and receive calls over a radio frequency link while the user is moving within a telephone service area', 2),
(3, 'Clothes', 'Includes clothing for all sectors of society', 3),
(5, 'Electronics', 'is the discipline dealing with the development and application of devices and systems involving the flow of electrons in a vacuum, in gaseous media, and in semiconductors', 2);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `c_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `comment_date` date NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`c_id`, `comment`, `status`, `comment_date`, `item_id`, `user_id`) VALUES
(0, 'very nice \r\nI want this', 0, '2018-07-27', 56, 4);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `Item_ID` int(11) NOT NULL,
  `Name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Description` text CHARACTER SET utf8 NOT NULL,
  `Price` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Add_Date` date NOT NULL,
  `Country_Made` varchar(255) CHARACTER SET utf8 NOT NULL,
  `image` varchar(255) CHARACTER SET utf8 NOT NULL,
  `status` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Rating` smallint(6) NOT NULL,
  `Approve` tinyint(4) NOT NULL DEFAULT '0',
  `Cat_id` int(11) NOT NULL,
  `Member_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`Item_ID`, `Name`, `Description`, `Price`, `Add_Date`, `Country_Made`, `image`, `status`, `Rating`, `Approve`, `Cat_id`, `Member_ID`) VALUES
(37, 'hp laptops i7', ' high quality', '200', '2018-07-26', 'USA', 'laptop1.jpg', '1', 0, 1, 5, 2),
(38, 'laptop lenovo', 'very good ', '350', '2018-07-26', 'USA', 'lap2.jpg', '1', 0, 1, 5, 2),
(39, 'mouse', 'very good mouse', '7', '2018-07-26', 'USA', 'mouse.jpg', '2', 0, 1, 5, 2),
(40, 'keyboard', 'very good keyboard', '20', '2018-07-26', 'USA', 'keyboard.jpg', '1', 0, 1, 5, 2),
(42, 'screen tv', 'very good ', '400', '2018-07-26', 'USA', 'screentv.jpg', '1', 0, 0, 1, 4),
(43, 'mouse', 'very good', '10', '2018-07-26', 'USA', 'mo2.jpg', '1', 0, 1, 5, 4),
(44, 'Washer', ' high quality', '300', '2018-07-26', 'USA', 'Washer.jpg', '1', 0, 1, 1, 4),
(47, 'microwave', '1100 watts of cooking power with 10 power levels', '70', '2018-07-26', 'USA', 'microwave.jpg', '1', 0, 1, 1, 4),
(48, 'iron', 'In testing I was working for over 450 hours. That&#39;s a lot of freshly ironed shirts', '100', '2018-07-26', 'USA', 'iron.jpg', '2', 0, 1, 1, 4),
(51, 'Huawei Y7 Prime 2018 ', 'runs on the fast and powerful Android 8.0 operating system', '100', '2018-07-26', 'China', 'Huawei-Enjoy-8-2-600x450.jpg', '1', 0, 1, 2, 4),
(53, 'huawei nova 2i', 'Nova 2i (RNE-L02) 4GB/64GB 5.9-inches Factory Unlocked - International Stock ', '200', '2018-07-26', 'China', 'n2.jpg', '1', 0, 1, 2, 2),
(54, 't-shirt ', 't-shirt of high quality cotton', '10', '2018-07-26', 'China', 't-shirt3.jpg', '1', 0, 1, 3, 5),
(55, 't-shirt ', 't-shirt of high quality cotton', '10', '2018-07-26', 'China', 't-shirt.jpg', '1', 0, 1, 3, 5),
(56, 'Dress', ' Elegant dress and gorgeous ', '100', '2018-07-26', 'China', 'women-s-glamour-sequin-sweetheart-neckline-long-prom-dress.jpg', '1', 0, 1, 3, 5),
(60, 'hair dryer ', '2400 Watt is a high power hair dryer putting professional power', '100', '2018-07-27', 'USA', 'Hair dryer.jpg', '1', 0, 1, 1, 1),
(61, 't-shirt', ' high quality', '7', '2018-07-27', 'China', '2103219_1364.jpg', '1', 0, 1, 3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `FullName` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `GroupID` int(11) NOT NULL DEFAULT '0',
  `RegStatus` int(11) NOT NULL DEFAULT '0',
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `FullName`, `Password`, `Email`, `GroupID`, `RegStatus`, `Date`) VALUES
(1, 'Dalal', 'DalalBassam', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'dalalbassam1@gmail.com', 1, 1, '0000-00-00'),
(2, 'AyaAhmad', 'AyaAhmad', '601f1889667efaebb33b8c12572835da3f027f78', 'Aya@gmail.com', 0, 1, '2018-07-14'),
(3, 'Rana', 'RanaAhmad', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Rana@gmail.com', 0, 1, '2018-07-28'),
(4, 'Yara', 'YaraAli', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Yara@gmail.com', 0, 1, '2018-07-26'),
(5, 'Sana', 'SanaOmar', 'df2983700ffecb52e6649f0cb3981b66537083a4', 'Sana@gmail.com', 0, 1, '2018-07-26'),
(6, 'Amal', 'AmalBassam', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Amal@gmail.com', 0, 1, '2018-07-28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `items_comment` (`item_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`Item_ID`),
  ADD KEY `cat_1` (`Cat_id`),
  ADD KEY `Member_ID` (`Member_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `Item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `items_comment` FOREIGN KEY (`item_id`) REFERENCES `items` (`Item_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `cat_1` FOREIGN KEY (`Cat_id`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`Member_ID`) REFERENCES `users` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
