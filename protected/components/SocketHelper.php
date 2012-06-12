<?php

/**
 * socket help class 
 * @author shadow
 *
 */
class SocketHelper{
    
    //IP地址
    private $ip;
    //端口号
    private $port;
    //socket链接
    private $socket;
    
    /**
     * 构造方法
     * @param string $ip
     * @param int $port
     */
    public function  __construct($ip, $port){
        $this->ip = $ip;
        $this->port = $port;
        $this->open();
    }
    
    /**
     * 打开socket链接
     */
    protected function open(){
        $this->socket = new ClientSocket();
        $this->socket->open($this->ip,$this->port);
    }
    
    /**
     * 发送数据包
     * @param string $cmd 二进制数据包
     */
    public function send($cmd){
        $this->socket->send($cmd);
    }
    
    /**
     * 接收响应数据 如果是二进制包返回 需要 unpack
     */
    public function recv(){
        $res = $this->socket->recv();
        return $res;
        //return unpack('L',$res);
    }
    
    /**
     * 获取socket错误信息
     */
    public function error(){
        return $this->socket->error();
    }
    
    /**
     * 关闭socket链接
     */
    public function close(){
        $this->socket->close();
    }
    
    /**
     * 获取逻辑服包头信息 打包顺序  nSock  nUserId  nType nLength nSerialNo nVersion
     * @param int $nType 协议类型
     * @param int $nLength 包体长度
     * @param int $nSock 默认值0
     * @param int $nUserId 默认值0
     * @param int $nSerialNo 默认值0
     * @param int $nVersion 默认值1
     * @return string
     */
    public function getLogicPackHeader($nType, $nLength, $nSock = 0, $nUserId = 0, $nSerialNo = 0, $nVersion = 1){
        $cmd = pack('L',$nSock);
        $cmd .= pack('L',$nUserId);
        $cmd .= pack('L',$nType);
        $cmd .= pack('L',$nLength);
        $cmd .= pack('L',$nSerialNo);
        $cmd .= pack('L',$nVersion);
        return $cmd;
    }
    
    /**
     * 获取网关包头信息 打包顺序   nType nLength nSerialNo nVersion
     * @param int $nType 协议类型
     * @param int $nLength 包体长度
     * @param int $nSerialNo 默认值0
     * @param int $nVersion 默认值1
     * @return string
     */
    public function getGateWayPackHeader($nType, $nLength, $nSerialNo = 0, $nVersion = 1){
        $cmd = pack('L',$nType);
        $cmd .= pack('L',$nLength);
        $cmd .= pack('L',$nSerialNo);
        $cmd .= pack('L',$nVersion);
        return $cmd;
    }
    
    /**
     * 解析服务端响应的包 模拟登录  进入场景 创建角色 包含包头信息
     * @param array $response 响应包
     * @param string $response_type 响应协议号
     * @param string $format 解析格式
     * @param int $head_length 包头长度 
     * @param int $kv_state_length key value 对声明长度
     * @return array
     */
    public function parseResponsePack($response, $response_type = null, $head_length = 32, $kv_state_length = 4, $format = 'H*'){
        if(empty($response)){
            $this->returnJson(0);
            Yii::app()->end();
        }
        //解包
        $res = unpack($format, $response);
        $res = implode('', $res);
        $length = $head_length + $kv_state_length;
        //截取响应的协议号包体
        if(!empty($response_type)){
            $response_type_arr = str_split($response_type, 2);
            $response_type_arr = array_reverse($response_type_arr);
            $code = implode('', $response_type_arr);
            $res = strstr($res, $code);
        }
        //获得包体内容
        $packet = substr($res, $length);
        //每两个长度组成一个字节数组
        $res_arr = str_split($packet, 2);
        //每4个字节截取为一个数组
        $chunk_arr = array_chunk($res_arr, 4);
        $result = array();
        //获取响应包体的key value 键值对
        foreach ($chunk_arr as $key => $value) {
            if($key % 2 == 0){
                $val = array_reverse($value);
                $str = implode('', $val);
                $k = base_convert($str, 16, 10);  
            }else{
                $val = array_reverse($value);
                $str = implode('', $val);
                $v = base_convert($str, 16, 10);  
                $result[$k] = $v;
            }
        }
        return $result;
    }
    
    /**
     * 解析服务端响应的包 禁言 解除禁言 禁止登录 解除禁止登录 关闭server 没有包头信息
     * @param array $response 响应包
     * @param string $response_type 响应协议号
     * @param string $format 解析格式
     * @return array
     */
    public function parseNoHeaderResonsePack($response, $response_type = null, $format = 'H*'){
        if(empty($response)){
            $this->returnJson(0);
            Yii::app()->end();
        }
        $v = 0;
        //解包
        $res = unpack($format, $response);
        foreach ($res as $value) {
            //每两个长度组成一个字节数组
            $res_arr = str_split($value, 2);
            $val = array_reverse($res_arr);
            $v = implode('', $val);
            $v = base_convert($v, 16, 10);
            return $v;
        }
    }
    
    /**
     * 解析socket响应信息, 并记录日志
     * @param int $flag
     */
    public function returnJson($flag, $msg = ''){
        switch ($flag) {
            case 0:
                $msg .= '数据响应错误';
                break;
            case 1:
                $msg .= '操作成功';
                break;
            case 2:
                $msg .= '鉴权错误';
                break;
            case 3:
                $msg .= '角色不存在';
                break;
            case 4:
                $msg .= '其他错误';
            break;
        }
        Util::log($msg, 'service', __FILE__, __LINE__);
        echo json_encode(array('flag' => $flag, 'msg' => $msg));
    }
    
}