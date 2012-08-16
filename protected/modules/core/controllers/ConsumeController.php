<?php

class ConsumeController extends Controller
{
    private $gift_gold_producer = array(
        "通关副本" => array("tableName" => "fetch_finishing_dungeon_award", "jsonName" => "fetching_finishing_dungeon_award", "whereClause" => "",
                            "timeWhereClause" => " and time >= :start_day and time <= :end_day"),
        "礼金丹" => array("tableName" => "use_item", "jsonName" => "use_item", "whereClause" => "",
                          "timeWhereClause" => " and time >= :start_day and time <= :end_day"),
        "挂机通关副本" => array("tableName" => "fetch_auto_finishing_dungeon__award", "jsonName" => "fetch_auto_finishing_dungeon__award", "whereClause" => "",
                          "timeWhereClause" => " and time >= :start_day and time <= :end_day"),
        "签到" => array("tableName" => "signup", "jsonName" => "signup", "whereClause" => "",
                          "timeWhereClause" => " and time >= :start_day and time <= :end_day"),
        "首三日登录" => array("tableName" => "receive_gift_bag", "jsonName" => "receive_gift_bag", "whereClause" => " and award_id=1",
                          "timeWhereClause" => " and time >= :start_day and time <= :end_day"),
        "充值有礼" => array("tableName" => "get_exciting_award", "jsonName" => "recharge_award", "whereClause" => " and activity_id=479251",
                          "timeWhereClause" => " and time >= :start_day and time <= :end_day"),
        "全服冲级赛" => array("tableName" => "get_exciting_award", "jsonName" => "level_up_award", "whereClause" => " and activity_id=479252",
                          "timeWhereClause" => " and time >= :start_day and time <= :end_day"),
        "随从大比拼" => array("tableName" => "get_exciting_award", "jsonName" => "partner_award", "whereClause" => " and activity_id=479253",
                          "timeWhereClause" => " and time >= :start_day and time <= :end_day"),
        "武林争霸赛" => array("tableName" => "get_exciting_award", "jsonName" => "arena_award", "whereClause" => " and activity_id=479254",
                          "timeWhereClause" => " and time >= :start_day and time <= :end_day"),
        "vip等级活动" => array("tableName" => "get_exciting_award", "jsonName" => "vip_award", "whereClause" => " and activity_id=479255",
                          "timeWhereClause" => " and time >= :start_day and time <= :end_day"),
        "江湖目标" => array("tableName" => "get_system_target_award", "jsonName" => "get_system_target_award", "whereClause" => "",
                          "timeWhereClause" => " and time >= :start_day and time <= :end_day"),
    );

    private $silverConsumptionType = array(
        "普通洗髓" => array("jsonName" => "xisui", "tableName" => "xisui", "whereClause" => " and cultivate_type = 1"),
        "购买道具" => array("jsonName" => "buy_item", "tableName" => "buy_item", "whereClause" => ""),
        "刷新伙伴" => array("jsonName" => "refresh_partner", "tableName" => "refresh_partner", "whereClause" => " and type = 2"),
        "强化装备" => array("jsonName" => "strengthen_equipment", "tableName" => "strengthen_item", "whereClause" => " and vip_level = 0"),
        "升级阵法" => array("jsonName" => "upgrade_formation", "tableName" => "upgrade_formation", "whereClause" => ""),
        "拜访高人" => array("jsonName" => "visit_master", "tableName" => "visit_master", "whereClause" => "")
        //"创建帮派" => array("jsonName" => "create_faction", "tableName" => "create_faction", "whereClause" => ""),
        //"帮战报名" => array("jsonName" => "apply_faction_battle", "tableName" => "signup_in_faction_battle", "whereClause" => "")
    );


    /**
     * 日黄金消费类型分布
     */
    public function actionIndex()
    {
        $select = Util::getRealServerSelect();
        $list = array();
        $param = $this->getParam(array('begintime', 'endtime', 'server_id'));
        if(Yii::app()->request->isAjaxRequest){
            $list = $this->getCostType($param);
            echo json_encode(array(
                'success'=>true,
                'data'=>$list
            ));
        }else{
            $this->render('index', array('select' => $select, 'list' => $list));
        }
    }

