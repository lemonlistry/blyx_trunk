<?php

class DefaultController extends Controller
{
    public $defaultAction = 'login';

    /**
     * 首页
     */
    public function actionIndex()
    {
        $this->render('index');
    }

    /**
     * 登录页
     */
    public function actionLogin()
    {
        if (isset($_POST['submit'])){
            $model = new User();
            $model->attributes = Yii::app()->request->getParam('user');
            if ($model->validate() && $model->login()) {
                $this->redirect(Yii::app()->createUrl('/passport/default/index'));
            }else{
                echo 'error';
            }
        }

        $this->render('login');
    }

}