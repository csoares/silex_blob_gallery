CREATE DATABASE  IF NOT EXISTS `pictureExample`;
USE `pictureExample`;

DROP TABLE IF EXISTS `ae_gallery`;
CREATE TABLE `ae_gallery` (
  `id` int(11) NOT NULL  AUTO_INCREMENT,
  `image_time` timestamp  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `data` mediumblob ,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
