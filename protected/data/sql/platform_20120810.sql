-- 添加游戏运营基础数据结构

set names 'utf8';

/*Table structure for table `statistic_old_player` */

DROP TABLE IF EXISTS `statistic_old_player`;

CREATE TABLE `statistic_old_player` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `server_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '服务器ID',
  `user_account` char(32) NOT NULL DEFAULT '' COMMENT '账号',
  `role_name` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '角色名字',
  `dt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建角色时间',
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Index_user_account` (`user_account`) USING BTREE,
  KEY `Index_server_id` (`server_id`,`dt`),
  KEY `Index_server_id_user` (`server_id`,`user_account`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci

/*Table structure for table `statistic_old_player_pay` */

DROP TABLE IF EXISTS `statistic_old_player_pay`;

CREATE TABLE `statistic_old_player_pay` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `server_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '服务器ID',
  `login_day` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '今日登录数',
  `old_player_login` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '老玩家今日登入数',
  `pay_role` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '付费总人数',
  `pay_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '付费总金额',
  `old_player_pay` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '老玩家付费人数',
  `old_player_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '老玩家付费总额',
  `date` date NOT NULL DEFAULT '0000-00-00' COMMENT '时间',
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '插入修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Index_server_id` (`server_id`,`date`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci

