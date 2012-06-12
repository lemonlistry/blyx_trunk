<?php

class ServiceModule extends CWebModule
{
    public function init()
    {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application

        // import the module-level models and components
        $this->setImport(array(
            'service.models.*',
            'service.components.*',
        ));
    }

    public function beforeControllerAction($controller, $action)
    {
        if(parent::beforeControllerAction($controller, $action))
        {
            $controller->navMenu = array(
                array('label' => 'GM管理', 'url' => array('/service/default/forbidlogin'), 'active' => $controller->id == 'default' ? true : false),
                array('label' => '玩家交互管理', 'url' => array('/service/interactive'), 'active' => $controller->id == 'interactive' ? true : false),
            );
            // this method is called before any module controller action is performed
            // you may place customized code here
            return true;
        }
        else
            return false;
    }
}
