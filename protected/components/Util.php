<?php

/**
 * 应用程序日志类
 */
class Util {
    
    /**
     * 记录日志
     * 日志格式：<系统名称>|<模块>|<日志级别>|<发生时间>|<所在机器>|<登录用户>|<客户端IP>|<浏览器信息>|<日志信息>|<其它信息(如Session、堆栈信息、POST/GET等)>
     * LOG_LEVEL INFO ERROR TARCE DEBUG
     * @param str $mssage
     * @param str $line_number  error line.
     * @return status
     */
    public static function log($message, $module, $file_name, $line_number, $level = 'INFO')
    {
        Yii::import('log.models.Log');
        if(is_object($message) || is_array($message)){
            $msg = print_r($message,true);
        }else{
            $msg = $message;
        }
       
        $model = new Log();
        $model->module = $module;
        $model->level = $level;
        $model->url = Yii::app()->request->getHostInfo() . Yii::app()->request->getUrl();
        $model->type = Yii::app()->request->getRequestType();
        $model->browse = $_SERVER['HTTP_USER_AGENT'];
        $model->client_ip = Yii::app()->request->userHostAddress;
        $model->file_name = $file_name;
        $model->line_number = $line_number;
        $model->msg = $msg;
        $model->param = print_r($_REQUEST,true);
        $model->create_time = time();
        $model->server_ip = $_SERVER['SERVER_ADDR'];
        $model->operator = Yii::app()->user->name;
        $model->id = Yii::app()->getController()->getAutoIncrementKey('bl_log');
        if($model->validate()){
            $model->save();
        }else{
            throw new CException('log model validate error ...');
        }
        
    }
    
    /**
     * 提示信息 并跳转父页面
     * @param $url 
     */
    public static function header($url, $msg = ''){
        if(!empty($msg)){
            $msg = "alert('{$msg}');";
        }
        $str = <<<EOF
<script language="javascript" charset="utf-8">
{$msg}
parent.location.href = '{$url}';
</script>
EOF;
        echo $str;
        Yii::app()->end();
    }
    
     /**
     * 切割字符串
     * @param array $array
     */
    public static function getSplit($array){
        $str = str_replace(' ', '', $array);
        $str = str_replace('{{', '{', $str);
        preg_match_all('/\{(.*?)\}/',$str,$arr);
        foreach ($arr[1] as $k => $v){
            $arr = explode(',',$v);
            $list[$arr[0]] = $arr[1];
        }
        return $list;
    }
    
    /**
     * 切割字符串
     * @param array $array
     */
    public static function getOneSplit($array){
        $str = str_replace(' ', '', $array);
        $str = str_replace('{{', '{', $str);
        preg_match_all('/\{(.*?)\}/',$str,$arr);
        return $arr[1];
    }
    
    /**
     * 跳转到上一页面
     * @param string $msg
     */
    public static function history($msg = ''){
        if(!empty($msg)){
            $msg = "alert('{$msg}');";
        }
        $str = <<<EOF
<script language="javascript" charset="utf-8">
{$msg}
history.go(-1);
</script>
EOF;
        echo $str;
        Yii::app()->end();
    }

    /**
     * 重新加载页面
     * @param string $msg
     */
    public static function reload($msg = ''){
        if(!empty($msg)){
            $msg = "alert('{$msg}');";
        }
        $str = <<<EOF
<script language="javascript" charset="utf-8">
{$msg}
location.href = location.href;
</script>
EOF;
        echo $str;
        Yii::app()->end();
    }
    
}
