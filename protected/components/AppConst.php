<?php

class AppConst
{
    /**
     * 系统保留数据导出权限对应URL
     */
    const SYSTEM_RETAIL_EXPORT = '/SYSTEM/RETAIN/EXPORT';

    /**
     * 物品获得 使用 变更 买卖 副本奖励 任务 相关数据表对应数据类型 0为获得 1为使用 2为变更 3为买卖 4 副本奖励 5 任务
     */
    public static $item_tables = array(
        'get_system_award' => 0,
        'fight_with_demons' => 4,
        'receive_gift_bag' => 0,
        'use_item' => 1,
        'fetch_fighting_dungeon_award' => 4,
        'fetch_finishing_dungeon_award' => 4,
        'fetch_auto_fighting_dungeon_award' => 4,
        'fetch_auto_finishing_dungeon__award' => 4,
        'submit_task' => 5,
        'buy_item' => 3,
        'sell_item' => 3,
        'rebuy_item' => 3,
        'strengthen_item' => 2,
        'synthesis_equipment' => 2
    );

    /**
     * 消费类型数组
     */
    public static $consume = array(
        'accelerateHangUp' => '加速挂机',
        'addChallengeTimes'  => '武林大会挑战次数',
        'addVitality'  => '购买精力',
        'bookSlot'  => '秘籍格子',
        'completeDailyTask'  => '一键完成日常任务',
        'enrollFactionMember'  => '招聘帮众',
        'equipmentStrengthen'  => '强化装备',
        'exchangeSilver'  => '兑换银两',
        'factionContribute'  => '帮会贡献',
        'factionFightInspire'  => '帮会战鼓舞',
        'factionFightRelive'  => '帮会战复活',
        'forgeEquip'  => '一键合成',
        'makeNewGarden'  => '开地块',
        'openItemAward'  => '开礼包',
        'openPackageSlot'  => '开包裹格子',
        'partyFightInspire'  => '门派战鼓舞',
        'refreshEliteTimes'  => '刷新精英副本',
        'refreshGardenQuality'  => '刷新种子',
        'refreshParterQuality'  => '刷新伙伴',
        'refreshTaskStarLevel'  => '刷新任务星级',
        'remoteOpenShop'  => '远程开商店',
        'remoteOpenStore'  => '远程开仓库',
        'removeChallengeCD'  => '清理武林大会cd',
        'removeLandCD'  => '清除地块cd',
        'removeRefreshDailyTaskTypeCD'  => '清除日常任务cd',
        'removeStrengthenCD'  => '清除强化cd',
        'storeSlot'  => '仓库格子',
        'visit4thOpenMaster'  => '寻访',
        'worldBossInspire'  => '世界boss鼓舞',
        'worldBossRelive'  => '世界boss复活',
        'xisui'  => '洗髓',
    );

    /**
     * 银两产出数据表 对应 VIP 玩家统计表数据类型
     *0：出售道具 1：副本战斗 2：挂机 3：兑换银两 4:任务奖励 5:出售秘籍 6:收获银两草 7:接收银两礼包 8:武林大会挑战 9:天罡金刚战斗
     *10:帮派俸禄 11：门派竞技战斗 12:签到 13:十大恶人 14：江湖目标
     *15:充值有礼 16：银两丹
     *17:普通洗髓 18:购买道具 19:刷新伙伴 20：强化装备 21:升级阵法 22:拜访高人
     */
    public static $silver_product_tables = array(
        "sell_item" => 0,
        "fetch_fighting_dungeon_award" => 1,
        "fetch_auto_fighting_dungeon_award" => 2,
        "exchange_silver" => 3,
        "submit_task" => 4,
        "sell_book" => 5,
        "harvest_medicine" => 6,
        "receive_gift_bag" => 7,
        "challenge_opponent" => 8,
        "fight_world_boss" => 9,
        "fetch_faction_salary" => 10,
        "fight_in_clan_fight" => 11,
        "signup" => 12,
        "fight_with_demons" => 13,
        "get_system_target_award" => 14,
        "get_exciting_award" => 15,
        "use_item" => 20
    );

