<?php

class DefaultController extends Controller
{
    public function actionIndex(){
        $this->actionSendAward();exit;
        $this->actionForbidLogin();
        $this->actionForbidChat();
        $this->actionPermitLogin();
        $this->actionPermitChat();
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
        //包头处理
        $cmd = pack('I',0); //nSock
        $cmd .= pack('L',0); //nUserId
        $cmd .= pack('L',0x01032001); //nType
        $cmd .= pack('L',41); //nLength
        $cmd .= pack('L',0); //nSerialNo
        $cmd .= pack('L',1); //nVersion
        //包体处理
        $cmd .= pack('a33', 'boluo123'); //Password
        $cmd .= pack('i*',1111); //roleId
        $cmd .= pack('i*',1111); //seconds
        //发送数据
        $socket = new SocketHelper(Yii::app()->params['socket_ip'], Yii::app()->params['socket_port']);
        $socket->send($cmd);
        $res = $socket->recv();
        sleep(1);
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
        //包头处理
        $cmd = pack('I',0); //nSock
        $cmd .= pack('L',0); //nUserId
        $cmd .= pack('L',0x01032003); //nType
        $cmd .= pack('L',41); //nLength
        $cmd .= pack('L',0); //nSerialNo
        $cmd .= pack('L',1); //nVersion
        //包体处理
        $cmd .= pack('a33', 'boluo123'); //Password
        $cmd.= pack('i*',2222); //roleId
        $cmd.= pack('i*',2222); //seconds
        //发送数据
        $socket = new SocketHelper(Yii::app()->params['socket_ip'], Yii::app()->params['socket_port']);
        $socket->send($cmd);
        $res = $socket->recv();
        sleep(1);
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
        //包头处理
        $cmd = pack('I',0); //nSock
        $cmd .= pack('L',0); //nUserId
        $cmd .= pack('L',0x01032005); //nType
        $cmd .= pack('L',37); //nLength
        $cmd .= pack('L',0); //nSerialNo
        $cmd .= pack('L',1); //nVersion
        //包体处理
        $cmd .= pack('a33', 'boluo123'); //Password
        $cmd .= pack('i*',3333); //roleId
        //发送数据
        $socket = new SocketHelper(Yii::app()->params['socket_ip'], Yii::app()->params['socket_port']);
        $socket->send($cmd);
        $res = $socket->recv();
        sleep(1);
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
        //包头处理
        $cmd = pack('I',0); //nSock
        $cmd .= pack('L',0); //nUserId
        $cmd .= pack('L',0x01032007); //nType
        $cmd .= pack('L',37); //nLength
        $cmd .= pack('L',0); //nSerialNo
        $cmd .= pack('L',1); //nVersion
        //包体处理
        $cmd .= pack('a33', 'boluo123'); //Password
        $cmd .= pack('i*',4444); //roleId
        //发送数据
        $socket = new SocketHelper(Yii::app()->params['socket_ip'], Yii::app()->params['socket_port']);
        $socket->send($cmd);
        $res = $socket->recv();
        sleep(1);
        $socket->close();
    }
    
    /**
     * GM 发送奖励给玩家
     * 
     * 包头: 
     * int nSock 默认填0
     * int nUserId 默认填0
     * int nType 协议id
     * int nLength 包体的长度62 = 33 + 4 + 25
     * int nSerialNo 默认填0
     * int nVersion  默认填1
     * 
     * 包体:
     * Password定长33个字节(默认填boluo123)
     * awardName定长25个字节  礼包名称
     * time 4字节  秒数
     * itemStruct 0字节   	物品结构体（物品id，物品数量）
     * roleList 0字节  角色列表
     */
    public function actionSendAward(){
        //包头处理
        $cmd = pack('I',0); //nSock
        $cmd .= pack('L',0); //nUserId
        $cmd .= pack('L',0x01032023); //nType
        $cmd .= pack('L',62); //nLength
        $cmd .= pack('L',0); //nSerialNo
        $cmd .= pack('L',1); //nVersion
        //包体处理
        $cmd .= pack('a33', 'boluo123'); //Password
        $cmd .= pack('i*',5555); //awardName
        $cmd .= pack('i*',5555); //time
        $cmd .= pack('s*',2); //数量设置 2字节 16bit 用S
        $cmd .= pack('i*',array()); //itemStruct
        $cmd .= pack('s*',2); //数量设置 2字节 16bit 用S
        $cmd .= pack('i*',5555); //roleList
        //发送数据
        $socket = new SocketHelper(Yii::app()->params['socket_ip'], Yii::app()->params['socket_port']);
        $socket->send($cmd);
        $res = $socket->recv();
        sleep(1);
        $socket->close();
    }
    
}