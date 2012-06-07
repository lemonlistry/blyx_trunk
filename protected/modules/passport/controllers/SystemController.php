<?php

class SystemController extends Controller
{

    /**
     * 角色管理
     */
    public function actionRoleList()
    {
        $title = '角色管理';
        $role = new Role();
        $list = $role->findAll();
        $result = Pages::initArray($list);
        $this->render('index', array('title' => $title, 'list' => $result['list'], 'pages' => $result['pages']));
    }
    
    /**
     * 添加角色
     */
    public function actionAddRole(){
        if(Yii::app()->request->isAjaxRequest){
            $param = $this->getParam(array('Role' => 1));
            $role = new Role();
            $role->create_time = time();
            $role->name = $param['Role']['name'];
            $role->desc = $param['Role']['desc'];
            $role->id = $this->getAutoIncrementKey('bl_role');
            $role->group_id = $param['Role']['group_id']; 
            $role->save();
            echo json_encode(array('flag' => 1, 'msg' => '添加成功'));
            Yii::app()->end();
        }else{
            $model = new Role();
            $group_list = array();
            $res = RoleGroup::model()->findAll();
            if (count($res)){
                foreach ($res as $v) {
                    $group_list[$v['id']] = $v['name'];
                }
            }
            $this->renderPartial('_add_role', array('model' => $model, 'group_list' => $group_list), false, true);
        }
    }
    
    /**
     * 更新角色
     * @param int $role_id
     */
    public function actionUpdateRole(){
        if(Yii::app()->request->isAjaxRequest){
            $param = $this->getParam(array('Role' => 1));
            $role = $this->loadModel($param['Role']['id'], 'Role');
            $role->attributes = $param['Role'];
            $role->save();
            echo json_encode(array('flag' => 1, 'msg' => '删除成功'));
            Yii::app()->end();
        }else{
            $param = $this->getParam(array('id' => 1));
            $model = $this->loadModel($param['id'], 'Role');
            $group_list = array();
            $res = RoleGroup::model()->findAll();
            if (count($res)){
                foreach ($res as $v) {
                    $group_list[$v['id']] = $v['name'];
                }
            }
            $this->renderPartial('_add_role', array('model' => $model, 'group_list' => $group_list), false, true);
        }
    }
    
    /**
     * 删除角色
     */
    public function actionDeleteRole(){
        if(Yii::app()->request->isAjaxRequest){
            $param = $this->getParam(array('id' => 1));
            $role = $this->loadModel($param['id'], 'Role');
            $role->delete();
            echo json_encode(array('flag' => 1, 'msg' => '删除成功'));
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
        $title = '角色管理';
        
    }

}