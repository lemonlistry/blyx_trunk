<?php

class DefaultController extends Controller
{

    /**
     * 关键数据总览
     */
    public function actionIndex()
    {
        if(Yii::app()->request->isAjaxRequest){
            $list = $this->getDashboard();
            echo json_encode($list);
        }
        else
        {
            $select = Util::getRealServerSelect(false);
            $this->render('index',array( 'select' => $select));
        }
     }

     private function getDashboardCoommands()
     {
         $start_of_today = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
         $end_of_today = mktime(23, 59, 59, date('m'), date('d'), date('Y'));
         $dashboard = array(
             'total_installation' => Yii::app()->db->createCommand()->select('server_id, count(*) as amount')->from('installation')->group('server_id')->queryAll(),
             'current_installation' => Yii::app()->db->createCommand()->select('server_id, count(*) as amount')->from('installation')->where('dt=curdate()')->group('server_id')->queryAll(),
             'current_cost' => Yii::app()->db->createCommand()->select('server_id, sum(balance) as amount')->from("pre_pay")->where('ret = 0 and dt = curdate()')->group('server_id')->queryAll(),
             'total_cost' => Yii::app()->db->createCommand()->select('server_id, sum(balance) as amount')->from('pre_pay')->where('ret = 0')->group('server_id')->queryAll(),
             'month_cost' => Yii::app()->db->createCommand()->select('server_id, sum(balance) as amount')->from('pre_pay')->where('ret = 0 and month(dt) = month(curdate())')->group('server_id')->queryAll(),
             'total_balance' => Yii::app()->db->createCommand()->select('server_id, sum(balance) as amount')->from('tencent_balance')->group('server_id')->queryAll(),
             'total_role' => Yii::app()->db->createCommand()->select('server_id, count(*) as amount')->from('create_role')->group('server_id')->queryAll(),
             'current_role' => Yii::app()->db->createCommand()->select('server_id, count(*) as amount')->from('create_role')->where(
                            'time >= :start_of_today and time <= :end_of_today', array(":start_of_today" => $start_of_today, ":end_of_today" => $end_of_today))->group('server_id')->queryAll(),
             'online' => Yii::app()->db->createCommand()->select('server_id, num as amount')->from('online')->group('server_id')->queryAll(),
             'current_num_of_pay' => Yii::app()->db->createCommand()->select('server_id, count(distinct openid) as amount')->from('pre_pay')->where('dt = curdate()')->group('server_id')->queryAll(),
             'num_of_pay' => Yii::app()->db->createCommand()->select('server_id, count(distinct openid) as amount')->from('pre_pay')->group('server_id')->queryAll()
        );
        return $dashboard;
     }

     private function getDashboardCommandsByDate($dt)
     {
         $start_of_day = mktime(0, 0, 0, date('m', $dt), date('d', $dt), date('Y', $dt));
         $end_of_day = mktime(23, 59, 59, date('m', $dt), date('d', $dt), date('Y', $dt));
         $param = array(":dt" => date('Y-m-d', $dt));
         $dashboard = array(
             'total_installation' => Yii::app()->db->createCommand()->select('server_id, count(*) as amount')->from('installation')->where("dt <= :dt", $param)->group('server_id')->queryAll(),
             'current_installation' => Yii::app()->db->createCommand()->select('server_id, count(*) as amount')->from('installation')->where('dt=:dt', $param)->group('server_id')->queryAll(),
             'current_cost' => Yii::app()->db->createCommand()->select('server_id, sum(balance) as amount')->from("pre_pay")->where('ret = 0 and dt = :dt', $param)->group('server_id')->queryAll(),
             'total_cost' => Yii::app()->db->createCommand()->select('server_id, sum(balance) as amount')->from('pre_pay')->where('ret = 0 and dt <= :dt', $param)->group('server_id')->queryAll(),
             'month_cost' => Yii::app()->db->createCommand()->select('server_id, sum(balance) as amount')->from('pre_pay')->where('ret = 0 and month(dt) = month(:dt)', $param)->group('server_id')->queryAll(),
             'total_balance' => Yii::app()->db->createCommand()->select('server_id, sum(balance) as amount')->from('tencent_balance')->group('server_id')->queryAll(),
             'total_role' => Yii::app()->db->createCommand()->select('server_id, count(*) as amount')->from('create_role')->where("time <= :end_of_day", array(":end_of_day" => $end_of_day))
             ->group('server_id')->queryAll(),

             'current_role' => Yii::app()->db->createCommand()->select('server_id, count(*) as amount')->from('create_role')->where(
                            'time >= :start_of_day and time <= :end_of_day', array(":start_of_day" => $start_of_day, ":end_of_day" => $end_of_day))->group('server_id')->queryAll(),
             'online' => Yii::app()->db->createCommand()->select('server_id, num as amount')->from('online')->group('server_id')->queryAll(),
             'current_num_of_pay' => Yii::app()->db->createCommand()->select('server_id, count(distinct openid) as amount')->from('pre_pay')->where('dt = :dt', $param)->group('server_id')->queryAll(),
             'num_of_pay' => Yii::app()->db->createCommand()->select('server_id, count(distinct openid) as amount')->from('pre_pay')->where("dt <= :dt", $param)->group('server_id')->queryAll()
        );
        return $dashboard;
     }

