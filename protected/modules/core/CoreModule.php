<?php

class CoreModule extends WebModule
{
    public function init()
    {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application

        // import the module-level models and components
        $this->setImport(array(
            'core.models.*',
            'core.components.*',
        ));
    }

    public function beforeControllerAction($controller, $action)
    {
        if(parent::beforeControllerAction($controller, $action))
        {
            $controller->navMenu = array(
                array('label' => '日常管理', 'url' => array('/core/default/index'), 'active' => $controller->id == 'default' ? true : false),
                array('label' => '统计分析', 'url' => array('/core/statistic/index'), 'active' => $controller->id == 'statistic' ? true : false),
            );
            return true;
        }
        else
            return false;
    }
}
