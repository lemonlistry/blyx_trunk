<?php

class DefaultController extends Controller
{
    /**
     * 生成验证码
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=>0xFFFFFF,  //背景颜色
                //'minLength'=>4,  //最短为4位
                //'maxLength'=>4,   //是长为4位
                'transparent'=>true,  //显示为透明，当关闭该选项，才显示背景颜色
            ),
        );
    }

    /**
     * GM 禁止玩家登录
     *
     * 包头:
     * int nSock 默认填0
     * int nUserId 默认填0
     * int nType 协议id
     * int nLength 包体的长度41 = 33 + 4 + 4
     * int nSerialNo 默认填0
     * int nVersion  默认填1
     *
     * 包体:
     * Password定长33个字节(默认填boluo123)
     * roleId  4字节(要封号的目标角色id)
     * seconds 4字节 (封号时长，秒数)
     *
     * request url : http://xxx/service/default/forbidlogin?seconds=1111&role_id=999
     */
    public function actionForbidLogin()
    {
        if(Yii::app()->request->isAjaxRequest){
            $param = $this->getParam(array('server_id', 'role_id', 'seconds'));
            $server = Server::model()->findByAttributes(array('server_id' => $param['server_id']));
            $socket = new SocketHelper($server->web_ip, $server->web_socket_port);
            //包头处理
            $cmd = $socket->getLogicPackHeader(0x0A032001, 41);
            //包体处理
            $cmd .= pack('a33', Yii::app()->params['socket_password']); //Password
            $cmd .= pack('L',$param['role_id']); //roleId
            $cmd .= pack('L',$param['seconds']); //seconds
            //发送数据
            $socket->send($cmd);
            //服务端返回数据
            $res = $socket->recv();
            $par_res = $socket->parseNoHeaderResponsePack($res);
            $response = $socket->parseSocketResponseMsg($par_res, 'socket请求: 禁止玩家登录');
            sleep(1);
            //关闭socket链接
            $socket->close();
            if($response['success']){
                $this->insertGmActionRecord(4);
            }
            echo json_encode($response);
            Yii::app()->end();
        }else{
            throw new CHttpException('无效的请求...');
        }
    }

    /**
     * GM 禁止玩家聊天
     *
     * 包头:
     * int nSock 默认填0
     * int nUserId 默认填0
     * int nType 协议id
     * int nLength 包体的长度41 = 33 + 4 + 4
     * int nSerialNo 默认填0
     * int nVersion  默认填1
     *
     * 包体:
     * Password定长33个字节(默认填boluo123)
     * roleId  4字节(要封号的目标角色id)
     * seconds 4字节 (封号时长，秒数)
     *
     * request url : http://xxx/service/default/forbidchat?seconds=1111&role_id=999
     */
    public function actionForbidChat()
    {
        if(Yii::app()->request->isAjaxRequest){
            $param = $this->getParam(array('server_id', 'role_id', 'seconds'));
            $server = Server::model()->findByAttributes(array('server_id' => $param['server_id']));
            $socket = new SocketHelper($server->web_ip, $server->web_socket_port);
            //包头处理
            $cmd = $socket->getLogicPackHeader(0x0A032003, 41);
            //包体处理
            $cmd .= pack('a33', Yii::app()->params['socket_password']); //Password
            $cmd .= pack('L',$param['role_id']); //roleId
            $cmd .= pack('L',$param['seconds']); //seconds
            //发送数据
            $socket->send($cmd);
            //服务端返回数据
            $res = $socket->recv();
            $par_res = $socket->parseNoHeaderResponsePack($res);
            $response = $socket->parseSocketResponseMsg($par_res, 'socket请求: 禁止玩家聊天');
            sleep(1);
            //关闭socket链接
            $socket->close();
            if($response['success']){
                $this->insertGmActionRecord(2);
            }
            echo json_encode($response);
            Yii::app()->end();
        }else{
            throw new CHttpException('无效的请求...');
        }
    }

    /**
     * GM 允许玩家登录
     *
     * 包头:
     * int nSock 默认填0
     * int nUserId 默认填0
     * int nType 协议id
     * int nLength 包体的长度37 = 33 + 4
     * int nSerialNo 默认填0
     * int nVersion  默认填1
     *
     * 包体:
     * Password定长33个字节(默认填boluo123)
     * roleId  4字节(要封号的目标角色id)
     *
     * request url : http://xxx/service/default/permitlogin?role_id=999
     */
    public function actionPermitLogin()
    {
        if(Yii::app()->request->isAjaxRequest){
            $param = $this->getParam(array('server_id', 'role_id'));
            $server = Server::model()->findByAttributes(array('server_id' => $param['server_id']));
            $socket = new SocketHelper($server->web_ip, $server->web_socket_port);
            //包头处理
            $cmd = $socket->getLogicPackHeader(0x0A032005, 37);
            //包体处理
            $cmd .= pack('a33', Yii::app()->params['socket_password']); //Password
            $cmd .= pack('L',$param['role_id']); //roleId
            //发送数据
            $socket->send($cmd);
            //服务端返回数据
            $res = $socket->recv();
            $par_res = $socket->parseNoHeaderResponsePack($res);
            $response = $socket->parseSocketResponseMsg($par_res, 'socket请求: 允许玩家登录');
            sleep(1);
            //关闭socket链接
            $socket->close();
            if($response['success']){
                $this->insertGmActionRecord(3);
            }
            echo json_encode($response);
            Yii::app()->end();
        }else{
            throw new CHttpException('无效的请求...');
        }
    }

