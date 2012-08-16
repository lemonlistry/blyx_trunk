<?php

class NoticeController extends Controller
{

    /**
     * 查看所有公告
     */
    public function actionList()
    {
        $model = new Notice();
        $criteria = new EMongoCriteria();
        $param = $this->getParam(array('page', 'content', 'server_id'));
        if(!empty($param['content'])){
            $criteria->content = new MongoRegex('/.*' . $param['content'] . '.*/i');
        }
        if(!empty($param['server_id'])){
            $criteria->addCond('server_id', '==', $param['server_id']);
        }
        $count = $model->count($criteria);
        $offset = empty($param['page']) ? 0 : ($param['page'] - 1) * Pages::LIMIT;
        $criteria->offset($offset)->limit(Pages::LIMIT);
        $criteria->sort('id', EMongoCriteria::SORT_DESC);
        $list = $model->findAll($criteria);
        $result = array();
        if($count){
            foreach ($list as $k => $v) {
                $result[$k] = get_object_vars($v);
                $result[$k]['sname'] = Util::getServerName($v->server_id);
                $result[$k]['tran_status'] = Notice::model()->getStatus($v->status);
            }
        }
        $servers = Util::getServerSelect();
        if(Yii::app()->request->isAjaxRequest){
            echo json_encode(array(
                "dataCount" => $count,
                "dataList" => $result
            ));
        }else{
            $this->render('list', array('list' => $result, 'count' => $count, 'model' => $model, 'servers' => $servers));
        }
    }

    /**
     * 添加公告
     */
    public function actionAddNotice()
    {
        $model = new Notice();
        if(Yii::app()->request->isPostRequest){
            $model->attributes = $this->getParam('Notice');
            $model->begin_time = empty($model->begin_time) ? '' : strtotime($model->begin_time);
            $model->end_time = empty($model->end_time) ? '' : strtotime($model->end_time);
            $model->id = $this->getAutoIncrementKey('bl_notice');
            $model->create_time = time();
            if($model->validate()){
                $res = WorkFlow::initFlow('Notice', $model->id);
                if($res['flag'] == 1){
                    $model->save();
                    Util::log('添加在线公告操作成功', 'service', __FILE__, __LINE__);
                    echo json_encode(array(
                            "success"=> true,
                            "reload"=>true,
                            "text"=>"添加在线公告操作成功"
                    ));
                }else{
                    echo json_encode(array(
                            "success"=> false,
                            "text"=>$res['msg']
                    ));
                }
            }else{
                echo json_encode(array(
                        "success"=> false,
                        "text"=>$model->getErrors()
                ));
            }
            $model->send_time = empty($model->send_time) ? '' : date('Y-m-d H:i:s', ($model->send_time));
            Yii::app()->end();
        }
        $select = Util::getServerSelect();
        $this->renderPartial('_add_notice', array(
            'select' => $select,
            'model' => $model,
            'action' => $this -> createUrl('/service/notice/addnotice'),
        ), false, true);
    }

    /**
     * 删除公告
     */
   public function actionDeleteNotice(){
        if(Yii::app()->request->isAjaxRequest){
            $id = $this->getParam('id');
            $notice = $this->loadModel($id, 'Notice');
            if($notice->status != 0 || !WorkFlow::isAllowDelete($notice->id, 'Notice')){
                echo json_encode(array(
                        "success"=> false,
                        "text"=>"公告已经产生审批数据,不能删除",
                ));
            }else{
                $notice->delete();
                Util::log('公告删除成功', 'service', __FILE__, __LINE__);
                WorkFlow::deleteTask($notice->id, 'Notice');
                echo json_encode(array(
                        "success"=> true,
                        "text"=>"公告删除成功",
                        "reload"=>true,
                ));
            }
            Yii::app()->end();
        }else{
            throw new CHttpException('无效的请求...');
        }
    }

}