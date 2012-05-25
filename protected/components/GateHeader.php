<?php
class GateHeader{
	private $nSock; //
	private $dwUserId; //
	private $dwType;//协议号
	private $dwLength;//长度
	private $dwSerialNo;//序列号
	private $dwVersion;//版本号
	public function __construct($nSock,$dwUserId,$dwType,$dwLength,$dwSerialNo,$dwVersion){
		$this->nSock = $nSock;
		$this->dwUserId = $dwUserId;
		$this->dwType = $dwType;
		$this->dwLength = $dwLength;
		$this->dwSerialNo = $dwSerialNo;
		$this->dwVersion = $dwVersion;
	}
	public function setNSock($nSock){
		$this->nSock = $nSock;
	}
	public function setDwUserId($dwUserId){
		$this->dwUserId = $dwUserId;
	}
	public function setDwType($dwType){
		$this->dwType = $dwType;
	}
	public function setDwLength($dwLength){
		$this->dwLength = $dwLength;
	}
	public function setDwSerialNo($dwSerialNo){
		$this->dwSerialNo = $dwSerialNo;
	}
	public function setDwVersion($dwVersion){
		$this->dwVersion = $dwVersion;
	}
	public function getNSock($nSock){
		return $this->nSock;
	}
	public function getDwUserId($dwUserId){
		return $this->dwUserId;
	}
	public function getDwType(){
		return $this->dwType;
	}
	public function getDwLength(){
		return $this->dwLength;
	}
	public function getDwSerialNo(){
		return $this->dwSerialNo;
	}
	public function getDwVersion(){
		return $this->dwVersion;
	}
	public function getGateHeaderPack(){
		$cmd =pack('I',$this->nSock);
		$cmd.=pack('L',$this->dwUserId);
		$cmd.=pack('L',$this->dwType); //协议号
    	$cmd.=pack('L',$this->dwLength); //长度
    	$cmd.=pack('L',$this->dwSerialNo); //序列号
    	$cmd.=pack('L',$this->dwVersion); //版本号
    	return $cmd;
	}
}