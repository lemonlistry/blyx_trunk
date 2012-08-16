<?php

class DefaultController extends Controller
{
    public function actionIndex()
    {
        set_time_limit(1200);
        ini_set('memory_limit', '2048M');
        $this->sendNotice();
        $this->giftGold();
        $this->syncItemRecord();
        $this->silver();
    }

    /**
     * 计划任务发送在线公告 每分钟执行一次
     */
    protected function sendNotice(){
        Yii::import('service.models.Notice');
        $list = Notice::model()->findAllByAttributes(array('status' => 1));
        if(count($list)){
            try {
                foreach ($list as $v) {
                    $model = $this->loadModel($v->id, 'Notice');
                    $now = time();
                    if($now >= $model->end_time){
                        $model->status = 3;
                        $model->save();
                    }else{
                        if(($model->send_time == 0 && $now >= $v->begin_time) || ($model->send_time != 0 && $now >= (intval($model->send_time) + intval($model->interval_time)))){
                            //全服发送公告
                            if(empty($model->server_id)){
                                $servers = Util::getServerSelect(false);
                                if(count($servers)){
                                    foreach ($servers as $key => $value) {
                                        Service::sendOnlineNotice($key, $v->interval_time, $v->play_times, $v->content);
                                    }
                                }
                            //单服发送公告
                            }else{
                                Service::sendOnlineNotice($v->server_id, $v->interval_time, $v->play_times, $v->content);
                            }
                            $model->send_time = $now;
                            $model->save();
                        }
                    }
                }
            } catch (Exception $e) {
                Util::log('计划任务发送公告异常' . $e->getMessage(), 'cron', __FILE__, __LINE__);
            }
        }
    }

    /**
     * 计划任务同步物品变更日志
     * 物品获得 使用 变更 买卖 副本奖励 任务 相关数据表对应数据类型 0为获得 1为使用 2为变更 3为买卖 4 副本奖励 5 任务
     */
    protected function syncItemRecord(){
        $cache_time = Yii::app()->cache->get('cache_time_item_record');
        if(!$cache_time){
            $cache_time = Yii::app()->cache->set('cache_time_item_record', true, 60 * 27);
            $list = array();
            $transaction = Yii::app()->db->beginTransaction();
            try {
                foreach (AppConst::$item_tables as $k => $v){
                    $last_id = 0;
                    $index = Yii::app()->db->createCommand()->select('index')->from('statistic_table_mark')->where('`type` = 3 AND `table` = :table', array(':table' => $k))->queryScalar();
                    $index = empty($index) ? 0 : $index;
                    switch ($k) {
                        case 'buy_item'://购买
                        case 'sell_item'://卖出
                        case 'rebuy_item'://回购
                            $list = Yii::app()->db->createCommand()->select('id, server_id, role_id, item_id, item_num, time')->from($k)->where('id > :id',
                                        array(':id' => $index))->limit(10000)->queryAll();
                            $last_id = $this->insertItemRecord($list, $v);
                            break;
                        case 'strengthen_item'://强化
                            $list = Yii::app()->db->createCommand()->select('id, server_id, role_id, item_id, time')->from($k)->where('id > :id AND success = 1',
                                        array(':id' => $index))->limit(10000)->queryAll();
                            $last_id = $this->insertItemRecord($list, $v);
                            break;
                        case 'synthesis_equipment'://合成
                            $list = Yii::app()->db->createCommand()->select('id, server_id, role_id, item_id, time')->from($k)->where('id > :id',
                                        array(':id' => $index))->limit(10000)->queryAll();
                            $last_id = $this->insertItemRecord($list, $v);
                            break;
                        default:
                            $list = Yii::app()->db->createCommand()->select('id, server_id, role_id, items, numItems, time')->from($k)->where('id > :id AND items != "[]"',
                                    array(':id' => $index))->limit(10000)->queryAll();
                            $last_id = $this->insertItemRecord($list, $v, true);
                            break;
                    }
                    //更新标记索引
                    if(!empty($last_id)){
                        if(empty($index)){
                            Yii::app()->db->createCommand()->insert('statistic_table_mark', array('type' => 3, 'index' => $last_id, 'table' => $k));
                        }else{
                            Yii::app()->db->createCommand()->update('statistic_table_mark', array('index' => $last_id), 'type = 3 AND `table` = :table', array(':table' => $k));
                        }
                    }
                }
                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollback();
                Util::log('计划任务汇总物品使用变更日志异常' . $e->getMessage(), 'cron', __FILE__, __LINE__);
            }
        }
    }

