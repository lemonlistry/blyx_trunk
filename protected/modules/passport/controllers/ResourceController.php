<?php

class ResourceController extends Controller
{

    /**
     * 权限资源管理
     */
    public function actionResourceList()
    {
        $title = '资源管理';
        $page = $this->getParam('page');
        $model = new Resource();
        $criteria = new EMongoCriteria();
        $offset = empty($page) ? 0 : ($page - 1) * Pages::LIMIT;
        $criteria->sort('id', EMongoCriteria::SORT_DESC);
        $criteria->offset($offset)->limit(Pages::LIMIT);
        $list = $model->findAll($criteria);
        $count = $model->count();
        if(Yii::app()->request->isAjaxRequest){
            echo json_encode(array(
                "dataCount" => $count,
                "dataList" => $list
            ));
        }else{
            $this->render('index', array('title' => $title, 'list' => $list, 'count' => $count, 'model' => $model));
        }
    }

    /**
     * 添加权限资源
     */
    public function actionAddResource(){
        $model = new Resource();
        if(Yii::app()->request->isPostRequest){
            $param = $this->getParam('Resource');
            $param['id'] = $this->getAutoIncrementKey('bl_resource');
            $param['create_time'] = time();
            $model->attributes = $param;
            if($model->validate()){
                $model->save();
                Util::log('资源添加成功', 'passport', __FILE__, __LINE__);
                echo json_encode(array(
                        "success"=> true,
                        "reload"=>true,
                        "text"=>"资源添加成功"
                    ));
            }else{
                echo json_encode(array(
                        "success"=> false,
                        "text"=>$model['_errors']
                    ));
            }
            Yii::app()->end();
        }
        $this->renderPartial('_add_resource', array(
            'model' => $model,
            'action' => $this->createUrl('/passport/resource/addresource')
        ), false, true);
    }

    /**
     * 更新权限资源
     *
     */
    public function actionUpdateResource(){
        if(Yii::app()->request->isPostRequest){
            $param = $this->getParam('Resource');
            $model = $this->loadModel($param['id'], 'Resource');
            $model->attributes = $param;
            if($model->validate()){
                $model->save();
                Util::log('资源更新成功', 'passport', __FILE__, __LINE__);
                echo json_encode(array(
                        "success"=> true,
                        "reload"=>true,
                        "text"=>"资源更新成功"
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
            $model = $this->loadModel($id , 'Resource');
        }
        $this->renderPartial('_add_resource', array(
            'model' => $model,
            'action' => $this->createUrl('/passport/resource/updateresource/id/'.$id)
        ), false, true);
    }

    /**
     * 删除权限资源
     */
    public function actionDeleteResource(){
        if(Yii::app()->request->isAjaxRequest){
            $id = $this->getParam('id');
            $role = $this->loadModel($id, 'Resource');
            $role->delete();
            Util::log('资源删除成功', 'passport', __FILE__, __LINE__);
            echo json_encode(array(
                'success'=>true,
                "reload"=>true,
                'text'=>'资源删除成功'
            ));
            Yii::app()->end();
        }else{
            throw new CHttpException('无效的请求...');
        }
    }

    /**
     * 资源绑定列表
     */
    public function actionResourceBindList(){
        $title = '资源绑定';
        $model = new ResourceRelate();
        $page = $this->getParam('page');
        $criteria = new EMongoCriteria();
        $offset = empty($page) ? 0 : ($page - 1) * Pages::LIMIT;
        $criteria->sort('id', EMongoCriteria::SORT_DESC);
        $criteria->offset($offset)->limit(Pages::LIMIT);
        $list = $model->findAll($criteria);
        $count = $model->count();
        $resources = Util::getResourceArr();
        if(Yii::app()->request->isAjaxRequest){
            echo json_encode(array(
                "dataCount" => $count,
                "dataList" => $list
            ));
        }else{
            $this->render('resource_bind', array('title' => $title, 'list' => $list, 'count' => $count, 'model' => $model, 'resources' => $resources));
        }
    }

    /**
     * 添加资源绑定
     */
    public function actionAddResourceBind(){
        $model = new ResourceRelate();
        $resource_list = array();
        $res = Resource::model()->findAll();
        if (count($res)){
            foreach ($res as $v) {
                $resource_list[$v['id']] = $v['name'];
            }
        }
        if(Yii::app()->request->isPostRequest){
            $param = $this->getParam('ResourceRelate');
            $param['id'] = $this->getAutoIncrementKey('bl_resource_relate');
            $model->attributes = $param;
            if($model->validate()){
                $model->save();
                Util::log('资源绑定添加成功', 'passport', __FILE__, __LINE__);
                echo json_encode(array(
                        "success"=> true,
                        "reload"=>true,
                        "text"=>"资源绑定添加成功"
                    ));
            }else{
                echo json_encode(array(
                        "success"=> false,
                        "text"=>$model['_errors']
                    ));
            }
            Yii::app()->end();
        }
        $this->renderPartial('_add_resource_bind', array(
            'model' => $model,
            'resource_list' => $resource_list,
            'action' => $this->createUrl('/passport/resource/addresourcebind')
        ), false, true);
    }

    /**
     * 修改资源绑定
     */
    public function actionUpdateResourceBind(){
        if(Yii::app()->request->isPostRequest){
            $param = $this->getParam('ResourceRelate');
            $model = $this->loadModel($param['id'], 'ResourceRelate');
            $model->attributes = $param;
            if($model->validate()){
                $model->save();
                Util::log('资源绑定更新成功', 'passport', __FILE__, __LINE__);
                echo json_encode(array(
                        "success"=> true,
                        "reload"=>true,
                        "text"=>"资源绑定更新成功"
                    ));
            }else{
                echo json_encode(array(
                        "success"=> false,
                        "text"=>$model['_errors']
                    ));
            }
            Yii::app()->end();
        }else{
            $resource_list = array();
            $res = Resource::model()->findAll();
            if (count($res)){
                foreach ($res as $v) {
                    $resource_list[$v['id']] = $v['name'];
                }
            }
            $id = $this->getParam('id');
            $model = $this->loadModel($id , 'ResourceRelate');
        }
        $this->renderPartial('_add_resource_bind', array(
            'model' => $model,
            'resource_list' => $resource_list,
            'action' => $this->createUrl('/passport/resource/updateresourcebind/id/'.$id)
        ), false, true);
    }

    /**
     * 删除资源绑定
     */
    public function actionDeleteResourceBind(){
        if(Yii::app()->request->isAjaxRequest){
            $id = $this->getParam('id');
            $role = $this->loadModel($id, 'ResourceRelate');
            $role->delete();
            Util::log('资源绑定删除成功', 'passport', __FILE__, __LINE__);
            echo json_encode(array(
                'success'=>true,
                "reload"=>true,
                'text'=>'资源绑定删除成功'
            ));
            Yii::app()->end();
        }else{
            throw new CHttpException('无效的请求...');
        }
    }
}