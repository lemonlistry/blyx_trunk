<?php

class StatisticController extends Controller
{
    
    /**
     * 日注册、登录数
     */
    public function actionIndex()
    {
        $param = $this->getParam(array('begintime', 'endtime', 'server_id'));
        $title = '日注册、登录数';
        $list = array();
        $select = Util::getServerSelect();
        //if(Yii::app()->request->isAjaxRequest){
            
        //}
        $this->render('index', array('title' => $title, 'list' => $list, 'param' => $param, 'select' => $select));
    }
    
    /**
     * 日留存率
     */
    public function actionDayActiveUser()
    {
        $title = '日留存率';
        $list = array();
        $this->render('day_active_user', array('title' => $title, 'list' => $list));
    }
    
}