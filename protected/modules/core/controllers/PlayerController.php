<?php

class PlayerController extends Controller
{

    /**
     * 日角色等级分析
     */
    public function actionDayRoleLevel()
    {
        if(Yii::app()->request->isAjaxRequest){
            $serverId = $this->getParam("server_id");
            $cache_data = Yii::app()->cache->get('CACHE_DAY_ROLE_LEVEL_' . $serverId);
            if($cache_data){
                echo json_encode($cache_data);
            }else{
                $levelHistgram = $this->getDayRoleLevel($serverId);
                Yii::app()->cache->set('CACHE_DAY_ROLE_LEVEL_' . $serverId, $levelHistgram, 1800);
                echo json_encode($levelHistgram);
            }
            Yii::app()->end();
        }else{
            $select = Util::getRealServerSelect(false);
            $this->render('day_role_level',array('select' => $select));
        }
     }

     /*
      * 获取日角色等级分布
      */
     protected function getDayRoleLevel($serverId){
        $openidToUpgradeLevel = Yii::app()->db->createCommand()->select('openid, max(level) as l')->from('user_level')
                                    ->where('server_id=:server_id', array(':server_id' => $serverId))->group('openid')->queryAll();
        $openidToLoginLevel = Yii::app()->db->createCommand()->select('role_id as openid, max(role_level) as l')->from('login_game')
                                    ->where('server_id=:server_id', array(':server_id' => $serverId))->group('openid')->queryAll();
        $openidToCreateRoleLevel = Yii::app()->db->createCommand()->select('role_id as openid, max(role_level) as l')->from('create_role')
                                    ->where('server_id=:server_id', array(':server_id' => $serverId))->group('openid')->queryAll();
        $openidToLevel = array();
        $openidToLevel = $this->mergeLevel($openidToLevel, $openidToUpgradeLevel);
        $openidToLevel = $this->mergeLevel($openidToLevel, $openidToLoginLevel);
        $openidToLevel = $this->mergeLevel($openidToLevel, $openidToCreateRoleLevel);
        for ($index = 0; $index <= 100; $index++){
            $levelHistgram[$index] = 0;
        }
        if(count($openidToLevel)){
            foreach ($openidToLevel as $openid => $level){
                $levelHistgram[$level] += 1;
            }
        }
        return $levelHistgram;
     }

     /*
      * 导出日角色等级分布
      */
     public function actionDayRoleLevelExport(){
         $title = '日角色等级分布';
         header("Content-Type: application/vnd.ms-excel;charset=utf8");
         header("Content-Disposition: attachment; filename=".$title.".xls");
         $serverId = $this->getParam("server_id");
         $list = $this->getDayRoleLevel($serverId);
         $header = '0'."\t";
         $data = $list[0]."\t";
         for ($i=1;$i<81;$i++){
             $header .= $i."\t";
         }
         $header = substr($header, 0, strlen($header) - 1)."\n";
         foreach ($list as $k => $v){
             if($k < 81 && $k > 0){
                 $data .= $v."\t";
             }
         }
         $data = substr($data, 0, strlen($data) - 1)."\n";
         echo $header, $data;
     }

     /*
      * 战斗过程分析
      */
     public function actionFightingProcess()
     {
        $select = Util::getRealServerSelect(false);
        $this->render('fightingprocess',array(
            'select' => $select
        ));
     }

    /**
     * 计算等级分布
     */
    protected function mergeLevel($openidToLevel, $rows)
    {
         foreach ($rows as $row)
         {
             $openid = $row['openid'];
             $level = $row['l'];
             if (!array_key_exists($openid, $openidToLevel))
             {
                 $openidToLevel[$openid] = 0;
             }
             if ($openidToLevel[$openid] < $level)
             {
                 $openidToLevel[$openid] = $level;
             }
         }
         return $openidToLevel;
    }

    /**
     * 玩家日在线统计
     */
    public function actionDayOnline()
    {
        if(Yii::app()->request->isAjaxRequest){
            $param = $this->getParam(array('end_month', 'type', 'server_id'));
            $cache_data = Yii::app()->cache->get('CACHE_DAY_ON_LINE' . $param['end_month'] . $param['type'] . $param['server_id']);
            if($cache_data){
                echo json_encode($cache_data);
            }else{
                $list = $this->getDayOnline($param);
                Yii::app()->cache->set('CACHE_DAY_ON_LINE' . $param['end_month'] . $param['type'] . $param['server_id'], $list, 1800);
                echo json_encode($list);
            }
            Yii::app()->end();
        }else{
            $select = Util::getRealServerSelect(false);
            $this->render('day_on_line',array('select' => $select));
        }
    }

