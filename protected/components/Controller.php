<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout='//layouts/column1';
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu=array();
    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs=array();

    /**
     * 用户登录以及权限验证
     * @return boolean
     */
    protected function beforeAction($action)
    {
        if (Yii::app()->user->isGuest) {
            if(in_array($this->module->id, array('install', 'cron')) || ($this->module->id == 'passport' && $this->id == 'default' && $action->id == 'login')){
                return true;
            } else {
                if (YII_DEBUG) {
                    $this->redirect(array('/passport'));
                } else {
                    throw new CHttpException(403);
                }
            }
        }else{
            Yii::app()->session->add('db_component', 'db');
            $module_arr = array('install', 'cron');
            $action_arr = array('nopermission', 'logout', 'updatepassword', 'main', 'welcome', 'treejson');
            if(in_array($this->module->id, $module_arr) || ($this->module->id == 'passport' && $this->id == 'default' && in_array($action->id, $action_arr))){
                return true;
            }else{
                if(!Account::isAdmin(Yii::app()->user->getUid())){
                    //数据导出权限统一验证
                    if(strpos($action->id, 'export') !== false && AuthManager::verifyExportAuth()){
                        return true;
                    }
                    //其他权限验证
                    $auth = false;
                    $resource_id = AuthManager::getResourceId($this->module->id, $this->id, $action->id);
                    if(!empty($resource_id)){
                        $auth = AuthManager::checkAuth(Yii::app()->user->getUid(), $resource_id);
                    }
                    if(!$auth){
                        if(Yii::app()->request->isAjaxRequest){
                            echo json_encode(array('success' => false, 'text' => '您没有权限操作,请联系管理员'));
                            Yii::app()->end();
                        }else{
                            $this->redirect($this->createUrl('/passport/default/nopermission'));
                        }
                    }
                }
            }
        }
        return true;
    }

    /**
     * 根据给出的主键返回数据模型
     * 如果没有发现模型，将触发一个404错误
     * @param integer $id 模型主键
     * @param string $model_name 模型名称
     * @param stirng $scenario 应用场景
     * @return ActiveModel
     */
    protected function loadModel($id, $model_name, $scenario=null)
     {
        $model = $model_name::model()->findByAttributes(array('id' => intval($id)));
        if($scenario) {
            $model->scenario = $scenario;
        }
        if ($model === null){
            throw new CException('model load error !');
        }else {
            return $model;
        }
    }

    /**
     * 验证参数
     */
    protected function getParam($param)
    {
        if(is_array($param)){
            $res = array();
            foreach ($param as $v) {
                $res[$v] = Yii::app()->request->getParam($v);
                $res[$v] = $this->changeFieldType($v, $res[$v]);
            }
        }else{
            $res = Yii::app()->request->getParam($param);
            if(is_array($res) && count($res)){
                foreach ($res as $k => $v) {
                    $res[$k] = $this->changeFieldType($k, $v);
                }
            }else{
                $res = $this->changeFieldType($param, $res);
            }
        }
        return $res;
    }

    /**
     * 更改字段类型
     * @param string $field
     */
    protected function changeFieldType($key, $field)
    {
        //浮点数验证
        $arr = explode('.', $field);
        if(strpos($field, '.') > 0 && count($arr) == 2){
            $field = floatval($field);
        }
        //整数验证
        if(strpos($key, 'id') !== false || strpos($key, 'status') !== false){
            $field = $field === '' ? '' : intval($field);
        }
        return $field;
    }

    /**
     * 获取自增Key
     */
    public function getAutoIncrementKey($table)
    {
        $model = AutoIncrement::model()->findByAttributes(array('table' => $table));
        return empty($model) ? 1 : ++$model->index;
    }

    /**
     * 设置DB连接 根据PK
     * @param string $dbname
     * @return CDbConnection the database connection used by active record.
     */
    public function setDbConnection($server_id){
        Yii::import('passport.models.Server');
        $server_id = intval($server_id);
        $model = Server::model()->findByAttributes(array('id' => $server_id));
        if(empty($model)){
            throw new CDbException('Active Record load server config error ...');
        }else{
            Yii::app()->session->add('db_component', 'db' . $server_id);
        }
    }

    /**
     * 设置DB连接 根据SERVER_ID
     * @param string $dbname
     * @return CDbConnection the database connection used by active record.
     */
    public function setDbConnectionByServerId($server_id){
        Yii::import('passport.models.Server');
        $server_id = intval($server_id);
        $model = Server::model()->findByAttributes(array('server_id' => $server_id));
        if(empty($model)){
            throw new CDbException('Active Record load server config error , server_id is ' . $server_id);
        }else{
            Yii::app()->session->add('db_component', 'db' . $model->id);
        }
    }

}