<?php
    $menu = array(
                array('label' => '所有角色', 'url' => array(''), 'active'=>($this->action->id == 'rolelist' ? true : false)),
                array('label' => '角色类型', 'url' => array(''), 'active'=>($this->action->id == 'rolegrouplist' ? true : false)),
                );
    $this->widget('zii.widgets.CBreadcrumbs', array('links' => array(
            '系统管理',
            $title,
            )));
?>