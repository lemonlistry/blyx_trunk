set names 'utf8';

-- 日注册登录统计数据结构

DROP TABLE IF EXISTS `statistic_register_login`;

CREATE TABLE `statistic_register_login` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `server_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '服务器ID',
  `create_tot` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建角色数',
  `register_tot` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '截止到当日注册人数',
  `login_tot` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '截止到当日登录人数',
  `more_than_ten_tot` int(10) unsigned NOT NULL DEFAULT '0',
  `moren_than_thirty_tot` int(10) unsigned NOT NULL DEFAULT '0',
  `create_day` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '当天新增创建角色数',
  `register_day` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '当天注册人数',
  `login_day` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '当日登录人数',
  `more_than_ten_day` int(11) NOT NULL DEFAULT '0',
  `moren_than_thirty_day` int(10) unsigned NOT NULL DEFAULT '0',
  `date` date NOT NULL DEFAULT '0000-00-00' COMMENT '日期',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Index_server_id_date` (`server_id`,`date`),
  KEY `Index_date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8