-- 增加留存率表

set names 'utf8';

DROP TABLE IF EXISTS `retention_rate`;

CREATE TABLE `retention_rate` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `server_id` int(11) NOT NULL DEFAULT '0' COMMENT '服务器ID',
  `current_day` date NOT NULL DEFAULT '0000-00-00' COMMENT '登入时间',
  `compare_day` date NOT NULL DEFAULT '0000-00-00' COMMENT '注册时间',
  `num` int(11) NOT NULL DEFAULT '0' COMMENT '注册时间为compare_day 登录时间为current_day的登录人数',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `Index_server_id` (`server_id`,`current_day`,`compare_day`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='留存率'