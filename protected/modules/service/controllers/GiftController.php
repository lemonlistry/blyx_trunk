<?php

class GiftController extends Controller
{

    /**
     * 查看所有礼包
     */
    public function actionList()
    {
        $param = $this->getParam(array('role_name', 'begintime', 'endtime'));
        $model = new Gift();
        $criteria = new EMongoCriteria();
        $page = $this->getParam('page');
        $offset = empty($page) ? 0 : ($page - 1) * Pages::LIMIT;
        $uid = Yii::app()->user->getUid();
        //超级管理员可以查看所有记录,否则只能看自己添加的记录
        if(!Account::isAdmin($uid)){
            $criteria->addCond('user_id', '==', $uid);
        }else{
            if(!empty($param['role_name'])){
                $criteria->addCond('role_name', '==', $param['role_name']);
            }
        }
        if(!empty($param['begintime'])){
            $criteria->addCond('create_time', '>=', strtotime($param['begintime']));
        }
        if(!empty($param['endtime'])){
            $criteria->addCond('create_time', '<', strtotime($param['endtime']) + 86400);
        }
        $count = $model->count($criteria);
        $criteria->offset($offset)->limit(Pages::LIMIT);
        $criteria->sort('id', EMongoCriteria::SORT_DESC);
        $list = $model->findAll($criteria);
        $result = array();
        if($count){
            foreach ($list as $k => $v) {
                $result[$k] = get_object_vars($v);
                $result[$k]['sname'] = Util::getServerName($v->server_id);
                $result[$k]['tran_status'] = $model->getStatus($v->status);
                $result[$k]['item_name'] = Util::translation('itemInformation', array('items'), 'itemId', $v['item_id'], 'itemName');
            }
        }
        if(Yii::app()->request->isAjaxRequest){
            echo json_encode(array(
                "dataCount" => $count,
                "dataList" => $result
            ));
        }else{
            $this->render('list', array('list' => $result, 'count' => $count, 'model' => $model));
        }
    }

    /**
     * 添加礼包
     */
    public function actionAddGift()
    {
        $model = new Gift();
        if(Yii::app()->request->isPostRequest){
            $param = $this->getParam('Gift');
            $item_name = Util::translation('itemInformation', array('items'), 'itemId', $param['item_id'], 'itemName');
            $error = $role_id_list = array();
            $flag = false;
            //单个角色发送 range 为 1 全服发送 range 为2
            if($param['range'] == 2){
                array_push($role_id_list, 987654321);
                $param['role_name'] = '所有玩家';
            }else{
                $role_name_list = explode('|', $param['role_name']);
                foreach ($role_name_list as $v) {
                    $role_id = Util::getPlayerRoleId($v, $param['server_id']);
                    if(empty($role_id)){
                        $flag = true;
                        array_push($error, $v);
                    }else{
                        array_push($role_id_list, $role_id);
                    }
                }
            }
            if(empty($item_name)){
                $model->addError('item_id', '物品不存在');
            }else if($flag || !count($role_id_list)){
                $notice = implode(',', $error);
                $notice = empty($notice) ? '' : '"' . $notice . '"';
                $model->addError('role_name', $notice .'角色名称不存在');
            }else{
                $model->attributes = $param;
                $model->id = $this->getAutoIncrementKey('bl_gift');
                $model->create_time = time();
                $model->role_id = implode('|', $role_id_list);
                $model->user_id = Yii::app()->user->getUid();
                if($model->validate()){
                    $res = WorkFlow::initFlow('Gift', $model->id);
                    if($res['flag'] == 1){
                        $model->save();
                        Util::log('添加礼包操作成功', 'service', __FILE__, __LINE__);
                        echo json_encode(array(
                                "success"=> true,
                                "reload"=>true,
                                "text"=>"添加礼包操作成功"
                        ));
                    }else{
                        echo json_encode(array(
                                "success"=> false,
                                "text"=>$res['msg']
                        ));
                    }
                    Yii::app()->end();
                }
            }
            echo json_encode(array(
                    "success"=> false,
                    "text"=>$model->getErrors()
            ));
            Yii::app()->end();
        }
        $select = Util::getServerSelect(false);
        $this->renderPartial('_add_gift', array(
            'select' => $select,
            'model' => $model,
            'action'=>$this->createUrl('/service/gift/addgift')
        ), false, true);
    }