    /**
     * 银两消耗数据表  对应 VIP 玩家统计表数据类型
     *0：出售道具 1：副本战斗 2：挂机 3：兑换银两 4:任务奖励 5:出售秘籍 6:收获银两草 7:接收银两礼包 8:武林大会挑战 9:天罡金刚战斗
     *10:帮派俸禄 11：门派竞技战斗 12:签到 13:十大恶人 14：江湖目标
     *15:充值有礼 16：银两丹
     *17:普通洗髓 18:购买道具 19:刷新伙伴 20：强化装备 21:升级阵法 22:拜访高人
     */
    public static $silver_consume_tables = array(
        'xisui' => 17,
        'buy_item' => 18,
        'refresh_partner' => 19,
        'strengthen_item' => 20,
        'upgrade_formation' => 21,
        'visit_master' => 22
    );

    /**
     * 礼金产出消耗数据表  对应 VIP 玩家统计表数据类型
     *0:购买精力 1：洗髓  2：解锁包囊 3：远程打开包囊 4：加强物品 5：强化物品秒CD 6：刷新精英副本 7： 加速挂机 8：兑换银两 9：解锁秘籍方格 10：寻访
     *11：合成装备 12： 开拓荒地  13：刷新种子 14: 药园清除cd时间 15:武林大会增加挑战次数  16:武林大会请求清除CD时间 17:世界boss复活 18:世界boss鼓舞
     *19:帮会战复活 20:门派战鼓舞 21:清除日常任务cd时间 22:刷新日常任务星级 23:刷新伙伴 24:帮派战鼓舞 25:一键完成日常任务 26:用道具要花钱
     */
    public static $gift_gold_tables = array(
        'buy_vitality' => 0,
        'xisui' => 1,
        'unlock_package_slot' => 2,
        'remote_open_package' => 3,
        'strengthen_item' => 4,
        'clear_strengthen_cd' => 5,
        'refresh_elite_dungeon' => 6,
        'accelerate_auto_fighting' => 7,
        'exchange_silver' => 8,
        'unlock_book_slot' => 9,
        'seek_hight_level_master' => 10,
        'synthesis_equipment' => 11,
        'unlock_earth' => 12,
        'refresh_seed' => 13,
        'clear_earth_cd' => 14,
        'add_challenge_times' => 15,
        'clear_challenge_cd' => 16,
        'revive_in_world_boss' => 17,
        'encourage_in_world_boss' => 18,
        'rivive_in_faction_battle' => 19,
        'encourage_in_clan_fight' => 20,
        'clear_daily_task_cd' => 21,
        'refresh_daily_task' => 22,
        'refresh_partner' => 23,
        'encourage_in_faction' => 24,
        'auto_finish_daily_task' => 25,
        'use_item' => 26
    );

    /**
     * 黄金消耗数据表 对应 VIP 玩家统计表数据类型
     *0:购买精力 1：洗髓  2：解锁包囊 3：远程打开包囊 4：加强物品 5：强化物品秒CD 6：刷新精英副本 7： 加速挂机 8：兑换银两 9：解锁秘籍方格 10：寻访
     *11：合成装备 12： 开拓荒地  13：刷新种子 14: 药园清除cd时间 15:武林大会增加挑战次数  16:武林大会请求清除CD时间 17:世界boss复活 18:世界boss鼓舞
     *19:帮会战复活 20:门派战鼓舞 21:清除日常任务cd时间 22:刷新日常任务星级 23:刷新伙伴 24:帮派战鼓舞 25:一键完成日常任务 26:用道具要花钱 27:帮会捐献 28 帮会招人
     */
    public static $gold_tables = array(
        'buy_vitality' => 0,
        'xisui' => 1,
        'unlock_package_slot' => 2,
        'remote_open_package' => 3,
        'strengthen_item' => 4,
        'clear_strengthen_cd' => 5,
        'refresh_elite_dungeon' => 6,
        'accelerate_auto_fighting' => 7,
        'exchange_silver' => 8,
        'unlock_book_slot' => 9,
        'seek_hight_level_master' => 10,
        'synthesis_equipment' => 11,
        'unlock_earth' => 12,
        'refresh_seed' => 13,
        'clear_earth_cd' => 14,
        'add_challenge_times' => 15,
        'clear_challenge_cd' => 16,
        'revive_in_world_boss' => 17,
        'encourage_in_world_boss' => 18,
        'rivive_in_faction_battle' => 19,
        'encourage_in_clan_fight' => 20,
        'clear_daily_task_cd' => 21,
        'refresh_daily_task' => 22,
        'refresh_partner' => 23,
        'encourage_in_faction' => 24,
        'auto_finish_daily_task' => 25,
        'use_item' => 26,
        'donate_to_faction' => 27,
        'send_faction_enrollment_notification' => 28
    );

