CREATE DATABASE  IF NOT EXISTS `pictureExample`;
USE `pictureExample`;

DROP TABLE IF EXISTS `ae_gallery`;
CREATE TABLE `ae_gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(64) CHARACTER SET utf8 NOT NULL,
  `ext` varchar(8) CHARACTER SET utf8 NOT NULL,
  `image_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `data` mediumblob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
