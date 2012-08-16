<?php

class DefaultController extends Controller
{
    public function beforeAction($action) {
        set_time_limit(1200);
        ini_set('memory_limit', '2048M');
        return parent::beforeAction($action);
    }

    /**
     * 生成历史留存率数据 包含截止日期
     * @param $from_day 开始日期
     * @param $end_day 截止日期
     */
    public function actionGenerateRetentionRateData(){
        $param = $this->getParam(array('from_day','end_day'));
        if(empty($param['from_day']) || !preg_match('/^\d{4}\-\d{2}\-\d{2}$/', $param['from_day']) || strlen($param['from_day']) != 10){
            throw new CException('param from_day error , for example 2012-06-06');
        }
        $num = 0;
        if(!empty($param['end_day'])){
            if(!preg_match('/^\d{4}\-\d{2}\-\d{2}$/', $param['end_day']) || strlen($param['end_day']) != 10){
                throw new CException('param end_day error , for example 2012-06-06');
            }
            $num = (strtotime($param['end_day']) - strtotime($param['from_day'])) / 86400;

        }
        $transaction = Yii::app()->db->beginTransaction();
        try {
            if($num > 0){
                for ($j = 0; $j <= $num; $j++) {
                    if($param['from_day'] <= $param['end_day']){
                        $this->insertRetentionRateData($param['from_day']);
                        $param['from_day'] = date('Y-m-d', (strtotime($param['from_day']) + 86400));
                    }
                }
            }else{
                $this->insertRetentionRateData($param['from_day']);
            }
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            Util::log('生成历史留存率数据异常' . $e->getMessage(), 'tools', __FILE__, __LINE__);
        }
    }

    /**
     * 留存率数据插入 默认统计30天
     * @param date $from_day
     */
    protected function insertRetentionRateData($from_day){
         for ($i = 1; $i < 31; $i++) {
            $day = date('Y-m-d', (strtotime($from_day) - 86400*$i));
//            $res = Yii::app()->db->createCommand()->select('a.server_id,COUNT(a.openid) AS num')->from('dau AS a')
//                        ->leftJoin('installation AS b', 'a.server_id = b.server_id AND a.openid = b.openid')
//                        ->where("b.ts LIKE '{$day}%'  AND a.ts LIKE '{$from_day}%'")
//                        ->group('server_id')
//                        ->queryAll();
            $begintime = strtotime($day);
            $endtime = $begintime + 86400;
            $res = Yii::app()->db->createCommand()->select('a.server_id,COUNT(a.openid) AS num')->from('dau AS a')
                    ->leftJoin('create_role AS b', 'a.server_id = b.server_id AND a.openid = b.role_id')
                    ->where("b.time >= {$begintime} AND b.time < {$endtime} AND a.ts LIKE '{$from_day}%'")
                    ->group('server_id')
                    ->queryAll();
            if(count($res)){
                foreach ($res as $value) {
                    Yii::app()->db->createCommand()->insert('retention_rate', array('server_id' => $value['server_id'],
                            'current_day' => $from_day, 'compare_day' => $day, 'num' => $value['num']));
                }
            }
        }
    }

    /*
     * 生成历史黄金消费类型分布数据 包含截止日期
     * @param $from_day 开始日期
     * @param $end_day 截止日期
     */
    public function actionGenerateDayGoldCostTypeDistribution(){
        $param = $this->getParam(array('from_day','end_day'));
        if(empty($param['from_day']) || !preg_match('/^\d{4}\-\d{2}\-\d{2}$/', $param['from_day']) || strlen($param['from_day']) != 10){
            throw new CException('param from_day error , for example 2012-06-06');
        }
        $num = 0;
        if(!empty($param['end_day'])){
            if(strlen($param['end_day']) != 10 || !preg_match('/^\d{4}\-\d{2}\-\d{2}$/', $param['end_day'])){
                throw new CException('param end_day error , for example 2012-06-06');
            }
            $num = (strtotime($param['end_day']) - strtotime($param['from_day'])) / 86400;
        }
        $transaction = Yii::app()->db->beginTransaction();
        try{
            for($i = 0; $i <= $num; $i++){
                $table = array('buy_vitality', 'xisui','unlock_package_slot','remote_open_package',
                                'strengthen_item','clear_strengthen_cd','refresh_elite_dungeon','accelerate_auto_fighting',
                                'exchange_silver','unlock_book_slot','seek_hight_level_master','synthesis_equipment',
                                'unlock_earth','refresh_seed','clear_earth_cd','add_challenge_times','clear_challenge_cd',
                                'revive_in_world_boss','encourage_in_world_boss','send_faction_enrollment_notification','donate_to_faction',
                                'rivive_in_faction_battle','encourage_in_clan_fight','clear_daily_task_cd','refresh_daily_task','refresh_partner',
                                'encourage_in_faction','auto_finish_daily_task','use_item');
                $begin_time = strtotime($param['from_day']) + ($i * 86400);
                $time = date('Y-m-d',$begin_time);
                $end_time = strtotime($param['from_day']) + (($i + 1) * 86400);
                foreach ($table as $key => $value) {
                    $res = Yii::app()->db->createCommand()->select('server_id, SUM(gold) AS sum, time')->from($value)
                            ->where("`time` >= :begin_time AND `time` < :end_time",array(':begin_time' => $begin_time, ':end_time' => $end_time))
                            ->group('server_id')->queryAll();
                    if(count($res)){
                        foreach ($res as $k  => $v){
                            Yii::app()->db->createCommand()->insert('statistic_gold_cost_type', array('server_id' => $v['server_id'],
                                'date' => $time, 'gold' => $v['sum'], 'type_id' => $key));
                        }
                    }
                }
            }
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            Util::log('生成历史黄金消费分布数据异常' . $e->getMessage(), 'tools', __FILE__, __LINE__);
        }
    }

