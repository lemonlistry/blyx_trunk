-- 项目二平台数据结构

set names 'utf8';

CREATE DATABASE /*!32312 IF NOT EXISTS*/`platform` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;

USE `platform`;

/*Table structure for table `dau` */

DROP TABLE IF EXISTS `dau`;

CREATE TABLE `dau` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `server_id` int(4) NOT NULL,
    `ts` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `openid` varchar(32) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `Index_openid_server_id` (`server_id`,`openid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `installation` */

DROP TABLE IF EXISTS `installation`;

CREATE TABLE `installation` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `openid` varchar(32) DEFAULT NULL,
    `server_id` int(4) DEFAULT NULL,
    `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `Index_openid_server_id` (`openid`,`server_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `tencent_user` */

DROP TABLE IF EXISTS `tencent_user`;

CREATE TABLE `tencent_user` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `openid` varchar(32) NOT NULL DEFAULT '',
    `nickname` varchar(1024) DEFAULT NULL,
    `gender` varchar(3) DEFAULT NULL,
    `country` varchar(100) DEFAULT NULL,
    `province` varchar(20) DEFAULT NULL,
    `city` varchar(20) DEFAULT NULL,
    `figureurl` varchar(1024) DEFAULT NULL,
    `is_yellow_vip` int(1) DEFAULT '0',
    `is_yellow_year_vip` int(1) DEFAULT '0',
    `yellow_vip_level` int(1) DEFAULT '0',
    `ip` varchar(20) DEFAULT NULL,
    `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `Index_openid` (`openid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