    /**
     * 游戏数据表 对应 VIP 玩家统计表数据类型
     *0：精力消耗1：精力剩余2：强化次数3：拜访次数：4：天罡北斗阵5：精钢伏魔圈6：门派竞技7：武林大会8：十大恶人9：帮派站
     *10：主任务进度11：英雄榜12：帮派名称13：帮派职务14：登录次数 15 钱庄兑换次数 16 vip等级 17 黄钻等级 18 是否是年付
     */
    public static $game_data_tables = array(
        //游戏数据表名索引
        'dau' => 14,
        'exchange_silver' => 15,
        'strengthen_item' => 2,
        'visit_master' => 3,
        'challenge_opponent' => 7,
        'fight_in_clan_fight' => 6,
        'fight_with_demons' => 8,
        'refresh_elite_dungeon' => 11,
        //黄钻信息索引
        'vip_level' => 16,
        'yellow_vip_level' => 17,
        'year_vip_level' => 18
    );

    /**
     * 任务映射等级数组
     * 任务等级	任务ID
     */
    public static $task_map_level = array(
        0 => 1,
        451079 => 21,
        451129 => 21,
        451179 => 21,
        451229 => 21,
        451001 => 2,
        451003 => 2,
        451004 => 3,
        451005 => 3,
        451006 => 4,
        451007 => 4,
        451008 => 5,
        451009 => 5,
        451010 => 6,
        451011 => 6,
        451012 => 7,
        451013 => 7,
        451014 => 8,
        451015 => 8,
        451016 => 9,
        451017 => 9,
        451018 => 10,
        451019 => 10,
        451020 => 11,
        451021 => 11,
        451051 => 11,
        451052 => 12,
        451053 => 12,
        451054 => 12,
        451055 => 13,
        451056 => 13,
        451057 => 13,
        451058 => 14,
        451059 => 14,
        451060 => 14,
        451061 => 15,
        451062 => 15,
        451063 => 15,
        451064 => 16,
        451065 => 16,
        451066 => 16,
        451067 => 17,
        451068 => 17,
        451069 => 17,
        451070 => 18,
        451071 => 18,
        451072 => 18,
        451073 => 19,
        451074 => 19,
        451075 => 19,
        451076 => 20,
        451077 => 20,
        451078 => 21,
        451101 => 11,
        451102 => 11,
        451103 => 12,
        451104 => 12,
        451105 => 12,
        451106 => 13,
        451107 => 13,
        451108 => 13,
        451109 => 14,
        451110 => 14,
        451111 => 14,
        451112 => 15,
        451113 => 15,
        451114 => 15,
        451115 => 16,
        451116 => 16,
        451117 => 16,
        451118 => 17,
        451119 => 17,
        451120 => 17,
        451121 => 18,
        451122 => 18,
        451123 => 18,
        451124 => 19,
        451125 => 19,
        451126 => 19,
        451127 => 20,
        451128 => 20,
        451023 => 21,
        451151 => 11,
        451152 => 11,
        451153 => 12,
        451154 => 12,
        451155 => 12,
        451156 => 13,
        451157 => 13,
        451158 => 13,
        451159 => 14,
        451160 => 14,
        451161 => 14,
        451162 => 15,
        451163 => 15,
        451164 => 15,
        451165 => 16,
        451166 => 16,
        451167 => 16,
        451168 => 17,
        451169 => 17,
        451170 => 17,
        451171 => 18,
        451172 => 18,
        451173 => 18,
        451174 => 19,
        451175 => 19,
        451176 => 19,
        451177 => 20,
        451178 => 20,
        451024 => 21,
        451201 => 11,
        451202 => 11,
        451203 => 12,
        451204 => 12,
        451205 => 12,
        451206 => 13,
        451207 => 13,
        451208 => 13,
        451209 => 14,
        451210 => 14,
        451211 => 14,
        451212 => 15,
        451213 => 15,
        451214 => 15,
        451215 => 16,
        451216 => 16,
        451217 => 16,
        451218 => 17,
        451219 => 17,
        451220 => 17,
        451221 => 18,
        451222 => 18,
        451223 => 18,
        451224 => 19,
        451225 => 19,
        451226 => 19,
        451227 => 20,
        451228 => 20,
        451251 => 21,
        451252 => 21,
        451253 => 22,
        451254 => 22,
        451255 => 22,
        451256 => 23,
        451257 => 23,
        451258 => 23,
        451259 => 24,
        451260 => 24,
        451261 => 24,
        451262 => 25,
        451263 => 25,
        451264 => 26,
        451265 => 26,
        451266 => 27,
        451267 => 27,
        451268 => 28,
        451269 => 28,
        451270 => 29,
        451271 => 30,
        451272 => 31,
        451301 => 31,
        451302 => 31,
        451303 => 32,
        451304 => 32,
        451305 => 33,
        451306 => 33,
        451307 => 34,
        451308 => 34,
        451309 => 35,
        451310 => 35,
        451311 => 36,
        451312 => 36,
        451313 => 37,
        451314 => 37,
        451315 => 38,
        451316 => 39,
        451317 => 40,
        451318 => 41,
        451351 => 41,
        451352 => 41,
        451353 => 42,
        451354 => 42,
        451355 => 43,
        451356 => 43,
        451357 => 44,
        451358 => 44,
        451359 => 45,
        451360 => 45,
        451361 => 46,
        451362 => 46,
        451363 => 47,
        451364 => 48,
        451365 => 49,
        451366 => 50,
        451367 => 51,
        451401 => 51,
        451402 => 51,
        451403 => 52,
        451404 => 52,
        451405 => 53,
        451406 => 53,
        451407 => 54,
        451408 => 54,
        451409 => 54,
        451410 => 55,
        451411 => 55,
        451412 => 56,
        451413 => 56,
        451414 => 57,
        451415 => 58,
        451416 => 59,
        451417 => 59,
        451451 => 61,
        451452 => 61,
        451453 => 61,
        451454 => 62,
        451455 => 62,
        451456 => 63,
        451457 => 63,
        451458 => 63,
        451459 => 64,
        451460 => 64,
        451461 => 65,
        451462 => 65,
        451463 => 66,
        451464 => 66,
        451465 => 67,
        451466 => 67,
        451467 => 68,
        451468 => 68,
        451469 => 68,
        451470 => 69,
        451471 => 70,
        451501 => 71,
        451502 => 71,
        451503 => 71,
        451504 => 72,
        451505 => 72,
        451506 => 73,
        451507 => 73,
        451508 => 74,
        451509 => 74,
        451510 => 75,
        451511 => 75,
        451512 => 76,
        451513 => 76,
        451514 => 77,
        451515 => 78,
        451516 => 79,
    );

