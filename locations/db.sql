/*

Author : Rodney Ncane
Date   : 2017-07-06
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `images`
-- ----------------------------
DROP TABLE IF EXISTS `images`;
CREATE TABLE `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location_name` varchar(50) NOT NULL,
  `image_id` bigint(21) NOT NULL DEFAULT '0',
  `image_owner` varchar(20) NOT NULL,
  `image_secret` varchar(20) NOT NULL,
  `image_server` int(11) NOT NULL,
  `image_farm` int(11) NOT NULL,
  `image_title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`,`image_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for `locations`
-- ----------------------------
DROP TABLE IF EXISTS `locations`;
CREATE TABLE `locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `term` varchar(50) NOT NULL,
  `location_id` varchar(50) NOT NULL,
  `location_name` varchar(50) NOT NULL,
  `location_address` varchar(255) DEFAULT NULL,
  `location_city` varchar(50) DEFAULT NULL,
  `location_state` varchar(50) DEFAULT NULL,
  `location_country` varchar(50) DEFAULT NULL,
  `lat` varchar(20) DEFAULT NULL,
  `lng` varchar(20) DEFAULT NULL,
  `categories` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`,`location_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` char(128) NOT NULL,
  `salt` char(128) DEFAULT NULL,
  `createdpdt` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for `user_locations`
-- ----------------------------
DROP TABLE IF EXISTS `user_locations`;
CREATE TABLE `user_locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;