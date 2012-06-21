<?php

class DefaultController extends Controller
{
    /**
     * 所有事务审批
     */
    public function actionIndex()
    {
        $title= '所有事务';
        $model = new Task();
        $list = $model->findAll();
        $result = Pages::initArray($list);
        $this->render('index', array('title' => $title, 'list' => $result['list'], 'pages' => $result['pages'], 'model' => $model));
    }
    
    /**
     * 等待审批的事务
     */
    public function actionWait()
    {
        $title= '等待审批的事务';
        $model = new Task();
        $list = $model->findAllByAttributes(array('status' => 0));
        if(count($list)){
            foreach ($list as $k => $v) {
                if(!WorkFlow::verifyAuth($v->flow_id, $v->id)){
                    unset($list[$k]);
                }
            }
        }
        $result = Pages::initArray($list);
        $this->render('index', array('title' => $title, 'list' => $result['list'], 'pages' => $result['pages'], 'model' => $model));
    }
    
    /**
     * 已经审批的事务
     */
    public function actionFinish()
    {
        $title= '已经审批的事务';
        $list = array();
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
            $list = $model->findAll($criteria);
        }
        $result = Pages::initArray($list);
        $this->render('index', array('title' => $title, 'list' => $result['list'], 'pages' => $result['pages'], 'model' => $model));
    }
    
    /**
     * 所有流程
     */
    public function actionFlowList()
    {
        $title= '流程管理';
        $model = new Flow();
        $list = $model->findAllByAttributes(array('status' => 2));
        $result = Pages::initArray($list);
        $this->render('flow_list', array('title' => $title, 'list' => $result['list'], 'pages' => $result['pages'], 'model' => $model));
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
                    Util::header($this->createUrl('/approve/default/flowlist'));
                }
            }
        }
        $this->renderPartial('_add_flow', array('model' => $model), false, true);
    }
    
  
    /**
     * 删除流程
     */
    public function actionDeleteFlow(){
        if(Yii::app()->request->isAjaxRequest){
            $id = $this->getParam('id');
            $flow = $this->loadModel($id, 'Flow');
            $flow->status = 1;
            $flow->save();
            Util::log('流程删除成功', 'approve', __FILE__, __LINE__);
            echo json_encode(array('status' => 1, 'location' => $this->createUrl('/approve/default/flowlist')));
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
        $flows = Flow::model()->findAll();
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
                Util::header($this->createUrl('/approve/default/flowlist'));
            }
        }
        $this->renderPartial('_add_node', array('model' => $model, 'flow_list' => $flow_list, 'user_list' => $user_list), false, true);
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
                                Service::sendAward($relate->server_id, $relate->role_id, $relate->name, $relate->time, $relate->item_id, $relate->num);
                            break;
                        }
                    }
                }
                Util::header($this->createUrl('/approve/default/wait'));
            }
        }
        $this->renderPartial('_approve', array('model' => $model), false, true);
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