<?php
    $menu = array(
                array('label' => '所有角色', 'url' => array('')),
                array('label' => '角色组', 'url' => array('')),
                );
    $this->widget('zii.widgets.CBreadcrumbs', array('links' => array(
            '系统管理',
            $title,
            )));
?>