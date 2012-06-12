<?php

class DefaultController extends Controller
{
    
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
        $title = 'GM管理';
        if(Yii::app()->request->isAjaxRequest){
            $param = $this->getParam(array('ip', 'port', 'role_id', 'seconds'));
            $socket = new SocketHelper($param['ip'], $param['port']);
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
            $par_res = $socket->parseNoHeaderResonsePack($res);
            $socket->returnJson($par_res, '禁止玩家登陆');
            sleep(1);
            //关闭socket链接
            $socket->close();
            Yii::app()->end();
        }
        $this->render('forbid_login', array('title' => $title));
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
        $title = 'GM管理';
        if(Yii::app()->request->isAjaxRequest){
            $param = $this->getParam(array('ip', 'port', 'role_id', 'seconds'));
            $socket = new SocketHelper($param['ip'], $param['port']);
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
            $par_res = $socket->parseNoHeaderResonsePack($res);
            $socket->returnJson($par_res, '禁止玩家聊天');
            sleep(1);
            //关闭socket链接
            $socket->close();
            Yii::app()->end();
        }
        $this->render('forbid_chat', array('title' => $title));
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
        $title = 'GM管理';
        if(Yii::app()->request->isAjaxRequest){
            $param = $this->getParam(array('ip', 'port', 'role_id'));
            $socket = new SocketHelper($param['ip'], $param['port']);
            //包头处理
            $cmd = $socket->getLogicPackHeader(0x0A032005, 37);
            //包体处理
            $cmd .= pack('a33', Yii::app()->params['socket_password']); //Password
            $cmd .= pack('L',$param['role_id']); //roleId
            //发送数据
            $socket->send($cmd);
            //服务端返回数据
            $res = $socket->recv();
            $par_res = $socket->parseNoHeaderResonsePack($res);
            $socket->returnJson($par_res, '允许玩家登陆');
            sleep(1);
            //关闭socket链接
            $socket->close();
            Yii::app()->end();
        }
        $this->render('permit_login', array('title' => $title));
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
        $title = 'GM管理';
        if(Yii::app()->request->isAjaxRequest){
            $param = $this->getParam(array('ip', 'port', 'role_id'));
            $socket = new SocketHelper($param['ip'], $param['port']);
            //包头处理
            $cmd = $socket->getLogicPackHeader(0x0A032007, 37);
            //包体处理
            $cmd .= pack('a33', Yii::app()->params['socket_password']); //Password
            $cmd .= pack('L',$param['role_id']); //roleId
            //发送数据
            $socket->send($cmd);
            //服务端返回数据
            $res = $socket->recv();
            $par_res = $socket->parseNoHeaderResonsePack($res);
            $socket->returnJson($par_res, '允许玩家聊天');
            sleep(1);
            //关闭socket链接
            $socket->close();
            Yii::app()->end();
        }
        $this->render('permit_chat', array('title' => $title));
    }
    
    /**
     * GM 发送奖励给玩家
     * 
     * 包头: 
     * int nSock 默认填0
     * int nUserId 默认填0
     * int nType 协议id
     * int nLength 包体的长度  33 + 4 + 25 + 物品结构体长度标识2字节 + 物品结构体长度 + 角色结构体长度标识2字节 + 角色结构体长度
     * int nSerialNo 默认填0
     * int nVersion  默认填1
     * 
     * 包体:
     * Password定长33个字节(默认填boluo123)
     * awardName定长25个字节  礼包名称
     * time 4字节  秒数
     * itemStruct  物品结构体（物品id，物品数量）
     * roleList  角色列表  roleId=0 表示全服奖励
     * 
     * request url : http://xxx/service/default/sendaward?award_name=xxx&time=111&item_id=222&num=11&role_id=999
     */
    public function actionSendAward()
    {
        $title = 'GM管理';
        if(Yii::app()->request->isAjaxRequest){
            $param = $this->getParam(array('ip', 'port', 'role_id', 'award_name', 'time', 'item_id', 'num'));
            $socket = new SocketHelper($param['ip'], $param['port']);
            //包头处理
            $cmd = $socket->getLogicPackHeader(0x0A032023, 78);
            //包体处理
            $cmd .= pack('a33', Yii::app()->params['socket_password']); //Password
            $cmd .= pack('a25',$param['award_name']); //awardName
            $cmd .= pack('L',$param['time']); //time
            $cmd .= pack('S',1); //数量设置 2字节 16bit 用S
            $cmd .= pack('L',$param['item_id']); //itemStruct
            $cmd .= pack('L',$param['num']); //itemStruct
            $cmd .= pack('S',1); //数量设置 2字节 16bit 用S
            $cmd .= pack('L',$param['role_id']); //roleList
            //发送数据
            $socket->send($cmd);
            //服务端返回数据
            $res = $socket->recv();
            $par_res = $socket->parseNoHeaderResonsePack($res);
            $socket->returnJson($par_res, '发送礼包');
            sleep(1);
            //关闭socket链接
            $socket->close();
            Yii::app()->end();
        }
        $this->render('send_award', array('title' => $title));
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
        $title = 'GM管理';
        if(Yii::app()->request->isAjaxRequest){
            $param = $this->getParam(array('ip', 'port'));
            $socket = new SocketHelper($param['ip'], $param['port']);
            //包头处理
            $cmd = $socket->getLogicPackHeader(0x0A032027, 33);
            //包体处理
            $cmd .= pack('a33', Yii::app()->params['socket_password']); //Password
            //发送数据
            $socket->send($cmd);
            //服务端返回数据
            $res = $socket->recv();
            $par_res = $socket->parseNoHeaderResonsePack($res);
            $socket->returnJson($par_res, '关闭服务器');
            sleep(1);
            //关闭socket链接
            $socket->close();
            Yii::app()->end();
        }
        $this->render('close_server', array('title' => $title));
    }
    
   /**
     * 请求登录
     * 
     * 包头: 
     * int nSock 默认填0
     * int nUserId 默认填0
     * int nType 协议id
     * int nLength 包体的长度 33
     * int nSerialNo 默认填0
     * int nVersion  默认填1
     * 包体:
     * serverGroupId 服务器组ID 定长4个字节 
     * userAccount 角色账户名  动长
     * sessionId 与web服务器交互验证ID 动长 最长33字节
     * parameter 可变参数 动长
     * @todo
     */
    public function actionRequestLogin()
    {
        $server_group_id = 9;
        $socket = new SocketHelper(Yii::app()->params['socket_gateway_ip'], Yii::app()->params['socket_gateway_port']);
        //定义socket响应状态码
        $key_result_code = 100000;
        $key_role_id = 431001;
        $key_has_role = 100001;
        //$key_role_name = 431002;
        //包头处理
        $cmd = $socket->getGateWayPackHeader(0x0A020001, 18);
        //包体处理
        $cmd .= pack('L',$server_group_id); //serverGroupId
        $cmd .= pack('S',4); //数量设置 2字节 16bit 用S
        $cmd .= pack('a*','ffff'); //userAccount
        $cmd .= pack('S',4); //数量设置 2字节 16bit 用S
        $cmd .= pack('a*','ffff'); //sessionId
        $cmd .= pack('S',0); //数量设置 2字节 16bit 用S
        $cmd .= pack('a*',''); //parameter
        //发送数据
        $socket->send($cmd);
        //服务端返回数据
        $res_login = $socket->recv(); 
        $par_res_login = $socket->parseResponsePack($res_login);
        //是否正常登录
        if($par_res_login[$key_result_code] == 0){
            Yii::log('socket login success ...');
            $role_id = $par_res_login[$key_role_id];
            //如果没有角色 创建角色
            if($par_res_login[$key_has_role] != 1){
                $res_role = $this->createRole($socket, $server_group_id, $role_id);
                $par_res_role = $socket->parseResponsePack($res_role);
                if($par_res_role[$key_result_code] == 0){
                    Yii::log('socket create role success ...');
                }else if($par_res_role[$key_result_code] == 481004){
                    throw new CException('socket create role error, role name exist ...');
                }else{
                    throw new CException('socket create role error ...');
                }
            }
            //进入场景
            $res_scene = $this->enterScene($socket, $server_group_id, $role_id);
            $par_res_scene = $socket->parseResponsePack($res_scene, '04010c02');
            //是否正常进入场景
            if($par_res_scene[$key_result_code] != 0){
                throw new CException('socket enter scene error ...');
            }else{
                Yii::log('socket enter scene success ...');
            }
        }else{
            throw new CException('socket login error ...');
        }
        sleep(1);
        //关闭socket链接
        $socket->close();
    }
    
    /**
     * 请求创建角色
     * 
     * 包头: 
     * int nSock 默认填0
     * int nUserId 默认填0
     * int nType 协议id
     * int nLength 包体的长度 33
     * int nSerialNo 默认填0
     * int nVersion  默认填1
     * 包体:
     * serverGroupId 服务器组ID 定长4个字节 
     * roleId 角色ID 定长4个字节 
     * roleTypeId 人物ID 定长4个字节 
     * roleName 角色名字 定长19个字节 
     */
    protected function createRole($socket, $server_group_id, $role_id)
    {
        //包头处理
        $cmd = $socket->getGateWayPackHeader(0x0A030003, 31);
        //包体处理
        $cmd .= pack('L',$server_group_id); //serverGroupId
        $cmd .= pack('L',$role_id); //roleId
        $cmd .= pack('L',431603); //roleTypeId
        $name = rand(1000, 9999) . date('YmdHis');
        $cmd .= pack('a19',$name); //roleName
        //发送数据
        $socket->send($cmd);
        //服务端返回数据
        return $socket->recv();
    }
    
   /**
     * 请求进入场景
     * 
     * 包头: 
     * int nSock 默认填0
     * int nUserId 默认填0
     * int nType 协议id
     * int nLength 包体的长度 33
     * int nSerialNo 默认填0
     * int nVersion  默认填1
     * 包体:
     * serverGroupId 服务器组ID 定长4个字节 
     * roleId 角色ID 定长4个字节 
     * sceneId 场景ID 定长4个字节 
     * crossingId 传送点ID 定长4个字节 
     */
    protected function enterScene($socket, $server_group_id, $role_id)
    {
        //包头处理
        $cmd = $socket->getGateWayPackHeader(0x0A030C01, 16);
        //包体处理
        $cmd .= pack('L',$server_group_id); //serverGroupId
        $cmd .= pack('L',$role_id); //roleId
        $cmd .= pack('L',441101); //sceneId
        $cmd .= pack('L',0); //crossingId
        //发送数据
        $socket->send($cmd);
        //服务端返回数据
        return $socket->recv();
    }
    
    /**
     * GM 发送在线公告
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
     * intervalTime  4字节(间隔时间)
     * playTimes 4字节 (播放次数)
     * content 动长
     * 
     * request url : http://xxx/service/default/onlinenotice?role_id=999
     */
    public function actionOnlineNotice()
    {
        $title = 'GM管理';
        if(Yii::app()->request->isAjaxRequest){
            $param = $this->getParam(array('ip', 'port', 'interval_time', 'playtimes', 'notice_content'));
            $socket = new SocketHelper($param['ip'], $param['port']);
            //包头处理
            $con_length = strlen($param['notice_content']);
            $length = $con_length + 43;
            $cmd = $socket->getLogicPackHeader(0x0A032011, $length);
            //包体处理
            $cmd .= pack('a33', Yii::app()->params['socket_password']); //Password
            $cmd .= pack('L',$param['interval_time']); //intervalTime
            $cmd .= pack('L',$param['playtimes']); //playTimes
            $cmd .= pack('S',$con_length); //数量设置 2字节 16bit 用S
            $cmd .= pack('a*',$param['notice_content']); //content
            //发送数据
            $socket->send($cmd);
            //服务端返回数据
            $res = $socket->recv();
            $par_res = $socket->parseNoHeaderResonsePack($res);
            $socket->returnJson($par_res, '发送在线公告');
            sleep(1);
            //关闭socket链接
            $socket->close();
            Yii::app()->end();
        }
        $this->render('online_notice', array('title' => $title));
    }
    
}