    /**
     * 插入物品变更数据
     * @param array $list 数据集合
     * @param int $type 数据类型
     */
    protected function insertItemRecord($list, $type, $flag = false){
        $last_id = 0;
        if(count($list)){
            foreach ($list as $val){
                if($flag){
                    $items = str_replace(array('[', ']'), array('' ,''), $val['items']);
                    $item_list = explode(' ', $items);
                    $nums = str_replace(array('[', ']'), array('' ,''), $val['numItems']);
                    $num_list = explode(' ', $nums);
                    if(count($item_list)){
                        foreach ($item_list as $key => $item_id) {
                            Yii::app()->db->createCommand()->insert('log_item', array('type' => $type, 'server_id' => $val['server_id'], 'user_account' => $val['role_id'],
                                'num' => $num_list[$key], 'item_id' => $item_id, 'time' => $val['time']));
                        }
                    }
                    $last_id = $val['id'];
                }else{
                    $num = isset($val['item_num']) ? $val['item_num'] : 1;
                    Yii::app()->db->createCommand()->insert('log_item', array('type' => $type, 'server_id' => $val['server_id'], 'user_account' => $val['role_id'],
                        'num' => $num, 'item_id' => $val['item_id'], 'time' => $val['time']));

                }
                $last_id = $val['id'];
            }
        }
        return $last_id;
    }

    /*
     * 计划任务统计礼金
     * $table 数组   0：购买精力 1：洗髓  2：解锁包囊 3：远程打开包囊 4：加强物品 5：强化物品秒CD 6：刷新精英副本 7： 加速挂机 8：兑换银两 9：解锁秘籍方格 10：寻访
     * 11：合成装备 12： 开拓荒地  13：刷新种子 14: 药园清除cd时间 15:武林大会增加挑战次数  16:武林大会请求清除CD时间 17:世界boss复活 18:世界boss鼓舞
     *  19:帮会战复活 20:门派战鼓舞 21:清除日常任务cd时间 22:刷新日常任务星级 23:刷新伙伴 24:帮派战鼓舞 25:一键完成日常任务 26:用道具要花钱27:下副本产出礼金
     */
    protected function giftGold(){
        $cache_time = Yii::app()->cache->get('cache_time_gift_gold');
        if(!$cache_time){
            $cache_time = Yii::app()->cache->set('cache_time_gift_gold', true, 60 * 19);
            $list = array();
            $tables = array('buy_vitality', 'xisui','unlock_package_slot','remote_open_package',
                            'strengthen_item','clear_strengthen_cd','refresh_elite_dungeon','accelerate_auto_fighting',
                            'exchange_silver','unlock_book_slot','seek_hight_level_master','synthesis_equipment',
                            'unlock_earth','refresh_seed','clear_earth_cd','add_challenge_times','clear_challenge_cd',
                            'revive_in_world_boss','encourage_in_world_boss',
                            'rivive_in_faction_battle','encourage_in_clan_fight','clear_daily_task_cd','refresh_daily_task','refresh_partner',
                            'encourage_in_faction','auto_finish_daily_task','use_item','fetch_auto_finishing_dungeon__award');
            $transaction = Yii::app()->db->beginTransaction();
            try {
                foreach ($tables as $k => $v){
                    $last_id = 0;
                    $index = Yii::app()->db->createCommand()->select('index')->from('statistic_table_mark')->where('`type` = 1 AND `table` = :table', array(':table' => $v))->queryScalar();
                    $index = empty($index) ? 0 : $index;
                    $list = Yii::app()->db->createCommand()->select('id, server_id, role_id, gift_gold, time')->from($v)->where('id > :id AND (gift_gold > 0 OR gift_gold < 0)',
                                    array(':id' => $index))->queryAll();
                    if(count($list)){
                        foreach ($list as $key => $val){
                            $val['type'] = $val['gift_gold'] > 0 ? 0 : 1;
                            $val['children_type'] = $k;
                            Yii::app()->db->createCommand()->insert('log_gift_gold', array('type' => $val['type'], 'children_type' => $val['children_type'],
                                    'server_id' => $val['server_id'], 'user_account' => $val['role_id'], 'num' => $val['gift_gold'], 'time' => $val['time']));
                            $last_id = $val['id'];
                        }
                        //更新标记索引
                        if(!empty($last_id)){
                            if(empty($index)){
                                Yii::app()->db->createCommand()->insert('statistic_table_mark', array('type' => 1, 'index' => $last_id, 'table' => $v));
                            }else{
                                Yii::app()->db->createCommand()->update('statistic_table_mark', array('index' => $last_id), 'type = 1 AND `table` = :table', array(':table' => $v));
                            }
                        }
                    }
                }
                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollback();
                Util::log('计划任务汇总礼金日志异常' . $e->getMessage(), 'cron', __FILE__, __LINE__);
            }
        }
    }