    /*
     * 获取日黄金消费类型分布
     */
    protected  function getCostType($param){
        $list = array();
        if(!empty($param['begintime']) && !empty($param['endtime']) && is_numeric($param['server_id'])){
            $create_time = Util::getServerAttribute($param['server_id'], 'create_time');
            $param['begintime'] = $param['begintime'] > $create_time ? $param['begintime'] :  substr($create_time, 0, 10);
            $end_time = strtotime($param['endtime']);
            $limit = ($end_time - strtotime($param['begintime']))/86400;
            for($i = 0; $i <= $limit;$i++){
                $date = date('Y-m-d',($end_time - 86400 * $i));
                $temp = Yii::app()->db->createCommand()->select('type_id, sum(gold) as gold')->from('statistic_gold_cost_type');
                //全区全服数据统计
                if(empty($param['server_id'])){
                    $temp = $temp->where("`date` = :date", array(':date' => $date));
                }else{
                //单服数据统计
                    $temp = $temp->where("`server_id` = :server_id AND `date` = :date", array(':server_id' => $param['server_id'], ':date' => $date));
                }
                $temp = $temp->group('type_id')->queryAll();
                $res['date'] = $date;
                $res['server_id'] = $param['server_id'];
                $sum = 0;
                if(count($temp)){
                    foreach($temp as $k => $v){
                        $sum += $v['gold'];
                        $res[$v['type_id']] = $v['gold'];
                    }
                }
                $res['sum'] = $sum;
                $list[] = $res;
                unset($res);
            }
        }
        return $list;
    }