     private function buildDashboard($dashboard)
     {
        $result = array();
        Yii::import('passport.models.Server');
        $servers = Server::model()->findAllByAttributes(array('status' => 1));
        foreach ($servers as $server){
            $result[$server->server_id]['server_id'] = $server->server_id;
            $result[$server->server_id]['name'] = $server->sname;
            $result[$server->server_id]['create_time'] = $server->create_time;
            foreach ($dashboard as $key => $value){
                $result[$server->server_id][$key] = 0;
            }

        }
        foreach($dashboard as $key => $command)
        {
            foreach ($command as $row)
            {
                if ($row['amount'] == 0)
                {
                    $row['amount'] = 0;
                }
                if (array_key_exists($row['server_id'], $result))
                {
                    $result[intval($row['server_id'])][$key] = $row['amount'];
                }
            }
        }
        $dashboard = array();
        foreach ($result as $key => $value)
        {
            array_push($dashboard, $value);
        }
        return $dashboard;
     }

     /**
      * 所有关键数据总览 包含消费数据
      */
     private function getDashboard()
     {
         $time = $this->getParam("endtime");
         if (empty($time))
         {
             $commands = $this->getDashboardCoommands();
         }
         else
         {
             $commands = $this->getDashboardCommandsByDate(strtotime($time));
         }
         return $this->buildDashboard($commands);
     }

     /*
      * 关键数据导出
      */
     public function actionExport(){
        $title = '关键数据';
        $list = $this->getDashboard();
        header("Content-Type: application/vnd.ms-excel;charset=utf8");
        header("Content-Disposition: attachment; filename=".$title.".xls");
        $header = iconv("UTF-8","GB2312//IGNORE",'服务器名称')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'开服时间')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'在线')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'日安装')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'总安装')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'日创建角色总数')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'总创建角色数')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'日消费')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'月消费')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'总消费')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'余额')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'日消费人数')."\t";
        $header .= iconv("UTF-8","GB2312//IGNORE",'总消费人数')."\n";
        echo $header;
        if (count($list)) {
            foreach ($list as $k => $v) {
                $server = Util::getServerAttribute($v['server_id']);
                echo iconv("UTF-8","GB2312//IGNORE",(isset($server->sname) ? $server->sname : ''))."\t" ;
                echo (isset($server->create_time) ? $server->create_time : '')."\t";
                echo (isset($v["online"]) ? $v["online"] : 0)."\t";
                echo (isset($v["current_installation"]) ? $v["current_installation"] : 0)."\t";
                echo (isset($v["total_installation"]) ? $v["total_installation"] : 0)."\t";
                echo (isset($v["current_role"]) ? $v["current_role"] : 0)."\t";
                echo (isset($v["total_role"]) ? $v["total_role"] : 0)."\t";
                echo (isset($v["current_cost"]) ? $v["current_cost"] : 0)."\t";
                echo (isset($v["month_cost"]) ? $v["month_cost"] : 0)."\t";
                echo (isset($v["total_cost"]) ? $v["total_cost"] : 0)."\t";
                echo (isset($v["total_balance"]) ? $v["total_balance"] : 0)."\t";
                echo (isset($v["current_num_of_pay"]) ? $v["current_num_of_pay"] : 0)."\t";
                echo (isset($v["num_of_pay"]) ? $v["num_of_pay"] : 0)."\n";
            }
        }
     }

     public function actionTestDate()
     {
         echo json_encode(TimeUtils::calcDateRanges($this->getParam("begintime"), $this->getParam("endtime")));
     }
}