    /*
     * 银两产出消费日志
     */
    protected function silver(){
        $cache_time = Yii::app()->cache->get('cache_time_silver');
        if(!$cache_time){
            $cache_time = Yii::app()->cache->set('cache_time_silver', true, 11 * 60);
            $list = array();
            $costtable = array(
                                0 => array("tableName" => "xisui"),
                                1 => array("tableName" => "buy_item"),
                                2 => array("tableName" => "refresh_partner"),
                                3 => array("tableName" => "strengthen_item"),
                                4 => array("tableName" => "upgrade_formation"),
                                5 => array("tableName" => "visit_master"),
                                6 => array("tableName" => "sell_item"),
                                7 => array("tableName" => "fetch_fighting_dungeon_award"),
                                8 => array("tableName" => "fetch_auto_fighting_dungeon_award"),
                                9 => array("tableName" => "exchange_silver"),
                                10 => array("tableName" => "submit_task"),
                                //10 => array("tableName" => "submit_task", "whereClause" => " and star_rate = 0"),
                                11 => array("tableName" => "sell_book"),
                                12 => array("tableName" => "harvest_medicine"),
                                13 => array("tableName" => "receive_gift_bag"),
                                //13 => array("tableName" => "receive_gift_bag",  "whereClause" => " and award_id = 10"),
                                14 => array("tableName" => "challenge_opponent", "whereClause" => ""),
                                15 => array("tableName" => "fight_world_boss"),
                                //16 => array("tableName" => "receive_gift_bag", "whereClause" => " and award_id = 5"),
                                //17 => array("tableName" => "receive_gift_bag", "whereClause" => " and award_id = 6"),
                                18 => array("tableName" => "fetch_faction_salary"),
                                //19 => array("tableName" => "receive_gift_bag", "whereClause" => " and award_id = 11"),
                                //20 => array("tableName" => "receive_gift_bag", "whereClause" => " and award_id = 12"),
                                21 => array("tableName" => "fight_in_clan_fight"),
                                //22 => array("tableName" => "receive_gift_bag", "whereClause" => " and award_id = 7"),
                                //23 => array("tableName" => "receive_gift_bag", "whereClause" => " and award_id = 9" ),
                                24 => array("tableName" => "signup"),
                                25 => array("tableName" => "fight_with_demons"),
                                //26 => array("tableName" => "submit_task", "whereClause" => " and star_rate != 0"),
                                //27 => array("tableName" => "receive_gift_bag", "whereClause" => " and award_id = 16"),
                                //28 => array("tableName" => "use_item", "whereClause" => " and item_id >= 410101 and item_id <= 410106"),
                                28 => array("tableName" => "use_item"),
                                29 => array("tableName" => "get_system_target_award"),
                                30 => array("tableName" => "get_exciting_award"),
                                //30 => array("tableName" => "get_exciting_award", "whereClause" => " and activity_id = 479251"),
                                //31 => array("tableName" => "get_exciting_award", "whereClause" => " and activity_id = 479252"),
                                //32 => array("tableName" => "get_exciting_award", "whereClause" => " and activity_id = 479253"),
                                //33 => array("tableName" => "get_exciting_award", "whereClause" => " and activity_id = 479254"),
                                //34 => array("tableName" => "get_exciting_award", "whereClause" => " and activity_id = 479255"),
                                //35 => array("tableName" => "receive_gift_bag", "whereClause" => " and award_id = 13"),
                                //36 => array("tableName" => "receive_gift_bag", "whereClause" => " and award_id = 14"),
                                //37 => array("tableName" => "receive_gift_bag", "whereClause" => " and award_id = 15"),
                                //38 => array("tableName" => "receive_gift_bag", "whereClause" => " and award_id >= 17 and award_id <= 19"),
                                //39 => array("tableName" => "use_item", "whereClause" => " and (item_id = 410209 or item_id = 410227)")
                            );
            foreach ($costtable as $k => $v){
                try {
                    $last_id = 0;
                    $index = Yii::app()->db->createCommand()->select('index')->from('statistic_table_mark')->where('`type` = 2 AND `table` = :table', array(':table' => $v['tableName']))->queryScalar();
                    $index = empty($index) ? 0 : $index;
                    $list = Yii::app()->db->createCommand()->select('id, server_id, role_id, silver, time')->from($v['tableName'])
                                    ->where('id > :id AND (silver > 0 OR silver < 0)',array(':id' => $index))->limit(10000)->queryAll();
                    if(count($list)){
                        $transaction = Yii::app()->db->beginTransaction();
                        foreach ($list as $key => $val){
                            $val['type'] = $val['silver'] > 0 ? 0 : 1;
                            $val['children_type'] = $k;
                            Yii::app()->db->createCommand()->insert('log_silver', array('type' => $val['type'], 'children_type' => $val['children_type'],
                                    'server_id' => $val['server_id'], 'user_account' => $val['role_id'], 'num' => $val['silver'], 'time' => $val['time']));
                            $last_id = $val['id'];
                        }
                        //更新标记索引
                        if(!empty($last_id)){
                            if(empty($index)){
                                Yii::app()->db->createCommand()->insert('statistic_table_mark', array('type' => 2, 'index' => $last_id, 'table' => $v['tableName']));
                            }else{
                                Yii::app()->db->createCommand()->update('statistic_table_mark', array('index' => $last_id), 'type = 2 AND `table` = :table', array(':table' => $v['tableName']));
                            }
                        }
                    }
                    $transaction->commit();
                }catch (Exception $e) {
                    $transaction->rollback();
                    Util::log('计划任务银两日志异常' . $e->getMessage(), 'cron', __FILE__, __LINE__, $v['tableName']);
                }
            }
        }
    }

}