    /*
     * 导出黄金类型分布
     */
    public function actionCostTypeExport(){
        $title = '黄金类型分布';
        $list = array();
        $param = $this->getParam(array('begintime', 'endtime', 'server_id'));
        $list = $this->getCostType($param);
        header("Content-Type: application/vnd.ms-excel;charset=utf8");
        header("Content-Disposition: attachment; filename=".$title.".xls");
        $header = iconv("UTF-8","GB2312//IGNORE",'日期')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'服务器')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'购买精力')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'精炼洗髓')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'黄金刷新')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'解锁包格')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'远程仓库&商店')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'成功率100%')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'强化秒CD')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'重置英雄本')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'加速挂机')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'兑换银两')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'寻访')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'解锁秘籍格')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'合成装备')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'扩地')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'刷新种子')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'种地秒CD')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'增加次数')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'舞林大会秒CD')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'复活BOSS')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'鼓舞')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'招人')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'捐献')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'帮派鼓舞')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'帮派秒CD')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'门派竞技鼓舞')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'日常任务秒CD')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'刷新星级')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'一键完成')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'充值大礼包')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'汇总')."\n";
        echo $header;
        //var_dump($list);exit;
        foreach($list as $k => $v){
            for($i=0;$i<=30;$i++){
                $v[$i] = isset($v[$i]) ? $v[$i] : 0;
            }
            $v['server_id'] = Util::getServerAttribute($v['server_id'], 'sname');
            $v['server_id'] = iconv("UTF-8","GB2312//IGNORE",$v['server_id']);
            echo "{$v['date']}\t"."{$v['server_id']}\t"."-{$v[0]}\t"."-{$v[1]}\t"."-{$v[25]}\t"."-{$v[2]}\t"."-{$v[3]}\t"."-{$v[4]}\t"."-{$v[5]}\t".
                 "-{$v[6]}\t"."-{$v[7]}\t"."-{$v[8]}\t"."-{$v[10]}\t"."-{$v[9]}\t"."-{$v[11]}\t"."-{$v[12]}\t"."-{$v[13]}\t"."-{$v[14]}\t"."-{$v[15]}\t".
                 "-{$v[16]}\t"."-{$v[17]}\t"."-{$v[18]}\t"."-{$v[19]}\t"."-{$v[20]}\t"."-{$v[26]}\t"."-{$v[21]}\t"."-{$v[22]}\t"."-{$v[23]}\t"."-{$v[24]}\t".
                 "-{$v[27]}\t"."-{$v[28]}\t"."-{$v['sum']}\n";
        }
    }

    /**
     * 日黄金兑换、消费
     */
    public function actionDayGoldExchange()
    {
        $select = Util::getRealServerSelect();
        $list = array();
        if(Yii::app()->request->isAjaxRequest){
            $param = $this->getParam(array('server_id','endtime'));
            $create_time = Util::getServerAttribute($param['server_id'], 'create_time');
            $create_date = substr($create_time, 0, 10);
            $list = $this->getDayGoldExchange($param, $create_date);
            echo json_encode(array(
                'success'=>true,
                'data'=>$list
            ));
        }else {
             $this->render('day_gold_exchange',  array('select' => $select, 'list' => $list));
        }
    }

    /*
     * 日黄金兑换、消费
     */
    protected  function getDayGoldExchange($param, $create_date){
        $list = array();
        if(is_numeric($param['server_id']) && !empty($param['endtime'])){
            for($i=0;$i<=29;$i++){
                $res = array();
                $res['date'] = date('Y-m-d',(strtotime($param['endtime']) - 86400*$i));
                if($create_date <= $res['date']){
                    $res['server_id'] = $param['server_id'];
                    $cost_total_query = Yii::app()->db->createCommand()->select('IFNULL(SUM(gold),0) AS cost_tot')->from('statistic_gold_cost_type');
                    $cost_day_query = Yii::app()->db->createCommand()->select('IFNULL(SUM(gold),0) AS cost_day')->from('statistic_gold_cost_type');
                    $yesterday = date('Y-m-d', strtotime($res['date']) - 86400);
                    //小于开服时间的余额为0 不统计
                    if($yesterday < $create_date && !empty($param['server_id'])){
                        $yesterday_blance = 0;
                    }else{
                        if(!empty($param['server_id'])){
                            $yesterday_blance = Yii::app()->db->createCommand()->select('sum(total_balance) as total_balance')->from('statistic_gold_cost_exchange')
                                            ->where('server_id = :server_id AND `date` = :date',array(':server_id' => $param['server_id'], ':date' => $yesterday))
                                            ->queryScalar();
                        }else{
                            $yesterday_blance = Yii::app()->db->createCommand()->select('sum(total_balance) as total_balance')->from('statistic_gold_cost_exchange')
                                            ->where('`date` = :date',array(':date' => $yesterday))->queryScalar();
                        }
                    }
                    //单服数据统计
                    if(!empty($param['server_id'])){
                        $res['cost_total'] = $cost_total_query->where('server_id = :server_id AND `date` <= :date AND `date` >= :create_date',
                                            array(':server_id' => $param['server_id'], ':date' => $res['date'], ':create_date' => $create_date))
                                            ->queryScalar();
                         $res['cost_day'] = $cost_day_query->where('server_id = :server_id AND `date` = :date', array(':server_id' => $param['server_id'],
                                           ':date' => $res['date']))->queryScalar();
                         $row = Yii::app()->db->createCommand()->from('statistic_gold_cost_exchange')
                                      ->where('server_id = :server_id AND `date` = :date', array(':server_id' => $param['server_id'], ':date' => $res['date']))
                                      ->queryRow();
                    //全区全服数据统计
                    }else{
                        $res['cost_total'] = $cost_total_query->where('`date` <= :date AND `date` >= :create_date',array(':date' => $res['date'],
                                                 ':create_date' => $create_date))->queryScalar();
                         $res['cost_day'] = $cost_day_query->where('`date` = :date', array(':date' => $res['date']))->queryScalar();
                         $row = Yii::app()->db->createCommand()->select('sum(give_gold) as give_gold, sum(total_give_gold) as total_give_gold, sum(total_balance) as total_balance')
                                          ->from('statistic_gold_cost_exchange')->where('`date` = :date', array(':date' => $res['date']))->queryRow();
                    }
                    $res['give_gold'] = $row['give_gold'];
                    $res['total_give_gold'] = $row['total_give_gold'];
                    $res['total_balance'] = $row['total_balance'];
                    $res['balance'] = $row['total_balance'] - $yesterday_blance;
                    $list[] = $res;
                }
            }
        }
        return $list;
    }

    /*
     * 日黄金兑换、消费导出
     */
    public function actionDayGoldExchangeExport(){
        $title = '日黄金兑换、消费';
        $list = array();
        $param = $this->getParam(array('server_id','endtime'));
        $create_time = Util::getServerAttribute($param['server_id'], 'create_time');
        $create_date = substr($create_time, 0, 10);
        $list = $this->getDayGoldExchange($param, $create_date);
        header("Content-Type: application/vnd.ms-excel;charset=utf8");
        header("Content-Disposition: attachment; filename=".$title.".xls");
        $header = iconv("UTF-8","GB2312//IGNORE",'日期')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'服务器')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'兑换金额')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'赠送金额')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'消费金额')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'余额')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'今日兑换金额')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'今日赠送金额')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'今日消费金额')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'今日余额')."\n";
        echo $header;
        foreach ($list as $k => $v){
            $v['server_id'] = Util::getServerAttribute($v['server_id'], 'sname');
            $v['server_id'] = iconv("UTF-8","GB2312//IGNORE",$v['server_id']);
            echo "{$v['date']}\t"."{$v['server_id']}\t"."\t"."\t"."-{$v['cost_total']}\t"."{$v['total_balance']}\t"."\t"."\t".
                 "-{$v['cost_day']}\t"."{$v['balance']}\n";
        }
    }

    /**
     * 月充值日兑换清单
     */
    public function actionMonthGoldExchange()
    {
        $this->render('month_gold_exchange');
    }

    private function calcTotalSilverConsumption($serverId)
    {
        $result = array();
        foreach ($this->silverConsumptionType as $key => $value)
        {
            $silver = Yii::app()->db->createCommand()->select("sum(silver) as s ")->from($value['tableName'])
                            ->where("server_id = :server_id " . $value['whereClause'],array(":server_id" => $serverId))->queryScalar();
            $silver = empty($silver) ? 0 : abs($silver);
            $result[$value['jsonName']] = $silver;
        }
        $silver = Yii::app()->db->createCommand()->select('count(*) as c')->from('create_faction')
                        ->where('server_id = :server_id', array(":server_id" => $serverId))->queryScalar();
        $silver = empty($silver) ? 0 : abs($silver);
        $result['create_faction'] = $silver * 200000;
        $silver = Yii::app()->db->createCommand()->select('count(*) as c')->from('signup_in_faction_battle')
                    ->where('server_id = :server_id', array(":server_id" => $serverId))->queryScalar();
        $silver = empty($silver) ? 0 : abs($silver);
        $result['apply_faction_battale'] = $silver * 100000;
        $result['time'] = date('Y-m-d');
        $result['serverId'] = $serverId;
        return $result;
    }

    private function calcSilverConsumptionByDate($serverId, $dt)
    {
        $start_of_day = mktime(0, 0, 0, date('m', $dt), date('d', $dt), date('Y', $dt));
        $end_of_day = mktime(23, 59, 59, date('m', $dt), date('d', $dt), date('Y', $dt));
        $param = array(":server_id" => $serverId, ":start_day" => $start_of_day, ":end_day" => $end_of_day);
        $timeWhereClause = " and time <= :end_day and time >= :start_day";
        $result = array();
        foreach ($this->silverConsumptionType as $key => $value)
        {
            $silver = Yii::app()->db->createCommand()->select("sum(silver) as s ")->from($value['tableName'])
                            ->where("server_id = :server_id " . $value['whereClause'] . $timeWhereClause,  $param)->queryScalar();
            $silver = empty($silver) ? 0 : abs($silver);
            $result[$value['jsonName']] = $silver;
        }
        $silver = Yii::app()->db->createCommand()->select('count(*) as c')->from('create_faction')
                        ->where('server_id = :server_id' . $timeWhereClause, $param)->queryScalar();
        $silver = empty($silver) ? 0 : abs($silver);
        $result['create_faction'] = $silver * 200000;
        $silver = Yii::app()->db->createCommand()->select('count(*) as c')->from('signup_in_faction_battle')
                    ->where('server_id = :server_id' . $timeWhereClause, $param)->queryScalar();
        $silver = empty($silver) ? 0 : abs($silver);
        $result['apply_faction_battale'] = $silver * 100000;
        $result['time'] = date('Y-m-d', $dt);
        $result['serverId'] = $serverId;
        return $result;
    }

    /**
     * 银两消耗
     */
    public function actionSilverConsume()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $result = array();
            $serverId = $this->getParam("serverId");
            $search_type = $this->getParam("search_type");
            if ($search_type == 0)
            {
                array_push($result, $this->calcTotalSilverConsumption($serverId));
            }
            else
            {
                $timeRanges = TimeUtils::calcDateRanges($this->getParam("begintime"), $this->getParam("endtime"));
                foreach ($timeRanges as $time)
                {
                    array_push($result, $this->calcSilverConsumptionByDate($serverId, strtotime($time)));
                }
            }
            echo json_encode($result);
        }
        else
        {
            $select = Util::getRealServerSelect(false);
            $this->render('silver_consume',array('select' => $select));
        }
    }

    /**
     * 银两产出
     */
    public function actionSilverOutput()
    {
        $select = Util::getRealServerSelect(false);
        $this->render('silver_output',array(
            'select' => $select
        ));
    }

    private function calcTotalGiftGoldProduction($serverId)
    {
         $result = array();
         foreach ($this->gift_gold_producer as $key => $value)
         {
             $tableName = $value['tableName'];
             $jsonName = $value['jsonName'];
             $whereClause = $value['whereClause'];
             $giftGold = Yii::app()->db->createCommand()->select("sum(gift_gold) as amount")->from($tableName)
             ->where("server_id=:server_id" . $whereClause, array(":server_id" => $serverId))->queryScalar();
             if (empty($giftGold)){
                 $giftGold = 0;
             }
             $result[$jsonName] = $giftGold;
        }
        $result['time'] = date('Y-m-d');
        $result['serverId'] = $serverId;
        return $result;
    }

    private function calcGiftGoldProductionByDate($serverId, $dt)
    {
        $start_of_day = mktime(0, 0, 0, date('m', $dt), date('d', $dt), date('Y', $dt));
        $end_of_day = mktime(23, 59, 59, date('m', $dt), date('d', $dt), date('Y', $dt));
        $param = array(":server_id" => $serverId, ":start_day" => $start_of_day, ":end_day" => $end_of_day);
        $result = array();
         foreach ($this->gift_gold_producer as $key => $value)
         {
             $tableName = $value['tableName'];
             $jsonName = $value['jsonName'];
             $whereClause = $value['whereClause'];
             $timeWhereClause = $value['timeWhereClause'];
             $giftGold = Yii::app()->db->createCommand()->select("sum(gift_gold) as amount")->from($tableName)
             ->where("server_id=:server_id" . $whereClause . $timeWhereClause, $param)->queryScalar();
             if (empty($giftGold)){
                 $giftGold = 0;
             }
             $result[$jsonName] = $giftGold;
        }
        $result['time'] = date('Y-m-d', $dt);
        $result['serverId'] = $serverId;
        return $result;
    }

    /**
     * 礼金产出
     */
    public function actionGiftGoldOutput()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $result = array();
            $serverId = $this->getParam("serverId");
            $search_type = $this->getParam("search_type");
            if ($search_type == 0)
            {
                array_push($result, $this->calcTotalGiftGoldProduction($serverId));
            }
            else
            {
                $timeRanges = TimeUtils::calcDateRanges($this->getParam("begintime"), $this->getParam("endtime"));
                foreach ($timeRanges as $time)
                {
                    array_push($result, $this->calcGiftGoldProductionByDate($serverId, strtotime($time)));
                }
            }
            echo json_encode($result);
        }
        else
        {
            $select = Util::getRealServerSelect(false);
            $this->render('gift_gold_output',array( 'select' => $select));
        }
    }

    /**
     * 道具产出
     */
    public function actionPropsOutput()
    {
        $select = Util::getRealServerSelect(false);
        $this->render('props_output',array(
            'select' => $select
        ));
    }

    /**
     * 消费日志
     */
    public function actionConsumeRecord()
    {
        $param = $this->getParam(array('role_name', 'server_id', 'begintime', 'endtime', 'user_account', 'page', 'consume_type'));
        $list = array();
        if(Yii::app()->request->isAjaxRequest){
            $res = $this->getConsumeRecord($param);
            $list = $res['list'];
            $count = $res['count'];
            echo json_encode(array(
                "dataCount" => $count,
                "dataList" => $list
            ));
        }else{
            $select = Util::getRealServerSelect(false);
            $this->render('consume_record',array('list' => $list, 'select'=>$select, 'consume' => AppConst::$consume));
        }
    }

    /*
     * 获取消费日志数据
     */
    protected function getConsumeRecord($param, $export = false){
        $bind = array();
        $list = array();
        $where = ' ret = 0';
        $bind = array();
        $role_ids = '';
        $count = 0;
        if(!empty($param['consume_type'])){
            $temp = AppConst::$consume;
            $type = array_flip($temp);
            $where .= ' AND b.payItem = :payItem';
            $bind[':payItem'] = $type[$param['consume_type']];
        }
        if(!empty($param['server_id'])){
            $where .= ' AND b.server_id = :server_id';
            $bind[':server_id'] = $param['server_id'];
        }
        if(!empty($param['role_name'])){
            $arr = explode('|', $param['role_name']);
            foreach ($arr as $k => $v){
                $role_id = Util::getPlayerAccount($v, $param['server_id']);
                if(!empty($role_id)){
                    $role_ids .= "'{$role_id}',";
                }
            }
            $role_ids = substr($role_ids, 0, (strlen($role_ids) - 1));
            $where .= " AND b.openid IN ({$role_ids})";
        }
        if(!empty($param['user_account'])){
            $where .= ' AND b.openid = :role_name';
            $bind[':role_name'] = $param['user_account'];
        }
        if(!empty($param['begintime'])){
            $where .= ' AND b.ts >= :begintime';
            $bind[':begintime'] = $param['begintime'];
        }
        if(!empty($param['endtime'])){
            $where .= ' AND b.ts <= :endtime';
            $bind[':endtime'] = $param['endtime'];
        }
        $offset = empty($param['page']) ? 0 : ($param['page'] - 1) * Pages::LIMIT;
         if($export){
            $list = Yii::app()->db->createCommand()->select('b.server_id, b.openid, b.ts, b.ret, b.balance, b.payItem, b.billno')->from('pre_pay as b')
                    ->where($where,$bind)->offset($offset)->limit(10000)->order('ts DESC')->queryAll();
        }else{
            $count = Yii::app()->db->createCommand()->select('count(openid) as count')->from('pre_pay as b')->where($where,$bind)->queryScalar();
            $list = Yii::app()->db->createCommand()->select('b.server_id, b.openid, b.ts, b.ret, b.balance, b.payItem, b.billno')->from('pre_pay as b')
                    ->where($where,$bind)->offset($offset)->limit(Pages::LIMIT)->order('ts DESC')->queryAll();
        }
        if(count($list)){
            foreach ($list as $k => $v){
                $list[$k]['role_name'] = Util::getPlayerRoleName($v['openid'], intval($v['server_id']));
            }
        }
        $res['list'] = $list;
        $res['count'] = $count;
        return $res;
    }

    /*
     * 消费日志导出
     */
    public function actionConsumeRecordExport(){
        set_time_limit(0);
        ini_set('memory_limit','2048M');
        $param = $this->getParam(array('role_name', 'server_id', 'begintime', 'endtime', 'user_account', 'page', 'consume_type'));
        $title = '消费日志';
        header("Content-Type: application/vnd.ms-excel;charset=utf8");
        header("Content-Disposition: attachment; filename=".$title.".xls");
        $header = iconv("UTF-8","GB2312//IGNORE",'服务器')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'帐号名')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'角色名')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'消费时间')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'消费类型')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'消费金额')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'订单号')."\n";
        echo $header;
        $res = $this->getConsumeRecord($param, true);
        $list = $res['list'];
            if (count($list)) {
                foreach ($list as $k => $v) {
                    $server = Util::getServerAttribute($v['server_id']);
                    echo iconv("UTF-8","GB2312//IGNORE",(isset($server->sname) ? $server->sname : ''))."\t" ;
                    echo (isset($v["openid"]) ? $v["openid"] : 0)."\t";
                    echo iconv("UTF-8","GB2312//IGNORE",(isset($v['role_name']) ? $v['role_name'] : ''))."\t" ;
                    echo (isset($v["ts"]) ? $v["ts"] : 0)."\t";
                    echo iconv("UTF-8","GB2312//IGNORE",(isset($v["payItem"]) && isset(AppConst::$consume[$v["payItem"]])) ? AppConst::$consume[$v["payItem"]] : $v["payItem"])."\t" ;
                    echo (isset($v["balance"]) ? $v["balance"] : 0)."\t";
                    echo (isset($v["billno"]) ? $v["billno"] : '')."\n";
                }
        }
    }

    /**
     * 老玩家消费统计
     */
    public function actionOldPlayerConsume(){
        if(Yii::app()->request->isAjaxRequest){
            $param = $this->getParam(array('begintime', 'endtime', 'server_id'));
            $where = '1';
            $bind = array();
            if(!empty($param['server_id'])){
                $where .= ' and server_id = :server_id';
                $bind[':server_id'] = $param['server_id'];
            }
            if(!empty($param['begintime'])){
                $where .= ' and date >= :begintime';
                $bind[':begintime'] = $param['begintime'];
            }
            if(!empty($param['endtime'])){
                $where .= ' and date <= :endtime';
                $bind[':endtime'] = $param['endtime'];
            }
            $list = Yii::app()->db->createCommand()->from('statistic_old_player_pay')->where($where, $bind)->queryAll();
            echo json_encode($list);
        }else{
        	$select = Util::getRealServerSelect(false);
            $this->render('old_player_consume',array( 'select' => $select));
        }
    }

    /*
     * 老玩家列表
     */
    public function actionOldPlayerList(){
        if(Yii::app()->request->isAjaxRequest){
            $param = $this->getParam(array('begintime', 'server_id', 'page'));
            $param['endtime'] = date('Y-m-d', (strtotime($param['begintime']) + 86400));
            $where = '1';
            $bind = array();
            if(!empty($param['server_id'])){
                $where .= ' and server_id = :server_id';
                $bind[':server_id'] = $param['server_id'];
            }
            if(!empty($param['begintime'])){
                $where .= ' and dt >= :begintime';
                $bind[':begintime'] = $param['begintime'];
                $where .= ' and dt < :endtime';
                $bind[':endtime'] = $param['endtime'];
            }
            $offset = empty($param['page']) ? 0 : ($param['page'] - 1) * Pages::LIMIT;
            $count = Yii::app()->db->createCommand()->select('count(distinct role_name) as count')->from('statistic_old_player')->where($where, $bind)->queryScalar();
            $list = Yii::app()->db->createCommand()->select('role_name')->from('statistic_old_player')->where($where, $bind)->offset($offset)->limit(Pages::LIMIT)->queryAll();
            echo json_encode(array(
            	"dataCount" => $count,
            	"dataList" => $list
                ));
        }
    }
}
