<?php

class DefaultController extends CController
{
    public $defaultAction = 'install';
    
    /**
     * 数据结构安装
     */
    public function actionInstall() {
        $configs = include Yii::app()->basePath . '/../protected/config/main.php';
        $modules = $configs['modules'];
        foreach ($modules as $module) {
            if (in_array($module, array('passport', 'core'))) {
                require Yii::app()->getModule($module)->basePath . "/data/1.0/" . ucfirst($module) . "Migrate.php"; 
                $class = $module . 'Migrate';
                $migrate = new $class();
                $migrate->init();
            }
        }
        Yii::app()->request->redirect(Yii::app()->createUrl('passport'));
    }
}