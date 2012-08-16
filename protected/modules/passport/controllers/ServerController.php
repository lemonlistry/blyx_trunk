<?php

class ServerController extends Controller
{

    /**
     * 服务器管理
     */
    public function actionServerList()
    {
        $model = new Server();
        $criteria = new EMongoCriteria();
        $page = $this->getParam('page');
        $offset = empty($page) ? 0 : ($page - 1) * Pages::LIMIT;
        $criteria->offset($offset)->limit(Pages::LIMIT);
        $list = $model->findAll($criteria);
        $count = $model->count();
        if(Yii::app()->request->isAjaxRequest){
            echo json_encode(array(
                "dataCount" => $count,
                "dataList" => $list
            ));
        }else{
            $this->render('index', array('list' => $list, 'count' => $count, 'model' => $model));
        }
    }

    /**
     * 添加服务器
     */
    public function actionAddServer(){
        $model = new Server();
        if(Yii::app()->request->isPostRequest){
            $param = $this->getParam('Server');
            $param['id'] = $this->getAutoIncrementKey('bl_server');
            $model->attributes = $param;
            if($model->validate()){
                $model->save();
                Util::log('服务器添加成功', 'passport', __FILE__, __LINE__);
                echo json_encode(array(
                        "success"=> true,
                        "text"=>"服务器添加成功",
                        "reload"=>true,
                ));
            }else{
                echo json_encode(array(
                        "success"=> false,
                        "text"=>$model['_errors']
                ));
            }
            Yii::app()->end();
        }
        $action = $this->createUrl('/passport/server/addServer');
        $this->renderPartial('_add_server', array(
            'model' => $model,
            'action' => $action
        ), false, true);
    }

    /**
     * 更新服务器
     */
    public function actionUpdateServer(){
        if(Yii::app()->request->isPostRequest){
            $param = $this->getParam('Server');
            $model = $this->loadModel($param['id'], 'Server');
            $model->attributes = $param;
            if($model->validate()){
                $model->save();
                Util::log('服务器更新成功', 'passport', __FILE__, __LINE__);
                echo json_encode(array(
                        "success"=> true,
                        "reload"=>true,
                        "text"=>"服务器更新成功"
                ));
            }else{
                echo json_encode(array(
                        "success"=> false,
                        "text"=>$model['_errors']
                ));
            }
            Yii::app()->end();
        }else{
            $id = $this->getParam('id');
            $model = $this->loadModel($id , 'Server');
        }
        $action = $this->createUrl('/passport/server/updateserver/id/'.$this->getParam('id'));
        $this->renderPartial('_add_server', array(
            'model' => $model,
            'action' => $action
        ), false, true);

    }

    /**
     * 删除服务器
     */
   public function actionDeleteServer(){
        if(Yii::app()->request->isAjaxRequest){
            $id = $this->getParam('id');
            $server = $this->loadModel($id, 'Server');
            $server->delete();
            Util::log('服务器删除成功', 'passport', __FILE__, __LINE__);
            echo json_encode(array(
                'success'=>true,
                "reload"=>true,
                'text'=>'服务器删除成功'
            ));
            Yii::app()->end();
        }else{
            throw new CHttpException('无效的请求...');
        }
    }

    /**
     * 服务器监控
     */
    public function actionServerMonitor(){
        if(Yii::app()->request->isAjaxRequest){
            $param = $this->getParam(array('open_id', 'open_key', 'config'));
            $message_box = Service::requestLogin($param['open_id'], $param['open_key'], $param['config']);
            $message = implode('', $message_box);
            echo $message;
            Yii::app()->end();
        }else{
            $this->renderPartial('server_monitor');
        }
    }

}