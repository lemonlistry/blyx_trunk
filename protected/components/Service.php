<?php

class Service
{

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
     * roleList  角色列表  roleId=987654321 表示全服奖励
     *
     * request url : http://xxx/service/default/sendaward?award_name=xxx&time=111&item_id=222&num=11&role_id=999
     */
    public static function sendAward($server_id, $role_ids, $award_name, $time, $item_id, $num)
    {
        $role_list = explode('|', $role_ids);
        $count = count($role_list);
        if($count){
            $server = Server::model()->findByAttributes(array('id' => $server_id));
            $socket = new SocketHelper($server->web_ip, $server->web_socket_port);
            //包头处理
            $length = 74 + $count * 4;
            $cmd = $socket->getLogicPackHeader(0x0A032023, $length);
            //包体处理
            $cmd .= pack('a33', Yii::app()->params['socket_password']); //Password
            $cmd .= pack('a25', $award_name); //awardName
            $cmd .= pack('L', $time); //time
            $cmd .= pack('S', 1); //数量设置 2字节 16bit 用S
            $cmd .= pack('L', $item_id); //itemStruct  $item_id
            $cmd .= pack('L', $num); //itemStruct
            $cmd .= pack('S', $count); //数量设置 2字节 16bit 用S
            foreach ($role_list as $v) {
                $cmd .= pack('L', $v); //roleList
            }
            //发送数据
            $socket->send($cmd);
            //服务端返回数据
            $res = $socket->recv();
            $par_res = $socket->parseNoHeaderResponsePack($res);
            $socket->parseSocketResponseMsg($par_res, 'socket请求: 发送礼包');
            sleep(1);
            //关闭socket链接
            $socket->close();
        }else{
            Util::log('发送礼包角色ID为空', 'service', __FILE__, __LINE__);
        }
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
        $par_res = $socket->parseNoHeaderResponsePack($res);
        $socket->parseSocketResponseMsg($par_res, 'socket请求: 发送在线公告');
        sleep(1);
        //关闭socket链接
        $socket->close();
    }

    /**
     * 刷新活动时间
     * @param int $server_id
     * @param int $activityId
     * @param int $startTime
     * @param int $endTime
     * @param int $duration
     * @param int $isEnable
     * @param int $isHot
     */
    public static function sendAwardActivity($server_id, $activityId, $startTime, $endTime, $duration, $isEnable, $isHot)
    {
        $server = Server::model()->findByAttributes(array('server_id' => $server_id));
        $socket = new SocketHelper($server->web_ip, $server->web_socket_port);
        $cmd = $socket->getLogicPackHeader(0x0A032031, 57);
        $cmd .= pack('a33', Yii::app()->params['socket_password']);
        $cmd .= pack('L', $activityId);
        $cmd .= pack('L', $startTime);
        $cmd .= pack('L', $endTime);
        $cmd .= pack('L', $duration);
        $cmd .= pack('L', $isEnable);
        $cmd .= pack('L', $isHot);
        $socket->send($cmd);
        $res = $socket->recv();
        $par_res = $socket->parseNoHeaderResponsePack($res);
        $result = $socket->parseSocketResponseMsg($par_res, 'socket请求: 刷新活动信息');
        sleep(1);
        $socket->close();
        return $result;
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
    public static function requestLogin($user_account, $session_id, $parameter)
    {
        $message_box = array();
        $servers = Util::getAllServers();
        if(count($servers)){
            //定义socket响应状态码
            $key_result_code = 100000;
            //$key_role_id = 431001;
            //$key_has_role = 100001;
            //$key_role_name = 431002;
            //包头处理
            $account_length = strlen($user_account);
            $session_length = strlen($session_id);
            $param_length = strlen($parameter);
            $length = 10 + $account_length + $session_length + $param_length;
            foreach ($servers as $v) {
                try {
                    $socket = new SocketHelper($v->gateway_ip, $v->gateway_socket_port);
                    $cmd = $socket->getGateWayPackHeader(0x01020001, $length);
                    //包体处理
                    $cmd .= pack('L', $v->server_id); //serverGroupId
                    $cmd .= pack('S', $account_length); //数量设置 2字节 16bit 用S
                    $cmd .= pack('a*', $user_account); //userAccount
                    $cmd .= pack('S', $session_length); //数量设置 2字节 16bit 用S
                    $cmd .= pack('a*', $session_id); //sessionId
                    $cmd .= pack('S', $param_length); //数量设置 2字节 16bit 用S
                    $cmd .= pack('a*', $parameter); //parameter
                    //发送数据
                    $socket->send($cmd);
                    //服务端返回数据
                    $res_login = $socket->recv();
                    $par_res_login = $socket->parseResponsePack($res_login);
                    //是否正常登录
                    $msg = isset($par_res_login[$key_result_code]) ? $par_res_login[$key_result_code] : -1;
                    $style = $msg == 0 ? '' : 'style="color:red"';
                    $message = '<p ' . $style . '>[' . date('Y-m-d H:i:s') . '] check server_id=' .$v->server_id . ', result=' . $msg . '</p>';
                    /*
                    if($par_res_login[$key_result_code] == 0){
                        Yii::log('socket login success ...');
                        $role_id = $par_res_login[$key_role_id];
                        //如果没有角色 创建角色
                        if($par_res_login[$key_has_role] != 1){
                            $res_role = self::createRole($socket, $server_group_id, $role_id);
                            $par_res_role = $socket->parseResponsePack(s);
                            if($par_res_role[$key_result_code] == 0){
                                Yii::log('socket create role success ...');
                            }else if($par_res_role[$key_result_code] == 481004){
                                throw new CException('socket create role error, role name exist ...');
                            }else{
                                throw new CException('socket create role error ...');
                            }
                        }
                        //进入场景
                        $res_scene = self::enterScene($socket, $server_group_id, $role_id);
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
                    */
                    //关闭socket链接
                    $socket->close();
                } catch (Exception $e) {
                    $message = '<p style="color:red">[' . date('Y-m-d H:i:s') . '] check server exception ' . $e->getMessage() . ', params is ' . print_r($v, true) . '</p>';
                }
                array_push($message_box, $message);
            }
        }
        return $message_box;
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
    protected static function createRole($socket, $server_group_id, $role_id)
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
    protected static function enterScene($socket, $server_group_id, $role_id)
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

}
