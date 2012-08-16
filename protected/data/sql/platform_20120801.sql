-- 添加游戏运营基础数据结构

set names 'utf8';

/*Table structure for table `statistic_table_mark` */

DROP TABLE IF EXISTS `statistic_table_mark`;

CREATE TABLE `statistic_table_mark` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '统计类型, 1为礼金统计 2为银两统计 3为物品统计',
  `table` varchar(255) COLLATE utf8_general_ci NOT NULL COMMENT '表名',
  `index` int(11) NOT NULL DEFAULT '1' COMMENT '索引',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '插入修改时间',
  PRIMARY KEY (`id`),
  KEY `Index_type` (`table`,`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Table structure for table `log_gift_gold` */

DROP TABLE IF EXISTS `log_gift_gold`;

CREATE TABLE `log_gift_gold` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `server_id` int(11) NOT NULL DEFAULT '0' COMMENT '服务器ID',
  `user_account` varchar(32) COLLATE utf8_general_ci NOT NULL COMMENT '账号',
  `type` tinyint(3) NOT NULL DEFAULT '1' COMMENT '0 产出 1 消费',
  `children_type` varchar(50) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '子类型',
  `num` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '时间',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '插入修改时间',
  PRIMARY KEY (`id`),
  KEY `Index_account` (`server_id`,`user_account`),
  KEY `Index_type` (`server_id`,`type`),
  KEY `Index_children_type` (`server_id`,`children_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Table structure for table `statistic_vip_player`
     *黄金消费类型 0：
     *0:购买精力 1：洗髓  2：解锁包囊 3：远程打开包囊 4：加强物品 5：强化物品秒CD 6：刷新精英副本 7： 加速挂机 8：兑换银两 9：解锁秘籍方格 10：寻访
     *11：合成装备 12： 开拓荒地  13：刷新种子 14: 药园清除cd时间 15:武林大会增加挑战次数  16:武林大会请求清除CD时间 17:世界boss复活 18:世界boss鼓舞
     *19:帮会战复活 20:门派战鼓舞 21:清除日常任务cd时间 22:刷新日常任务星级 23:刷新伙伴 24:帮派战鼓舞 25:一键完成日常任务 26:用道具要花钱 27:帮会捐献 28 帮会招人
     *
     *礼金消费产出类型1：
     *0:购买精力 1：洗髓  2：解锁包囊 3：远程打开包囊 4：加强物品 5：强化物品秒CD 6：刷新精英副本 7： 加速挂机 8：兑换银两 9：解锁秘籍方格 10：寻访
     *11：合成装备 12： 开拓荒地  13：刷新种子 14: 药园清除cd时间 15:武林大会增加挑战次数  16:武林大会请求清除CD时间 17:世界boss复活 18:世界boss鼓舞
     *19:帮会战复活 20:门派战鼓舞 21:清除日常任务cd时间 22:刷新日常任务星级 23:刷新伙伴 24:帮派战鼓舞 25:一键完成日常任务 26:用道具要花钱
     *
     *银两消费产出2：
     *0：出售道具 1：副本战斗 2：挂机 3：兑换银两 4:任务奖励 5:出售秘籍 6:收获银两草 7:接收银两礼包 8:武林大会挑战 9:天罡金刚战斗
     *10:帮派俸禄 11：门派竞技战斗 12:签到 13:十大恶人 14：江湖目标
     *15:充值有礼 16：银两丹
     *17:普通洗髓 18:购买道具 19:刷新伙伴 20：强化装备 21:升级阵法 22:拜访高人
     *
     *游戏数据3：
     *0：精力消耗1：精力剩余2：强化次数3：拜访次数：4：天罡北斗阵5：精钢伏魔圈6：门派竞技7：武林大会8：十大恶人9：帮派站
     *10：主任务进度11：英雄榜12：帮派名称13：帮派职务14：登录次数 15 钱庄兑换次数 16 vip等级 17 黄钻等级 18 是否是年付
 */

DROP TABLE IF EXISTS `statistic_vip_player`;

CREATE TABLE `statistic_vip_player` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `server_id` int(11) NOT NULL DEFAULT '0' COMMENT '服务器ID',
  `user_account` varchar(32) COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '账号名',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:黄金 1：礼金 2 银两',
  `children_type` int(11) NOT NULL DEFAULT '0' COMMENT '子类类型',
  `num` int(11) NOT NULL DEFAULT '0' COMMENT '数值',
  `date` date NOT NULL DEFAULT '0000-00-00' COMMENT '日期',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '插入修改时间',
  PRIMARY KEY (`id`),
  KEY `Index_user_account` (`server_id`,`user_account`),
  KEY `Index_type` (`server_id`,`type`),
  KEY `Index_date` (`server_id`,`date`),
  KEY `Index_children_type` (`server_id`,`children_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;