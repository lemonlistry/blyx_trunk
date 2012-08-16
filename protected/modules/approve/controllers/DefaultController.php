<?php

class DefaultController extends Controller
{
    /**
     * 所有事务审批
     */
    public function actionIndex()
    {
        $model = new Task();
        $criteria = new EMongoCriteria();
        $criteria->sort('id', EMongoCriteria::SORT_DESC);
        $page = $this->getParam('page');
        $offset = empty($page) ? 0 : ($page - 1) * Pages::LIMIT;
        $criteria->offset($offset)->limit(Pages::LIMIT);
        $list = $model->findAll($criteria);
        $count = $model->count();
        $result = array();
        if($count){
            foreach ($list as $k => $v) {
                $result[$k] = $this->dataConvert($v);
                if($v->status == 0 && WorkFlow::verifyAuth($v->flow_id, $v->id)){
                    $result[$k]['prime'] = true;
                }else{
                    $result[$k]['prime'] = false;
                }
            }
        }
        if(Yii::app()->request->isAjaxRequest){
            echo json_encode(array("dataCount" => $count, "dataList" => $result));
        }else{
            $this->render('index', array(
                'list' => $result,
                'count' => $count,
                'model' => $model,
                'current_page' => $this -> createUrl('/approve/default/index'),
            ));
        }
    }

    /**
     * 等待审批的事务
     */
    public function actionWait()
    {
        $model = new Task();
        $criteria = new EMongoCriteria();
        $criteria->sort('id', EMongoCriteria::SORT_DESC);
        $criteria->addCond('status', '==', 0);
        $list = $model->findAll($criteria);
        $result = $res = array();
        $i = 0;
        if(count($list)){
            foreach ($list as $k => $v) {
                if(WorkFlow::verifyAuth($v->flow_id, $v->id)){
                    $result[$i] = $this->dataConvert($v);
                    $result[$i]['prime'] = true;
                    $i++;
                }
            }
        }
        $page = $this->getParam('page');
        $page = empty($page) ? 0 : $page - 1;
        $count = count($result);
        if($count){
            $result = array_chunk($result, Pages::LIMIT);
            $res = $result[$page];
        }
        if(Yii::app()->request->isAjaxRequest){
            echo json_encode(array("dataCount" => $count, "dataList" => $res));
        }else{
            $this->render('index', array(
                'list' => $res,
                'model' => $model,
                'count' => $count,
                'current_page' => $this -> createUrl('/approve/default/wait'),
            ));
        }
    }

    /**
     * 已经审批的事务
     */
    public function actionFinish()
    {
        $list = $result = array();
        $count = 0;
        $record = Approve::model()->findAllByAttributes(array('user_id' => Yii::app()->user->getUid()));
        $task_arr = array();
        if(count($record)){
            foreach ($record as $v) {
                array_push($task_arr, $v->task_id);
            }
        }
        $model = new Task();
        if(count($task_arr)){
            $criteria = new EMongoCriteria();
            $criteria->addCond('id', 'in', $task_arr);
            $count = $model->count($criteria);
            $criteria->sort('id', EMongoCriteria::SORT_DESC);
            $page = $this->getParam('page');
            $offset = empty($page) ? 0 : ($page - 1) * Pages::LIMIT;
            $criteria->offset($offset)->limit(Pages::LIMIT);
            $list = $model->findAll($criteria);
        }
        if($count){
            foreach ($list as $k => $v) {
                $result[$k] = $this->dataConvert($v);
                $result[$k]['prime'] = false;
            }
        }
        if(Yii::app()->request->isAjaxRequest){
            echo json_encode(array("dataCount" => $count, "dataList" => $result));
        }else{
            $this->render('index', array(
                'list' => $result,
                'count' => $count,
                'model' => $model,
                'current_page' => $this -> createUrl('/approve/default/finish'),
                'show_approve' => false
            ));
        }
    }