    /**
     * GM 允许玩家聊天
     *
     * 包头:
     * int nSock 默认填0
     * int nUserId 默认填0
     * int nType 协议id
     * int nLength 包体的长度41 = 33 + 4
     * int nSerialNo 默认填0
     * int nVersion  默认填1
     *
     * 包体:
     * Password定长33个字节(默认填boluo123)
     * roleId  4字节(要封号的目标角色id)
     * seconds 4字节 (封号时长，秒数)
     *
     * request url : http://xxx/service/default/permitlogin?role_id=999
     */
    public function actionPermitChat()
    {
        if(Yii::app()->request->isAjaxRequest){
            $param = $this->getParam(array('server_id', 'role_id'));
            $server = Server::model()->findByAttributes(array('server_id' => $param['server_id']));
            $socket = new SocketHelper($server->web_ip, $server->web_socket_port);
            //包头处理
            $cmd = $socket->getLogicPackHeader(0x0A032007, 37);
            //包体处理
            $cmd .= pack('a33', Yii::app()->params['socket_password']); //Password
            $cmd .= pack('L',$param['role_id']); //roleId
            //发送数据
            $socket->send($cmd);
            //服务端返回数据
            $res = $socket->recv();
            $par_res = $socket->parseNoHeaderResponsePack($res);
            $response = $socket->parseSocketResponseMsg($par_res, 'socket请求: 允许玩家聊天');
            sleep(1);
            //关闭socket链接
            $socket->close();
            if($response['success']){
                $this->insertGmActionRecord(1);
            }
            echo json_encode($response);
            Yii::app()->end();
        }else{
            throw new CHttpException('无效的请求...');
        }
    }

    /**
     * 请求关闭服务器
     *
     * 包头:
     * int nSock 默认填0
     * int nUserId 默认填0
     * int nType 协议id
     * int nLength 包体的长度 33
     * int nSerialNo 默认填0
     * int nVersion  默认填1
     * 包体:
     * Password定长33个字节(默认填boluo123)
     *
     * request url : http://xxx/service/default/closeserver
     */
    public function actionCloseServer()
    {
        if(Yii::app()->request->isAjaxRequest){
            $code = $this->createAction('captcha')->getVerifyCode();
            $param = $this->getParam(array('server_id', 'code'));
            if($code != $param['code']){
                echo json_encode(array('success' => false, 'text' => '请输入正确的验证码'));
            }else{
                $server = Server::model()->findByAttributes(array('id' => $param['server_id']));
                $socket = new SocketHelper($server->web_ip, $server->web_socket_port);
                //包头处理
                $cmd = $socket->getLogicPackHeader(0x0A032027, 33);
                //包体处理
                $cmd .= pack('a33', Yii::app()->params['socket_password']); //Password
                //发送数据
                $socket->send($cmd);
                //服务端返回数据
                $res = $socket->recv();
                $par_res = $socket->parseNoHeaderResponsePack($res);
                $response = $socket->parseSocketResponseMsg($par_res, 'socket请求: 关闭服务器');
                sleep(1);
                //关闭socket链接
                $socket->close();
                echo json_encode($response);
            }
            Yii::app()->end();
        }
        $select = Util::getServerSelect(false);
        $server_id = $this->getParam('id');
        $this->renderPartial('close_server', array('server_id' => $server_id, 'select' => $select, 'url' => Yii::app()->request->baseUrl), false, true);
    }

    /**
     * 查看GM的禁言 封号 解禁言 解封号
     * 允许聊天 1 禁止聊天 2  允许登陆 3 禁止登陆4
     */
    public function actionShowGmActionRecord()
    {
        $model = new GmActionRecord();
        $param = $this->getParam(array('begin_time', 'end_time', 'search_name', 'search_type', 'type', 'page'));
        $criteria = new EMongoCriteria();
        if(!empty($param['search_name'])){
            if(1 == $param['search_type']){
                $criteria->addCond('user_account', '==', $param['search_name']);
            }else{
                $criteria->addCond('role_name', '==', $param['search_name']);
            }
        }
        if(!empty($param['begin_time'])){
            $criteria->addCond('begin_time', '>=', $param['begin_time']);
        }
        if(!empty($param['end_time'])){
            $criteria->addCond('begin_time', '<', date('Y-m-d', strtotime($param['end_time']) + 86400));
        }
        if(!empty($param['type'])){
            $type_list = explode(',', $param['type']);
            $criteria->addCond('type', 'in', array(intval($type_list[0]), intval($type_list[1])));
        }
        $criteria->sort('id', EMongoCriteria::SORT_DESC);
        $count = $model->count($criteria);
        $offset = empty($param['page']) ? 0 : ($param['page']-1) * Pages::LIMIT;
        $criteria->offset($offset)->limit(Pages::LIMIT);
        $list = $model->findAll($criteria);
        $select = Util::getRealServerSelect();
        if(Yii::app()->request->isAjaxRequest){
            echo json_encode(array(
                "dataCount" => $count,
                "dataList" => $list
            ));
        }else{
            $this->render('gm_action_record', array('list' => $list, 'count' => $count,'select' => $select));
        }
    }

    /**
     * GM 操作禁言封号日志记录
     * @param int $type
     */
    protected function insertGmActionRecord($type){
        $param = $this->getParam(array('server_id', 'seconds', 'role_id', 'role_name', 'comment', 'user_account'));
        $param['seconds'] = empty($param['seconds']) ? 0 : $param['seconds'];
        $param['begin_time'] = date('Y-m-d H:i:s', time());
        $param['operator'] = Yii::app()->user->name;
        $param['type'] = $type;
        $param['id'] = $this->getAutoIncrementKey('bl_gm_action_record');
        $model = new GmActionRecord();
        $model->attributes = $param;
        if($model->validate()){
            $model->save();
        }else{
            Util::log('GM操作异常' . print_r($model->getErrors(), true), 'service', __FILE__, __LINE__);
        }
    }

}