    /*
     * 获取玩家日在线统计
     */
    protected function getDayOnline($param){
        $list = array();
        $date = date('Y-m-d');
        $first_day = $param['end_month'] . '-01';
        $first_time = strtotime($first_day);
        $end_day = $param['end_month'] . '-' . date('t', $first_time);
        $end_day = $end_day > $date ? $date : $end_day;
        $create_time = Util::getServerAttribute($param['server_id'], 'create_time');
        $begin_day = substr($create_time, 0, 10);
        $count = (strtotime($end_day) - strtotime($begin_day)) / 86400;
        for ($i = 0; $i <= $count; $i++) {
            $tmp_day = date('Y-m-d', strtotime($begin_day) + $i * 86400);
            $index = date('Ym', strtotime($tmp_day));
            $d = date('j', strtotime($tmp_day));
            $num = 0;
            switch ($param['type']) {
                //峰值
                case 0:
                    $num = Yii::app()->db->createCommand()->select('MAX(num) AS num')->from('online_log')
                                ->where('server_id = :server_id AND ts LIKE CONCAT(:day,"%") ', array(':server_id' => $param['server_id'], ':day' => $tmp_day))->queryScalar();
                    break;
                //谷值
                case 1:
                    $num = Yii::app()->db->createCommand()->select('MIN(num) AS num')->from('online_log')
                                ->where('server_id = :server_id AND ts LIKE CONCAT(:day,"%") ', array(':server_id' => $param['server_id'], ':day' => $tmp_day))->queryScalar();
                    break;
                //平均值
                case 2:
                    $result = Yii::app()->db->createCommand()->select('num')->from('online_log')
                                ->where('server_id = :server_id AND ts LIKE CONCAT(:day,"%") ', array(':server_id' => $param['server_id'], ':day' => $tmp_day))->queryAll();
                    $total = count($result);
                    if($total){
                        foreach ($result as $v) {
                            $num += $v['num'];
                        }
                        $num = intval($num / $total);
                    }
                    break;
            }
            $list[$index][$d] = empty($num) ? 0 : intval($num);
        }
        return $list;
    }

    /*
     * 导出玩家日在线统计
     */
    public function actionDayOnlineExport(){
        $title = '玩家日在线统计';
        header("Content-Type: application/vnd.ms-excel;charset=utf8");
        header("Content-Disposition: attachment; filename=".$title.".xls");
        $param = $this->getParam(array('end_month', 'type', 'server_id'));
        $list = $this->getDayOnline($param);
        $header = iconv("UTF-8","GB2312//IGNORE",'日期')."\t";
        $res = '';
        for($i=1;$i<=31;$i++){
            $header .= $i."\t";
        }
        $header = substr($header, 0, strlen($header) - 1)."\n";
        foreach ($list as $k => $v){
            $res .= $k."\t";
            for ($t=1;$t<=31;$t++){
                $res .= (isset($v[$t]) ? $v[$t]."\t" : "\t");
            }
            $res = substr($res, 0, strlen($res) - 1)."\n";
        }
        echo $header.$res;
    }

    /**
     * 玩家小时在线统计
     */
    public function actionHourOnline()
    {
        if(Yii::app()->request->isAjaxRequest){
            $param = $this->getParam(array('end_day', 'type', 'server_id'));
            $cache_data = Yii::app()->cache->get('CACHE_HOUR_ON_LINE' . $param['end_day'] . $param['type'] . $param['server_id']);
            if($cache_data){
                echo json_encode($cache_data);
            }else{
                $list = $this->getHourOnline($param);
                Yii::app()->cache->set('CACHE_HOUR_ON_LINE' . $param['end_day'] . $param['type'] . $param['server_id'], $list, 1800);
                echo json_encode($list);
            }
            Yii::app()->end();
        }else{
            $select = Util::getRealServerSelect(false);
            $this->render('hour_on_line',array('select' => $select));
        }
    }

