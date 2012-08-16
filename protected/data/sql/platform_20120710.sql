-- 添加游戏运营基础数据结构

set names 'utf8';

/*Table structure for table `accelerate_auto_fighting` */

DROP TABLE IF EXISTS `accelerate_auto_fighting`;

CREATE TABLE `accelerate_auto_fighting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `role_level` int(11) NOT NULL DEFAULT '0',
  `gold` int(11) NOT NULL DEFAULT '0',
  `gift_gold` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `accept_task` */

DROP TABLE IF EXISTS `accept_task`;

CREATE TABLE `accept_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `role_level` int(11) NOT NULL DEFAULT '0',
  `task` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `add_challenge_times` */

DROP TABLE IF EXISTS `add_challenge_times`;

CREATE TABLE `add_challenge_times` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `role_level` int(11) NOT NULL DEFAULT '0',
  `gold` int(11) NOT NULL DEFAULT '0',
  `gift_gold` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `add_faction_exp` */

DROP TABLE IF EXISTS `add_faction_exp`;

CREATE TABLE `add_faction_exp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `faction_id` int(11) NOT NULL DEFAULT '0',
  `experience` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `add_friend` */

DROP TABLE IF EXISTS `add_friend`;

CREATE TABLE `add_friend` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `auto_finish_daily_task` */

DROP TABLE IF EXISTS `auto_finish_daily_task`;

CREATE TABLE `auto_finish_daily_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `role_level` int(11) NOT NULL DEFAULT '0',
  `task_id` int(11) NOT NULL DEFAULT '0',
  `star_rate` int(11) NOT NULL DEFAULT '0',
  `silver` int(11) NOT NULL DEFAULT '0',
  `experience` int(11) NOT NULL DEFAULT '0',
  `gift_gold` int(11) NOT NULL DEFAULT '0',
  `gold` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `buy_item` */

DROP TABLE IF EXISTS `buy_item`;

CREATE TABLE `buy_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `item_id` int(11) NOT NULL DEFAULT '0',
  `item_num` int(11) NOT NULL DEFAULT '0',
  `silver` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `buy_vitality` */

DROP TABLE IF EXISTS `buy_vitality`;

CREATE TABLE `buy_vitality` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `role_level` int(11) NOT NULL DEFAULT '0',
  `gold` int(11) NOT NULL DEFAULT '0',
  `gift_gold` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `challenge_opponent` */

DROP TABLE IF EXISTS `challenge_opponent`;

CREATE TABLE `challenge_opponent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `silver` int(11) NOT NULL DEFAULT '0',
  `reputation` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `clear_challenge_cd` */

DROP TABLE IF EXISTS `clear_challenge_cd`;

CREATE TABLE `clear_challenge_cd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `role_level` int(11) NOT NULL DEFAULT '0',
  `gold` int(11) NOT NULL DEFAULT '0',
  `gift_gold` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `clear_daily_task_cd` */

DROP TABLE IF EXISTS `clear_daily_task_cd`;

CREATE TABLE `clear_daily_task_cd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `parter_id` int(11) NOT NULL DEFAULT '0',
  `gold` int(11) NOT NULL DEFAULT '0',
  `gift_gold` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `clear_earth_cd` */

DROP TABLE IF EXISTS `clear_earth_cd`;

CREATE TABLE `clear_earth_cd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `role_level` int(11) NOT NULL DEFAULT '0',
  `gold` int(11) NOT NULL DEFAULT '0',
  `gift_gold` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `clear_strengthen_cd` */

DROP TABLE IF EXISTS `clear_strengthen_cd`;

CREATE TABLE `clear_strengthen_cd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `role_level` int(11) NOT NULL DEFAULT '0',
  `gold` int(11) NOT NULL DEFAULT '0',
  `gift_gold` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `command` */

DROP TABLE IF EXISTS `command`;

