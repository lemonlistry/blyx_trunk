<?php

class DefaultController extends Controller
{
    
    public function actionIndex()
    {     
        $title = '角色信息查询';
        $list = array();
        $param = $this->getParam(array('server_id' => 0, 'role_name' => 0));
        $server_id = $param['server_id'];
        $role_name = $param['role_name'];
        if(!empty($param['server_id']) && !empty($param['role_name'])){
            $list = UserRole::model()->findAll('server_group_id = :server_group_id AND role_name = :role_name', 
                                            array(':server_group_id' => $param['server_id'], ':role_name' => $param['role_name']));
        }
        $this->render('userlook',array('title' => $title,'list' => $list,'server_id' => $server_id, 'role_name' => $role_name));
    }
    
}