    /*
     * 黄金消费类型对应数组
     */
    public static  $gold_children_type = array(
        1 => '洗髓',
        0 => '购买精力',
        2 => '解锁包裹',
        3 => '远程打开包裹',
        4 => '强化装备',
        5 => '强化装备秒CD',
        6 => '刷新精英副本',
        7 => '加速挂机',
        8 => '兑换银两',
        9 => '解锁秘籍方格',
        10 => '寻访',
        11 => '合成装备',
        12 => '开拓荒地',
        13 => '刷新种子',
        14 => '药园清除cd时间',
        15 => '武林大会增加挑战次数 ',
        16 => '武林大会清除CD时间',
        17 => '世界boss复活',
        18 => '世界boss鼓舞',
        19 => '帮会战复活',
        20 => '门派战鼓舞',
        21 => '清除日常任务cd时间',
        22 => '刷新日常任务星级',
        23 => '刷新随从',
        24 => '帮派战鼓舞',
        25 => '一键完成日常任务',
        26 => '使用物品',
        27 => '挂机通关副本'
    );

    /*
     * 银两消费类型数组
     */
    public static $silver_children_type = array(
        17 => "普通洗髓",
        18 => "购买道具",
        19 => "刷新伙伴",
        20 => "强化装备",
        21 => "升级阵法",
        22 => "拜访高人"
    );

