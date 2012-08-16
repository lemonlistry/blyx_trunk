<?php

class VipController extends Controller
{

    /**
     * VIP玩家信息统计
     */
    public function actionIndex()
    {
        if(Yii::app()->request->isAjaxRequest){
            $res = array();
            $list = $this->getVipMessage();
            $page = $this->getParam('page');
            $page = empty($page) ? 0 : $page - 1;
            $count = count($list);
            if($count){
                $result = array_chunk($list, Pages::LIMIT);
                $res = $result[$page];
            }
            echo json_encode(array(
                "dataCount" => $count,
                "dataList" => $res
            ));
        }else{
            $select = Util::getRealServerSelect(false);
            $this->render('index',array( 'select' => $select));
        }
    }

    /*
     * 获得VIP玩家信息
     */
     protected  function getVipMessage($export = false){
         $list = array();
         $res = array();
         $condition = $this->getCondition();
         $res = Yii::app()->db->createCommand()->from('statistic_vip_player')->where($condition['where'], $condition['bind'])->order('date DESC')->queryAll();
         if(count($res)){
             foreach ($res as $k => $v){
                 $list[$v['date']][$v['user_account']]['server_id'] = $v['server_id'];
                 switch ($v['type']) {
                     case 0://黄金
                         if(!isset($list[$v['date']][$v['user_account']]['gold_cost'])){
                             $list[$v['date']][$v['user_account']]['gold_cost'] = 0;
                         }
                         $list[$v['date']][$v['user_account']]['gold_cost'] += $v['num'];
                         break;
                     case 1://礼金
                         if($v['num'] > 0){
                             if(!isset($list[$v['date']][$v['user_account']]['giftgold_product'])){
                                $list[$v['date']][$v['user_account']]['giftgold_product'] = 0;
                             }
                             $list[$v['date']][$v['user_account']]['giftgold_product'] += $v['num'];
                         }else{
                             if(!isset($list[$v['date']][$v['user_account']]['giftgold_consume'])){
                                $list[$v['date']][$v['user_account']]['giftgold_consume'] = 0;
                             }
                             $list[$v['date']][$v['user_account']]['giftgold_consume'] += $v['num'];
                         }
                         break;
                     case 2://银两
                         if($v['num'] > 0){
                             if(!isset($list[$v['date']][$v['user_account']]['silver_product'])){
                                $list[$v['date']][$v['user_account']]['silver_product'] = 0;
                             }
                             $list[$v['date']][$v['user_account']]['silver_product'] += $v['num'];
                         }else{
                             if(!isset($list[$v['date']][$v['user_account']]['silver_consume'])){
                                $list[$v['date']][$v['user_account']]['silver_consume'] = 0;
                             }
                             $list[$v['date']][$v['user_account']]['silver_consume'] += $v['num'];
                         }
                         break;
                     case 3://游戏数据
                         switch ($v['children_type']) {
                             case 14://登录次数
                                 $list[$v['date']][$v['user_account']]['logintimes'] = $v['num'];
                                 break;
                             case 15://兑换银两次数
                                 $list[$v['date']][$v['user_account']]['exchange_silver'] = $v['num'];
                                 break;
                             case 16://VIP等级
                                 $list[$v['date']][$v['user_account']]['vip_level'] = $v['num'];
                                 break;
                         }
                         break;
                 }
             }
         }
         //重新组装数据格式
         $result = array();
         if(count($list)){
             foreach ($list as $key => $value) {
                 if(count($value)){
                     foreach ($value as $k => $v) {
                         $tmp = array();
                         $tmp['date'] = $key;
                         $tmp['user_account'] = $k;
                         $tmp = array_merge($tmp, $v);
                         $result[] = $tmp;
                     }
                 }
             }
         }
         return $result;
     }

     /*
      * VIP黄金消费明细
      */