    /*
     * 生成历史黄金消费消费 兑换数据 包含截止日期
     * @param $from_day 开始日期
     * @param $end_day 截止日期
     */
    public function actionGenerateDayGoldCostExchange(){
        $param = $this->getParam(array('from_day','end_day'));
        if(empty($param['from_day']) || !preg_match('/^\d{4}\-\d{2}\-\d{2}$/', $param['from_day']) || strlen($param['from_day']) != 10){
            throw new CException('param from_day error , for example 2012-06-06');
        }
        $num = 0;
        if(!empty($param['end_day'])){
            if(strlen($param['end_day']) != 10 || !preg_match('/^\d{4}\-\d{2}\-\d{2}$/', $param['end_day'])){
                throw new CException('param end_day error , for example 2012-06-06');
            }
            $num = (strtotime($param['end_day']) - strtotime($param['from_day'])) / 86400;
        }
        $transaction = Yii::app()->db->beginTransaction();
        try{
            for($i = 0; $i <= $num; $i++){
                $begin_time = strtotime($param['from_day']) + ($i * 86400);
                $end_time = $begin_time + 86400;
                $begin_date = date('Y-m-d', $begin_time);
                $end_date = date('Y-m-d', $end_time);
                $result = array();
                //当天余额
                $balance_res = Yii::app()->db->createCommand()->select('server_id, IFNULL(SUM(balance),0) AS balance')->from('tencent_balance')
                                   ->where("`ts` >= :begin_date AND `ts` < :end_date",array(':begin_date' => $begin_date, ':end_date' => $end_date))
                                   ->group('server_id')->queryAll();
                if(count($balance_res)){
                   foreach ($balance_res as $v) {
                       $result[$v['server_id']]['balance'] = $v['balance'];
                   }
                }
                //截止到当前日期余额
                $total_balance_res = Yii::app()->db->createCommand()->select('server_id, IFNULL(SUM(balance),0) AS total_balance')->from('tencent_balance')
                                           ->where("`ts` < :end_date",array(':end_date' => $end_date))->group('server_id')->queryAll();
                if(count($total_balance_res)){
                    foreach ($total_balance_res as $v) {
                        $result[$v['server_id']]['total_balance'] = $v['total_balance'];
                    }
                }
                //当天赠送金额
                $item_res = Yii::app()->db->createCommand()->select('server_id, IFNULL(SUM(gold),0) AS give_gold')->from('use_item')
                               ->where("`time` >= :begin_time AND `time` < :end_time",array(':begin_time' => $begin_time, ':end_time' => $end_time))
                               ->group('server_id')->queryAll();
                if(count($item_res)){
                    foreach ($item_res as $v) {
                        $result[$v['server_id']]['give_gold'] = $v['give_gold'];
                    }
                }
                //截止到当期日前赠送金额
                $total_item_res = Yii::app()->db->createCommand()->select('server_id, IFNULL(SUM(gold),0) AS total_give_gold')->from('use_item')
                                       ->where("`time` < :end_time",array(':end_time' => $end_time))->group('server_id')->queryAll();
                if(count($total_item_res)){
                    foreach ($total_item_res as $v) {
                        $result[$v['server_id']]['total_give_gold'] = $v['total_give_gold'];
                    }
                }
                if(count($result)){
                    foreach ($result as $k => $v) {
                        $v['balance'] = isset($v['balance']) ? $v['balance'] : 0;
                        $v['total_balance'] = isset($v['total_balance']) ? $v['total_balance'] : 0;
                        $v['total_give_gold'] = isset($v['total_give_gold']) ? $v['total_give_gold'] : 0;
                        $v['give_gold'] = isset($v['give_gold']) ? $v['give_gold'] : 0;
                        Yii::app()->db->createCommand()->insert('statistic_gold_cost_exchange', array('server_id' => $k,
                            'date' => $begin_date, 'total_give_gold' => $v['total_give_gold'], 'give_gold' => $v['give_gold'],
                            'total_balance' => $v['total_balance'], 'balance' => $v['balance']));
                    }
                }
            }
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            Util::log('生成历史黄金消费 兑换数据异常' . $e->getMessage(), 'tools', __FILE__, __LINE__);
        }
    }

