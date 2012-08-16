-- 添加游戏运营基础数据结构

set names 'utf8';

DROP TABLE IF EXISTS `log_item`;

CREATE TABLE `log_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `server_id` int(11) NOT NULL DEFAULT '0' COMMENT '服务器ID',
  `user_account` varchar(32) COLLATE utf8_general_ci NOT NULL COMMENT '账号',
  `type` tinyint(3) NOT NULL DEFAULT '1' COMMENT '类型 0为获得 1为使用 2为变更 3为买卖 4 副本奖励 5 任务',
  `item_id` int(11) NOT NULL DEFAULT '0' COMMENT '物品ID',
  `num` int(11) NOT NULL DEFAULT '0' COMMENT '物品数量',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '时间',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '插入修改时间',
  PRIMARY KEY (`id`),
  KEY `Index_account` (`server_id`,`user_account`),
  KEY `Index_type` (`server_id`,`type`),
  KEY `Index_item_id` (`server_id`,`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
