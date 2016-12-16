-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2016 at 06:53 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bug_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `bug`
--

CREATE TABLE `bug` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` char(64) NOT NULL,
  `description` text NOT NULL,
  `link` varchar(256) NOT NULL,
  `photo` char(255) DEFAULT NULL,
  `project_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `reported_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `resolved_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(2) UNSIGNED NOT NULL DEFAULT '11'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bug`
--

INSERT INTO `bug` (`id`, `title`, `description`, `link`, `photo`, `project_id`, `user_id`, `reported_at`, `resolved_at`, `status`) VALUES
(1, 'Load more function', 'Can not load more card asyncounously. In index.php look line 117', 'bugdb/index.php<br>github.com/blah/blah/code.php', 'betterEOF2.PNG', 1, 1, '2016-12-12 14:54:46', NULL, 11),
(6, 'Photo Upload', 'The process of photo upload never happen at the back end.', '', NULL, 1, 1, '2016-12-13 19:59:47', '2016-12-14 20:07:27', 22),
(7, 'Test', 'test', 'test', 'betterEOF2.PNG', 2, 1, '2016-12-14 11:18:34', '2016-12-14 20:05:54', 22),
(8, 'Lack of Calculus', 'Often we forgot about the fundamental, arhitmatical way.', '', NULL, 3, 1, '2016-12-15 17:46:59', '2016-12-15 10:47:13', 22);

-- --------------------------------------------------------

--
-- Table structure for table `bug_clue`
--

CREATE TABLE `bug_clue` (
  `id` int(10) UNSIGNED NOT NULL,
  `bug_id` int(10) UNSIGNED NOT NULL,
  `clue` text NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bug_clue`
--

INSERT INTO `bug_clue` (`id`, `bug_id`, `clue`, `user_id`) VALUES
(1, 1, 'Just create ajax file to grab rest of resource.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` char(128) NOT NULL,
  `description` varchar(256) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(2) UNSIGNED NOT NULL DEFAULT '11',
  `creator_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `name`, `description`, `created_at`, `status`, `creator_id`) VALUES
(1, 'Bug Database', 'The bug database web app', '2016-12-12 22:22:18', 11, 1),
(2, 'test', 'test', '2016-12-12 22:22:18', 11, 1),
(3, 'Calculate Infinite Number', 'Make possibility to calculate any decimal number, without care about number length or limitation.', '2016-12-13 19:18:52', 11, 1);

-- --------------------------------------------------------

--
-- Table structure for table `project_follower`
--

CREATE TABLE `project_follower` (
  `id` int(10) UNSIGNED NOT NULL,
  `project_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `project_log`
--

CREATE TABLE `project_log` (
  `id` int(10) UNSIGNED NOT NULL,
  `project_id` int(10) UNSIGNED NOT NULL,
  `last_report_bug` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` char(32) NOT NULL,
  `password` char(32) NOT NULL,
  `level` tinyint(2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `level`) VALUES
(1, 'beta', 'beta', 11);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bug`
--
ALTER TABLE `bug`
  ADD PRIMARY KEY (`id`),
  ADD KEY `b_project_user` (`project_id`,`user_id`) USING BTREE,
  ADD KEY `b_user_id` (`user_id`);

--
-- Indexes for table `bug_clue`
--
ALTER TABLE `bug_clue`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bc_bug_user` (`bug_id`,`user_id`),
  ADD KEY `bc_user_id` (`user_id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`),
  ADD KEY `p_user` (`creator_id`);

--
-- Indexes for table `project_follower`
--
ALTER TABLE `project_follower`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pc_project` (`project_id`),
  ADD KEY `pc_user` (`user_id`);

--
-- Indexes for table `project_log`
--
ALTER TABLE `project_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pl_project` (`project_id`),
  ADD KEY `pl_user` (`last_user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bug`
--
ALTER TABLE `bug`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `bug_clue`
--
ALTER TABLE `bug_clue`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `project_follower`
--
ALTER TABLE `project_follower`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `project_log`
--
ALTER TABLE `project_log`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `bug`
--
ALTER TABLE `bug`
  ADD CONSTRAINT `b_project_id` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`),
  ADD CONSTRAINT `b_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `bug_clue`
--
ALTER TABLE `bug_clue`
  ADD CONSTRAINT `bc_bug_id` FOREIGN KEY (`bug_id`) REFERENCES `bug` (`id`),
  ADD CONSTRAINT `bc_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `p_user_id` FOREIGN KEY (`creator_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `project_follower`
--
ALTER TABLE `project_follower`
  ADD CONSTRAINT `pc_project_id` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`),
  ADD CONSTRAINT `pc_user_id` FOREIGN KEY (`project_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `project_log`
--
ALTER TABLE `project_log`
  ADD CONSTRAINT `pl_project_id` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`),
  ADD CONSTRAINT `pl_user_id` FOREIGN KEY (`project_id`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