CREATE TABLE `command` (
  `id` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `create_faction` */

DROP TABLE IF EXISTS `create_faction`;

CREATE TABLE `create_faction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `faction_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `create_role` */

DROP TABLE IF EXISTS `create_role`;

CREATE TABLE `create_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `role_type` int(11) NOT NULL DEFAULT '0',
  `vip_level` int(11) NOT NULL DEFAULT '0',
  `yellow_vip_level` int(11) NOT NULL DEFAULT '0',
  `year_vip_level` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `delete_friend` */

DROP TABLE IF EXISTS `delete_friend`;

CREATE TABLE `delete_friend` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `dismiss_faction` */

DROP TABLE IF EXISTS `dismiss_faction`;

CREATE TABLE `dismiss_faction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `faction_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `donate_to_faction` */

DROP TABLE IF EXISTS `donate_to_faction`;

CREATE TABLE `donate_to_faction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `role_level` int(11) NOT NULL DEFAULT '0',
  `gold` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `encourage_in_clan_fight` */

DROP TABLE IF EXISTS `encourage_in_clan_fight`;

CREATE TABLE `encourage_in_clan_fight` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `role_level` int(11) NOT NULL DEFAULT '0',
  `gold` int(11) NOT NULL DEFAULT '0',
  `gift_gold` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `encourage_in_faction` */

DROP TABLE IF EXISTS `encourage_in_faction`;

CREATE TABLE `encourage_in_faction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `role_level` int(11) NOT NULL DEFAULT '0',
  `round` int(11) NOT NULL DEFAULT '0',
  `scene_id` int(11) NOT NULL DEFAULT '0',
  `gold` int(11) NOT NULL DEFAULT '0',
  `gift_gold` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `encourage_in_world_boss` */

DROP TABLE IF EXISTS `encourage_in_world_boss`;

CREATE TABLE `encourage_in_world_boss` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `role_level` int(11) NOT NULL DEFAULT '0',
  `scene_id` int(11) NOT NULL DEFAULT '0',
  `gold` int(11) NOT NULL DEFAULT '0',
  `gift_gold` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `enter_clan_battle` */

DROP TABLE IF EXISTS `enter_clan_battle`;

CREATE TABLE `enter_clan_battle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `party_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `enter_map` */

DROP TABLE IF EXISTS `enter_map`;

CREATE TABLE `enter_map` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `from_scene_id` int(11) NOT NULL DEFAULT '0',
  `to_scene_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `exchange_silver` */

DROP TABLE IF EXISTS `exchange_silver`;

CREATE TABLE `exchange_silver` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `role_level` int(11) NOT NULL DEFAULT '0',
  `gold` int(11) NOT NULL DEFAULT '0',
  `gift_gold` int(11) NOT NULL DEFAULT '0',
  `silver` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `exit_game` */

DROP TABLE IF EXISTS `exit_game`;

CREATE TABLE `exit_game` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `role_type` int(11) NOT NULL DEFAULT '0',
  `vip_level` int(11) NOT NULL DEFAULT '0',
  `yellow_vip_level` int(11) NOT NULL DEFAULT '0',
  `year_vip_level` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `fetch_auto_fighting_dungeon_award` */

DROP TABLE IF EXISTS `fetch_auto_fighting_dungeon_award`;

CREATE TABLE `fetch_auto_fighting_dungeon_award` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `transcript_type` int(11) NOT NULL DEFAULT '0',
  `silver` int(11) NOT NULL DEFAULT '0',
  `gift_gold` int(11) NOT NULL DEFAULT '0',
  `experience` int(11) NOT NULL DEFAULT '0',
  `cultivation` int(11) NOT NULL DEFAULT '0',
  `vitality` int(11) NOT NULL DEFAULT '0',
  `items` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `fetch_auto_finishing_dungeon__award` */

DROP TABLE IF EXISTS `fetch_auto_finishing_dungeon__award`;

CREATE TABLE `fetch_auto_finishing_dungeon__award` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `transcript_type` int(11) NOT NULL DEFAULT '0',
  `silver` int(11) NOT NULL DEFAULT '0',
  `gift_gold` int(11) NOT NULL DEFAULT '0',
  `experience` int(11) NOT NULL DEFAULT '0',
  `cultivation` int(11) NOT NULL DEFAULT '0',
  `items` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `fetch_faction_salary` */

DROP TABLE IF EXISTS `fetch_faction_salary`;

CREATE TABLE `fetch_faction_salary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `silver` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `fetch_fighting_dungeon_award` */

DROP TABLE IF EXISTS `fetch_fighting_dungeon_award`;

CREATE TABLE `fetch_fighting_dungeon_award` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `transcript_type` int(11) NOT NULL DEFAULT '0',
  `silver` int(11) NOT NULL DEFAULT '0',
  `gift_gold` int(11) NOT NULL DEFAULT '0',
  `experience` int(11) NOT NULL DEFAULT '0',
  `cultivation` int(11) NOT NULL DEFAULT '0',
  `items` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `fetch_finishing_dungeon_award` */

DROP TABLE IF EXISTS `fetch_finishing_dungeon_award`;

CREATE TABLE `fetch_finishing_dungeon_award` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `transcript_type` int(11) NOT NULL DEFAULT '0',
  `silver` int(11) NOT NULL DEFAULT '0',
  `gift_gold` int(11) NOT NULL DEFAULT '0',
  `experience` int(11) NOT NULL DEFAULT '0',
  `cultivation` int(11) NOT NULL DEFAULT '0',
  `items` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `fight_in_clan_fight` */

DROP TABLE IF EXISTS `fight_in_clan_fight`;

CREATE TABLE `fight_in_clan_fight` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `parter_id` int(11) NOT NULL DEFAULT '0',
  `silver` int(11) NOT NULL DEFAULT '0',
  `reputation` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `fight_with_demons` */

DROP TABLE IF EXISTS `fight_with_demons`;

CREATE TABLE `fight_with_demons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `team_id` int(11) NOT NULL DEFAULT '0',
  `silver` int(11) NOT NULL DEFAULT '0',
  `experience` int(11) NOT NULL DEFAULT '0',
  `items` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `fight_world_boss` */

DROP TABLE IF EXISTS `fight_world_boss`;

CREATE TABLE `fight_world_boss` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `scene_id` int(11) NOT NULL DEFAULT '0',
  `silver` int(11) NOT NULL DEFAULT '0',
  `experience` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `get_ready_to_fight_in_clan_battle` */

DROP TABLE IF EXISTS `get_ready_to_fight_in_clan_battle`;

CREATE TABLE `get_ready_to_fight_in_clan_battle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `party_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `harvest_medicine` */

DROP TABLE IF EXISTS `harvest_medicine`;

CREATE TABLE `harvest_medicine` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `role_level` int(11) NOT NULL DEFAULT '0',
  `vip_level` int(11) NOT NULL DEFAULT '0',
  `crop_id` int(11) NOT NULL DEFAULT '0',
  `crop_index` int(11) NOT NULL DEFAULT '0',
  `experience` int(11) NOT NULL DEFAULT '0',
  `silver` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `join_clan` */

DROP TABLE IF EXISTS `join_clan`;

CREATE TABLE `join_clan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `party_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `leave_clan_battle` */

DROP TABLE IF EXISTS `leave_clan_battle`;

CREATE TABLE `leave_clan_battle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `party_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `login_game` */

DROP TABLE IF EXISTS `login_game`;

CREATE TABLE `login_game` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `role_type` int(11) NOT NULL DEFAULT '0',
  `vip_level` int(11) NOT NULL DEFAULT '0',
  `yellow_vip_level` int(11) NOT NULL DEFAULT '0',
  `year_vip_level` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `make_faction_contribution` */

DROP TABLE IF EXISTS `make_faction_contribution`;

CREATE TABLE `make_faction_contribution` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `faction_contribute` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `meditation` */

DROP TABLE IF EXISTS `meditation`;

CREATE TABLE `meditation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `plant_medicine` */

DROP TABLE IF EXISTS `plant_medicine`;

CREATE TABLE `plant_medicine` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `parter_id` int(11) NOT NULL DEFAULT '0',
  `crop_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `receive_gift_bag` */

DROP TABLE IF EXISTS `receive_gift_bag`;

CREATE TABLE `receive_gift_bag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `role_level` int(11) NOT NULL DEFAULT '0',
  `scene_id` int(11) NOT NULL DEFAULT '0',
  `award_id` int(11) NOT NULL DEFAULT '0',
  `silver` int(11) NOT NULL DEFAULT '0',
  `gift_gold` int(11) NOT NULL DEFAULT '0',
  `reputation` int(11) NOT NULL DEFAULT '0',
  `vitality` int(11) NOT NULL DEFAULT '0',
  `experience` int(11) NOT NULL DEFAULT '0',
  `cultivation` int(11) NOT NULL DEFAULT '0',
  `items` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `recharge` */

DROP TABLE IF EXISTS `recharge`;

CREATE TABLE `recharge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `role_level` int(11) NOT NULL DEFAULT '0',
  `gold` int(11) NOT NULL DEFAULT '0',
  `vip_level` int(11) NOT NULL DEFAULT '0',
  `yellow_vip_level` int(11) NOT NULL DEFAULT '0',
  `year_vip_level` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `refresh_daily_task` */

DROP TABLE IF EXISTS `refresh_daily_task`;

CREATE TABLE `refresh_daily_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `role_level` int(11) NOT NULL DEFAULT '0',
  `gold` int(11) NOT NULL DEFAULT '0',
  `gift_gold` int(11) NOT NULL DEFAULT '0',
  `tasks` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `refresh_elite_dungeon` */

DROP TABLE IF EXISTS `refresh_elite_dungeon`;

CREATE TABLE `refresh_elite_dungeon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `gold` int(11) NOT NULL DEFAULT '0',
  `gift_gold` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `refresh_partner` */

DROP TABLE IF EXISTS `refresh_partner`;

CREATE TABLE `refresh_partner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `role_level` int(11) NOT NULL DEFAULT '0',
  `parter_id` int(11) NOT NULL DEFAULT '0',
  `parter_quality` int(11) NOT NULL DEFAULT '0',
  `type` int(11) NOT NULL DEFAULT '0',
  `silver` int(11) NOT NULL DEFAULT '0',
  `gold` int(11) NOT NULL DEFAULT '0',
  `gift_gold` int(11) NOT NULL DEFAULT '0',
  `success` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `refresh_seed` */

DROP TABLE IF EXISTS `refresh_seed`;

CREATE TABLE `refresh_seed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `role_level` int(11) NOT NULL DEFAULT '0',
  `crop_id` int(11) NOT NULL DEFAULT '0',
  `vip_level` int(11) NOT NULL DEFAULT '0',
  `gold` int(11) NOT NULL DEFAULT '0',
  `gift_gold` int(11) NOT NULL DEFAULT '0',
  `quality` int(11) NOT NULL DEFAULT '0',
  `new_quality` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `remote_open_package` */

DROP TABLE IF EXISTS `remote_open_package`;

CREATE TABLE `remote_open_package` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `role_level` int(11) NOT NULL DEFAULT '0',
  `container_id` int(11) NOT NULL DEFAULT '0',
  `gold` int(11) NOT NULL DEFAULT '0',
  `gift_gold` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `reply_faction_application` */

DROP TABLE IF EXISTS `reply_faction_application`;

CREATE TABLE `reply_faction_application` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `faction_id` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `applicant_id` int(11) NOT NULL DEFAULT '0',
  `approve` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `revive_in_world_boss` */

DROP TABLE IF EXISTS `revive_in_world_boss`;

CREATE TABLE `revive_in_world_boss` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `scene_id` int(11) NOT NULL DEFAULT '0',
  `role_level` int(11) NOT NULL DEFAULT '0',
  `gold` int(11) NOT NULL DEFAULT '0',
  `gift_gold` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `rivive_in_faction_battle` */

DROP TABLE IF EXISTS `rivive_in_faction_battle`;

CREATE TABLE `rivive_in_faction_battle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `role_level` int(11) NOT NULL DEFAULT '0',
  `gold` int(11) NOT NULL DEFAULT '0',
  `gift_gold` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `seek_hight_level_master` */

DROP TABLE IF EXISTS `seek_hight_level_master`;

CREATE TABLE `seek_hight_level_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `role_level` int(11) NOT NULL DEFAULT '0',
  `gold` int(11) NOT NULL DEFAULT '0',
  `gift_gold` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `sell_book` */

DROP TABLE IF EXISTS `sell_book`;

CREATE TABLE `sell_book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `role_level` int(11) NOT NULL DEFAULT '0',
  `book_id` int(11) NOT NULL DEFAULT '0',
  `silver` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `sell_item` */

DROP TABLE IF EXISTS `sell_item`;

CREATE TABLE `sell_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `item_id` int(11) NOT NULL DEFAULT '0',
  `item_num` int(11) NOT NULL DEFAULT '0',
  `silver` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `send_faction_enrollment_notification` */

DROP TABLE IF EXISTS `send_faction_enrollment_notification`;

CREATE TABLE `send_faction_enrollment_notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `role_level` int(11) NOT NULL DEFAULT '0',
  `gold` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `signup` */

DROP TABLE IF EXISTS `signup`;

CREATE TABLE `signup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `parter_id` int(11) NOT NULL DEFAULT '0',
  `sign_times` int(11) NOT NULL DEFAULT '0',
  `silver` int(11) NOT NULL DEFAULT '0',
  `gift_gold` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `signup_in_faction_battle` */

DROP TABLE IF EXISTS `signup_in_faction_battle`;

CREATE TABLE `signup_in_faction_battle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `faction_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `stop_fight_in_clan_clan_battle` */

DROP TABLE IF EXISTS `stop_fight_in_clan_clan_battle`;

CREATE TABLE `stop_fight_in_clan_clan_battle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `party_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `strengthen_item` */

DROP TABLE IF EXISTS `strengthen_item`;

CREATE TABLE `strengthen_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `role_level` int(11) NOT NULL DEFAULT '0',
  `database_id` int(11) NOT NULL DEFAULT '0',
  `vip_level` int(11) NOT NULL DEFAULT '0',
  `ratio` int(11) NOT NULL DEFAULT '0',
  `gold` int(11) NOT NULL DEFAULT '0',
  `gift_gold` int(11) NOT NULL DEFAULT '0',
  `silver` int(11) NOT NULL DEFAULT '0',
  `success` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `study_book` */

DROP TABLE IF EXISTS `study_book`;

CREATE TABLE `study_book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `book_id` int(11) NOT NULL DEFAULT '0',
  `knowledge` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `submit_task` */

DROP TABLE IF EXISTS `submit_task`;

CREATE TABLE `submit_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `role_level` int(11) NOT NULL DEFAULT '0',
  `task_id` int(11) NOT NULL DEFAULT '0',
  `star_rate` int(11) NOT NULL DEFAULT '0',
  `silver` int(11) NOT NULL DEFAULT '0',
  `experience` int(11) NOT NULL DEFAULT '0',
  `items` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `synthesis_equipment` */

DROP TABLE IF EXISTS `synthesis_equipment`;

CREATE TABLE `synthesis_equipment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `role_level` int(11) NOT NULL DEFAULT '0',
  `item_id` int(11) NOT NULL DEFAULT '0',
  `gold` int(11) NOT NULL DEFAULT '0',
  `gift_gold` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `unlock_book_slot` */

DROP TABLE IF EXISTS `unlock_book_slot`;

CREATE TABLE `unlock_book_slot` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `role_level` int(11) NOT NULL DEFAULT '0',
  `gold` int(11) NOT NULL DEFAULT '0',
  `gift_gold` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `unlock_earth` */

DROP TABLE IF EXISTS `unlock_earth`;

CREATE TABLE `unlock_earth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `role_level` int(11) NOT NULL DEFAULT '0',
  `gold` int(11) NOT NULL DEFAULT '0',
  `gift_gold` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `unlock_package_slot` */

DROP TABLE IF EXISTS `unlock_package_slot`;

CREATE TABLE `unlock_package_slot` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `role_level` int(11) NOT NULL DEFAULT '0',
  `container_id` int(11) NOT NULL DEFAULT '0',
  `open_num` int(11) NOT NULL DEFAULT '0',
  `gold` int(11) NOT NULL DEFAULT '0',
  `gift_gold` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `upgrade_book` */

DROP TABLE IF EXISTS `upgrade_book`;

CREATE TABLE `upgrade_book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `parter_id` int(11) NOT NULL DEFAULT '0',
  `book_id` int(11) NOT NULL DEFAULT '0',
  `knowledge` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `upgrade_formation` */

DROP TABLE IF EXISTS `upgrade_formation`;

CREATE TABLE `upgrade_formation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `role_level` int(11) NOT NULL DEFAULT '0',
  `formation_id` int(11) NOT NULL DEFAULT '0',
  `silver` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `upgrade_title` */

DROP TABLE IF EXISTS `upgrade_title`;

CREATE TABLE `upgrade_title` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `upgrade_vein` */

DROP TABLE IF EXISTS `upgrade_vein`;

CREATE TABLE `upgrade_vein` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `cultivation` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `use_item` */

DROP TABLE IF EXISTS `use_item`;

CREATE TABLE `use_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `parter_id` int(11) NOT NULL DEFAULT '0',
  `container_id` int(11) NOT NULL DEFAULT '0',
  `item_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `visit_master` */

DROP TABLE IF EXISTS `visit_master`;

CREATE TABLE `visit_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `role_level` int(11) NOT NULL DEFAULT '0',
  `master_id` int(11) NOT NULL DEFAULT '0',
  `new_master_id` int(11) NOT NULL DEFAULT '0',
  `book_id` int(11) NOT NULL DEFAULT '0',
  `silver` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Table structure for table `xisui` */

DROP TABLE IF EXISTS `xisui`;

CREATE TABLE `xisui` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL DEFAULT '0',
  `command_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  `parter_id` int(11) NOT NULL DEFAULT '0',
  `role_level` int(11) NOT NULL DEFAULT '0',
  `cultivate_type` int(11) NOT NULL DEFAULT '0',
  `muscle` int(11) NOT NULL DEFAULT '0',
  `spirit` int(11) NOT NULL DEFAULT '0',
  `aptitude` int(11) NOT NULL DEFAULT '0',
  `gold` int(11) NOT NULL DEFAULT '0',
  `gift_gold` int(11) NOT NULL DEFAULT '0',
  `silver` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server_id_role_id_command_id_time` (`server_id`,`role_id`,`command_id`,`time`),
  KEY `server_id_role_id` (`server_id`,`role_id`),
  KEY `command_id` (`command_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;
