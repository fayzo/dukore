-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2020 at 07:16 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tweet`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `comment_id` int(10) UNSIGNED NOT NULL,
  `comment` varchar(140) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_on` int(10) UNSIGNED NOT NULL,
  `comment_by` int(10) UNSIGNED NOT NULL,
  `comment_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`comment_id`, `comment`, `comment_on`, `comment_by`, `comment_at`) VALUES
(3, 'bite', 1, 1, '2019-01-08 00:00:00'),
(4, 'da', 1, 2, '2019-01-08 22:17:54'),
(7, 'sd', 1, 2, '2019-01-08 22:37:23'),
(8, 'gud', 1, 1, '2019-02-02 07:39:06');

-- --------------------------------------------------------

--
-- Table structure for table `follow`
--

CREATE TABLE `follow` (
  `follow_id` int(10) UNSIGNED NOT NULL,
  `sender` int(10) UNSIGNED NOT NULL,
  `receiver` int(10) UNSIGNED NOT NULL,
  `follow_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `follow`
--

INSERT INTO `follow` (`follow_id`, `sender`, `receiver`, `follow_on`) VALUES
(6, 1, 1, '2019-01-26 09:00:27'),
(16, 5, 3, '2019-01-26 10:40:42'),
(17, 5, 8, '2019-01-26 10:41:23'),
(19, 5, 7, '2019-01-26 11:31:07'),
(23, 2, 1, '2019-02-02 09:12:54'),
(27, 1, 5, '2019-02-06 09:46:13'),
(28, 5, 1, '2019-02-06 09:47:30'),
(29, 1, 6, '2019-02-08 19:02:00'),
(30, 1, 7, '2020-11-22 09:56:57');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `like_id` int(10) UNSIGNED NOT NULL,
  `like_by` int(10) UNSIGNED NOT NULL,
  `like_on` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`like_id`, `like_by`, `like_on`) VALUES
(37, 1, 1),
(38, 1, 2),
(40, 5, 2),
(42, 5, 1),
(43, 1, 38),
(44, 1, 45),
(45, 1, 46),
(46, 1, 51),
(47, 1, 30),
(48, 1, 56),
(49, 1, 57),
(50, 1, 54),
(51, 1, 48),
(52, 1, 123),
(53, 1, 50);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `message_id` int(10) UNSIGNED NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `message_to` int(10) UNSIGNED NOT NULL,
  `message_from` int(10) UNSIGNED NOT NULL,
  `message_on` datetime NOT NULL,
  `status` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`message_id`, `message`, `message_to`, `message_from`, `message_on`, `status`) VALUES
