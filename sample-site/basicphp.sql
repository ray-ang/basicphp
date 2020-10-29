SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_title` varchar(100) NOT NULL,
  `post_content` varchar(250) NOT NULL,
  PRIMARY KEY (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `posts` (`post_id`, `post_title`, `post_content`) VALUES
(1,	'First Title',	'Content\r\ncontent'),
(2,	'Second Title',	'Content\r\n\r\ncontent'),
(3,	'Third Title',	'Content\r\n\r\nContent');
