<?php

class Service
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
     */
    public static function forbidLogin($server_id, $role_id, $seconds)
    {
        $server = Server::model()->findByAttributes(array('id' => $server_id));
        $socket = new SocketHelper($server->web_ip, $server->web_socket_port);
        //包头处理
        $cmd = $socket->getLogicPackHeader(0x0A032001, 41);
        //包体处理
        $cmd .= pack('a33', Yii::app()->params['socket_password']); //Password
        $cmd .= pack('L', $role_id); //roleId
        $cmd .= pack('L', $seconds); //seconds
        //发送数据
        $socket->send($cmd);
        //服务端返回数据
        $res = $socket->recv();
        $par_res = $socket->parseNoHeaderResonsePack($res);
        $socket->returnJson($par_res, 'socket请求: 禁止玩家登陆');
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
     * 
     * request url : http://xxx/service/default/forbidchat?seconds=1111&role_id=999
     */
    public static function forbidChat($server_id, $role_id, $seconds)
    {
        $server = Server::model()->findByAttributes(array('id' => $server_id));
        $socket = new SocketHelper($server->web_ip, $server->web_socket_port);
        //包头处理
        $cmd = $socket->getLogicPackHeader(0x0A032003, 41);
        //包体处理
        $cmd .= pack('a33', Yii::app()->params['socket_password']); //Password
        $cmd .= pack('L', $role_id); //roleId
        $cmd .= pack('L', $seconds); //seconds
        //发送数据
        $socket->send($cmd);
        //服务端返回数据
        $res = $socket->recv();
        $par_res = $socket->parseNoHeaderResonsePack($res);
        $socket->returnJson($par_res, 'socket请求: 禁止玩家聊天');
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
     * 
     * request url : http://xxx/service/default/permitlogin?role_id=999
     */
    public static function permitLogin($server_id, $role_id)
    {
        $server = Server::model()->findByAttributes(array('id' => $server_id));
        $socket = new SocketHelper($server->web_ip, $server->web_socket_port);
        //包头处理
        $cmd = $socket->getLogicPackHeader(0x0A032005, 37);
        //包体处理
        $cmd .= pack('a33', Yii::app()->params['socket_password']); //Password
        $cmd .= pack('L', $role_id); //roleId
        //发送数据
        $socket->send($cmd);
        //服务端返回数据
        $res = $socket->recv();
        $par_res = $socket->parseNoHeaderResonsePack($res);
        $socket->returnJson($par_res, 'socket请求: 允许玩家登陆');
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
     * 
     * request url : http://xxx/service/default/permitlogin?role_id=999
     */
    public static function permitChat($server_id, $role_id)
    {
        $server = Server::model()->findByAttributes(array('id' => $server_id));
        $socket = new SocketHelper($server->web_ip, $server->web_socket_port);
        //包头处理
        $cmd = $socket->getLogicPackHeader(0x0A032007, 37);
        //包体处理
        $cmd .= pack('a33', Yii::app()->params['socket_password']); //Password
        $cmd .= pack('L', $role_id); //roleId
        //发送数据
        $socket->send($cmd);
        //服务端返回数据
        $res = $socket->recv();
        $par_res = $socket->parseNoHeaderResonsePack($res);
        $socket->returnJson($par_res, 'socket请求: 允许玩家聊天');
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
     * roleList  角色列表  roleId=0 表示全服奖励
     * 
     * request url : http://xxx/service/default/sendaward?award_name=xxx&time=111&item_id=222&num=11&role_id=999
     */
    public static function sendAward($server_id, $role_id, $award_name, $time, $item_id, $num)
    {
        $server = Server::model()->findByAttributes(array('id' => $server_id));
        $socket = new SocketHelper($server->web_ip, $server->web_socket_port);
        //包头处理
        $cmd = $socket->getLogicPackHeader(0x0A032023, 78);
        //包体处理
        $cmd .= pack('a33', Yii::app()->params['socket_password']); //Password
        $cmd .= pack('a25', $award_name); //awardName
        $cmd .= pack('L', $time); //time
        $cmd .= pack('S', 1); //数量设置 2字节 16bit 用S
        $cmd .= pack('L', 410228); //itemStruct  $param['item_id']
        $cmd .= pack('L', $num); //itemStruct
        $cmd .= pack('S', 1); //数量设置 2字节 16bit 用S
        $cmd .= pack('L', $role_id); //roleList
        //发送数据
        $socket->send($cmd);
        //服务端返回数据
        $res = $socket->recv();
        $par_res = $socket->parseNoHeaderResonsePack($res);
        $socket->returnJson($par_res, 'socket请求: 发送礼包');
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
     * 
     * request url : http://xxx/service/default/closeserver
     */
    public static function closeServer($server_id)
    {
        $server = Server::model()->findByAttributes(array('id' => $server_id));
        $socket = new SocketHelper($server->web_ip, $server->web_socket_port);
        //包头处理
        $cmd = $socket->getLogicPackHeader(0x0A032027, 33);
        //包体处理
        $cmd .= pack('a33', Yii::app()->params['socket_password']); //Password
        //发送数据
        $socket->send($cmd);
        //服务端返回数据
        $res = $socket->recv();
        $par_res = $socket->parseNoHeaderResonsePack($res);
        $socket->returnJson($par_res, 'socket请求: 关闭服务器');
        sleep(1);
        //关闭socket链接
        $socket->close();
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
    public static function sendOnlineNotice($server_id, $interval_time, $play_times, $content)
    {
        $server = Server::model()->findByAttributes(array('id' => $server_id));
        $socket = new SocketHelper($server->web_ip, $server->web_socket_port);
        //包头处理
        $con_length = strlen($content);
        $length = $con_length + 43;
        $cmd = $socket->getLogicPackHeader(0x0A032011, $length);
        //包体处理
        $cmd .= pack('a33', Yii::app()->params['socket_password']); //Password
        $cmd .= pack('L', $interval_time); //intervalTime
        $cmd .= pack('L', $play_times); //playTimes
        $cmd .= pack('S', $con_length); //数量设置 2字节 16bit 用S
        $cmd .= pack('a*', $content); //content
        //发送数据
        $socket->send($cmd);
        //服务端返回数据
        $res = $socket->recv();
        $par_res = $socket->parseNoHeaderResonsePack($res);
        $socket->returnJson($par_res, 'socket请求: 发送在线公告');
        sleep(1);
        //关闭socket链接
        $socket->close();
    }
    
}