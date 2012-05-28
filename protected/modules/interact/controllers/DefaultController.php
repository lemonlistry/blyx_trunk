<?php

class DefaultController extends Controller
{
    public function actionIndex(){
        $this->actionRequestLogin();
        $this->actionForbidLogin();
        $this->actionForbidChat();
        $this->actionPermitLogin();
        $this->actionPermitChat();
        $this->actionSendAward();
        //$this->actionCloseServer();
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
     */
    public function actionForbidLogin(){
        $socket = new SocketHelper(Yii::app()->params['socket_logic_ip'], Yii::app()->params['socket_logic_port']);
        //包头处理
        $cmd = $socket->getLogicPackHeader(0x01032001, 41);
        //包体处理
        $cmd .= pack('a33', Yii::app()->params['socket_password']); //Password
        $cmd .= pack('L',1111); //roleId
        $cmd .= pack('L',1111); //seconds
        //发送数据
        $socket->send($cmd);
        //服务端返回数据
        $res = $socket->recv();
        sleep(1);
        //关闭socket链接
        $socket->close();
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
     */
    public function actionForbidChat(){
        $socket = new SocketHelper(Yii::app()->params['socket_logic_ip'], Yii::app()->params['socket_logic_port']);
        //包头处理
        $cmd = $socket->getLogicPackHeader(0x01032003, 41);
        //包体处理
        $cmd .= pack('a33', Yii::app()->params['socket_password']); //Password
        $cmd .= pack('L',2222); //roleId
        $cmd .= pack('L',2222); //seconds
        //发送数据
        $socket->send($cmd);
        //服务端返回数据
        $res = $socket->recv();
        sleep(1);
        //关闭socket链接
        $socket->close();
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
     */
    public function actionPermitLogin(){
        $socket = new SocketHelper(Yii::app()->params['socket_logic_ip'], Yii::app()->params['socket_logic_port']);
        //包头处理
        $cmd = $socket->getLogicPackHeader(0x01032005, 37);
        //包体处理
        $cmd .= pack('a33', Yii::app()->params['socket_password']); //Password
        $cmd .= pack('L',3333); //roleId
        //发送数据
        $socket->send($cmd);
        //服务端返回数据
        $res = $socket->recv();
        sleep(1);
        //关闭socket链接
        $socket->close();
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
     */
    public function actionPermitChat(){
        $socket = new SocketHelper(Yii::app()->params['socket_logic_ip'], Yii::app()->params['socket_logic_port']);
        //包头处理
        $cmd = $socket->getLogicPackHeader(0x01032007, 37);
        //包体处理
        $cmd .= pack('a33', Yii::app()->params['socket_password']); //Password
        $cmd .= pack('L',4444); //roleId
        //发送数据
        $socket->send($cmd);
        //服务端返回数据
        $res = $socket->recv();
        sleep(1);
        //关闭socket链接
        $socket->close();
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
     * roleList  角色列表
     */
    public function actionSendAward(){
        $socket = new SocketHelper(Yii::app()->params['socket_logic_ip'], Yii::app()->params['socket_logic_port']);
        //包头处理
        $cmd = $socket->getLogicPackHeader(0x01032023, 78);
        //包体处理
        $cmd .= pack('a33', Yii::app()->params['socket_password']); //Password
        $cmd .= pack('a25',5555); //awardName
        $cmd .= pack('L',5555); //time
        $cmd .= pack('S',1); //数量设置 2字节 16bit 用S
        $cmd .= pack('L','66'); //itemStruct
        $cmd .= pack('L','77'); //itemStruct
        $cmd .= pack('S',1); //数量设置 2字节 16bit 用S
        $cmd .= pack('L','88'); //roleList
        //发送数据
        $socket->send($cmd);
        //服务端返回数据
        $res = $socket->recv();
        sleep(1);
        //关闭socket链接
        $socket->close();
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
     */
    public function actionCloseServer(){
        $socket = new SocketHelper(Yii::app()->params['socket_logic_ip'], Yii::app()->params['socket_logic_port']);
        //包头处理
        $cmd = $socket->getLogicPackHeader(0x01032027, 33);
        //包体处理
        $cmd .= pack('a33', Yii::app()->params['socket_password']); //Password
        //发送数据
        $socket->send($cmd);
        //服务端返回数据
        $res = $socket->recv();
        sleep(1);
        //关闭socket链接
        $socket->close();
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
    public function actionRequestLogin(){
        $server_group_id = 9;
        $socket = new SocketHelper(Yii::app()->params['socket_gateway_ip'], Yii::app()->params['socket_gateway_port']);
        //定义socket响应状态码
        $key_result_code = 100000;
        $key_role_id = 431001;
        $key_has_role = 100001;
        //$key_role_name = 431002;
        //包头处理
        $cmd = $socket->getGateWayPackHeader(0x01020001, 18);
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
    protected function createRole($socket, $server_group_id, $role_id){
        //包头处理
        $cmd = $socket->getGateWayPackHeader(0x01030003, 31);
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
    protected function enterScene($socket, $server_group_id, $role_id){
        //包头处理
        $cmd = $socket->getGateWayPackHeader(0x01030C01, 16);
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
    
}