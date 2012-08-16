<?php

class RoleController extends Controller
{

    /**
     * 角色管理
     */
    public function actionRoleList()
    {
        $title = '角色管理';
        $model = new Role();
        $criteria = new EMongoCriteria();
        $page = $this->getParam('page');
        $offset = empty($page) ? 0 : ($page - 1) * Pages::LIMIT;
        $criteria->offset($offset)->limit(Pages::LIMIT);
        $list = $model->findAll($criteria);
        $count = $model->count();
        $groups = Util::getRoleGroupArr();
        if(Yii::app()->request->isAjaxRequest){
            echo json_encode(array(
                "dataCount" => $count,
                "dataList" => $list
            ));
        }else{
            $this->render('index', array('title' => $title, 'list' => $list,'count' => $count, 'model' => $model, 'groups' => $groups));
        }
    }

    /**
     * 添加角色
     */
    public function actionAddRole(){
        $model = new Role();
        $group_list = Util::getRoleGroupArr();
        if(Yii::app()->request->isPostRequest){
            $param = $this->getParam('Role');
            $param['id'] = $this->getAutoIncrementKey('bl_role');
            $param['create_time'] = time();
            $model->attributes = $param;
            if ($model->validate()) {
                $model->save();
                Util::log('角色添加成功', 'passport', __FILE__, __LINE__);
                echo json_encode(array(
                        "success"=> true,
                		"reload"=>true,
                        "text"=>"角色添加成功"
                ));
            }else{
                echo json_encode(array(
                        "success"=> false,
                        "text"=>$model['_errors']
                ));
            }
            Yii::app()->end();
        }
        $this->renderPartial('_add_role', array(
        	'model' => $model,
        	'group_list' => $group_list,
        	'action' => $this->createUrl('/passport/role/addrole')
        ), false, true);
    }

    /**
     * 更新角色
     * @param int $role_id
     */
    public function actionUpdateRole(){
        if(Yii::app()->request->isPostRequest){
            $param = $this->getParam('Role');
            $model = $this->loadModel($param['id'], 'Role');
            $model->attributes = $param;
            if($model->validate()){
                $model->save();
                Util::log('角色更新成功', 'passport', __FILE__, __LINE__);
                echo json_encode(array(
                        "success"=> true,
                        "reload"=>true,
                        "text"=>"角色更新成功"
                ));
            }else{
                echo json_encode(array(
                        "success"=> false,
                        "text"=>$model['_errors']
                ));
            }
            Yii::app()->end();
        }else{
            $group_list = array();
            $res = RoleGroup::model()->findAll();
            if (count($res)){
                foreach ($res as $v) {
                    $group_list[$v['id']] = $v['name'];
                }
            }
            $id = $this->getParam('id');
            $model = $this->loadModel($id , 'Role');
            $this->renderPartial('_add_role', array(
        	'model' => $model,
        	'group_list' => $group_list,
        	'action' => $this->createUrl('/passport/role/updaterole/id/'.$id)
            ), false, true);
        }
    }

    /**
     * 删除角色
     */
    public function actionDeleteRole(){
        if(Yii::app()->request->isAjaxRequest){
            $id = $this->getParam('id');
            $role = $this->loadModel($id, 'Role');
            $role->delete();
            Util::log('角色删除成功', 'passport', __FILE__, __LINE__);
            echo json_encode(array(
                'success'=>true,
                "reload"=>true,
                'text'=>'角色删除成功'
            ));
            Yii::app()->end();
        }else{
            throw new CHttpException('无效的请求...');
        }
    }

    /**
     * 角色类型管理
     */
    public function actionRoleGroupList()
    {
        $title = '角色类型管理';
        $model = new RoleGroup();
        $criteria = new EMongoCriteria();
        $page = $this->getParam('page');
        $offset = empty($page) ? 0 : ($page - 1) * Pages::LIMIT;
        $criteria->offset($offset)->limit(Pages::LIMIT);
        $list = $model->findAll($criteria);
        $count = $model->count();
        $groups = Util::getRoleGroupArr();
        if(Yii::app()->request->isAjaxRequest){
            echo json_encode(array(
                "dataCount" => $count,
                "dataList" => $list
            ));
        }else{
            $this->render('role_group', array('title' => $title, 'list' => $list,'count' => $count, 'model' => $model, 'groups' => $groups));
        }
    }

    /**
     * 添加角色类型
     */
    public function actionAddRoleGroup(){
        $model = new RoleGroup();
        if(Yii::app()->request->isPostRequest){
            $param = $this->getParam('RoleGroup');
            $param['id'] = $this->getAutoIncrementKey('bl_role_group');
            $param['create_time'] = time();
            $model = new RoleGroup();
            $model->attributes = $param;
            if ($model->validate()) {
                $model->save();
                Util::log('角色类型添加成功', 'passport', __FILE__, __LINE__);
                echo json_encode(array(
                    'success'=>true,
                    "reload"=>true,
                    'text'=>'角色类型添加成功'
                ));
                Yii::app()->end();
            }
        }
        $this->renderPartial('_add_role_group', array(
        	'model' => $model,
        	'action' => $this->createUrl('/passport/role/addrolegroup')
        ), false, true);
    }

    /**
     * 删除角色类型
     */
    public function actionDeleteRoleGroup(){
        if(Yii::app()->request->isAjaxRequest){
            $id = $this->getParam('id');
            $role = $this->loadModel($id, 'RoleGroup');
            $role->delete();
            Util::log('角色类型删除成功', 'passport', __FILE__, __LINE__);
            echo json_encode(array(
                'success'=>true,
                "reload"=>true,
                'text'=>'角色类型删除成功'
            ));
            Yii::app()->end();
        }else{
            throw new CHttpException('无效的请求...');
        }
    }

    /**
     * 更新角色类型
     * @param int $role_id
     */
    public function actionUpdateRoleGroup(){
        if(Yii::app()->request->isPostRequest){
            $param = $this->getParam('RoleGroup');
            $model = $this->loadModel($param['id'], 'RoleGroup');
            $model->attributes = $param;
            if($model->validate()){
                $model->save();
                Util::log('角色类型更新成功', 'passport', __FILE__, __LINE__);
                echo json_encode(array(
                        "success"=> true,
                        "reload"=>true,
                        "text"=>"角色类型更新成功"
                ));
                Yii::app()->end();
            }
        }else{
            $id = $this->getParam('id');
            $model = $this->loadModel($id , 'RoleGroup');
        }
        $this->renderPartial('_add_role_group', array(
        	'model' => $model,
        	'action' => $this->createUrl('/passport/role/updaterolegroup/id/'.$id)
        ), false, true);
    }

}