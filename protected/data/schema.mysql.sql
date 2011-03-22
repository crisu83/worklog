# --------------------------------------------------------
# Host:                         127.0.0.1
# Server version:               5.1.36-community
# Server OS:                    Win32
# HeidiSQL version:             6.0.0.3603
# Date/time:                    2011-03-22 18:19:13
# --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

# Dumping database structure for worklog
CREATE DATABASE IF NOT EXISTS `worklog` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `worklog`;


# Dumping structure for table worklog.Activity
CREATE TABLE IF NOT EXISTS `Activity` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `projectId` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `updated` timestamp NULL DEFAULT NULL,
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

# Dumping data for table worklog.Activity: ~0 rows (approximately)
/*!40000 ALTER TABLE `Activity` DISABLE KEYS */;
INSERT INTO `Activity` (`id`, `projectId`, `name`, `created`, `updated`, `deleted`) VALUES
	(1, 1, 'Daily Scrum', '2011-03-22 09:43:45', NULL, 0);
/*!40000 ALTER TABLE `Activity` ENABLE KEYS */;


# Dumping structure for table worklog.Entry
CREATE TABLE IF NOT EXISTS `Entry` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ownerId` int(10) unsigned NOT NULL,
  `activityId` int(10) unsigned NOT NULL,
  `comment` text NOT NULL,
  `tags` text,
  `startDate` timestamp NULL DEFAULT NULL,
  `endDate` timestamp NULL DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `updated` timestamp NULL DEFAULT NULL,
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

# Dumping data for table worklog.Entry: ~0 rows (approximately)
/*!40000 ALTER TABLE `Entry` DISABLE KEYS */;
INSERT INTO `Entry` (`id`, `ownerId`, `activityId`, `comment`, `tags`, `startDate`, `endDate`, `created`, `updated`, `deleted`) VALUES
	(1, 1, 1, 'Attended the meeting.', NULL, '2011-03-22 09:43:45', '2011-03-22 09:43:56', NULL, NULL, 0),
	(2, 1, 1, 'Attended the meeting.', NULL, '2011-03-22 09:44:11', '2011-03-22 09:44:15', NULL, NULL, 0),
	(3, 1, 1, 'Attended the meeting.', NULL, '2011-03-22 09:45:31', '2011-03-22 09:45:34', NULL, NULL, 0);
/*!40000 ALTER TABLE `Entry` ENABLE KEYS */;


# Dumping structure for table worklog.EntryTag
CREATE TABLE IF NOT EXISTS `EntryTag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entryId` int(10) unsigned NOT NULL,
  `tagId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `entryId_tagId` (`entryId`,`tagId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

# Dumping data for table worklog.EntryTag: ~0 rows (approximately)
/*!40000 ALTER TABLE `EntryTag` DISABLE KEYS */;
INSERT INTO `EntryTag` (`id`, `entryId`, `tagId`) VALUES
	(1, 1, 4),
	(2, 2, 4),
	(3, 3, 4);
/*!40000 ALTER TABLE `EntryTag` ENABLE KEYS */;


# Dumping structure for table worklog.Project
CREATE TABLE IF NOT EXISTS `Project` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parentId` int(10) unsigned DEFAULT NULL,
  `key` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `updated` timestamp NULL DEFAULT NULL,
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

# Dumping data for table worklog.Project: ~0 rows (approximately)
/*!40000 ALTER TABLE `Project` DISABLE KEYS */;
INSERT INTO `Project` (`id`, `parentId`, `key`, `name`, `created`, `updated`, `deleted`) VALUES
	(1, 0, 'PX', 'Project X', '2011-03-22 09:00:02', NULL, 0),
	(2, 0, 'PY', 'Project Y', '2011-03-22 09:00:09', NULL, 0),
	(3, 1, 'PZ', 'Project Z', '2011-03-22 09:00:18', '2011-03-22 09:00:33', 0);
/*!40000 ALTER TABLE `Project` ENABLE KEYS */;


# Dumping structure for table worklog.ProjectUser
CREATE TABLE IF NOT EXISTS `ProjectUser` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `projectId` int(10) unsigned NOT NULL,
  `userId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `contextId_userId` (`projectId`,`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Dumping data for table worklog.ProjectUser: ~0 rows (approximately)
/*!40000 ALTER TABLE `ProjectUser` DISABLE KEYS */;
/*!40000 ALTER TABLE `ProjectUser` ENABLE KEYS */;


# Dumping structure for table worklog.Tag
CREATE TABLE IF NOT EXISTS `Tag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `categoryId` int(10) unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

# Dumping data for table worklog.Tag: ~0 rows (approximately)
/*!40000 ALTER TABLE `Tag` DISABLE KEYS */;
INSERT INTO `Tag` (`id`, `categoryId`, `name`) VALUES
	(1, 2, 'Enhancement'),
	(2, 2, 'BugFix'),
	(3, 2, 'Feature'),
	(4, 2, 'Meeting'),
	(5, 3, 'Overtime');
/*!40000 ALTER TABLE `Tag` ENABLE KEYS */;


# Dumping structure for table worklog.TagCategory
CREATE TABLE IF NOT EXISTS `TagCategory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# Dumping data for table worklog.TagCategory: 0 rows
/*!40000 ALTER TABLE `TagCategory` DISABLE KEYS */;
INSERT INTO `TagCategory` (`id`, `name`) VALUES
	(1, 'Global'),
	(2, 'IssueType'),
	(3, 'WorkType');
/*!40000 ALTER TABLE `TagCategory` ENABLE KEYS */;


# Dumping structure for table worklog.User
CREATE TABLE IF NOT EXISTS `User` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `updated` timestamp NULL DEFAULT NULL,
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

# Dumping data for table worklog.User: ~0 rows (approximately)
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