    /*
     * 生成日注册登录历史数据
     */

    public function actionGenerateRegisterLogin(){
        $param = $this->getParam(array('from_day', 'end_day'));
        if(empty($param['from_day']) || !preg_match('/^\d{4}\-\d{2}\-\d{2}$/', $param['from_day']) || strlen($param['from_day']) != 10){
            throw new CException('param from_day error , for example 2012-06-06');
        }
        $num = 0;
        if(!empty($param['end_day'])){
            if(!preg_match('/^\d{4}\-\d{2}\-\d{2}$/', $param['end_day']) || strlen($param['end_day']) != 10){
                throw new CException('param end_day error , for example 2012-06-06');
            }else{
                $num = (strtotime($param['end_day']) - strtotime($param['from_day'])) / 86400;
            }
        }
        $transaction = Yii::app()->db->beginTransaction();
        try {
            for($i=0; $i<=$num; $i++){
                $list = array();
                $com_date = date('Y-m-d', strtotime($param['from_day']) + 86400*$i);
                $reg_date = date('Y-m-d',(strtotime($com_date)+ 86400));
                $register_tot = Yii::app()->db->createCommand()->select('COUNT(DISTINCT openid) AS register_tot, server_id')->from('installation')
                    ->where('ts <= :date',array(':date' => $reg_date))->group('server_id')->queryAll();
                if(count($register_tot)){
                    foreach ($register_tot as $k => $v){
                        $list[$v['server_id']]['register_tot'] = $v['register_tot'];
                    }
                }
                $login_tot = Yii::app()->db->createCommand()->select('COUNT(DISTINCT openid) AS login_tot, server_id')->from('dau')
                    ->where('ts LIKE CONCAT(:date,"%")', array(':date' => $com_date))->group('server_id')->queryAll();
                if(count($login_tot)){
                    foreach ($login_tot as $k => $v){
                        $list[$v['server_id']]['login_tot'] = $v['login_tot'];
                    }
                }
                $register_day = Yii::app()->db->createCommand()->select('COUNT(DISTINCT openid) AS register_day, server_id')->from('installation')
                    ->where('ts LIKE CONCAT(:date,"%")', array(':date' => $com_date))->group('server_id')->queryAll();
                if(count($register_day)){
                    foreach ($register_day as $k => $v){
                        $list[$v['server_id']]['register_day'] = $v['register_day'];
                    }
                }
                $login_day = Yii::app()->db->createCommand()->select('COUNT(DISTINCT a.openid) AS login_day, a.server_id')->from('dau AS a')
                    ->leftJoin('installation AS b','a.server_id = b.server_id AND a.openid = b.openid')
                    ->where('a.ts LIKE CONCAT(:date,"%") AND b.ts LIKE CONCAT(:date,"%")',
                            array(':date' => $com_date, ':date' => $com_date,))->group('a.server_id')->queryAll();
                if(count($login_day)){
                    foreach($login_day as $k => $v){
                        $list[$v['server_id']]['login_day'] = $v['login_day'];
                    }
                }
                $create_tot = Yii::app()->db->createCommand()->select('COUNT(DISTINCT role_id) AS create_tot, server_id')->from('create_role')
                    ->where('time < :endtime', array(':endtime' => (strtotime($com_date)+ 86400)))
                    ->group('server_id')->queryAll();
                if(count($create_tot)){
                    foreach($create_tot as $k => $v){
                        $list[$v['server_id']]['create_tot'] = $v['create_tot'];
                    }
                }
                $create_day = Yii::app()->db->createCommand()->select('COUNT(DISTINCT role_id) AS create_day, server_id')->from('create_role')
                    ->where('time < :endtime AND time >= :begintime', array(':endtime' => (strtotime($com_date)+ 86400), ':begintime' => strtotime($com_date)))
                    ->group('server_id')->queryAll();
                if(count($create_day)){
                    foreach($create_day as $k => $v){
                        $list[$v['server_id']]['create_day'] = $v['create_day'];
                    }
                }
                if(count($list)){
                    foreach ($list as $k => $v){
                        $check = Util::getServerAttribute($k, 'create_time');
                        if(empty($check) || $check < $reg_date){
                            $register_tot = isset($v['register_tot']) ?  $v['register_tot'] : 0;
                            $login_tot = isset($v['login_tot']) ?  $v['login_tot'] : 0;
                            $register_day = isset($v['register_day']) ?  $v['register_day'] : 0;
                            $login_day = isset($v['login_day']) ? $v['login_day'] : 0;
                            $create_day = isset($v['create_day']) ?  $v['create_day'] : 0;
                            $create_tot = isset($v['create_tot']) ?  $v['create_tot'] : 0;
                            Yii::app()->db->createCommand()->insert('statistic_register_login', array('server_id' => $k, 'register_tot' => $register_tot,
                                    'login_tot' => $login_tot, 'register_day' => $register_day, 'login_day' => $login_day, 'date' => $com_date, 'create_day' => $create_day, 'create_tot' => $create_tot));
                        }
                    }
                }
            }
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            Util::log('生成历史日注册登录数据异常' . $e->getMessage(), 'tools', __FILE__, __LINE__);
        }
    }

