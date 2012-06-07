<?php
    $menu = array(
                array('label' => '角色信息查询', 'url' => array('/realtime/default'), 'active'=>($this->action->id == 'index' ? true : false)),
                );
    $this->widget('zii.widgets.CBreadcrumbs', array('links' => array(
            '实时数据',
            $title,
            )));
?>