    /*
     * 游戏数据数组
     */
    public static $game_children_type = array(
        14 => "日登录次数",
        15 => "兑换银两次数",
        2 => "强化装备次数",
        3 => "拜访次数",
        7 => "武林大会次数",
        6 => "门派竞技次数",
        8 => "十大恶人次数",
        11 => "英雄榜次数"
    );

    /*
     * 银两日志数组
     */
    public static $log_silver = array(
        1 => '购买道具',
        2 => '刷新伙伴',
        3 => '强化装备',
        4 => '升级阵法',
        5 => '拜访高人',
        0 => '普通洗髓',
        6 => "出售道具" ,
        7 => "副本战斗",
        8 => "挂机",
        9 => "兑换银两",
        10 => "任务奖励",
        11 => "出售秘籍",
        12 => "收获银两草",
        13 => "武林大会排名奖励",
        14 => "武林大会挑战",
        15 => "天罡金刚战斗",
        16 => "天罡金刚击杀",
        17 => "天罡金刚排名",
        18 =>  "帮派俸禄",
        19 => "帮战排名",
        20 => "帮战击杀",
        21 => "门派竞技战斗",
        22 => "门派冠军",
        23 => "门派内前三",
        24 => "签到",
        25 => "十大恶人",
        26 => "任务收益",
        27 => "称号俸禄",
        28 => "新手礼包",
        29 => "江湖目标",
        30 => "充值有礼",
        31 => "全服冲级赛",
        32 => "随从大比武",
        33 => "武林争霸赛",
        34 => "vip等级活动",
        35 => "黄钻新手",
        36 => "黄钻每日",
        37 => "黄钻升级",
        38 => "vip奖励",
        39 => "银两丹"
    );
    
