<?php
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
     * 获取包头信息 打包顺序  nSock  nUserId  nType nLength nSerialNo nVersion
     * @param int $nType 协议类型
     * @param int $nLength 包体长度
     * @param int $nSock 默认值0
     * @param int $nUserId 默认值0
     * @param int $nSerialNo 默认值0
     * @param int $nVersion 默认值1
     * @return string
     */
    public function getPackHeader($nType, $nLength, $nSock = 0, $nUserId = 0, $nSerialNo = 0, $nVersion = 1){
        $cmd = pack('L',$nSock);
        $cmd .= pack('L',$nUserId);
        $cmd .= pack('L',$nType);
        $cmd .= pack('L',$nLength);
        $cmd .= pack('L',$nSerialNo);
        $cmd .= pack('L',$nVersion);
        return $cmd;
    }
}