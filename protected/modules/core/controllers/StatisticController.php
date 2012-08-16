<?php

class StatisticController extends Controller
{

    /**
     * 日注册、登录数
     */
    public function actionIndex()
    {
        $param = $this->getParam(array('begintime', 'endtime', 'server_id'));
        $title = '日注册、登录数';
        $select = Util::getRealServerSelect();
        $list = $this->getRegisterLogin($param);
        if(Yii::app()->request->isAjaxRequest){
            echo json_encode(array(
                'success'=>true,
                'data'=>$list
            ));
        }else{
            $this->render('index', array('title' => $title, 'list' => $list, 'param' => $param, 'select' => $select));
        }
    }
    
    /*
     * 获取日注册登录数据
     */
    protected function getRegisterLogin($param){
        $list = array();
        $res = array();
        if(!empty($param['begintime']) && !empty($param['endtime'])){
            if(!empty($param['server_id'])){
                $res = Yii::app()->db->createCommand()->select('server_id, register_tot, login_tot, register_day, login_day, date, create_tot, create_day')
                    ->from('statistic_register_login')->where('server_id = :server_id AND date >= :begintime AND date <= :endtime',
                    array(':server_id' => $param['server_id'], ':begintime' => $param['begintime'], 'endtime' => $param['endtime']))->queryAll();
            }else{
                $res = Yii::app()->db->createCommand()->select('server_id, SUM(register_tot) AS register_tot, SUM(login_tot) AS login_tot, 
                    SUM(register_day) AS register_day, SUM(login_day) AS login_day, date, SUM(create_tot) AS create_tot, SUM(create_day) AS create_day')
                    ->from('statistic_register_login')->where('date >= :begintime AND date <= :endtime',
                    array(':begintime' => $param['begintime'], 'endtime' => $param['endtime']))->group('date')->queryAll();
            }
        }
        if(count($res)){
            foreach ($res as $k => $v){
                $list[$v['date']]['role_rate'] = empty($v['register_tot']) ? 0 : round(($v['create_tot']/$v['register_tot'])*100,2).'%';
                $list[$v['date']]['create_tot'] = $v['create_tot'];
                $list[$v['date']]['create_day'] = $v['create_day'];
                $list[$v['date']]['register_tot'] = $v['register_tot'];
                $list[$v['date']]['login_tot'] = $v['login_tot'];
                $list[$v['date']]['register_day'] = $v['register_day'];
                $list[$v['date']]['login_day'] = $v['login_day'];
                $list[$v['date']]['date'] = $v['date'];
            }
        }
        return $list;
    }
    
    /*
     * 导出日注册登录
     */

    public function actionRegisterLoginExport(){
        $param = $this->getParam(array('begintime', 'endtime', 'server_id'));
        $title = '日注册、登录数';
        $list = $this->getRegisterLogin($param);
        header("Content-Type: application/vnd.ms-excel;charset=utf8");
        header("Content-Disposition: attachment; filename=".$title.".xls");
        $header = iconv("UTF-8","GB2312//IGNORE",'日期')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'注册用户数')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'创建角色数')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'开通率')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'今日登录数(DAU)')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'登录IP数')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'登录角色数')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'登录率')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'>=10级角色数')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'百分比')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'>=30级角色数')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'百分比')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'注册用户数')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'创建角色数')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'今日登录数')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'登录IP数')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'登录角色数')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'登录率')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'>=10级角色数')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'百分比')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'>=30级角色数')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'百分比')."\n";
        echo $header;
        foreach ($list as $k => $v){
            echo isset($v['date']) ? $v['date']."\t" : ("0\t");
            echo isset($v['register_tot']) ? $v['register_tot']."\t" : ("0\t");
            echo isset($v['create_tot']) ? $v['create_tot']."\t" : ("0\t");
            echo isset($v['role_rate']) ? $v['role_rate']."\t" : ("0\t");
            echo isset($v['login_tot']) ? $v['login_tot']."\t" : ("0\t");
            echo isset($v['login_ip_tot']) ? $v['login_ip_tot']."\t" : ("0\t");
            echo isset($v['role_tot_tot']) ? $v['role_tot_tot']."\t" : ("0\t");
            echo isset($v['register_tot_rate']) ? $v['register_tot_rate']."\t" : ("0\t");
            echo isset($v['morethan_ten_tot']) ? $v['morethan_ten_tot']."\t" : ("0\t");
            echo isset($v['ten_tot_rate']) ? $v['ten_tot_rate']."\t" : ("0\t");
            echo isset($v['morethan_thirty_tot']) ? $v['morethan_thirty_tot']."\t" : ("0\t");
            echo isset($v['thirty_tot_rate']) ? $v['thirty_tot_rate']."\t" : ("0\t");
            echo isset($v['register_day']) ? $v['register_day']."\t" : ("0\t");
            echo isset($v['create_day']) ? $v['create_day']."\t" : ("0\t");
            echo isset($v['login_day']) ? $v['login_day']."\t" : ("0\t");
            echo isset($v['login_ip_day']) ? $v['login_ip_day']."\t" : ("0\t");
            echo isset($v['role_day']) ? $v['role_day']."\t" : ("0\t");
            echo isset($v['role_day_rate']) ? $v['role_day_rate']."\t" : ("0\t");
            echo isset($v['morethan_ten_day']) ? $v['morethan_ten_day']."\t" : ("0\t");
            echo isset($v['ten_day_rate']) ? $v['ten_day_rate']."\n" : ("0\t");
            echo isset($v['morethan_thirty_day']) ? $v['morethan_thirty_day']."\n" : ("0\t");
            echo isset($v['thirty_day_rate']) ? $v['thirty_day_rate']."\n" : ("0\n");
        }
    }

    /**
     * 日留存率
     */
    public function actionRetentionRate(){
        $result = array();
        $title = '日留存率';
        $param = $this->getParam(array('begintime', 'endtime', 'server_id'));
        $list = $register_list = array();
        if(!empty($param['begintime']) && !empty($param['endtime']) && is_numeric($param['server_id'])){
            $create_time = Util::getServerAttribute($param['server_id'], 'create_time');
            if(!empty($param['server_id'])){
                $param['begintime'] = $param['begintime'] > $create_time ? $param['begintime'] :  substr($create_time, 0, 10);
            }
            $data = $this->getRetentionRateData($param);
            $list = $data['list'];
            $register_list = $data['register_list'];
        }
        $select = Util::getRealServerSelect();
        if(count($list)){
            $begin = date('Y-m-d',strtotime($param['begintime']));
            $end = date('Y-m-d',strtotime($param['endtime']));
            foreach ($list as $v){
                $value[$v['compare_day']][$v['current_day']] = $v['num'];
            }
            for($m=1;intval(strtotime($end)) - intval(strtotime($begin)) >= 0;$m++){
                $result[$end]['date'] =  $end;
                $result[$end]['server_id'] = $param['server_id'];
                for($i=1;$i<31;$i++){
                    $result[$end]['register'] = 0;
                    if(isset($register_list[$end])){
                        $result[$end][] = isset($value[$end][date('Y-m-d',(strtotime($end)+($i*24*3600)))]) ?
                                                round((($value[$end][date('Y-m-d',(strtotime($end)+($i*24*3600)))]/($register_list[$end]))*100),2) : 0;
                        $result[$end]['register'] = $register_list[$end];
                    }
                }
                $end = date('Y-m-d',strtotime($param['endtime'])-3600*24*$m);
            }
        }
        $result = array_values($result);
        if(Yii::app()->request->isAjaxRequest){
            echo json_encode(array(
                'success'=>true,
                'data'=>$result
            ));
        }else{
            $this->render('retention_rate', array('title' => $title, 'list' => $list, 'param' => $param, 'select' => $select,'register_list' => $register_list));
        }
    }

    /**
     * 获取留存率数据
     */
    protected function getRetentionRateData($param)
    {
        $register_list = array();
        $list = Yii::app()->db->createCommand()->from('retention_rate');
        $result = Yii::app()->db->createCommand()->select('DATE(FROM_UNIXTIME(`time`)) AS day, count(role_id) AS num')->from('create_role');
        //全区全服数据统计
        if(empty($param['server_id'])){
            $list = $list->where('current_day >= :begintime AND current_day <= :endtime',
                    array(':begintime' => $param['begintime'], ':endtime' => $param['endtime']));
            $result = $result->where('time >= :begintime AND time <= :endtime',array( ':begintime' => strtotime($param['begintime']),
                      ':endtime' => (strtotime($param['endtime'])+24*3600)))->group('day');
        }else{
            //单服数据统计
            $list = $list->where('server_id = :server_id AND current_day >= :begintime AND current_day <= :endtime',
                    array(':server_id' => $param['server_id'], ':begintime' => $param['begintime'], ':endtime' => $param['endtime']));
            $result = $result->where('server_id = :server_id AND time >= :begintime AND time <= :endtime',array(':server_id' => $param['server_id'],
                      ':begintime' => strtotime($param['begintime']), ':endtime' => (strtotime($param['endtime'])+24*3600)))->group('day');
        }
        $list = $list->queryAll();
        $result = $result->queryAll();
        if(count($result)){
            foreach ($result as $v) {
                $register_list[$v['day']] = $v['num'];
            }
        }
        return array('list' => $list, 'register_list' => $register_list);
    }

    /*
     * 日留存率导出excel
     */
    public function actionRetentionRateExport(){
        $title = '日留存率';
        $param = $this->getParam(array('begintime', 'endtime', 'server_id'));
        $create_time = Util::getServerAttribute($param['server_id'], 'create_time');
        if(!empty($param['server_id'])){
            $param['begintime'] = $param['begintime'] > $create_time ? $param['begintime'] :  substr($create_time, 0, 10);
        }
        $list = $register_list = array();
        $data = $this->getRetentionRateData($param);
        $list = $data['list'];
        $register_list = $data['register_list'];
        header("Content-Type: application/vnd.ms-excel;charset=utf8");
        header("Content-Disposition: attachment; filename=".$title.".xls");
        $header = iconv("UTF-8","GB2312//IGNORE",'统计日期')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'服务器')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'注册玩家数')."\t";
        for($i=1;$i<=30;$i++){
            $header .= $i."\t";
        }
        $header .= "\n";
        echo $header;
        if (count($list)) {
           $begin = date('Y-m-d',strtotime($param['begintime']));
           $end = date('Y-m-d',strtotime($param['endtime']));
            foreach ($list as $v){
                    $value[$v['compare_day']][$v['current_day']] = $v['num'];
            }
            for($m=1;intval(strtotime($end)) - intval(strtotime($begin)) >= 0;$m++){
                echo $end;
                echo "\t".iconv("UTF-8","GB2312//IGNORE",Util::getServerAttribute($param['server_id'],'sname'));
                echo "\t" . (isset($register_list[$end]) ? $register_list[$end] : 0);
                for($i=1;$i<31;$i++){
                    echo isset($value[$end][date('Y-m-d',(strtotime($end)+($i*24*3600)))]) ?
                    "\t".round((($value[$end][date('Y-m-d',(strtotime($end)+($i*24*3600)))]/($register_list[$end]))*100),2).
                    '%' : "\t0";
                }
                echo "\n";
                $end = date('Y-m-d',strtotime($param['endtime'])-3600*24*$m);
            }
         }
        Yii::app()->end();
    }
}