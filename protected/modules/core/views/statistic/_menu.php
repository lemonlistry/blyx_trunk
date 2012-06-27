<?php
    $menu = array(
                array('label' => '日注册、登录数', 'url' => array('/core/statistic/index'), 'active'=>($this->action->id == 'index' ? true : false)),
                array('label' => '日留存率', 'url' => array('/core/statistic/dayactiveuser'), 'active'=>($this->action->id == 'dayactiveuser' ? true : false)),
                );
    $this->widget('zii.widgets.CBreadcrumbs', array('links' => array(
            '运营管理',
            $title,
            )));
?>