    /**
     * 根据前端需求 转换数据
     */
    protected function dataConvert($v){
        $data = get_object_vars($v);
        $flow = Flow::model()->findByAttributes(array('id' => $v->flow_id));
        $current_node =  WorkFlow::getCurrentNode($v->flow_id, $v->id);
        $data['current_node_id'] = isset($current_node->id) ? $current_node->id : '';
        $data['flow_name'] = $flow->name;
        $data['username'] = Account::user('id', $v->user_id, 'username');
        $data['status'] = Task::model()->getStatus($v->status);
        $data['current_user'] = ($v->status == 0 && !empty($current_node)) ? Account::user('id', $current_node->user_id, 'username') : '';
        return $data;
    }


    /**
     * 所有流程
     */
    public function actionFlowList()
    {
        $model = new Flow();
        $criteria = new EMongoCriteria();
        $criteria->addCond('status', '==', 2);
        $count = $model->count($criteria);
        $page = $this->getParam('page');
        $offset = empty($page) ? 0 : ($page - 1) * Pages::LIMIT;
        $criteria->offset($offset)->limit(Pages::LIMIT);
        $list = $model->findAll($criteria);
        $result = array();
        if($count){
            foreach ($list as $k => $v) {
                $result[$k] = get_object_vars($v);
                $result[$k]['node_info'] = WorkFlow::getNodeInfo($v->id);
                $result[$k]['status'] = $model->getStatus($v->status);
            }
        }
        if(Yii::app()->request->isAjaxRequest){
            echo json_encode(array("dataCount" => $count, "dataList" => $result));
        }else{
            $this->render('flow_list', array(
                'list' => $result,
                'count' => $count,
                'model' => $model,
                'current_page' => $this -> createUrl('/approve/default/flowlist'),
            ));
        }
    }

    /**
     * 添加流程
     */
    public function actionAddFlow()
    {
        $model = new Flow();
        if(Yii::app()->request->isPostRequest){
            $param = $this->getParam('Flow');
            $param['id'] = $this->getAutoIncrementKey('bl_flow');
            $param['create_time'] = time();
            $model->attributes = $param;
            $flow = Flow::model()->findByAttributes(array('tag' => $param['tag'], 'status' => 2));
            if(!empty($flow)){
                $model->addError('tag', '标签 不是唯一的');
            }else{
                if($model->validate()){
                    $model->save();
                    Util::log('流程添加成功', 'approve', __FILE__, __LINE__);
                    echo json_encode(array(
                        "success"=> true,
                        "reload"=>true,
                        "text"=>"流程添加成功"
                    ));
                    Yii::app()->end();
                }
            }
            echo json_encode(array("success"=> false,"text"=>$model['_errors']));
            Yii::app()->end();
        }
        $action = $this->createUrl('/approve/default/addflow');
        $this->renderPartial('_add_flow', array('model' => $model, 'action' => $action), false, true);
    }


    /**
     * 删除流程
     */
    public function actionDeleteFlow(){
        if(Yii::app()->request->isAjaxRequest){
            $id = $this->getParam('id');
            $task = Task::model()->findByAttributes(array('flow_id' => $id, 'status' => 0));
            if(empty($task)){
                $flow = $this->loadModel($id, 'Flow');
                $flow->status = 1;
                $flow->save();
                Util::log('流程删除成功', 'approve', __FILE__, __LINE__);
                echo json_encode(array(
                    "success"=> true,
                    "text"=>"流程删除成功",
                    "reload"=>true,
                ));
            }else{
                echo json_encode(array('success' => false, 'text' => '该流程存在正在审批的事务,不允许删除'));
            }
            Yii::app()->end();
        }else{
            throw new CHttpException('无效的请求...');
        }
    }

