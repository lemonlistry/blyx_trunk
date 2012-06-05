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
        $this->render('index', array('title' => $title, 'list' => $list));
    }
    
    /**
     * 添加角色
     */
    public function actionAddRole(){
        if(Yii::app()->request->isAjaxRequest){
            $param = $this->getParam(array('name' => 1, 'desc' => 1));
            $role = new Role();
            $role->name = $param['name'];
            $role->desc = $param['desc'];
            $role->id = $this->getAutoIncrementKey('bl_role');
            $role->save(true, array('id', 'name', 'desc'));
            echo json_encode(array('flag' => 1, 'msg' => '添加成功'));
            Yii::app()->end();
        }else{
            throw new CHttpException('http request error ...');
        }
    }
    

}