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
            $model = new User('search');
            $model->attributes = Yii::app()->request->getParam('user');
            if ($model->validate() && $model->login()) {
                $this->redirect(Yii::app()->createUrl('/passport/default/main'));
            }else{
                echo 'error';
            }
        }

        $this->render('login');
    }

    /**
     * 退出登录
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    /**
     * 没有权限页面渲染
     */
    public function actionNopermission()
    {
        $this->render('nopermission');
    }

    /**
     * 更新密码
     */
    public function actionUpdatePassword()
    {
        $model = $this->loadModel(Yii::app()->user->getUid(), 'User');
        if(Yii::app()->request->isAjaxRequest){
            $param = $this->getParam(array('old_password', 'new_password', 'confirm_password'));
            if($param['new_password'] != $param['confirm_password']){
                echo json_encode(array(
                    'success'=>false,
                    'text'=>'两次输入密码不一致,请重新输入'
                ));
            }else if(md5($param['old_password']) != Yii::app()->user->getPassword()){
                echo json_encode(array(
                    'success'=>false,
                    'text'=>'原始密码错误,请重新输入'
                ));
            }else{
                $model->password = md5($param['new_password']);
                if($model->validate()){
                    $model->save();
                    Util::log('密码更新成功', 'passport', __FILE__, __LINE__);
                    echo json_encode(array(
                        'success'=>true,
                        'reload' => true,
                        'text'=>'密码更新成功'
                ));
                }
            }
            Yii::app()->end();
        }
        $this->renderPartial('_update_password', array(
        	'model' => $model,
                'action'=> $this->createUrl('/passport/default/updatepassword'),
        ), false, true);
    }

    /**
     * 后台布局页面主页面
     */
    public function actionMain()
    {
    	$this->layout='//layouts/column3';
        $this->render('main');
    }

    /**
     * 后台欢迎页面
     */
    public function actionWelcome()
    {
        $this->renderPartial('welcome');
    }

    /**
     * 后台左边栏json数据过滤
     */
    public function actionTreeJson()
    {
    	$json_str = AppConst::getMenuList();
    	$json = json_decode($json_str);
        $url_list = AuthManager::getPrimeUrlList();
        Yii::app()->cache->set('PRIME_URL_LIST', $url_list, 30);
    	$json = $this->leftMenuFilter($json);
    	$json_result = json_encode( $json );
    	echo $json_result;

    }

    /**
     * 验证菜单权限
     * @return object
     */
	protected function leftMenuFilter( $obj )
	{
        if(Account::isAdmin(Yii::app()->user->getUid())){
            return $obj;
        }else{
            $children = array();
            if(isset($obj->children) && is_array($obj->children)){
                foreach ($obj->children as $key => $value) {
                    if(isset($value->children)){
                        $children[] = $this->leftMenuFilter($value);
                    }else{
                        $url_list = Yii::app()->cache->get('PRIME_URL_LIST');
                        $url = str_replace('/index.php?r=', '', $value->url);
                        if(in_array($url, $url_list)){
                            $children[] = $obj->children[$key];
                        }else{
                            unset($obj->children[$key]);
                        }
                    }
                }
                $obj->children = $children;
            }
            return $obj;
        }
	}



}