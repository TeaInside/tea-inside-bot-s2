-- Adminer 4.3.1 MySQL dump
create database pg2ice;
use pg2ice;
SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `group_id` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `private_link` varchar(255) DEFAULT NULL,
  `msg_count` bigint(20) DEFAULT NULL,
  `creator` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`group_id`),
  KEY `username` (`username`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `group_admins`;
CREATE TABLE `group_admins` (
  `user_id` varchar(255) NOT NULL,
  `group_id` varchar(255) NOT NULL,
  `status` enum('creator','administrator') NOT NULL,
  `can_be_edited` tinyint(1) NOT NULL DEFAULT '1',
  `can_change_info` tinyint(1) NOT NULL DEFAULT '1',
  `can_delete_messages` tinyint(1) NOT NULL DEFAULT '1',
  `can_invite_users` tinyint(1) NOT NULL DEFAULT '1',
  `can_restrict_members` tinyint(1) NOT NULL DEFAULT '1',
  `can_pin_messages` tinyint(1) NOT NULL DEFAULT '1',
  `can_promote_members` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  KEY `user_id` (`user_id`),
  KEY `group_id` (`group_id`),
  CONSTRAINT `group_admins_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `group_admins_ibfk_4` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `group_history`;
CREATE TABLE `group_history` (
  `group_id` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `private_link` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  KEY `group_id` (`group_id`),
  KEY `username` (`username`),
  KEY `name` (`name`),
  CONSTRAINT `group_history_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `group_messages`;
CREATE TABLE `group_messages` (
  `message_identifier` bigint(20) NOT NULL AUTO_INCREMENT,
  `group_id` varchar(255) NOT NULL,
  `message_id` bigint(20) NOT NULL,
  `sender` varchar(255) NOT NULL,
  `type` enum('text','photo','voice','video') NOT NULL,
  `reply_to_message_id` bigint(20) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`message_identifier`),
  KEY `group_id` (`group_id`),
  KEY `sender` (`sender`),
  CONSTRAINT `group_messages_ibfk_4` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `group_messages_ibfk_5` FOREIGN KEY (`sender`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `group_messages_data`;
CREATE TABLE `group_messages_data` (
  `message_identifier` bigint(20) NOT NULL,
  `text` text,
  `file_id` varchar(255) DEFAULT NULL,
  KEY `message_identifier` (`message_identifier`),
  CONSTRAINT `group_messages_data_ibfk_1` FOREIGN KEY (`message_identifier`) REFERENCES `group_messages` (`message_identifier`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `group_settings`;
CREATE TABLE `group_settings` (
  `group_id` varchar(255) NOT NULL,
  `cycle` bigint(20) NOT NULL DEFAULT '0',
  `welcome_message` text,
  `max_warn` int(11) DEFAULT '3',
  `other_bot` tinyint(1) DEFAULT '1',
  `updated_at` datetime DEFAULT NULL,
  KEY `group_id` (`group_id`),
  CONSTRAINT `group_settings_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `private_messages`;
CREATE TABLE `private_messages` (
  `message_identifier` bigint(20) NOT NULL AUTO_INCREMENT,
  `message_id` bigint(20) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `type` enum('text','photo','voice','video') NOT NULL,
  `reply_to_message_id` bigint(20) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`message_identifier`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `private_messages_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `private_messages_data`;
CREATE TABLE `private_messages_data` (
  `message_identifier` bigint(20) NOT NULL,
  `text` text NOT NULL,
  `file_id` varchar(255) DEFAULT NULL,
  KEY `message_identifier` (`message_identifier`),
  CONSTRAINT `private_messages_data_ibfk_2` FOREIGN KEY (`message_identifier`) REFERENCES `private_messages` (`message_identifier`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `display_name` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `authority` enum('user','bot_admin','superuser') NOT NULL DEFAULT 'user',
  `is_bot` tinyint(1) NOT NULL DEFAULT '0',
  `has_private_message` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `first_name` (`first_name`),
  KEY `last_name` (`last_name`),
  KEY `display_name` (`display_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `user_history`;
CREATE TABLE `user_history` (
  `user_id` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `display_name` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  KEY `first_name` (`first_name`),
  KEY `last_name` (`last_name`),
  KEY `display_name` (`display_name`),
  KEY `user_id` (`user_id`),
  KEY `username` (`username`),
  CONSTRAINT `user_history_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- 2017-12-20 13:16:01
