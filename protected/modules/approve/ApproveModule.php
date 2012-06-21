<?php

class ApproveModule extends CWebModule
{
    public function init()
    {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application

        // import the module-level models and components
        $this->setImport(array(
            'approve.models.*',
            'approve.components.*',
            'passport.models.*',
            'service.models.*',
        ));
    }

    public function beforeControllerAction($controller, $action)
    {
        if(parent::beforeControllerAction($controller, $action))
        {
            $controller->navMenu = array(
                array('label' => '所有事务', 'url' => array('/approve/default/index'), 'active' => $action->id == 'index' ? true : false),
                array('label' => '等待审批的事务', 'url' => array('/approve/default/wait'), 'active' => $action->id == 'wait' ? true : false),
                array('label' => '已经审批的事务', 'url' => array('/approve/default/finish'), 'active' => $action->id == 'finish' ? true : false),
                array('label' => '流程管理', 'url' => array('/approve/default/flowlist'), 'active' => $action->id == 'flowlist' ? true : false),
            );
            return true;
        }
        else
            return false;
    }
}