    /*
     * 添加内服礼包
     */
    public function actionAddOwnerGift(){
        $model = new Gift();
        if(Yii::app()->request->isPostRequest){
            $param = $this->getParam('Gift');
            $item_name = Util::translation('itemInformation', array('items'), 'itemId', $param['item_id'], 'itemName');
            $error = $role_id_list = array();
            $flag = false;
            $role_name_list = explode('|', $param['role_name']);
            if(count($role_name_list)){
                foreach ($role_name_list as $v) {
                    $role_id = Util::getPlayerRoleId($v, $param['server_id']);
                    if(empty($role_id)){
                        $flag = true;
                        array_push($error, $v);
                    }else{
                        array_push($role_id_list, $role_id);
                    }
                }
            }
            if(empty($item_name)){
                $model->addError('item_id', '物品不存在');
            }else if($flag || !count($role_id_list)){
                $notice = implode(',', $error);
                $notice = empty($notice) ? '' : '"' . $notice . '"';
                $model->addError('role_name', $notice .'角色名称不存在');
            }else{
                $model->attributes = $param;
                $model->id = $this->getAutoIncrementKey('bl_gift');
                $model->create_time = time();
                $model->role_id = implode('|', $role_id_list);
                $model->user_id = Yii::app()->user->getUid();
                if($model->validate()){
                    $res = WorkFlow::initFlow('OwnerGift', $model->id);
                    if($res['flag'] == 1){
                        $model->save();
                        Util::log('添加内服礼包操作成功', 'service', __FILE__, __LINE__);
                        echo json_encode(array(
                                "success"=> true,
                                "reload"=>true,
                                "text"=>"添加内服礼包操作成功"
                        ));
                    }else{
                        echo json_encode(array(
                                "success"=> false,
                                "text"=>$res['msg']
                        ));
                    }
                    Yii::app()->end();
                }
            }
            echo json_encode(array(
                    "success"=> false,
                    "text"=>$model->getErrors()
            ));
            Yii::app()->end();
        }
        $select = Util::getServerSelect(false);
        $this->renderPartial('_add_owner_gift', array(
            'select' => $select,
            'model' => $model,
            'action'=>$this->createUrl('/service/gift/addownergift')
        ), false, true);
    }

    /**
     * 删除礼包
     */
   public function actionDeleteGift(){
        if(Yii::app()->request->isAjaxRequest){
            $id = $this->getParam('id');
            $gift = $this->loadModel($id, 'Gift');
            if($gift->status != 0 || !WorkFlow::isAllowDelete($gift->id, 'Gift')){
                echo json_encode(array(
                        "success"=> false,
                        "text"=>"礼包已经产生审批数据,不能删除",
                ));
            }else{
                $gift->delete();
                Util::log('礼包删除成功', 'service', __FILE__, __LINE__);
                WorkFlow::deleteTask($gift->id, 'Gift');
                echo json_encode(array(
                        "success"=> true,
                        "text"=>"礼包删除成功",
                        "reload"=>true,
                ));
            }
            Yii::app()->end();
        }else{
            throw new CHttpException('无效的请求...');
        }
    }

    /**
     * 获取礼包名称
     * @param $item_id 礼包ID
     */
    public function actionGetGiftNameById(){
        if(Yii::app()->request->isAjaxRequest){
            $item_id = $this->getParam('item_id');
            $item_name = Util::translation('itemInformation', array('items'), 'itemId', $item_id, 'itemName');
            if( empty($item_name ) ){
                echo json_encode(array('success' => false, 'text' => '无效物品ID' ));
            }else{
                echo json_encode(array('success' => true, 'text' => $item_name ));
            }
            Yii::app()->end();
        }else{
            throw new CHttpException('无效的请求...');
        }
    }

}