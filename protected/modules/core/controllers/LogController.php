<?php

class LogController extends Controller
{

    /**
     * 礼金产出消费日志
     */
    public function actionGiftGold()
    {
        $list = array();
        $type = array(1 => '消费', 0 => '产出',);
        $children_type = AppConst::$gold_children_type;
        if(Yii::app()->request->isAjaxRequest){
            $param = $this->getParam(array('user_account', 'server_id', 'role_name', 'output_consume', 'consume_type', 'begintime', 'endtime', 'page'));
            $res = $this->getGiftGold($param);
            $list = $res['list'];
            $count = $res['count'];
            echo json_encode(array(
                "dataCount" => intval($count),
                "dataList" => $list
            ));
        }else{
            $select = Util::getRealServerSelect(false);
            $this->render('gift_gold', array('list' => $list, 'select' => $select,"type" => $type,"children_type" => $children_type));
        }
    }

    /*
     * 获取礼金产出消费日志数据
     */
    protected function getGiftGold($param, $export = false){
        $where = '1';
        $bind = array();
        $list = array();
        $res = array();
        $count = 0;
        if(!empty($param['server_id'])){
            $where .= ' AND server_id = :server_id';
            $bind[':server_id'] = $param['server_id'];
        }
        if(!empty($param['user_account'])){
            $where .= ' AND user_account = :user_account';
            $bind[':user_account'] = $param['user_account'];
        }
        if($param['output_consume'] != ''){
            $where .= ' AND type = :type';
            $bind[':type'] = $param['output_consume'];
        }
        if($param['consume_type'] != ''){
            $where .= ' AND children_type = :children_type';
            $bind[':children_type'] = $param['consume_type'];
        }
        if(!empty($param['begintime'])){
            $where .= ' AND time >= :begintime';
            $bind[':begintime'] = strtotime($param['begintime']);
        }
        if(!empty($param['endtime'])){
            $where .= ' AND time < :endtime';
            $bind[':endtime'] = strtotime($param['endtime']) + 86400;
        }
        if(!empty($param['role_name'])){
            $role_ids = '';
            $role_name = explode('|', $param['role_name']);
            foreach ($role_name as $k => $v){
                $role_id = Util::getPlayerAccount($v, $param['server_id']);
                if(!empty($role_id)){
                    $role_ids .= "'{$role_id}',";
                }
            }
            $role_ids = substr($role_ids, 0, (strlen($role_ids) - 1));
            $where .= " AND user_account in ( {$role_ids}) ";
        }
        $offset = empty($param['page']) ? 0 : ($param['page'] - 1) * Pages::LIMIT;
        if($export){
            $list = Yii::app()->db->createCommand()->select('*')->from('log_gift_gold')->where($where, $bind)->offset($offset)->limit(10000)->order('time DESC')->queryAll();
        }else{

            $count = Yii::app()->db->createCommand()->select('count(1)')->from('log_gift_gold')->where($where, $bind)->queryScalar();
            $list = Yii::app()->db->createCommand()->select('*')->from('log_gift_gold')->where($where, $bind)->offset($offset)->limit(Pages::LIMIT)->order('time DESC')->queryAll();
        }
        if(count($list)){
            foreach ($list as $k => $v){
                $list[$k]['role_name'] = Util::getPlayerRoleName($v['user_account'], intval($v['server_id']));
                if($list[$k]['type'] == 1){
                    $list[$k]['num'] = -$list[$k]['num'];
                }
            }
        }
        $res = array('count' => $count, 'list' => $list);
        return $res;
    }

    /*
     * 礼金产出消费日志数据导出
     */
    public function actionGiftGoldExport(){
        set_time_limit(0);
        ini_set('memory_limit','2048M');
        $param = $this->getParam(array('user_account', 'server_id', 'role_name', 'output_consume', 'consume_type', 'begintime', 'endtime', 'page'));
        $title = '礼金日志';
        header("Content-Type: application/vnd.ms-excel;charset=utf8");
        header("Content-Disposition: attachment; filename=".$title.".xls");
        $header = array('服务器', '帐号名', '角色名', '消费时间', '消费类型', '消费子类', '消费金额');
        $res = $this->getGiftGold($param, true);
        $list = $res['list'];
        $data = Util::export($header, $list, array('server_id', 'user_account', 'role_name', 'time', 'type', 'children_type', 'num'));
        echo $data;
    }

    /**
     * 银两产出消费日志
     */
    public function actionSilver()
    {
        if(Yii::app()->request->isAjaxRequest){
            $param = $this->getParam(array('server_id', 'begintime', 'endtime', 'role_name', 'user_account', 'search_type', 'consume_type_parent','output_consume', 'page'));
            $res = $this->getSilverData($param);
            $list = $res['list'];
            $count = $res['count'];
            echo json_encode(array(
                'dataCount'=>$count,
                'dataList' =>$list
            ));
        }else{
            $select = Util::getRealServerSelect(false);
            $this->render('silver', array('select' => $select));
        }
    }