     /*
     * 生成VIP玩家分析数据
     *$table 数组   0：购买精力 1：洗髓  2：解锁包囊 3：远程打开包囊 4：加强物品 5：强化物品秒CD 6：刷新精英副本 7： 加速挂机 8：兑换银两 9：解锁秘籍方格 10：寻访
     *11：合成装备 12： 开拓荒地  13：刷新种子 14: 药园清除cd时间 15:武林大会增加挑战次数  16:武林大会请求清除CD时间 17:世界boss复活 18:世界boss鼓舞
     *19:帮会战复活 20:门派战鼓舞 21:清除日常任务cd时间 22:刷新日常任务星级 23:刷新伙伴 24:帮派战鼓舞 25:一键完成日常任务 26:用道具要花钱
     */
    public function actionGenerateVipPlayer(){
        $begin_day = $this->getParam('from_day');
        if(empty($begin_day) || !preg_match('/^\d{4}\-\d{2}\-\d{2}$/', $begin_day) || strlen($begin_day) != 10){
            throw new CException('param from_day error , for example 2012-06-06');
        }
        $begin_time = strtotime($begin_day);
        $end_time = $begin_time + 86400;
        $end_day = date('Y-m-d', $end_time);
        $list = $res = array();
        $servers = Util::getAllServers();
        if(count($servers)){
            foreach ($servers as $server) {
                $vip_list = Yii::app()->db->createCommand()->select('openid')->from('pre_pay')->where('ret = 0 AND server_id = :server_id',
                                array(':server_id' => $server->server_id))->group('openid')->queryColumn();
                if(count($vip_list)){
                    $in_vip = implode("','", $vip_list);
                    $where = " in ('" . $in_vip . "')";
                    //VIP等级
                    $sql = 'SELECT * FROM (SELECT * FROM login_game WHERE role_id ' . $where . ' AND server_id =  ' . $server->server_id . ' ORDER BY `time` DESC)
                                AS tab GROUP BY role_id';
                    $vip_result = Yii::app()->db->createCommand($sql)->queryAll();
                    if(count($vip_result)){
                        foreach ($vip_result as $v) {
                            $list[$v['role_id']]['vip_level'] = $v['vip_level'];
                            $list[$v['role_id']]['yellow_vip_level'] = $v['vip_level'];
                            $list[$v['role_id']]['year_vip_level'] = $v['year_vip_level'];
                        }
                    }
                    //登录次数
                    $login_result = Yii::app()->db->createCommand()->select('count(`id`) as num, openid, server_id')->from('dau')
                                        ->where('dt >= :begin_day AND dt < :end_day AND server_id = :server_id AND openid ' . $where,
                                                array(':begin_day' => $begin_day, ':end_day' => $end_day, ':server_id' => $server->server_id))
                                        ->group('openid')->queryAll();
                    if(count($login_result)){
                        foreach ($login_result as $v) {
                            $list[$v['openid']]['dau'] = $v['num'];
                        }
                    }
                    //黄金消费分析
                    $gold_tables = AppConst::$gold_tables;
                    foreach ($gold_tables as $key => $value){
                        $gold_gift_result = Yii::app()->db->createCommand()->select('server_id, role_id, sum(gold) AS gold')->from($key)
                                                ->where('time >= :begin_time AND server_id = :server_id AND time < :end_time AND role_id ' . $where,
                                                    array(':begin_time' => $begin_time, ':end_time' => $end_time, ':server_id' => $server->server_id))
                                                ->group('role_id')->queryAll();
                        if(count($gold_gift_result)){
                            foreach ($gold_gift_result as $v) {
                                $list[$v['role_id']]['gold'][$key] = $v['gold'];
                            }
                        }
                    }
                    //礼金分析
                    $gift_gold_tables = AppConst::$gift_gold_tables;
                    foreach ($gift_gold_tables as $key => $value){
                        //礼金产出
                        $gift_gold_product_result = Yii::app()->db->createCommand()->select('server_id, role_id, sum(gift_gold) AS gift_gold_product')->from($key)
                                                        ->where('time >= :begin_time AND time < :end_time AND gift_gold > 0 AND server_id = :server_id AND role_id ' . $where,
                                                            array(':begin_time' => $begin_time, ':end_time' => $end_time, ':server_id' => $server->server_id))
                                                        ->group('role_id')->queryAll();
                        if(count($gift_gold_product_result)){
                            foreach ($gift_gold_product_result as $v) {
                                $list[$v['role_id']]['gift_gold_product'][$key] = $v['gift_gold_product'] > 0 ? $v['gift_gold_product'] : (-1 * intval($v['gift_gold_product']));
                            }
                        }
                        //礼金消费
                        $gift_gold_consume_result = Yii::app()->db->createCommand()->select('server_id, role_id, sum(gift_gold) AS gift_gold_consume')->from($key)
                                                        ->where('time >= :begin_time AND time < :end_time AND gift_gold < 0  AND server_id = :server_id AND role_id ' . $where,
                                                            array(':begin_time' => $begin_time, ':end_time' => $end_time, ':server_id' => $server->server_id))
                                                        ->group('role_id')->queryAll();
                        if(count($gift_gold_consume_result)){
                            foreach ($gift_gold_consume_result as $v) {
                                $list[$v['role_id']]['gift_gold_consume'][$key] = $v['gift_gold_consume'] > 0 ? (-1 * intval($v['gift_gold_consume'])) : $v['gift_gold_consume'];
                            }
                        }
                    }
                    //钱庄兑换次数
                    $silver_result = Yii::app()->db->createCommand()->select('server_id, role_id, count(role_id) AS sum')->from('exchange_silver')
                                        ->where('time >= :begin_time AND time < :end_time AND server_id = :server_id AND role_id ' . $where,
                                            array(':begin_time' => $begin_time, ':end_time' => $end_time, ':server_id' => $server->server_id))
                                        ->group('role_id')->queryAll();
                    if(count($silver_result)){
                        foreach ($silver_result as $v) {
                            $list[$v['role_id']]['exchange_silver'] = $v['sum'];
                        }
                    }
                    //强化装备次数
                    $strengthen_item_result = Yii::app()->db->createCommand()->select('server_id, role_id, count(role_id) AS sum')->from('strengthen_item')
                                                ->where('time >= :begin_time AND time < :end_time AND server_id = :server_id AND role_id ' . $where,
                                                    array(':begin_time' => $begin_time, ':end_time' => $end_time, ':server_id' => $server->server_id))
                                                ->group('role_id')->queryAll();
                    if(count($strengthen_item_result)){
                        foreach ($strengthen_item_result as $v) {
                            $list[$v['role_id']]['strengthen_item'] = $v['sum'];
                        }
                    }
                    //拜访次数
                    $visit_master_result = Yii::app()->db->createCommand()->select('server_id, role_id, count(role_id) AS sum')->from('strengthen_item')
                                                ->where('time >= :begin_time AND time < :end_time AND server_id = :server_id AND role_id ' . $where,
                                                    array(':begin_time' => $begin_time, ':end_time' => $end_time, ':server_id' => $server->server_id))
                                                ->group('role_id')->queryAll();
                    if(count($visit_master_result)){
                        foreach ($visit_master_result as $v) {
                            $list[$v['role_id']]['visit_master'] = $v['sum'];
                        }
                    }
                    //武林大会战斗次数
                    $challenge_opponent_result = Yii::app()->db->createCommand()->select('server_id, role_id, count(role_id) AS sum')->from('challenge_opponent')
                                                    ->where('time >= :begin_time AND time < :end_time AND server_id = :server_id AND role_id ' . $where,
                                                        array(':begin_time' => $begin_time, ':end_time' => $end_time, ':server_id' => $server->server_id))
                                                    ->group('role_id')->queryAll();
                    if(count($challenge_opponent_result)){
                        foreach ($challenge_opponent_result as $v) {
                            $list[$v['role_id']]['challenge_opponent'] = $v['sum'];
                        }
                    }
                    //门派竞技战斗次数
                    $fight_in_clan_fight_result = Yii::app()->db->createCommand()->select('server_id, role_id, count(role_id) AS sum')->from('fight_in_clan_fight')
                                                    ->where('time >= :begin_time AND time < :end_time AND server_id = :server_id AND role_id ' . $where,
                                                        array(':begin_time' => $begin_time, ':end_time' => $end_time, ':server_id' => $server->server_id))
                                                    ->group('role_id')->queryAll();
                    if(count($fight_in_clan_fight_result)){
                        foreach ($fight_in_clan_fight_result as $v) {
                            $list[$v['role_id']]['fight_in_clan_fight'] = $v['sum'];
                        }
                    }
                    //十大恶人战斗次数
                    $fight_with_demons_result = Yii::app()->db->createCommand()->select('server_id, role_id, count(role_id) AS sum')->from('fight_with_demons')
                                                    ->where('time >= :begin_time AND time < :end_time AND server_id = :server_id AND role_id ' . $where,
                                                        array(':begin_time' => $begin_time, ':end_time' => $end_time, ':server_id' => $server->server_id))
                                                    ->group('role_id')->queryAll();
                    if(count($fight_with_demons_result)){
                        foreach ($fight_in_clan_fight_result as $v) {
                            $list[$v['role_id']]['fight_with_demons'] = $v['sum'];
                        }
                    }
                    //刷新精英副本次数
                    $refresh_elite_dungeon_result = Yii::app()->db->createCommand()->select('server_id, role_id, count(role_id) AS sum')->from('refresh_elite_dungeon')
                                                    ->where('time >= :begin_time AND time < :end_time AND server_id = :server_id AND role_id ' . $where,
                                                        array(':begin_time' => $begin_time, ':end_time' => $end_time, ':server_id' => $server->server_id))
                                                    ->group('role_id')->queryAll();
                    if(count($refresh_elite_dungeon_result)){
                        foreach ($refresh_elite_dungeon_result as $v) {
                            $list[$v['role_id']]['refresh_elite_dungeon'] = $v['sum'];
                        }
                    }
                    //银两消耗
                    $silver_consume_table = AppConst::$silver_consume_tables;
                    foreach ($silver_consume_table as $key => $value) {
                        $silver_result = Yii::app()->db->createCommand()->select('server_id, role_id, sum(silver) AS silver')->from($key)
                                            ->where('time >= :begin_time AND time < :end_time AND server_id = :server_id AND role_id ' . $where,
                                                array(':begin_time' => $begin_time, ':end_time' => $end_time, ':server_id' => $server->server_id))
                                            ->group('role_id')->queryAll();
                        if(count($silver_result)){
                            foreach ($silver_result as $v) {
                                $list[$v['role_id']]['consume_silver'][$key] = $v['silver'] > 0 ? (-1 * intval($v['silver'])) : $v['silver'];
                            }
                        }
                    }
                    //银两产出
                    $silver_product_table = AppConst::$silver_product_tables;
                    foreach ($silver_product_table as $key => $value) {
                        $silver_result = Yii::app()->db->createCommand()->select('server_id, role_id, sum(silver) AS silver')->from($key)
                                            ->where('time >= :begin_time AND time < :end_time AND server_id = :server_id AND role_id ' . $where,
                                                array(':begin_time' => $begin_time, ':end_time' => $end_time, ':server_id' => $server->server_id))
                                            ->group('role_id')->queryAll();
                        if(count($silver_result)){
                            foreach ($silver_result as $v) {
                                $list[$v['role_id']]['product_silver'][$key] = $v['silver'] > 0 ? $v['silver'] : (-1 * intval($v['silver']));
                            }
                        }
                    }
                }
                //保存数据
                if(count($list)){
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        $param = array();
                        $param['date'] = $begin_day;
                        $param['server_id'] = $server->server_id;
                        foreach ($list as $key => $value) {
                            $param['user_account'] = $key;
                            if(count($value)){
                                foreach ($value as $index => $val) {
                                    switch ($index) {
                                        //生产银两
                                        case 'product_silver':
                                                $param['type'] = 2;
                                                $this->insertVipPlayerBatch($param, $val, AppConst::$silver_product_tables);
                                            break;
                                        //消耗银两
                                        case 'consume_silver':
                                                $param['type'] = 2;
                                                $this->insertVipPlayerBatch($param, $val, AppConst::$silver_consume_tables);
                                            break;
                                        //礼金消费
                                        case 'gift_gold_consume':
                                                $param['type'] = 1;
                                                $this->insertVipPlayerBatch($param, $val, AppConst::$gift_gold_tables);
                                            break;
                                        //礼金产出
                                        case 'gift_gold_product':
                                                $param['type'] = 1;
                                                $this->insertVipPlayerBatch($param, $val, AppConst::$gift_gold_tables);
                                            break;
                                        //黄金消费
                                        case 'gold':
                                                $param['type'] = 0;
                                                $this->insertVipPlayerBatch($param, $val, AppConst::$gold_tables);
                                            break;
                                        //游戏数据
                                        default :
                                                $param['type'] = 3;
                                                $param['children_type'] = AppConst::$game_data_tables[$index];
                                                $param['num'] = $val;
                                                Yii::app()->db->createCommand()->insert('statistic_vip_player', $param);
                                            break;
                                    }
                                }
                            }
                        }
                        $transaction->commit();
                    } catch (Exception $e) {
                        $transaction->rollback();
                        Util::log('生成VIP玩家数据异常' . $e->getMessage() . ' server_id is ' . $server->server_id, 'tools', __FILE__, __LINE__);
                    }
                }
            }
        }
    }

    /**
     * 插入VIP玩家统计数据 批处理
     * @param array $param
     */
    protected function insertVipPlayerBatch($param, $val, $map_list){
        if(count($val)){
            foreach ($val as $type => $num) {
                $param['children_type'] = $map_list[$type];
                $param['num'] = $num;
                Yii::app()->db->createCommand()->insert('statistic_vip_player', $param);
            }
        }
    }

    /*
     * 插入老玩家消费数据
     */
    public function actionGenerateOldPlayerPay(){
        $param= $this->getParam(array('from_day'));
        $begindate = $param['from_day'];
        if(empty($begindate) || !preg_match('/^\d{4}\-\d{2}\-\d{2}$/', $begindate) || strlen($begindate) != 10){
            throw new CException('param from_day error , for example 2012-06-06');
        }
        $enddate = date('Y-m-d', strtotime($begindate) + 86400);
        $temp = '(';
        $list = array();
        $oldplayer = Yii::app()->db->createCommand()->select('DISTINCT(user_account)')->from('statistic_old_player')->queryColumn();
        foreach ($oldplayer as $k => $v){
            $temp .= "'{$v}',";
        }
        $temp = substr($temp, 0, strlen($temp) - 1).')';
        //总登录人数
        $login_tot = Yii::app()->db->createCommand()->select('server_id, count(distinct openid) as login_tot')->from('dau')
                     ->where('ts >= :begindate and ts < :enddate', array(':begindate' => $begindate, ':enddate' => $enddate))
                     ->group('server_id')->queryAll();
         if(count($login_tot)){
             foreach ($login_tot as $k => $v){
                 $list[$v['server_id']]['login_tot'] = $v['login_tot'];
             }
         }
         //老玩家登录数
        $old_player_login = Yii::app()->db->createCommand()->select('server_id, count(distinct openid) as old_player_login')->from('dau')
                     ->where("ts >= :begindate and ts < :enddate and openid in {$temp}", array(':begindate' => $begindate, ':enddate' => $enddate))
                     ->group('server_id')->queryAll();
         if(count($old_player_login)){
             foreach ($old_player_login as $k => $v){
                 $list[$v['server_id']]['old_player_login'] = $v['old_player_login'];
             }
         }
         //付费总人数和金额
         $pay_tot = Yii::app()->db->createCommand()->select('COUNT(DISTINCT openid) as user_account_tot,sum(balance) as pay_tot, server_id')
                     ->where('ts >= :begindate and ts < :enddate', array(':begindate' => $begindate, ':enddate' => $enddate))
                     ->from('pre_pay')->group('server_id')->having('sum(balance ) > 0')->queryAll();
         if(count($pay_tot)){
             foreach ($pay_tot as $k => $v){
                 $list[$v['server_id']]['pay_tot'] = $v['pay_tot'];
                 $list[$v['server_id']]['user_account_tot'] = $v['user_account_tot'];
             }
         }
         //付费老玩家人数和金额
         $pay_old_player = Yii::app()->db->createCommand()->select('COUNT(DISTINCT openid) as old_player_tot,sum(balance) as pay_old_player, server_id')
                     ->from('pre_pay')->where("ts >= :begindate and ts < :enddate and openid in {$temp}", array(':begindate' => $begindate, ':enddate' => $enddate))
                     ->group('server_id')->having('sum(balance ) > 0')->queryAll();
         if(count($pay_old_player)){
             foreach ($pay_old_player as $k => $v){
                 $list[$v['server_id']]['pay_old_player'] = $v['pay_old_player'];
                 $list[$v['server_id']]['old_player_tot'] = $v['old_player_tot'];
             }
         }
         $transaction = Yii::app()->db->beginTransaction();
         try {
             foreach ($list as $key => $value){
                 $value['login_tot'] = isset($value['login_tot']) ? $value['login_tot'] : 0;
                 $value['old_player_login'] = isset($value['old_player_login']) ? $value['old_player_login'] : 0;
                 $value['user_account_tot'] = isset($value['user_account_tot']) ? $value['user_account_tot'] : 0;
                 $value['old_player_tot'] = isset($value['old_player_tot']) ? $value['old_player_tot'] : 0;
                 $value['pay_tot'] = isset($value['pay_tot']) ? $value['pay_tot'] : 0;
                 $value['pay_old_player'] = isset($value['pay_old_player']) ? $value['pay_old_player'] : 0;
                 Yii::app()->db->createCommand()->insert('statistic_old_player_pay', array('server_id' => $key, 'login_day' => $value['login_tot'],
                                 'old_player_login' => $value['old_player_login'], 'pay_role' => $value['user_account_tot'], 'date' => $begindate,
                                 'old_player_pay' => $value['old_player_tot'], 'pay_num' => $value['pay_tot'], 'old_player_num' => $value['pay_old_player']));
             }
             $transaction->commit();
         } catch (Exception $e) {
             $transaction->rollback();
             Util::log('生成老玩家付费信息异常' . $e->getMessage(), 'tools', __FILE__, __LINE__);
         }
    }

    /*
     * 插入老玩家
     */
    public function actionGenerateOldPlayer(){
        $param= $this->getParam(array('from_day', 'check'));
        $begindate = $param['from_day'];
        if(empty($begindate) || !preg_match('/^\d{4}\-\d{2}\-\d{2}$/', $begindate) || strlen($begindate) != 10){
            throw new CException('param from_day error , for example 2012-06-06');
        }
        $temp = '';
        $begintime = strtotime($begindate);
        $endtime = $begintime + 86400;
        if($param['check'] == 1){
            Yii::app()->db->createCommand()->truncateTable('statistic_old_player');
            $user_account = Yii::app()->db->createCommand()->select('role_id as user_account, time')->from('create_role')
                    ->group('role_id')->having("COUNT(DISTINCT server_id) > 1 and time < {$endtime} ")->queryColumn();
            $temp = "('".implode("','", $user_account)."')";
            $list = Yii::app()->db->createCommand()->select('server_id, role_id as user_account, time')->from('create_role')
                    ->where("role_id in {$temp} and  time < {$endtime}")->queryAll();
        }else{
            $user_account = Yii::app()->db->createCommand()->select('role_id as user_account, time')->from('create_role')
                    ->group('role_id')->having("COUNT(DISTINCT server_id) > 1 and time < {$endtime} and time >= {$begintime}")->queryColumn();
            $temp = "('".implode("','", $user_account)."')";
            $list = Yii::app()->db->createCommand()->select('server_id, role_id as user_account, time')->from('create_role')
                    ->where("role_id in {$temp} and time < {$endtime} and time >= {$begintime}")->queryAll();
        }
            $transaction = Yii::app()->db->beginTransaction();
            try {
                foreach ($list as $k => $v){
                    $role_name = Util::getPlayerRoleName($v['user_account'], intval($v['server_id']));
                    $dt = date('Y-m-d H:i:s', $v['time']);
                    $sql = "REPLACE INTO statistic_old_player (server_id, user_account, role_name, dt) VALUES
                    ({$v['server_id']}, '{$v['user_account']}', '{$role_name}', '{$dt}')";
                    Yii::app()->db->createCommand($sql)->query();
                }
                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollback();
                Util::log('生成老玩家数据异常' . $e->getMessage(), 'tools', __FILE__, __LINE__);
            }
    }
}