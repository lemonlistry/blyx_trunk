<?php

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $title = '关键数据总览';
        $list = array();
        $this->render('index', array('title' => $title, 'list' => $list));
    }
    
}