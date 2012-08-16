<?php
class GoldController extends Controller
{

    private $gold_consumption =  array(
        "购买精力" => array("buy_vitality", "buy_vitality", 0, "", "and time >= :start_day and time <= :end_day"),
        "精炼洗髓" => array("level2_xisui", "xisui", 0, " and cultivate_type = 1", " and time >= :start_day and time <= :end_day"),
        "白金洗髓" => array("level3_xisui", "xisui", 0, " and cultivate_type = 2", " and time >= :start_day and time <= :end_day"),
        "刷新随从" => array("refresh_partner", "refresh_partner", 0, " and type=3", " and time >= :start_day and time <= :end_day"),
        "一键史诗" => array("buy_excellent_partner", "refresh_partner", 0, " and type=4", " and time >= :start_day and time <= :end_day"),
        "购买背包格子" => array("unlock_package_slot", "unlock_package_slot", 0, " and container_id=1", " and time >= :start_day and time <= :end_day"),
        "购买仓库格子" => array("unlock_store_slot", "unlock_package_slot", 0, " and container_id=2", " and time >= :start_day and time <= :end_day"),
        "远程商店" => array("remote_open_shop", "remote_open_package", 0, " and container_id=3", " and time >= :start_day and time <= :end_day"),
        "远程仓库" => array("remote_open_store", "remote_open_package", 0, " and container_id=2", " and time >= :start_day and time <= :end_day"),
        "保证成功率100%" => array("ensure_strengthen_success", "strengthen_item", 0, "and vip_level>0", " and time >= :start_day and time <= :end_day"),
        "清除强化cd" => array("clear_strengthen_cd", "clear_strengthen_cd", 0, "", "and time >= :start_day and time <= :end_day"),
        "重置精英副本" => array("refresh_elite_dungeon", "refresh_elite_dungeon", 0, "", "and time >= :start_day and time <= :end_day"),
        "加速挂机" => array("accelerate_auto_fighting", "accelerate_auto_fighting", 0, "", "and time >= :start_day and time <= :end_day"),
        "兑换银两" => array("exchange_silver", "exchange_silver", 0, "", "and time >= :start_day and time <= :end_day"),
        "寻访" => array("seek_hight_level_master", "seek_hight_level_master", 0, "", "and time >= :start_day and time <= :end_day"),
        "解锁秘籍格子" => array("unlock_book_slot", "unlock_book_slot", 0, "", "and time >= :start_day and time <= :end_day"),
        "合成装备" => array("synthesis_equipment", "synthesis_equipment", 0, "", "and time >= :start_day and time <= :end_day"),
        "扩地" => array("unlock_earth", "unlock_earth", 0, "", "and time >= :start_day and time <= :end_day"),
        "刷新银两草" => array("refresh_silver_seed", "refresh_seed", 0, " and crop_id=471141 and vip_level = 0", " and time >= :start_day and time <= :end_day"),
        "刷新经验草" => array("refresh_exp_seed", "refresh_seed", 0, " and crop_id=471140 and vip_level = 0", " and time >= :start_day and time <= :end_day"),
        "一键满星银两草" => array("refresh_excellent_silver_seed", "refresh_seed", 0, " and crop_id=471141 and vip_level > 0", " and time >= :start_day and time <= :end_day"),
        "一键满星经验草" => array("refresh_excellent_exp_seed", "refresh_seed", 0, " and crop_id=471140 and vip_level > 0", " and time >= :start_day and time <= :end_day"),
        "清除地块cd" => array("clear_earth_cd", "clear_earth_cd", 0, "", "and time >= :start_day and time <= :end_day"),
        "增加挑战次数" => array("add_challenge_times", "add_challenge_times", 0, "", "and time >= :start_day and time <= :end_day"),
        "清除秒cd时间" => array("clear_challenge_cd", "clear_challenge_cd", 0, "", "and time >= :start_day and time <= :end_day"),
        "世界boss复活" => array("revive_in_world_boss", "revive_in_world_boss", 0, "", "and time >= :start_day and time <= :end_day"),
        "世界boss鼓舞" => array("encourage_in_world_boss", "encourage_in_world_boss", 0, "", "and time >= :start_day and time <= :end_day"),
        "帮会捐献" => array("donate_to_faction", "donate_to_faction", 1, "", "and time >= :start_day and time <= :end_day"),
        "帮会招人" => array("send_faction_enrollment_notification", "send_faction_enrollment_notification", 1, "", "and time >= :start_day and time <= :end_day"),
        "帮会战复活" => array("rivive_in_faction_battle", "rivive_in_faction_battle", 0, "", "and time >= :start_day and time <= :end_day"),
        "帮会战鼓舞" => array("encourage_in_faction", "encourage_in_faction", 0, "", "and time >= :start_day and time <= :end_day"),
        "门派竞技鼓舞" => array("encourage_in_clan_fight", "encourage_in_clan_fight", 0, "", "and time >= :start_day and time <= :end_day"),
        "清理日常任务cd" => array("clear_daily_task_cd", "clear_daily_task_cd", 0, "", "and time >= :start_day and time <= :end_day"),
        "刷新日常任务星级" => array("refresh_daily_task", "refresh_daily_task", 0, "", "and time >= :start_day and time <= :end_day"),
        "一键完成日常任务" => array("auto_finish_daily_task", "auto_finish_daily_task", 0, "", "and time >= :start_day and time <= :end_day"),
        "充值大礼包" => array("recharge_gift_bag", "use_item", 1, " and gold < 0", " and time >= :start_day and time <= :end_day")
    );