(19, 'amakuru', 1, 5, '2019-01-26 00:00:00', 1),
(20, 'ndaho', 5, 1, '2019-01-26 00:00:00', 1),
(21, 'birandenn', 1, 5, '2019-01-26 00:00:00', 1),
(22, 'okk', 5, 1, '2019-01-26 00:00:00', 1),
(23, 'ndaho', 0, 1, '2019-01-26 16:01:39', 0),
(24, 'nda', 0, 1, '2019-01-27 13:56:22', 0),
(25, 'dd', 5, 1, '2019-01-27 14:02:05', 1),
(26, 'bite', 2, 1, '2019-02-05 11:47:54', 1),
(27, 'ndaho', 1, 2, '2019-02-05 11:50:32', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `notification_id` int(10) UNSIGNED NOT NULL,
  `notification_for` int(11) UNSIGNED NOT NULL,
  `notification_from` int(11) UNSIGNED NOT NULL,
  `target` int(11) UNSIGNED NOT NULL,
  `type` enum('follow','retweet','likes','mention') COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` datetime NOT NULL,
  `status` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`notification_id`, `notification_for`, `notification_from`, `target`, `type`, `time`, `status`) VALUES
(18, 5, 1, 48, 'likes', '2019-02-06 08:17:25', 1),
(21, 5, 1, 37, 'retweet', '2019-02-06 08:28:43', 1),
(23, 1, 5, 122, 'mention', '2019-02-06 09:29:10', 1),
(24, 2, 5, 123, 'mention', '2019-02-06 09:29:47', 0),
(25, 5, 1, 123, 'likes', '2019-02-06 09:30:44', 1),
(26, 5, 1, 123, 'retweet', '2019-02-06 09:30:46', 1),
(27, 5, 1, 125, 'mention', '2019-02-06 09:30:57', 1),
(29, 5, 1, 5, 'follow', '2019-02-06 09:46:13', 1),
(30, 1, 5, 1, 'follow', '2019-02-06 09:47:31', 1),
(31, 6, 1, 6, 'follow', '2019-02-08 19:02:01', 0),
(32, 5, 1, 50, 'likes', '2019-02-08 19:03:07', 0),
(33, 1, 1, 52, 'retweet', '2019-02-08 19:03:16', 1),
(34, 0, 1, 127, 'mention', '2019-02-24 09:33:42', 0),
(35, 0, 1, 128, 'mention', '2019-02-24 09:57:37', 0),
(36, 0, 1, 129, 'mention', '2019-02-24 09:59:30', 0),
(37, 0, 1, 130, 'mention', '2019-02-24 10:02:08', 0),
(38, 0, 1, 131, 'mention', '2019-02-24 10:02:51', 0),
(39, 0, 1, 132, 'mention', '2019-02-24 10:04:41', 0),
(40, 0, 1, 133, 'mention', '2019-02-24 10:06:06', 0),
(41, 0, 1, 135, 'mention', '2019-02-24 10:12:11', 0),
(42, 0, 1, 136, 'mention', '2019-02-24 10:17:21', 0),
(43, 0, 1, 137, 'mention', '2019-02-24 10:24:32', 0),
(44, 0, 1, 138, 'mention', '2019-02-24 10:27:43', 0),
(45, 0, 1, 127, 'mention', '2019-03-04 20:15:03', 0),
(46, 0, 1, 128, 'mention', '2019-03-04 20:15:19', 0),
(47, 7, 1, 7, 'follow', '2020-11-22 09:56:57', 0);

-- --------------------------------------------------------

--
-- Table structure for table `trends`
--

CREATE TABLE `trends` (
  `trend_id` int(11) NOT NULL,
  `hashtag` varchar(140) COLLATE utf8mb4_unicode_ci NOT NULL,
  `create_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trends`
--

INSERT INTO `trends` (`trend_id`, `hashtag`, `create_on`) VALUES
(1, 'php', '2019-01-06 00:00:00'),
(2, 'lfllv', '2019-01-06 16:43:26'),
(3, 'kfsgk', '2019-01-06 17:32:36'),
(4, 'bite', '2019-01-07 13:11:34'),
(5, 'turaburanye', '2019-01-08 17:01:42'),
(6, 'da', '2019-01-08 17:23:47'),
(7, 'mwana', '2019-01-09 20:30:01'),
(8, 'amakuru', '2019-01-26 17:38:42'),
(9, 'df', '2019-01-26 17:39:08');

-- --------------------------------------------------------

--
-- Table structure for table `tweety`
--

CREATE TABLE `tweety` (
  `tweet_id` int(10) UNSIGNED NOT NULL,
  `status` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tweetBy` int(10) UNSIGNED NOT NULL,
  `retweet_id` int(10) UNSIGNED NOT NULL,
  `retweet_by` int(10) UNSIGNED NOT NULL,
  `tweet_image` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `likes_counts` int(10) UNSIGNED NOT NULL,
  `retweet_counts` int(10) UNSIGNED NOT NULL,
  `posted_on` datetime NOT NULL,
  `retweet_msg` varchar(140) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tweety`
--

INSERT INTO `tweety` (`tweet_id`, `status`, `tweetBy`, `retweet_id`, `retweet_by`, `tweet_image`, `likes_counts`, `retweet_counts`, `posted_on`, `retweet_msg`) VALUES
(1, 'amakuru', 1, 0, 0, 'uploads/posts/6481.jpg', 3, 1, '2019-01-06 10:03:15', ''),
(2, 'urmuntu mubi cyane', 1, 0, 0, '', 2, 0, '2019-01-06 11:30:55', ''),
(30, 'amakuru', 1, 1, 5, 'uploads/posts/6481.jpg', 3, 1, '2019-01-08 16:08:54', 'nii byiza'),
(36, 'muraho abaho @bantu #turaburanye @fayzoo', 5, 0, 0, '', 0, 2, '2019-01-08 16:01:42', ''),
(37, 'muraho abaho @bantu #turaburanye @fayzoo', 5, 36, 5, '', 0, 2, '2019-01-08 17:22:45', 'uraho'),
(38, 'dsd', 1, 0, 0, '', 1, 1, '2019-01-10 11:10:10', ''),
(40, 'dsd', 1, 38, 1, '', 0, 1, '2019-01-10 13:16:07', 'ad'),
(45, 'khaled yaze kuryama', 1, 0, 0, '', 1, 1, '2019-01-10 14:33:07', ''),
(46, 'faysal  yanze   kuniza  machine', 1, 0, 0, '', 1, 0, '2019-01-10 14:38:51', ''),
(47, 'khaled yaze kuryama', 1, 45, 1, '', 1, 1, '2019-01-10 16:25:14', 'd'),
(48, 'bite byawe', 5, 0, 0, '', 1, 3, '2019-01-11 10:38:52', ''),
(49, 'bite byawe', 5, 48, 5, '', 0, 1, '2019-01-11 10:38:52', 'ndaho msr'),
(50, 'muraho abaho @bantu #turaburanye @fayzoo', 5, 36, 1, '', 1, 2, '2019-01-08 16:01:42', 'yegoo!!!!$papa#papa'),
(51, 'amakuru', 1, 0, 0, '', 1, 0, '2019-01-26 11:47:42', ''),
(52, '#amakuru', 1, 0, 0, '', 0, 1, '2019-01-26 16:38:42', ''),
(53, 'bite', 1, 0, 0, '', 0, 0, '2019-01-26 16:39:00', ''),
(54, '#df', 1, 0, 0, '', 1, 0, '2019-01-26 16:39:08', ''),
(55, '#bite', 1, 0, 0, 'uploads/posts/3733.jpg', 0, 0, '2019-02-01 15:41:23', ''),
(56, '@dada hi', 1, 0, 0, '', 1, 0, '2019-02-02 09:10:58', ''),
(57, '#amakuru', 2, 0, 0, '', 1, 1, '2019-02-02 09:12:33', ''),
(58, '#amakuru', 2, 57, 1, '', 1, 1, '2019-02-02 09:12:33', ''),
(89, 'j', 1, 0, 0, 'uploads/posts/7651.jpg', 0, 0, '2019-02-05 10:54:05', ''),
(122, '@fayzoo', 5, 0, 0, '', 0, 0, '2019-02-06 09:29:10', ''),
(123, '@dada', 5, 0, 0, '', 1, 1, '2019-02-06 09:29:46', ''),
(124, '@dada', 5, 123, 1, '', 1, 1, '2019-02-06 09:29:46', ''),
(126, '#amakuru', 1, 52, 1, '', 0, 1, '2019-01-26 16:38:42', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `screenname` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_image` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_cover` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `followers` int(10) UNSIGNED NOT NULL,
  `following` int(10) UNSIGNED NOT NULL,
  `bio` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `website` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `screenname`, `profile_image`, `profile_cover`, `followers`, `following`, `bio`, `country`, `website`) VALUES
(1, 'fayzo', 'shema@yahoo.com', 'fayzo', 'fayzo', 'uploads/posts/236f.jpg', 'uploads/posts/4932.jpg', 3, 4, 'freelance', 'jamaica', 'http//www.jamaica.com'),
(2, 'dada', 'shemafaysal@gmail.com', 'dadada', '', '', '', 0, 1, '', '', ''),
(3, 'shema', 'shemaa@gmail.com', 'faysal', 'shema', 'uploads/profile/305fayz.jpg', 'uploads/profile/8501.jpg', 1, 0, 'freelancer', 'Rwanda', ''),
(4, 'faysal shemaa', 'shemafaysalda@gmail.com', 'dadadada', '', '', '', 0, 0, '', '', ''),
(5, 'karim', 'karim@yahoo.com', 'karim', 'karim', 'uploads/profile/838fays.gif', 'uploads/profile/681caus.jpg', 1, 4, 'web developer', 'Rwanda', ''),
(6, 'karims', 'karims@yahoo.com', 'karims', '', '', '', 1, 0, '', '', ''),
(7, 'fays', 'she@gmail.com', 'faysfafa', '', '', '', 2, 0, '', '', ''),
(8, 'karoli', 'karoli@yahoo.com', '31a440f1bc8ce121cee05b36763255a3', '', '', '', 1, 0, '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `follow`
--
ALTER TABLE `follow`
  ADD PRIMARY KEY (`follow_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`like_id`),
  ADD KEY `like_by` (`like_by`),
  ADD KEY `like_on` (`like_on`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `trends`
--
ALTER TABLE `trends`
  ADD PRIMARY KEY (`trend_id`),
  ADD UNIQUE KEY `hashtag` (`hashtag`);

--
-- Indexes for table `tweety`
--
ALTER TABLE `tweety`
  ADD PRIMARY KEY (`tweet_id`),
  ADD KEY `tweetBy` (`tweetBy`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `follow`
--
ALTER TABLE `follow`
  MODIFY `follow_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `like_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `message_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `notification_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `trends`
--
ALTER TABLE `trends`
  MODIFY `trend_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tweety`
--
ALTER TABLE `tweety`
  MODIFY `tweet_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`like_by`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`like_on`) REFERENCES `tweety` (`tweet_id`);

--
-- Constraints for table `tweety`
--
ALTER TABLE `tweety`
  ADD CONSTRAINT `tweety_ibfk_1` FOREIGN KEY (`tweetBy`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
