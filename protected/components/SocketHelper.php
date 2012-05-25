<?php
class SocketHelper{
    
    private $ip;
    private $port;
    private $socket;
    
    public function  __construct($ip, $port){
        $this->ip = $ip;
        $this->port = $port;
        $this->open();
    }
    
    protected function open(){
        $this->socket = new ClientSocket();
        $this->socket->open($this->ip,$this->port);
    }
    
    public function send($cmd){
        $this->socket->send($cmd);
    }
    
    public function recv(){
        $res = $this->socket->recv();
        return $res;
        //return unpack('L',$res);
    }
    
    public function error(){
        return $this->socket->error();
    }
    
    public function close(){
        $this->socket->close();
    }
}