    /*
     * 获得银两日志数据
     */
    protected   function getSilverData($param, $export = false){
        $where = 1;
        $bind = array();
        $count = 0;
        $list = array();
        if (!empty($param['server_id'])){
            $where .= ' and server_id = :server_id';
            $bind[':server_id'] = $param['server_id'];
        }
        if (!empty($param['begintime'])){
            $begintime = strtotime($param['begintime']);
            $where .= ' and time >= :begintime';
            $bind[':begintime'] = $begintime;
        }
        if (!empty($param['endtime'])){
            $endtime = strtotime($param['endtime']) + 86400;
            $where .= ' and time < :endtime';
            $bind[':endtime'] = $endtime;
        }
        if (!empty($param['role_name'])){
            $role_name = explode('|', $param['role_name']);
            $temp = ' and user_account in(';
            foreach ($role_name as $key => $value){
                $user_account = Util::getPlayerAccount($value, $param['server_id']);
                $temp .='\''.$user_account.'\',';
            }
            $temp = substr($temp, 0, strlen($temp) - 1).')';
            $where .= $temp;
        }
        if (!empty($param['user_account'])){
            $where .= ' and user_account = :user_account';
            $bind[':user_account'] = $param['user_account'];
        }
        if ($param['output_consume'] != ''){
            $where .= ' and type = :output_consume';
            $bind[':output_consume'] = $param['output_consume'];
        }
        if ($param['consume_type_parent'] != ''){
            $where .= ' and children_type = :children_type';
            $bind[':children_type'] = $param['consume_type_parent'];
        }
        if ($export){
            $list = Yii::app()->db->createCommand()->from('log_silver')->where($where, $bind)->limit(10000)->queryAll();
        }else{
            $offset = empty($param['page']) ? 0 : ($param['page'] - 1) * Pages::LIMIT;
            $list = Yii::app()->db->createCommand()->from('log_silver')->where($where, $bind)->offset($offset)->limit(Pages::LIMIT)->queryAll();
            $count = Yii::app()->db->createCommand()->select('count(1)')->from('log_silver')->where($where, $bind)->queryScalar();
        }
        foreach ($list as $k => $v){
            $list[$k]['role_name'] = Util::getPlayerRoleName($v['user_account'], $v['server_id']);
            $list[$k]['children_type'] = AppConst::$log_silver[$v['children_type']];
            $list[$k]['type'] = empty($v['type']) ? '产出' : '消费';
        }
        return array('list' => $list,'count' => $count);
    }

    /**
     * 物品变更使用日志
     */
    public function actionItemRecord()
    {
        if(Yii::app()->request->isAjaxRequest){
            $param = $this->getParam(array('server_id', 'begintime', 'endtime', 'role_name', 'user_account', 'search_type', 'page', 'items_type', 'item_name'));
            $count = 0;
            $res = array();
            $list = array();
            $res = $this->getItemRecord($param);
            $list = $res['list'];
            $count = $res['count'];
            echo json_encode(array(
                'dataCount'=>$count,
                'dataList' =>$list
            ));
        }else{
            $select = Util::getRealServerSelect(false);
            $this->render('item_record', array('select' => $select));
        }
    }

    /*
     * 获得物品变更日志
     */
    protected function getItemRecord($param, $export = false){
        $where = '1';
        $bind = array();
        $count = 0;
        $list = array();
        if(!empty($param['begintime'])){
            $begintime = strtotime($param['begintime']);
            $where .= ' and time >= :begintime';
            $bind[':begintime'] = $begintime;
        }
        if(!empty($param['endtime'])){
            $endtime = strtotime($param['endtime']) + 86400;
            $where .= ' and time < :endtime';
            $bind[':endtime'] = $endtime;
        }
        if(!empty($param['server_id'])){
            $where .= ' and server_id = :server_id';
            $bind[':server_id'] = $param['server_id'];
        }
        if(!empty($param['user_account'])){
            $where .= ' and user_account = :user_account';
            $bind[':user_account'] = $param['user_account'];
        }
        if(!empty($param['role_name'])){
            $user_account= Util::getPlayerAccount($param['role_name'], $param['server_id']);
            $where .= ' and user_account = :user_account';
            $bind[':user_account'] = $user_account;
        }
        if(!empty($param['item_name'])){
            $item_id = Util::translation('itemInformation', array('items'), 'itemName', $param['item_name'], 'itemId');
            $where .= ' and item_id = :item_id';
            $bind[':item_id'] = $item_id;
        }
        if($param['items_type'] != ''){
            $where .= ' and type = :type';
            $bind[':type'] = $param['items_type'];
        }
        if ($export){
            $list = Yii::app()->db->createCommand()->from('log_item')->where($where, $bind)->limit(10000)->queryAll();
        }else{
            $offset = empty($param['page']) ? 0 : ($param['page'] - 1) * Pages::LIMIT;
            $count = Yii::app()->db->createCommand()->select('count(1)')->from('log_item')->where($where, $bind)->queryScalar();
            $list = Yii::app()->db->createCommand()->from('log_item')->where($where, $bind)->offset($offset)->limit(Pages::LIMIT)->queryAll();
        }
        foreach ($list as $k => $v){
            $list[$k]['role_name'] = Util::getPlayerRoleName($v['user_account'], $v['server_id']);
            $list[$k]['time'] = date('Y-m-d', $v['time']);
            $list[$k]['item_name'] = Util::translation('itemInformation', array('items'), 'itemId', $v['item_id'], 'itemName');
        }
        return array('list' => $list, 'count' => $count);
    }

}
