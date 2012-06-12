<?php

class DefaultController extends Controller
{
    
    public function actionIndex()
    {     
        $title = '角色信息查询';
        $list = array();
        $param = $this->getParam(array('server_group_id', 'role_name'));
        $server_group_id= $param['server_group_id'];
        $role_name = $param['role_name'];
        Yii::import('passport.models.Server');
        $servers = Server::model()->findAll();
        $select = array();
        if(count($servers)){
            foreach ($servers as $k => $v) {
                $select[$v->id] = $v->sname;
            }
        }
        if(!empty($param['server_group_id']) && !empty($param['role_name'])){
            $model = new UserRoleAR();
            $model->setDbConnection($server_group_id);
            $list = $model->findAll('server_group_id = :server_group_id AND role_name = :role_name', 
                                                    array(':server_group_id' => $param['server_group_id'], ':role_name' => $param['role_name']));
        }
        $this->render('userinfo',array('title' => $title,'list' => $list,'server_group_id' => $server_group_id, 
                                               'role_name' => $role_name, 'select' =>$select));
    }
    
}