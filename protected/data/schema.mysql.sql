# --------------------------------------------------------
# Host:                         127.0.0.1
# Server version:               5.1.36-community
# Server OS:                    Win32
# HeidiSQL version:             6.0.0.3603
# Date/time:                    2011-03-08 19:12:51
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
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

# Dumping data for table worklog.Assignment: ~4 rows (approximately)
/*!40000 ALTER TABLE `Assignment` DISABLE KEYS */;
INSERT INTO `Assignment` (`id`, `projectId`, `name`, `created`, `updated`, `deleted`) VALUES
	(1, 1, 'New feature x', '2010-12-27 22:30:26', '2011-01-05 06:25:36', 0),
	(2, 1, 'New feature y', '2011-03-06 16:11:19', NULL, 0),
	(3, 1, 'Feature foo', '2011-03-07 07:27:48', NULL, 0),
	(4, 1, 'Foobar', '2011-03-08 15:49:09', NULL, 0);
/*!40000 ALTER TABLE `Assignment` ENABLE KEYS */;


# Dumping structure for table worklog.Entry
CREATE TABLE IF NOT EXISTS `Entry` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `ownerId` int(10) NOT NULL,
  `assignmentId` int(10) NOT NULL,
  `comment` text NOT NULL,
  `tags` text,
  `startDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `endDate` timestamp NULL DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

# Dumping data for table worklog.Entry: ~15 rows (approximately)
/*!40000 ALTER TABLE `Entry` DISABLE KEYS */;
INSERT INTO `Entry` (`id`, `ownerId`, `assignmentId`, `comment`, `tags`, `startDate`, `endDate`, `deleted`) VALUES
	(1, 1, 1, 'Added some dummy content.', 'Array', '2010-12-26 23:55:37', NULL, 0),
	(2, 1, 2, 'Added some more dummy content.', NULL, '2011-03-06 16:11:19', NULL, 0),
	(3, 1, 3, 'Did some planning.', NULL, '2011-03-07 07:27:48', NULL, 0),
	(4, 1, 3, 'Also did some planning.', NULL, '2011-03-07 07:28:35', NULL, 0),
	(5, 1, 1, 'Doing some testing.', NULL, '2011-03-08 06:26:42', '2011-03-08 06:27:38', 0),
	(6, 1, 2, 'Doing some core development', NULL, '2011-03-08 06:29:01', '2011-03-08 06:33:19', 0),
	(7, 1, 2, 'Doing some core development', NULL, '2011-03-08 06:33:37', '2011-03-08 06:33:54', 0),
	(8, 1, 2, 'Doing some core development', NULL, '2011-03-08 06:34:17', '2011-03-08 06:34:20', 0),
	(9, 1, 3, 'Did something.', NULL, '2011-03-08 06:40:26', '2011-03-08 06:41:17', 0),
	(10, 1, 3, 'Doing some development', NULL, '2011-03-08 06:54:53', '2011-03-08 06:55:20', 0),
	(11, 1, 3, 'Doing some development', NULL, '2011-03-08 06:55:26', '2011-03-08 06:55:29', 0),
	(12, 1, 3, 'Doing some testing.', NULL, '2011-03-08 15:43:51', '2011-03-08 15:44:36', 0),
	(13, 1, 3, 'Doing some testing.', NULL, '2011-03-08 15:44:51', '2011-03-08 15:44:56', 0),
	(14, 1, 1, 'Foobar', NULL, '2011-03-08 15:48:48', '2011-03-08 15:48:52', 0),
	(15, 1, 4, 'Foo.', NULL, '2011-03-08 15:49:09', '2011-03-08 15:49:20', 0),
	(17, 1, 4, 'More foo.', NULL, '2011-03-08 17:07:26', '2011-03-08 17:07:39', 0);
/*!40000 ALTER TABLE `Entry` ENABLE KEYS */;


# Dumping structure for table worklog.EntryTag
CREATE TABLE IF NOT EXISTS `EntryTag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entryId` int(10) unsigned NOT NULL,
  `tagId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `entryId_tagId` (`entryId`,`tagId`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

# Dumping data for table worklog.EntryTag: ~32 rows (approximately)
/*!40000 ALTER TABLE `EntryTag` DISABLE KEYS */;
INSERT INTO `EntryTag` (`id`, `entryId`, `tagId`) VALUES
	(1, 2, 1),
	(2, 2, 2),
	(3, 2, 3),
	(4, 3, 1),
	(5, 3, 2),
	(6, 3, 4),
	(7, 4, 1),
	(8, 4, 2),
	(9, 4, 4),
	(10, 5, 1),
	(11, 5, 2),
	(12, 5, 5),
	(13, 6, 1),
	(14, 6, 2),
	(15, 6, 6),
	(16, 7, 1),
	(17, 7, 2),
	(18, 7, 6),
	(19, 8, 1),
	(20, 8, 2),
	(21, 8, 6),
	(22, 9, 1),
	(23, 9, 6),
	(24, 9, 7),
	(25, 10, 6),
	(26, 11, 6),
	(27, 12, 1),
	(28, 12, 5),
	(29, 13, 1),
	(30, 13, 5),
	(31, 15, 1),
	(32, 16, 1),
	(33, 17, 1),
	(34, 17, 9),
	(35, 17, 10);
/*!40000 ALTER TABLE `EntryTag` ENABLE KEYS */;


# Dumping structure for table worklog.Project
CREATE TABLE IF NOT EXISTS `Project` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parentId` int(10) DEFAULT NULL,
  `key` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

# Dumping data for table worklog.Project: ~2 rows (approximately)
/*!40000 ALTER TABLE `Project` DISABLE KEYS */;
INSERT INTO `Project` (`id`, `parentId`, `key`, `name`, `created`, `updated`, `deleted`) VALUES
	(1, 0, 'PX', 'Project x', '2010-12-26 20:08:14', '2011-03-08 06:27:55', 0),
	(2, 0, 'PY', 'Project y', '2010-12-26 22:21:01', '2011-03-08 06:36:37', 0);
/*!40000 ALTER TABLE `Project` ENABLE KEYS */;


# Dumping structure for table worklog.ProjectUser
CREATE TABLE IF NOT EXISTS `ProjectUser` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `projectId` int(10) unsigned NOT NULL,
  `userId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `projectId_userId` (`projectId`,`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

# Dumping data for table worklog.ProjectUser: ~1 rows (approximately)
/*!40000 ALTER TABLE `ProjectUser` DISABLE KEYS */;
INSERT INTO `ProjectUser` (`id`, `projectId`, `userId`) VALUES
	(1, 1, 1);
/*!40000 ALTER TABLE `ProjectUser` ENABLE KEYS */;


# Dumping structure for table worklog.Tag
CREATE TABLE IF NOT EXISTS `Tag` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

# Dumping data for table worklog.Tag: ~7 rows (approximately)
/*!40000 ALTER TABLE `Tag` DISABLE KEYS */;
INSERT INTO `Tag` (`id`, `name`) VALUES
	(1, 'foo'),
	(2, 'bar'),
	(3, 'var'),
	(4, 'planning'),
	(5, 'testing'),
	(6, 'development'),
	(7, 'feature'),
	(9, 'foobar'),
	(10, 'more');
/*!40000 ALTER TABLE `Tag` ENABLE KEYS */;


# Dumping structure for table worklog.User
CREATE TABLE IF NOT EXISTS `User` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

# Dumping data for table worklog.User: ~1 rows (approximately)
/*!40000 ALTER TABLE `User` DISABLE KEYS */;
INSERT INTO `User` (`id`, `name`, `password`, `created`, `updated`, `deleted`) VALUES
	(1, 'Admin', '63c1a25aaf63549bfcc68f8fe3910063', '2010-12-26 20:57:26', '2010-12-26 21:35:32', 0);
/*!40000 ALTER TABLE `User` ENABLE KEYS */;


# Dumping structure for table worklog.UserAccount
CREATE TABLE IF NOT EXISTS `UserAccount` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ownerId` int(10) unsigned NOT NULL,
  `firstName` varchar(255) DEFAULT NULL,
  `lastName` varchar(255) DEFAULT NULL,
  `defaultProjectId` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Dumping data for table worklog.UserAccount: ~0 rows (approximately)
/*!40000 ALTER TABLE `UserAccount` DISABLE KEYS */;
/*!40000 ALTER TABLE `UserAccount` ENABLE KEYS */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
