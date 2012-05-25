<?php

class DefaultController extends Controller
{
    public function actionIndex(){
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
        $socket = new SocketHelper(Yii::app()->params['socket_ip'], Yii::app()->params['socket_port']);
        //包头处理
        $cmd = $socket->getPackHeader('0x01032001', 41);
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
        $socket = new SocketHelper(Yii::app()->params['socket_ip'], Yii::app()->params['socket_port']);
        //包头处理
        $cmd = $socket->getPackHeader('0x01032003', 41);
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
        $socket = new SocketHelper(Yii::app()->params['socket_ip'], Yii::app()->params['socket_port']);
        //包头处理
        $cmd = $socket->getPackHeader('0x01032005', 37);
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
        $socket = new SocketHelper(Yii::app()->params['socket_ip'], Yii::app()->params['socket_port']);
        //包头处理
        $cmd = $socket->getPackHeader('0x01032007', 37);
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
     * itemStruct 0字节   	物品结构体（物品id，物品数量）
     * roleList 0字节  角色列表
     */
    public function actionSendAward(){
        $socket = new SocketHelper(Yii::app()->params['socket_ip'], Yii::app()->params['socket_port']);
        //包头处理
        $cmd = $socket->getPackHeader('0x01032023', 78);
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
     * int nLength 包体的长度0
     * int nSerialNo 默认填0
     * int nVersion  默认填1
     */
    public function actionCloseServer(){
        $socket = new SocketHelper(Yii::app()->params['socket_ip'], Yii::app()->params['socket_port']);
        //包头处理
        $cmd = $socket->getPackHeader('0x01032027', 33);
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
    
}