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
        $this->layout = false;
        if (isset($_POST['login'])){
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
    
    /**
     * 退出登录
     */
    public function actionLogout(){
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

}