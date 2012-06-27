<?php

class NoticeController extends Controller
{
    public $select;
    
    /**
     * 初始化服务器信息
     */
    protected function initServer()
    {
        $servers = Server::model()->findAll();
        $select = array();
        if(count($servers)){
            foreach ($servers as $k => $v) {
                $select[$v->id] = $v->sname;
            }
        }
        $this->select = $select;
    }
    
    /**
     * 查看所有公告
     */
    public function actionList()
    {
        $title = 'GM管理';
        $model = new Notice();
        $criteria = new EMongoCriteria();
        $criteria->sort('id', EMongoCriteria::SORT_DESC);
        $list = $model->findAll($criteria);
        $result = Pages::initArray($list);
        $this->render('list', array('title' => $title, 'list' => $result['list'], 'pages' => $result['pages'], 'model' => $model));
    }
    
    /**
     * 添加公告
     */
    public function actionAddNotice()
    {
        $title = 'GM管理';
        $model = new Notice();
        if(Yii::app()->request->isPostRequest){
            $model->attributes = $this->getParam('Notice');
            $model->send_time = empty($model->send_time) ? '' : strtotime($model->send_time);
            $model->id = $this->getAutoIncrementKey('bl_notice');
            $model->create_time = time();
            if($model->validate()){
                $res = WorkFlow::initFlow('Notice', $model->id);
                $url = $this->createUrl('/service/notice/list');
                if($res['flag'] == 1){
                    $model->save();
                    Util::log('添加在线公告操作成功', 'service', __FILE__, __LINE__);
                    Util::header($url);
                }else{
                    Util::header($url, $res['msg']);
                }
            }
            $model->send_time = empty($model->send_time) ? '' : date('Y-m-d H:i:s', ($model->send_time));
        }
        $this->initServer();
        $this->renderPartial('_add_notice', array('title' => $title, 'select' => $this->select, 'model' => $model), false, true);
    }
    
    /**
     * 删除公告
     */
   public function actionDeleteNotice(){
        if(Yii::app()->request->isAjaxRequest){
            $id = $this->getParam('id');
            $notice = $this->loadModel($id, 'Notice');
            if($notice->status != 0 || !WorkFlow::isAllowDelete($notice->id, 'Notice')){
                echo json_encode(array('status' => 0, 'msg' => '公告已经产生审批数据,不能删除'));
            }else{
                $notice->delete();
                Util::log('公告删除成功', 'service', __FILE__, __LINE__);
                WorkFlow::deleteTask($notice->id, 'Notice');
                echo json_encode(array('status' => 1, 'location' => $this->createUrl('/service/notice/list')));
            }
            Yii::app()->end();
        }else{
            throw new CHttpException('无效的请求...');
        }
    }
    
}