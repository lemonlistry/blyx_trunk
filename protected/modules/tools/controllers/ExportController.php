<?php
class ExportController extends Controller
{
    /**
     * 导出正常的正式服务器VIP玩家游戏数据 ： 账号，角色名，玩家最后等级  黄钻等级 第一次登录时间 最后登录时间  首次充值金额 首次充值时间  总计充值金额的数据
     */
    public function actionExportVipGameData()
    {
        set_time_limit(300);
        ini_set('memory_limit', '2048M');
        $filename = '游戏数据' . date('YmdHis'). '.xls';
        header("Content-type:application/vnd.ms-excel;charset:utf-8;");
        header('Content-Disposition:filename='.$filename);
        header("Pragma: no-cache");
        header("Expires: 0");
        header("Cache-control:must-revalidate,post-check=0,pre-check=0"); // 解决IE不能下载问题。
        $thead = "服务器\t帐号名\t角色名\t角色等级\t黄钻等级\t第一次登录时间\t最后登录时间\t首次消费金额\t首次消费时间\t总计消费金额\t\n";
        echo(iconv("UTF-8","GBK//IGNORE",$thead));
        $sql = 'SELECT server_id,  openid,  balance, SUM(balance) AS all_balance, ts FROM pre_pay WHERE server_id < 5 AND server_id > 0 AND ret = 0 GROUP BY server_id, openid';
        $list = Yii::app()->db->createCommand($sql)->queryAll();
        if(count($list)){
            $servers = Util::getRealServerSelect();
            $first_time = 0;
            $time = 0;
            $role_level = 0;
            $yellow_vip_level = 0;
            foreach ($list as $v) {
                echo iconv("UTF-8","GBK//IGNORE", $servers[$v['server_id']] . "\t");
                echo iconv("UTF-8","GBK//IGNORE", $v['openid'] . "\t");
                $role_name = Util::getPlayerRoleName($v['openid'], intval($v['server_id']));
                echo mb_convert_encoding($role_name . "\t", "GBK", "UTF-8");
                $role_level = Yii::app()->db->createCommand()->select('level')->from('user_level')
                                ->where('server_id = :server_id AND openid = :openid', array(':server_id' => $v['server_id'], ':openid' => $v['openid']))->queryScalar();
                echo $role_level . "\t";
                $level_sql = "SELECT `time`, `role_level`, `yellow_vip_level` FROM login_game WHERE role_id = '" . $v['openid'] . "' AND server_id = " . $v['server_id'];
                $result = Yii::app()->db->createCommand($level_sql)->queryAll();
                if(count($result)){
                    foreach ($result as $key => $value) {
                        if($key == 0){
                            $first_time = $value['time'];
                            $time = $value['time'];
                            $yellow_vip_level = $value['yellow_vip_level'];
                        }else{
                            $time = $value['time'];
                            $yellow_vip_level = $value['yellow_vip_level'];
                        }
                    }
                }
                echo $yellow_vip_level . "\t";
                echo date('Y-m-d H:i:s', $first_time) . "\t";
                echo date('Y-m-d H:i:s', $time) . "\t";
                echo $v['balance'] . "\t";
                echo $v['ts'] . "\t";
                echo $v['all_balance'] . "\t\n";
            }
        }
        Yii::app()->end();
    }

}