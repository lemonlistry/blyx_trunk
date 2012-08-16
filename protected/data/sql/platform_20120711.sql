set names 'utf8';

-- 黄金消费类型分布统计数据结构

DROP TABLE IF EXISTS `statistic_gold_cost_type`;

CREATE TABLE `statistic_gold_cost_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `server_id` int(11) NOT NULL DEFAULT '0' COMMENT '服务器ID',
  `type_id` int(11) NOT NULL DEFAULT '0' COMMENT '消费类型ID',
  `gold` int(11) NOT NULL DEFAULT '0' COMMENT '金币',
  `date` date NOT NULL DEFAULT '0000-00-00' COMMENT '消费时间',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `Index_serverid_date` (`server_id`,`date`),
  KEY `Index_date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='黄金消费类型分布';

-- 黄金日兑换消费统计数据结构

DROP TABLE IF EXISTS `statistic_gold_cost_exchange`;

CREATE TABLE `statistic_gold_cost_exchange` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `server_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '服务器ID',
  `total_give_gold` int(11) NOT NULL DEFAULT '0' COMMENT '截止到当前日期赠送金额',
  `give_gold` int(11) NOT NULL DEFAULT '0' COMMENT '当天赠送金额',
  `total_balance` int(11) NOT NULL DEFAULT '0' COMMENT '截止到当前日期余额',
  `balance` int(11) NOT NULL DEFAULT '0' COMMENT '当天赠送金额',
  `date` date NOT NULL DEFAULT '0000-00-00' COMMENT '当天余额',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `Index_serverid_date` (`server_id`,`date`),
  KEY `Index_date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='日黄金消费兑换';