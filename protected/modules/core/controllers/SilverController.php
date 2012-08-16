<?php
class SilverController extends Controller
{
    private $silverProductionType = array(
        "出售道具" => array("tableName" => "sell_item", "jsonName" => "sell_item", "whereClause" => ""),
        "副本战斗" => array("tableName" => "fetch_fighting_dungeon_award", "jsonName" => "fetch_fighting_dungeon_award", "whereClause" => ""),
        "挂机" => array("tableName" => "fetch_auto_fighting_dungeon_award", "jsonName" => "fetch_auto_fighting_dungeon_award", "whereClause" => ""),
        "兑换银两" => array("tableName" => "exchange_silver", "jsonName" => "exchange_silver", "whereClause" => ""),
        "任务奖励" => array("tableName" => "submit_task", "jsonName" => "submit_task", "whereClause" => " and star_rate = 0"),
        "出售秘籍" => array("tableName" => "sell_book", "jsonName" => "sell_book", "whereClause" => ""),
        "收获银两草" => array("tableName" => "harvest_medicine", "jsonName" => "harvest_medicine", "whereClause" => ""),
        "武林大会排名奖励" => array("tableName" => "receive_gift_bag", "jsonName" => "arena_award", "whereClause" => " and award_id = 10"),
        "武林大会挑战" => array("tableName" => "challenge_opponent", "jsonName" => "chanllenge_opponent", "whereClause" => ""),
        "天罡金刚战斗" => array("tableName" => "fight_world_boss" , "jsonName" => "fight_world_boss", "whereClause" => ""),
        "天罡金刚击杀" => array("tableName" => "receive_gift_bag", "jsonName" => "kill_world_boss", "whereClause" => " and award_id = 5"),
        "天罡金刚排名" => array("tableName" => "receive_gift_bag", "jsonName" => "world_boss_rank", "whereClause" => " and award_id = 6"),
        "帮派俸禄" => array("tableName" => "fetch_faction_salary", "jsonName" => "faction_salary", "whereClause" => ""),
        "帮战排名" => array("tableName" => "receive_gift_bag", "jsonName" => "rand_award_in_faction_battle", "whereClause" => " and award_id = 11"),
        "帮战击杀" => array("tableName" => "receive_gift_bag", "jsonName" => "killing_award_in_faction_battle", "whereClause" => " and award_id = 12"),
        "门派竞技战斗" => array("tableName" => "fight_in_clan_fight", "jsonName" => "fight_in_clan_fight", "whereClause" => ""),
        "门派冠军" => array("tableName" => "receive_gift_bag", "jsonName" => "winner_of_party_fight", "whereClause" => " and award_id = 7"),
        "门派内前三" => array("tableName" => "receive_gift_bag", "jsonName" => "top3_of_party", "whereClause" => " and award_id = 9" ),
        "签到" => array("tableName" => "signup", "jsonName" => "signup", "whereClause" => ""),
        "十大恶人" => array("tableName" => "fight_with_demons", "jsonName" => "fight_with_demons", "whereClause" => ""),
        "任务收益" => array("tableName" => "submit_task", "jsonName" => "submit_task", "whereClause" => " and star_rate != 0"),
        "称号俸禄" => array("tableName" => "receive_gift_bag", "jsonName" => "title_award", "whereClause" => " and award_id = 16"),
        "新手礼包" => array("tableName" => "use_item", "jsonName" => "newbie_gift_bag", "whereClause" => " and item_id >= 410101 and item_id <= 410106"),
        "江湖目标" => array("tableName" => "get_system_target_award", "jsonName" => "system_target_award", "whereClause" => ""),
        "充值有礼" => array("tableName" => "get_exciting_award", "jsonName" => "award_of_recharge", "whereClause" => " and activity_id = 479251"),
        "全服冲级赛" => array("tableName" => "get_exciting_award", "jsonName" => "award_of_levelup", "whereClause" => " and activity_id = 479252"),
        "随从大比武" => array("tableName" => "get_exciting_award", "jsonName" => "award_of_partner", "whereClause" => " and activity_id = 479253"),
        "武林争霸赛" => array("tableName" => "get_exciting_award", "jsonName" => "award_of_arena", "whereClause" => " and activity_id = 479254"),
        "vip等级活动" => array("tableName" => "get_exciting_award", "jsonName" => "award_of_vip", "whereClause" => " and activity_id = 479255"),
        "黄钻新手" => array("tableName" => "receive_gift_bag", "jsonName" => "yellow_newbie", "whereClause" => " and award_id = 13"),
        "黄钻每日" => array("tableName" => "receive_gift_bag", "jsonName" => "yellow_vip_per_day", "whereClause" => " and award_id = 14"),
        "黄钻升级" => array("tableName" => "receive_gift_bag", "jsonName" => "yellow_vip_upgrade", "whereClause" => " and award_id = 15"),
        "vip奖励" => array("tableName" => "receive_gift_bag", "jsonName" => "vip_award", "whereClause" => " and award_id >= 17 and award_id <= 19"),
        "银两丹" => array("tableName" => "use_item", "jsonName" => "silver_medicine", "whereClause" => " and (item_id = 410209 or item_id = 410227)")
    );

    public function actionGetSilverProduction()
    {
         $result = array();
         $serverId = $this->getParam("serverId");
         $search_type = $this->getParam("search_type");
         if ($search_type == 0)
         {
             array_push($result, $this->calcTotalSilverProduction($serverId));
         }
         else
         {
             $timeRanges = TimeUtils::calcDateRanges($this->getParam("begintime"), $this->getParam("endtime")); 
             foreach ($timeRanges as $time)
             {
                 array_push($result, $this->calcSilverProductionByDate($serverId, strtotime($time)));
             }
         }
         echo json_encode($result);
    }

    private function calcTotalSilverProduction($serverId)
    {
        $result = array();
        foreach ($this->silverProductionType as $key => $value)
        {
            $silver = Yii::app()->db->createCommand()->select('sum(silver) as amount')->from($value['tableName'])->where('server_id = :server_id ' . $value['whereClause'], array(":server_id" => $serverId))->queryScalar();
            if (!empty($silver))
            {
                $result[$value['jsonName']] = intval($silver);
            }
            else
            {
                $result[$value['jsonName']] = 0;
            }
        }
        $result['time'] = date('Y-m-d');
        $result['serverId'] = $serverId;
        return $result;
    }

    private function calcSilverProductionByDate($serverId, $dt)
    {
        $result = array();
        $start_of_day = mktime(0, 0, 0, date('m', $dt), date('d', $dt), date('Y', $dt));
        $end_of_day = mktime(23, 59, 59, date('m', $dt), date('d', $dt), date('Y', $dt));
        $param = array(":server_id" => $serverId, ":start_day" => $start_of_day, ":end_day" => $end_of_day);
        $result = array();
        foreach ($this->silverProductionType as $key => $value)
        {
            $silver = Yii::app()->db->createCommand()->select('sum(silver) as amount')->from($value['tableName'])->where('server_id = :server_id ' . $value['whereClause'] . " and time <= :end_day and time >= :start_day", $param)->queryScalar();
            if (!empty($silver))
            {
                $result[$value['jsonName']] = intval($silver);
            }
            else
            {
                $result[$value['jsonName']] = 0;
            }
        }
        $result['time'] = date('Y-m-d', $dt);
        $result['serverId'] = $serverId;
        return $result;
    }
}
?>