    /**
     * 添加节点
     */
    public function actionAddNode(){
        $model = new Node();
        $model->flow_id = $this->getParam('id');
        $flow_list = array();
        $flows = Flow::model()->findAllByAttributes(array('status' => 2));
        if(count($flows)){
            foreach ($flows as $flow) {
                $flow_list[$flow->id] = $flow->name;
            }
        }
        $user_list = array();
        $users = Account::allUser();
        if(count($users)){
            foreach ($users as $user) {
                $user_list[$user->id] = $user->username;
            }
        }
        if(Yii::app()->request->isPostRequest){
            $param = $this->getParam('Node');
            $param['id'] = $this->getAutoIncrementKey('bl_node');
            $model->attributes = $param;
            if($model->validate()){
                $model->save();
                Util::log('节点添加成功', 'approve', __FILE__, __LINE__);
                echo json_encode(array(
                    "success"=> true,
                    "reload"=>true,
                    "text"=>"节点添加成功"
                ));
            }else{
                echo json_encode(array("success"=> false,"text"=>$model['_errors']));
            }
            Yii::app()->end();
        }
        $this->renderPartial('_add_node', array(
            'model' => $model,
            'flow_list' => $flow_list,
            'user_list' => $user_list,
            'action' => $this->createUrl('/approve/default/addnode/id/'.$model->flow_id)
        ), false, true);
    }

    /**
     * 审批
     */
    public function actionApprove(){
        $model = new Approve();
        if(Yii::app()->request->isPostRequest){
            $model->task_id = $this->getParam('task_id');
            $model->flow_id = $this->getParam('flow_id');
            $model->node_id = $this->getParam('node_id');
            $model->id = $this->getAutoIncrementKey('bl_approve');
            $model->user_id = Yii::app()->user->getUid();
            $model->create_time = time();
            $param = $this->getParam('Approve');
            $model->attributes = $param;
            if($model->validate()){
                $model->save();
                $flow = $this->loadModel($model->flow_id, 'Flow');
                $msg = $model->status == 1 ? $flow->name . '审批通过' : $flow->name . '审批拒绝';
                Util::log($msg, 'approve', __FILE__, __LINE__);
                if($model->status == 2 || WorkFlow::isLastNode($model->flow_id, $model->node_id)){
                    $task = $this->loadModel($model->task_id, 'Task');
                    $task->status = $model->status;
                    $task->save();
                    $relate = $this->loadModel($task->relate_id, $flow->tag);
                    $relate->status = $model->status;
                    $relate->save();
                    if($model->status == 1){
                        switch ($flow->tag) {
                            case 'Gift':
                            case 'OwnerGift':
                                Service::sendAward($relate->server_id, $relate->role_id, $relate->name, $relate->time, $relate->item_id, $relate->num);
                            break;
                        }
                    }
                }
                echo json_encode(array("success"=> true, "text"=>"审批成功"));
            }else{
                echo json_encode(array("success"=> false,"text"=>$model['_errors']));
            }
            Yii::app()->end();
        }
        $task_id = $this->getParam('task_id');
        $flow_id = $this->getParam('flow_id');
        $node_id = $this->getParam('node_id');
        $action = $this -> createUrl('/approve/default/approve/task_id/'.$task_id.'/flow_id/'.$flow_id.'/node_id/'.$node_id);
        $this->renderPartial('_approve', array(
            'model' => $model,
            'action' => $action
        ), false, true);
    }

    /**
     * 查看任务详细信息
     */
    public function actionRelateInfo()
    {
        $relate_id = $this->getParam('relate_id');
        $flow_id = $this->getParam('flow_id');
        $flow = $this->loadModel($flow_id, 'Flow');
        $model = $this->loadModel($relate_id, $flow->tag);
        $view = '_' . strtolower($flow->tag) . '_info';
        $this->renderPartial($view, array('model' => $model), false, true);
    }

    /**
     * 查看审批记录
     */
    public function actionApproveRecord()
    {
        $task_id = $this->getParam('task_id');
        $model = new Approve();
        $list = $model->findAllByAttributes(array('task_id' => $task_id));
        $this->renderPartial('_approve_record', array('list' => $list, 'model' => $model), false, true);
    }

}