     public function actionVipGold(){
         $res = array();
         $list = array();
         $condition = $this->getConditionDetail();
         $condition['where'] .= ' AND type = 0';
         $res = Yii::app()->db->createCommand()->from('statistic_vip_player')->where($condition['where'], $condition['bind'])->queryAll();
         if(count($res)){
             foreach ($res as $k => $v){
                 $list[$v['children_type']] = $v['num'];
             }
         }
         $this->render('_vip_gold',array('children_type' => AppConst::$gold_children_type,'list' => $list),false,true);
     }

     /*
      * VIP银两消费明细
      */

     public function actionVipSilver(){
         $res = array();
         $list = array();
         $condition = $this->getConditionDetail();
         $condition['where'] .= ' AND type = 2 AND num < 0';
         $res = Yii::app()->db->createCommand()->from('statistic_vip_player')->where($condition['where'], $condition['bind'])->queryAll();
         if(count($res)){
             foreach ($res as $k => $v){
                 $list[$v['children_type']] = $v['num'];
             }
         }
         $this->render('_vip_silver',array('children_type' => AppConst::$silver_children_type,'list' => $list),false,true);
     }

     /*
      * 游戏数据明细
      */

     public function actionVipGame(){
         $res = array();
         $list = array();
         $condition = $this->getConditionDetail();
         $condition['where'] .= ' AND type = 3';
         $res = Yii::app()->db->createCommand()->from('statistic_vip_player')->where($condition['where'], $condition['bind'])->queryAll();
         if(count($res)){
             foreach ($res as $k => $v){
                 $list[$v['children_type']] = $v['num'];
             }
         }
         $this->render('_vip_game',array('children_type' => AppConst::$game_children_type,'list' => $list),false,true);
     }

     /**
      * 组装查询条件
      */
     protected function getCondition(){
     	 $bind =array();
         $param = $this->getParam(array('begintime', 'endtime', 'server_id', 'role_name', 'user_account', 'vip_level'));
         $where = '1';
         if(!empty($param['server_id'])){
             $where .= ' AND server_id = :server_id';
             $bind[':server_id'] = $param['server_id'];
         }
         if(!empty($param['user_account'])){
             $where .= ' AND user_account = :user_account';
             $bind[':user_account'] = $param['user_account'];
         }
         if(!empty($param['begintime'])){
             $where .= ' AND `date` >= :begintime';
             $bind[':begintime'] = $param['begintime'];
         }
         if(!empty($param['endtime'])){
             $where .= ' AND `date` <= :endtime';
             $bind[':endtime'] = $param['endtime'];
         }
         if(!empty($param['role_name'])){
             $user_account = Util::getPlayerAccount($param['role_name'], $param['server_id']);
             $where .= ' AND user_account = :user_account';
             $bind[':user_account'] = $user_account;
         }
         if(!empty($param['vip_level'])){
             $list = Yii::app()->db->createCommand()->select('user_account')->from('statistic_vip_player')
                        ->where('`type` = 3 AND children_type = 16 AND num = :vip_level AND server_id = :server_id',
                                array(':vip_level' => $param['vip_level'], ':server_id' => $param['server_id']))
                        ->group('user_account')->queryColumn();
             if(isset($bind[':user_account']) && !in_array($bind[':user_account'], $list)){
                 $where = ' AND 0 ' . $where;
             }else{
                 $str = implode("','", $list);
                 $where .= " AND user_account in ('" .$str . "')";
             }
         }
         return array('where' => $where, 'bind' => $bind);
     }

     /**
      * 组装查询条件
      */
     protected function getConditionDetail(){
     	 $bind =array();
         $param = $this->getParam(array('begintime', 'server_id', 'user_account'));
         $where = '1';
         if(!empty($param['server_id'])){
             $where .= ' AND server_id = :server_id';
             $bind[':server_id'] = $param['server_id'];
         }
         if(!empty($param['user_account'])){
             $where .= ' AND user_account = :user_account';
             $bind[':user_account'] = $param['user_account'];
         }
         if(!empty($param['begintime'])){
             $where .= ' AND `date` = :begintime';
             $bind[':begintime'] = $param['begintime'];
         }
         return array('where' => $where, 'bind' => $bind);
     }

}