    /**
     * 黄金礼金消耗
     */
    public function actionGetGoldConsumption()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $serverId = $this->getParam("serverId");
            $search_type = $this->getParam("search_type");
            $result = $this->getGoldConsumption($serverId, $search_type);
            echo json_encode($result);
        }
        else
        {
            $select = Util::getRealServerSelect(false);
            $this->render('get_gold_consumption',array( 'select' => $select));
        }
    }
    
    /*
     * 获取黄金礼金消耗
     */
    protected function getGoldConsumption($serverId, $search_type){
        $result = array();
        if ($search_type == 0)
        {
            array_push($result, $this->calcTotalConsumption($serverId));
        }
        else
        {
            $timeRanges = TimeUtils::calcDateRanges($this->getParam("begintime"), $this->getParam("endtime")); 
            foreach ($timeRanges as $time)
            {
                array_push($result, $this->calcConsumptionByDate($serverId, strtotime($time)));
            }
        }
        return $result;
    }
    
    /*
     * 导出黄金礼金消耗
     */
    public  function actionGoldConsumptionExport(){
        $title = '黄金礼金消耗';
        header("Content-Type: application/vnd.ms-excel;charset=utf8");
        header("Content-Disposition: attachment; filename=".$title.".xls");
        $serverId = $this->getParam("serverId");
        $search_type = $this->getParam("search_type");
        $array = array('日期', '服务器', '购买精力', '精炼洗髓', '白金洗髓', '黄金刷新', '一键史诗', '购买背包格', '购买仓库格', 
         '远程仓库', '远程道具店', '保证100%成功', '秒CD', '重置英雄榜', '加速挂机', '兑换银两', '寻访', '购买秘籍格', 
         '合成装备', '扩地', '刷新银两', '一键满星银两', '刷新经验', '一键满星经验', '秒CD', '增加挑战次数', '秒CD', '复活', 
         '鼓舞', '招人', '捐献', '鼓舞', '秒CD', '鼓舞', '秒CD', '刷新星级', '一键完成', '一件大礼包');
        $header = '';
        $list = '';
        $result = $this->getGoldConsumption($serverId, $search_type);
            if(count($array)){
                foreach($array as $k => $v){
                        $header .= iconv("UTF-8","GB2312//IGNORE",$v)."\t";
                }
            }
            $header = substr($header, 0, strlen($header) - 1)."\n";
            echo $header;
            foreach ($result as $ke => $val){
                $list = '';
                $server_name = iconv("UTF-8","GB2312//IGNORE",Util::getServerName(intval($result[$ke]['serverId'])));
                $list .= $result[$ke]['time']."\t";
                $list .= $server_name."\t";
                foreach ($result[$ke] as $key => $value){
                    if($key != 'time' && $key != 'serverId')
                    $list .= $value['gift_gold'].'|'.$value['gold']."\t";
                }
                $list = substr($list, 0, strlen($list) - 1)."\n";
                echo $list;
            }
    }
    
    private function calcTotalConsumption($serverId)
    {
        $result = array();
        foreach ($this->gold_consumption as $key => $value)
        {
            $result[$value[0]]['gold'] = abs(Yii::app()->db->createCommand()->select('sum(gold) as amount')->from($value[1])->where("server_id=:server_id " . $value[3], array(":server_id" => $serverId))->queryScalar());
            if ($value[2] == 0)
            {
                $result[$value[0]]['gift_gold'] = abs(Yii::app()->db->createCommand()->select('sum(gift_gold) as amount')->from($value[1])->where("server_id=:server_id " . $value[3], array(":server_id" => $serverId))->queryScalar());
            }
            else
            {
                $result[$value[0]]['gift_gold'] = 0;
            }
        }
        $result['serverId'] = $serverId;
        $result['time'] = date('Y-m-d');
        return $result;
    }

    private function calcConsumptionByDate($serverId, $dt)
    {
        $start_of_day = mktime(0, 0, 0, date('m', $dt), date('d', $dt), date('Y', $dt));
        $end_of_day = mktime(23, 59, 59, date('m', $dt), date('d', $dt), date('Y', $dt));
        $param = array(":server_id" => $serverId, ":start_day" => $start_of_day, ":end_day" => $end_of_day);
        $result = array();
        foreach ($this->gold_consumption as $key => $value)
        {
            $result[$value[0]]['gold'] = abs(Yii::app()->db->createCommand()->select('sum(gold) as amount')->from($value[1])->where("server_id=:server_id " . $value[3] . $value[4], $param)->queryScalar());
            if ($value[2] == 0)
            {
                $result[$value[0]]['gift_gold'] = abs(Yii::app()->db->createCommand()->select('sum(gift_gold) as amount')->from($value[1])->where("server_id=:server_id " . $value[3] . $value[4], $param)->queryScalar());
            }
            else
            {
                $result[$value[0]]['gift_gold'] = 0;
            }
        }
        $result['serverId'] = $serverId;
        $result['time'] = date('Y-m-d', $dt);
        return $result;
    }
}
?>
