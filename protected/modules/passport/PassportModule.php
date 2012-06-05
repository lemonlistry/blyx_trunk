<?php

class PassportModule extends WebModule
{
    public $defaultController = 'default';

    public function init()
    {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application

        // import the module-level models and components
        $this->setImport(array(
            'passport.models.*',
            'passport.components.*',
        ));
    }

    public function beforeControllerAction($controller, $action)
    {
        if(parent::beforeControllerAction($controller, $action))
        {
            $controller->navMenu = array(
                array('label' => '角色管理', 'url' => array('/system/default/rolelist')),
                array('label' => '用户管理', 'url' => array('/system/default/userlist')),
                array('label' => '权限管理', 'url' => array('/system/default/authlist')),
            );
            // this method is called before any module controller action is performed
            // you may place customized code here
            return true;
        }
        else
            return false;
    }
}
