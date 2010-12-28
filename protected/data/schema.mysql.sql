# --------------------------------------------------------
# Host:                         127.0.0.1
# Server version:               5.1.36-community-log
# Server OS:                    Win32
# HeidiSQL version:             6.0.0.3603
# Date/time:                    2010-12-28 02:58:12
# --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

# Dumping database structure for worklog
CREATE DATABASE IF NOT EXISTS `worklog` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `worklog`;


# Dumping structure for table worklog.Assignment
CREATE TABLE IF NOT EXISTS `Assignment` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `projectId` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `tags` text,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

# Dumping data for table worklog.Assignment: ~1 rows (approximately)
/*!40000 ALTER TABLE `Assignment` DISABLE KEYS */;
INSERT INTO `Assignment` (`id`, `projectId`, `name`, `tags`, `created`, `updated`, `deleted`) VALUES
	(1, 1, 'Task Test', 'task, test', '2010-12-27 22:30:26', '2010-12-27 23:38:09', 0);
/*!40000 ALTER TABLE `Assignment` ENABLE KEYS */;


# Dumping structure for table worklog.Entry
CREATE TABLE IF NOT EXISTS `Entry` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `ownerId` int(10) NOT NULL,
  `assignmentId` int(10) NOT NULL,
  `comment` text NOT NULL,
  `startDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `endDate` timestamp NULL DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

# Dumping data for table worklog.Entry: ~1 rows (approximately)
/*!40000 ALTER TABLE `Entry` DISABLE KEYS */;
INSERT INTO `Entry` (`id`, `ownerId`, `assignmentId`, `comment`, `startDate`, `endDate`, `deleted`) VALUES
	(1, 1, 1, 'This is for testing listing of entries.', '2010-12-26 23:55:37', NULL, 0);
/*!40000 ALTER TABLE `Entry` ENABLE KEYS */;


# Dumping structure for table worklog.Project
CREATE TABLE IF NOT EXISTS `Project` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parentId` int(10) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

# Dumping data for table worklog.Project: ~2 rows (approximately)
/*!40000 ALTER TABLE `Project` DISABLE KEYS */;
INSERT INTO `Project` (`id`, `parentId`, `name`, `created`, `updated`, `deleted`) VALUES
	(1, NULL, 'Test Project', '2010-12-26 20:08:14', '2010-12-26 22:18:53', 0),
	(2, 1, 'Test Project 2', '2010-12-26 22:21:01', '2010-12-26 22:22:08', 0);
/*!40000 ALTER TABLE `Project` ENABLE KEYS */;


# Dumping structure for table worklog.ProjectUser
CREATE TABLE IF NOT EXISTS `ProjectUser` (
  `projectId` int(10) NOT NULL,
  `userId` int(10) NOT NULL,
  PRIMARY KEY (`projectId`,`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Dumping data for table worklog.ProjectUser: ~1 rows (approximately)
/*!40000 ALTER TABLE `ProjectUser` DISABLE KEYS */;
INSERT INTO `ProjectUser` (`projectId`, `userId`) VALUES
	(1, 1);
/*!40000 ALTER TABLE `ProjectUser` ENABLE KEYS */;


# Dumping structure for table worklog.User
CREATE TABLE IF NOT EXISTS `User` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

# Dumping data for table worklog.User: ~1 rows (approximately)
/*!40000 ALTER TABLE `User` DISABLE KEYS */;
INSERT INTO `User` (`id`, `name`, `password`, `created`, `updated`, `deleted`) VALUES
	(1, 'Admin', '63c1a25aaf63549bfcc68f8fe3910063', '2010-12-26 20:57:26', '2010-12-26 21:35:32', 0);
/*!40000 ALTER TABLE `User` ENABLE KEYS */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
