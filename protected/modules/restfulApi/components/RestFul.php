<?php

/**
 * RestFul Components
 *
 * @author shadow
 */
class RestFul extends CController {

    //请求url
    public $url;
    //请求方式 GET PUT POST DELETE
    public $verb;
    //POST 字段
    public $field;
    //请求字段长度
    public $length;
    //身份验证 用户名称
    public $username;
    //身份验证 用户密码
    public $password;
    //接受数据类型
    public $type;
    //响应内容
    public $response;
    //请求状态
    public $status;
    //curl handle
    public $ch;

    /**
     * 接受请求 并分发到响应的action
     */
    public function actionIndex(){
        $method = strtolower(Yii::app()->request->getRequestType());
        Yii::app()->controller->$method();
    }

    /**
     * 发送响应
     * @param type $status
     * @param type $body
     * @param type $content_type
     */
    public function sendResponse($status = 200, $body = '', $content_type = 'text/html'){
        $status_header = 'HTTP/1.1 ' . $status;
        header($status_header);
        header('Content-type: ' . $content_type);
        echo $body;
        exit;
    }

    /**
     * 发送请求
     * @param type $url 请求地址
     * @param type $verb 请求放啊是
     * @param type $field 请求参数
     */
    public function sendRequest ($url, $verb = 'GET', $field = array())
    {
        $this->url = $url;
        $this->verb = $verb;
        $this->length = 0;
        $this->type = 'application/json';
        $this->field = http_build_query($field, '', '&');
        $this->status = null;
        $this->ch = curl_init();
        if ($this->username !== null && $this->password !== null){
            $this->setAuth($ch);
        }
        $method = '_init' . strtoupper($this->verb);
        $this->$method();
    }

    /**
     * 设置GET参数
     */
    protected function _initGet ()
    {
        $this->_exec($this->ch);
    }

    /**
     * 设置POST参数
     */
    protected function _initPost ()
    {
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $this->field);
        curl_setopt($this->ch, CURLOPT_POST, 1);
        $this->_exec($this->ch);
    }

    /**
     * 设置PUT参数
     */
    protected function _initPut ()
    {
        $this->length = strlen($this->field);
        $fh = fopen('php://memory', 'rw');
        fwrite($fh, $this->requestBody);
        rewind($fh);
        curl_setopt($this->ch, CURLOPT_INFILE, $fh);
        curl_setopt($this->ch, CURLOPT_INFILESIZE, $this->length);
        curl_setopt($this->ch, CURLOPT_PUT, true);
        $this->_exec($this->ch);
        fclose($fh);
    }

    /**
     * 设置DELETE参数
     */
    protected function _initDelete ()
    {
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        $this->_exec($this->ch);
    }

    /**
     * 添加curl参数并执行
     */
    protected function _exec ()
    {
        curl_setopt($this->ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($this->ch, CURLOPT_URL, $this->url);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, array ('Accept: ' . $this->type));
        $this->response = curl_exec($this->ch);
        $this->status = curl_getinfo($this->ch);
        curl_close($this->ch);
    }

    /**
     * 添加身份验证
     */
    protected function _setAuth ()
    {
        curl_setopt($this->ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
        curl_setopt($this->ch, CURLOPT_USERPWD, $this->username . ':' . $this->password);
    }

    /**
     * 设置请求类型
     * @param string $type
     */
    public function setType ($type)
    {
        $this->type = $type;
    }

    /**
     * 设置密码
     * @param string $password
     */
    public function setPassword ($password)
    {
        $this->password = $password;
    }

    /**
     * 设置url
     * @param string $url
     */
    public function setUrl ($url)
    {
        $this->url = $url;
    }

    /**
     * 设置用户名
     * @param string $username
     */
    public function setUsername ($username)
    {
        $this->username = $username;
    }

    /**
     * 设置请求方式
     * @param string $verb
     */
    public function setVerb ($verb)
    {
        $this->verb = $verb;
    }

    /**
     * 获取响应内容
     * @return string
     */
    public function getResponse ()
    {
        return $this->response;
    }

    /**
     * 获取请求状态
     * #return string
     */
    public function getStatus ()
    {
        return $this->status;
    }

}