    /*
     * 获取玩家小时在线统计
     */
    protected function getHourOnline($param){
        $list = array();
        $end_time = strtotime($param['end_day']);
        for ($i = 0; $i < 30; $i++) {
            $date = date('Y-m-d', $end_time - $i * 86400);
            for ($j = 1; $j < 25; $j++) {
                $m = $j == 24 ? 0 : $j;
                $hour = $m < 10 ? '0' . $m : $m;
                $hour = $date . ' ' . $hour;
                $num = 0;
                switch ($param['type']) {
                    //峰值
                    case 0:
                        $num = Yii::app()->db->createCommand()->select('MAX(num) AS num')->from('online_log')
                                    ->where('server_id = :server_id AND ts LIKE CONCAT(:time,"%") ', array(':server_id' => $param['server_id'], ':time' => $hour))->queryScalar();
                        break;
                    //谷值
                    case 1:
                        $num = Yii::app()->db->createCommand()->select('MIN(num) AS num')->from('online_log')
                                    ->where('server_id = :server_id AND ts LIKE CONCAT(:time,"%") ', array(':server_id' => $param['server_id'], ':time' => $hour))->queryScalar();
                        break;
                    //平均值
                    case 2:
                        $result = Yii::app()->db->createCommand()->select('num')->from('online_log')
                                    ->where('server_id = :server_id AND ts LIKE CONCAT(:time,"%") ', array(':server_id' => $param['server_id'], ':time' => $hour))->queryAll();
                        $count = count($result);
                        if($count){
                            foreach ($result as $v) {
                                $num += $v['num'];
                            }
                            $num = intval($num / $count);
                        }
                        break;
                }
                $list[$date][$j] = empty($num) ? 0 : $num;
            }
        }
        return $list;
    }

    /*
     *  导出玩家小时在线统计
     */
    public function actionHourOnlineExport(){
        $title = '玩家小时在线统计';
        header("Content-Type: application/vnd.ms-excel;charset=utf8");
        header("Content-Disposition: attachment; filename=".$title.".xls");
        $param = $this->getParam(array('end_day', 'type', 'server_id'));
        $list = $this->getHourOnline($param);
        $header = iconv("UTF-8","GB2312//IGNORE",'日期')."\t";
        $res = '';
        for($i=1;$i<=24;$i++){
            $header .= $i."\t";
        }
        $header = substr($header, 0, strlen($header) - 1)."\n";
        foreach ($list as $k => $v){
            $res .= $k."\t";
            for ($t=1;$t<=24;$t++){
                $res .= (isset($v[$t]) ? $v[$t]."\t" : "\t");
            }
            $res = substr($res, 0, strlen($res) - 1)."\n";
        }
        echo $header.$res;
    }

    /**
     * 玩家登录日志
     */
    public function actionLoginRecord()
    {
        $list = array();
        if(Yii::app()->request->isAjaxRequest){
            $param = $this->getParam(array('begintime', 'endtime', 'server_id', 'role_name', 'user_account', 'page', 'yellow_vip_level', 'vip_level', 'year_vip_level'));
            $res = $this->getLoginRecord($param);
            $list = $res['list'];
            $count = $res['count'];
            echo json_encode(array(
                "dataCount" => $count,
                "dataList" => $list,
            ));
        }else{
            $select = Util::getRealServerSelect(false);
            $this->render('login_record',array('list' => $list,'select' => $select));
        }
    }

