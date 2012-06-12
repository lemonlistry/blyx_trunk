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
    
    public $navMenu = array();
    
    /**
     * 用户登录验证
     * @return boolean
     */
    protected function beforeAction($action) {
        if (Yii::app()->user->isGuest) {
            if (isset($this->module->id) && $this->module->id == 'passport' && $this->id == 'default' && $action->id == 'login') {
                return true;
            } else {
                if (YII_DEBUG) {
                    $this->redirect(array('/passport'));
                } else {
                    throw new CHttpException(403);
                }
            }
        }
        $this->menu = $this->getMenu();
        return true;
    }
    
    /**
     * 菜单处理
     */
    protected function getMenu(){
        return array(
                        '/passport/role/rolelist' => '系统管理',
                        '/log/default/loglist' => '日志管理',
                        '/service/default/forbidlogin' => '客服管理',
                        '/realtime/default' => '实时数据',
                    );
    }
    
    /**
     * 根据给出的主键返回数据模型
     * 如果没有发现模型，将触发一个404错误
     * @param integer $id 模型主键
     * @param string $model_name 模型名称
     * @param stirng $scenario 应用场景
     * @return ActiveModel
     */
    protected function loadModel($id, $model_name, $scenario=null) {
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
    protected function getParam($param){
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
    protected function changeFieldType($key, $field){
        //浮点数验证
        $arr = explode('.', $field);
        if(strpos($field, '.') > 0 && count($arr) == 2){
            $field = floatval($field);
        }
        //整数验证
        if(strpos($key, 'id') !== false){
            $field = intval($field);
        }
        return $field;
    }
    
    /**
     * 获取自增Key
     */
    public function getAutoIncrementKey($table){
        $model = AutoIncrement::model()->findByAttributes(array('table' => $table));
        return empty($model) ? 1 : ++$model->index;
    }
}