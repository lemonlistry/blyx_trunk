<?php
    $menu = array(
                array('label' => '禁止玩家登录', 'url' => array('/service/default/forbidlogin')),
                array('label' => '禁止玩家聊天', 'url' => array('/service/default/forbidchat')),
                array('label' => '允许玩家登录', 'url' => array('/service/default/permitlogin')),
                array('label' => '允许玩家聊天', 'url' => array('/service/default/permitchat')),
                array('label' => '发送礼包', 'url' => array('/service/gift/list')),
                array('label' => '关闭服务器', 'url' => array('/service/default/closeserver')),
                array('label' => '在线公告', 'url' => array('/service/notice/list')),
                );
    $this->widget('zii.widgets.CBreadcrumbs', array('links' => array(
            '客服管理',
            $title,
            )));
?>