    /**
     * 后台菜单JSON
     */
    public static function getMenuList(){
        $menu = <<<EOF
        {
"text": ".",
"children": [
{
    "text":"运营管理",
    "expanded": true,
    "children":[
    {
        "text":"统计分析",
        "expanded": true,
        "children":[
        {
            "text":"日注册、登录数",
            "url" : "/index.php?r=/core/statistic/index",
            "leaf":true
        },
        {
            "text":"日留存率",
            "url" : "/index.php?r=/core/statistic/retentionrate",
            "leaf":true
        },
        {
            "text":"关键数据总览",
            "url" : "/index.php?r=/core/default/index",
            "leaf":true
        },
        {
            "text":"日黄金兑换、消费",
            "url" : "/index.php?r=/core/consume/daygoldexchange",
            "leaf":true
        },
        {
            "text":"日黄金消费类型分布",
            "url" : "/index.php?r=/core/consume/index",
            "leaf":true
        },{
            "text":"日角色等级分析",
            "url" : "/index.php?r=/core/player/dayrolelevel",
            "leaf":true
        },{
            "text":"黄金礼金消耗",
            "url" : "/index.php?r=/core/gold/getgoldconsumption",
            "leaf":true
        },{
            "text":"日在线人数分析",
            "url" : "/index.php?r=/core/player/dayonline",
            "leaf":true
        },{
            "text":"小时在线人数分析",
            "url" : "/index.php?r=/core/player/houronline",
            "leaf":true
        },{
            "text":"老玩家付费统计",
            "url" : "/index.php?r=/core/consume/oldplayerconsume",
            "leaf":true
        }]
    },{
        "text":"日常管理",
        "expanded": true,
        "children":[
        {
            "text":"公告发布",
            "url" : "/index.php?r=/service/notice/list",
            "leaf":true
        },
        {
            "text":"添加礼包",
            "url" : "/index.php?r=/service/gift/addgift",
            "leaf":true
        },
        {
            "text":"添加内服礼包",
            "url" : "/index.php?r=/service/gift/addownergift",
            "leaf":true
        },
        {
            "text":"礼包发放",
            "url" : "/index.php?r=/service/gift/list",
            "leaf":true
        },
        {
            "text":"活动管理",
            "url" : "/index.php?r=/service/awardActivity/activities",
            "leaf":true
        }]
    },{
        "text":"游戏数据",
        "expanded": true,
        "children":[{
            "text":"礼金产出分析",
            "url" : "/index.php?r=/core/consume/giftgoldoutput",
            "leaf":true
        },{
            "text":"银两消耗分析",
            "url" : "/index.php?r=/core/consume/silverconsume",
            "leaf":true
        },{
            "text":"银两产出分析",
            "url" : "/index.php?r=/core/consume/silveroutput",
            "leaf":true
        },{
            "text":"道具产出分析",
            "url" : "/index.php?r=/core/consume/propsoutput",
            "leaf":true
        },{
            "text":"任务分析",
            "url" : "/index.php?r=/core/task/taskanalysis",
            "leaf":true
        },{
            "text":"战斗过程分析",
            "url" : "/index.php?r=/core/player/fightingprocess",
            "leaf":true
        },{
            "text":"VIP玩家分析",
            "url" : "/index.php?r=/core/vip/index",
            "leaf":true
        }]
    }]
},{
    "text":"客服管理",
    "expanded": true,
    "children":[

    {
        "text":"GM管理",
        "expanded": true,
        "children":[
        {
            "text":"玩家信息管理",
            "url" : "/index.php?r=/realtime/default/playerinfo",
            "leaf":true
        },
        {
            "text":"禁言封号管理",
            "url" : "/index.php?r=/service/default/showgmactionrecord",
            "leaf":true
        }
        ]
    }]
},
{
    "text":"日志查询",
    "expanded": true,
    "children":[
    {
        "text":"玩家登录日志",
        "url" : "/index.php?r=/core/player/loginrecord",
        "leaf":true
	},{
        "text":"黄金消费日志",
        "url" : "/index.php?r=/core/consume/consumerecord",
    	"leaf":true
	},{
        "text":"礼金产出消费日志",
        "url" : "/index.php?r=/core/log/giftgold",
    	"leaf":true
	},{
        "text":"银两产出消费日志",
		"url" : "/index.php?r=/core/log/silver",
    	"leaf":true
	},{
        "text":"物品产生/变更/消亡日志",
		"url" : "/index.php?r=/core/log/itemrecord",
    	"leaf":true
	}]
},
{
    "text":"系统管理",
    "expanded": true,
    "children":[
    {
        "text":"服务器管理",
        "url" : "/index.php?r=/passport/server/serverlist",
        "leaf":true
    },
    {
        "text":"服务器监控",
        "url" : "/index.php?r=/passport/server/servermonitor",
        "leaf":true
    },
    {
        "text":"系统日志",
        "url" : "/index.php?r=/log/default/loglist",
        "leaf":true
    },
    {
        "text":"所有角色",
        "url" : "/index.php?r=/passport/role/rolelist",
        "leaf":true
    },
    {
        "text":"角色类型",
        "url" : "/index.php?r=/passport/role/rolegrouplist",
        "leaf":true
    },
    {
        "text":"所有用户",
        "url" : "/index.php?r=/passport/user/userlist",
        "leaf":true
    },
    {
        "text":"权限管理",
        "url" : "/index.php?r=/passport/prime/primelist",
        "leaf":true
    },
    {
            "text":"资源管理",
            "url" : "/index.php?r=/passport/resource/resourcelist",
            "leaf":true
    },
    {
            "text":"资源绑定",
            "url" : "/index.php?r=/passport/resource/resourcebindlist",
            "leaf":true
    }]
},
{
    "text":"事务审批",
    "expanded": true,
    "children":[
        {
            "text":"所有事务",
            "url" : "/index.php?r=/approve/default/index",
            "leaf":true
        },
        {
            "text":"等待审批的事务",
            "url" : "/index.php?r=/approve/default/wait",
            "leaf":true
        },
        {
            "text":"已经审批的事务",
            "url" : "/index.php?r=/approve/default/finish",
            "leaf":true
        },
        {
            "text":"流程管理",
            "url" : "/index.php?r=/approve/default/flowlist",
            "leaf":true
        }
    ]
}
]
}
EOF;
        return $menu;
    }

}
