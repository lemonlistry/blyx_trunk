<?php

class GiftController extends Controller
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
     * 查看所有礼包
     */
    public function actionList()
    {
        $title = 'GM管理';
        $model = new Gift();
        $criteria = new EMongoCriteria();
        $criteria->sort('id', EMongoCriteria::SORT_DESC);
        $list = $model->findAll($criteria);
        $result = Pages::initArray($list);
        $this->render('list', array('title' => $title, 'list' => $result['list'], 'pages' => $result['pages'], 'model' => $model));
    }
    
    /**
     * 添加礼包
     */
    public function actionAddGift()
    {
        $title = 'GM管理';
        $model = new Gift();
        if(Yii::app()->request->isPostRequest){
            $model->attributes = $this->getParam('Gift');
            $model->id = $this->getAutoIncrementKey('bl_gift');
            $model->create_time = time();
            $item_name = Util::translation('itemInformation', array('items'),'itemId',$model->item_id,'itemName');
            if(empty($item_name)){
                $model->addError('item_id', '物品不存在');
            }else{
                if($model->validate()){
                    $res = WorkFlow::initFlow('Gift', $model->id);
                    $url = $this->createUrl('/service/gift/list');
                    if($res['flag'] == 1){
                        $model->save();
                        Util::log('添加礼包操作成功', 'service', __FILE__, __LINE__);
                        Util::header($url);
                    }else{
                        Util::header($url, $res['msg']);
                    }
                }
            }
        }
        $this->initServer();
        $this->renderPartial('_add_gift', array('title' => $title, 'select' => $this->select, 'model' => $model), false, true);
    }
    
    /**
     * 删除礼包
     */
   public function actionDeleteGift(){
        if(Yii::app()->request->isAjaxRequest){
            $id = $this->getParam('id');
            $gift = $this->loadModel($id, 'Gift');
            if($gift->status != 0 || !WorkFlow::isAllowDelete($gift->id, 'Gift')){
                echo json_encode(array('status' => 0, 'msg' => '礼包已经产生审批数据,不能删除'));
            }else{
                $gift->delete();
                Util::log('礼包删除成功', 'service', __FILE__, __LINE__);
                WorkFlow::deleteTask($gift->id, 'Gift');
                echo json_encode(array('status' => 1, 'location' => $this->createUrl('/service/gift/list')));
            }
            Yii::app()->end();
        }else{
            throw new CHttpException('无效的请求...');
        }
    }
    
}