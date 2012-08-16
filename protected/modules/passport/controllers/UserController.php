<?php

class UserController extends Controller
{

    /**
     * 用户管理
     */
    public function actionUserList()
    {
        $title = '用户管理';
        $model = new User();
        $criteria = new EMongoCriteria();
        $page = $this->getParam('page');
        $offset = empty($page) ? 0 : ($page - 1) * Pages::LIMIT;
        $criteria->offset($offset)->limit(Pages::LIMIT);
        $list = $model->findAll($criteria);
        $count = $model->count();
        $roles = Util::getRoleArr();
        if(Yii::app()->request->isAjaxRequest){
            echo json_encode(array(
                "dataCount" => $count,
                "dataList" => $list
            ));
        }else{
            $this->render('index', array('title' => $title, 'list' => $list,'count' => $count, 'model' => $model, 'roles' => $roles));
        }
    }

    /**
     * 添加用户
     */
    public function actionAddUser(){
        $model = new User();
        $role_list = array();
        $res = Role::model()->findAll();
        if (count($res)){
            foreach ($res as $v) {
                $role_list[$v['id']] = $v['name'];
            }
        }
        if(Yii::app()->request->isPostRequest){
            $param = $this->getParam('User');
            $model->attributes = $param;
            $model->id = $this->getAutoIncrementKey('bl_user');
            $model->create_time = time();
            if ($model->validate()) {
                $model->password = md5($param['password']);
                $model->save();
                Util::log('用户添加成功', 'passport', __FILE__, __LINE__);
                echo json_encode(array(
                        "success"=> true,
                        "reload"=>true,
                        "text"=>"用户添加成功"
                ));
            }else{
                echo json_encode(array(
                        "success"=> false,
                        "text"=>$model['_errors']
                ));
            }
            Yii::app()->end();
        }
        $this->renderPartial('_add_user', array(
        	'model' => $model,
        	'role_list' => $role_list,
        	'action' => $this->createUrl('/passport/user/adduser')
        ), false, true);
    }

    /**
     * 更新用户
     */
    public function actionUpdateUser(){
        $role_list = array();
        $res = Role::model()->findAll();
        if (count($res)){
            foreach ($res as $v) {
                $role_list[$v['id']] = $v['name'];
            }
        }
        if(Yii::app()->request->isPostRequest){
            $param = $this->getParam('User');
            $model = $this->loadModel($param['id'], 'User');
            $param['password'] = empty($param['password']) ? $param['password'] : md5($param['password']);
            $model->attributes = $param;
            if($model->validate()){
                $model->save();
                Util::log('用户更新成功', 'passport', __FILE__, __LINE__);
                echo json_encode(array(
                        "success"=> true,
                        "reload"=>true,
                        "text"=>"用户更新成功"
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
            $model = $this->loadModel($id , 'User');
        }
        $this->renderPartial('_add_user', array(
            'model' => $model,
            'role_list' => $role_list,
            'action' => $this->createUrl('/passport/user/updateuser/id/'.$id)
        ), false, true);
    }

    /**
     * 删除用户
     */
    public function actionDeleteUser(){
        if(Yii::app()->request->isAjaxRequest){
            $id = $this->getParam('id');
            if(Account::isAdmin($id)){
                echo json_encode(array('success' => false, 'text' => '超级管理员不可以删除'));
            }else{
                $user = $this->loadModel($id, 'User');
                $user->delete();
                Util::log('用户删除成功', 'passport', __FILE__, __LINE__);
                echo json_encode(array(
                    'success' => true,
                    "reload"=>true,
                    'text' => '用户删除成功'
                ));
            }
            Yii::app()->end();
        }else{
            throw new CHttpException('无效的请求...');
        }
    }


}