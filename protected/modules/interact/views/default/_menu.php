<?php
    $menu = array(
                array('label' => '禁止玩家登录', 'url' => array('/interact/default/forbidlogin')),
                array('label' => '禁止玩家聊天', 'url' => array('/interact/default/forbidchat')),
                array('label' => '允许玩家登录', 'url' => array('/interact/default/permitlogin')),
                array('label' => '允许玩家聊天', 'url' => array('/interact/default/permitchat')),
                array('label' => '发送礼包', 'url' => array('/interact/default/sendaward')),
                array('label' => '关闭服务器', 'url' => array('/interact/default/closeserver')),
                array('label' => '发送在线公告', 'url' => array('/interact/default/onlinenotice')),
                );
    $this->widget('zii.widgets.CBreadcrumbs', array('links' => array(
            'GM管理',
            $title,
            )));
?>