<?php

class ServerController extends Controller
{

    /**
     * 服务器管理
     */
    public function actionServerList()
    {
        $title = '服务器管理';
        $list = Server::model()->findAll();
        $result = Pages::initArray($list);
        $this->render('index', array('title' => $title, 'list' => $result['list'], 'pages' => $result['pages']));
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
                Util::header($this->createUrl('/passport/server/serverlist'));
            }
        }
        $this->renderPartial('_add_server', array('model' => $model), false, true);
    }
    
    /**
     * 更新服务器
     * 
     */
    public function actionUpdateServer(){
        if(Yii::app()->request->isPostRequest){
            $param = $this->getParam('Server');
            $model = $this->loadModel($param['id'], 'Server');
            $model->attributes = $param;
            if($model->validate()){
                $model->save();
                Util::log('服务器更新成功', 'passport', __FILE__, __LINE__);
                Util::header($this->createUrl('/passport/server/serverlist'));
            }
        }else{
            $id = $this->getParam('id');
            $model = $this->loadModel($id , 'Server');
        }
        $this->renderPartial('_add_server', array('model' => $model), false, true);
        
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
            echo json_encode(array('status' => 1, 'location' => $this->createUrl('/passport/server/serverlist')));
            Yii::app()->end();
        }else{
            throw new CHttpException('无效的请求...');
        }
    }

}