    /*
     * 获得玩家登录日志
     */
    protected function getLoginRecord($param, $export = false){
            $where = ' 1 ';
            $bind = array();
            $role_ids = '';
            if(!empty($param['server_id'])){
                $where .= ' AND server_id = :server_id';
                $bind[':server_id'] = $param['server_id'];
            }
            if(!empty($param['begintime'])){
                $where .= ' AND time >= :begintime';
                $bind[':begintime'] = strtotime($param['begintime']);
            }
            if(!empty($param['endtime'])){
                $where .= ' AND time <= :endtime';
                $bind[':endtime'] = strtotime($param['endtime']) + 86400;
            }
            if (!empty($param['role_name'])){
                $role_name = explode('|', $param['role_name']);
                foreach ($role_name as $k => $v){
                    $role_id = Util::getPlayerAccount($v, $param['server_id']);
                    if(!empty($role_id)){
                        $role_ids .= "'{$role_id}',";
                    }
                }
                $role_ids = substr($role_ids, 0, (strlen($role_ids) - 1));
                $where .= " AND role_id IN ($role_ids)";
            }
            if (!empty($param['user_account'])){
                $where .= ' AND role_id = :role_id';
                $bind[':role_id'] = $param['user_account'];
            }
            if (!empty($param['yellow_vip_level'])){
                $where .= ' AND yellow_vip_level = :yellow_vip_level';
                $bind[':yellow_vip_level'] = $param['yellow_vip_level'];
            }
            if (!empty($param['vip_level'])){
                $where .= ' AND vip_level = :vip_level';
                $bind[':vip_level'] = $param['vip_level'];
            }
            if (!empty($param['year_vip_level'])){
                $where .= ' AND year_vip_level = :year_vip_level';
                $bind[':year_vip_level'] = $param['year_vip_level'];
            }
            $offset = empty($param['page']) ? 0 : ($param['page'] - 1) * Pages::LIMIT;
            $count = Yii::app()->db->createCommand()->select('count(id) as count')->from('login_game')->where($where,$bind)->queryScalar();
            if($export){
                $list = Yii::app()->db->createCommand()->select('*')->from('login_game')->where($where,$bind)->offset($offset)->limit(10000)->order('time DESC')->queryAll();
            }else{
                $list = Yii::app()->db->createCommand()->select('*')->from('login_game')->where($where,$bind)->offset($offset)->limit(Pages::LIMIT)->order('time DESC')->queryAll();
            }
            if(count($list)){
                foreach ($list as $k => $v){
                    $list[$k]['logout_time'] = '';
                    $list[$k]['online_time'] = '';
                    if(!empty($v['session_id'])){
                        $logout_time = Yii::app()->db->createCommand()->select('time')->from('exit_game')
                                ->where('server_id = :server_id AND role_id = : role_id AND session_id = :session_id',
                                        array(':server_id' => $v['server_id'], ':role_id' => $v['role_id'], ':session_id' => $v['session_id']))->queryScalar();
                        $list[$k]['logout_time'] = date('Y-m-d H:i:s', $logout_time);
                        $online_time = intval($logout_time) - intval($v['time']);
                        $hour = intval($online_time / 3600);
                        $minutes = intval(intval($online_time % 3600) / 60);
                        $second = intval($online_time % 60);
                        $list[$k]['online_time'] = $hour . '小时' . $minutes . '分钟' . $second . '秒';
                    }
                    $list[$k]['role_name'] = Util::getPlayerRoleName($v['role_id'], intval($v['server_id']));
                }
            }
            $res = array('list' =>$list, 'count' => $count);
            return $res;
    }

    /*
     * 导出玩家登录日志
     */
    public function  actionLoginRecordExport(){
        set_time_limit(0);
        ini_set('memory_limit','2048M');
        $param = $this->getParam(array('begintime', 'endtime', 'server_id', 'role_name', 'user_account', 'page', 'yellow_vip_level', 'vip_level', 'year_vip_level'));
        $title = '登录日志';
        header("Content-Type: application/vnd.ms-excel;charset=utf8");
        header("Content-Disposition: attachment; filename=".$title.".xls");
        $header = iconv("UTF-8","GB2312//IGNORE",'服务器')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'帐号名')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'角色名')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'登录时间')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'黄钻等级')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'年VIP等级')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'VIP等级')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'下线时间')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'在线时长')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'登录IP')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'登录地域')."\n";
        echo $header;
        $res = $this->getLoginRecord($param, true);
        $list = $res['list'];
            if (count($list)) {
                foreach ($list as $k => $v) {
                    $server = Util::getServerAttribute($v['server_id']);
                    echo iconv("UTF-8","GB2312//IGNORE",(isset($server->sname) ? $server->sname : ''))."\t" ;
                    echo (isset($v["role_id"]) ? $v["role_id"] : 0)."\t";
                    echo iconv("UTF-8","GB2312//IGNORE",(isset($v['role_name']) ? $v['role_name'] : ''))."\t" ;
                    echo (isset($v["time"]) ? date('Y-m-d', $v["time"]) : 0)."\t";
                    echo (isset($v["yellow_vip_level"]) ? $v["yellow_vip_level"] : 0)."\t";
                    echo (isset($v["year_vip_level"]) ? $v["year_vip_level"] : 0)."\t";
                    echo (isset($v["vip_level"]) ? $v["vip_level"] : 0)."\t";
                    echo (isset($v["logout_time"]) ? $v["logout_time"] : 0)."\t";
                    echo iconv("UTF-8","GB2312//IGNORE",(isset($v['online_time']) ? $v['online_time'] : ''))."\t" ;
                    echo (isset($v["login_ip"]) ? $v["login_ip"] : 0)."\t";
                    echo (isset($v["local"]) ? $v["local"] : 0)."\n";
                }
        }
    }
}