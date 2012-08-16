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
     * 提示信息
     */
    public static function message($msg){
        $msg = "alert('{$msg}');";
        $str = <<<EOF
<script language="javascript" charset="utf-8">
{$msg}
</script>
EOF;
        echo $str;
    }

     /**
     * 切割字符串
     * @param array $array
     */
    public static function getSplit($array){
        $list =array();
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
parent.location.href = parent.location.href;
</script>
EOF;
        echo $str;
        Yii::app()->end();
    }

    /**
     * 数据翻译 获取属性的value
     * $file_name 文件名称
     * item 递归循环的xml选项
     * attribute 匹配的属性
     * $return_key 返回的属性
     * $attribute_value 匹配的属性值
     * @return string
     */
     public static function translation($file_name, $item, $attribute, $attribute_value, $return_key = null){
        $item_str = implode('_', $item);
        $cache_key = 'TRANSLATION_' . $file_name . '_' . $item_str . '_' . $attribute . '_' . $attribute_value; 
        $cache_result = Yii::app()->cache->get($cache_key);
        if($cache_result){
            return $cache_result;
        }else{
            $xml = dirname(__DIR__) . '/data/' . $file_name . '.xml';
            if(file_exists($xml)){
                $result = null;
                $xml = simplexml_load_file($xml);
                if(count($item)){
                    foreach ($item as $value) {
                        $xml = $xml->$value;
                    }
                }
                $childrens = $xml->children();
                if(count($childrens)){
                    foreach ($childrens as $v) {
                        if($v[$attribute] == $attribute_value){
                            if(empty($return_key)){
                                $result = $v;
                            }else{
                                $result = $v[$return_key];
                            }
                            break;
                        }
                    }
                }
                Yii::app()->cache->set($cache_key, strval($result));
                return strval($result);
            }else{
                throw new CException("File {$xml} not exist");
            }
        }
    }

    /**
     * 数据翻译 获取属性的value 支持多个
     * formations 文件名称
     * item 递归循环的xml选项
     * attribute 匹配的属性
     * formationName 返回的属性
     * formationId 匹配的属性值数组
     * Util::translation($data);
     * @return array
     */
    public static function translationMuti($data){
        $result = array();
        $list = array();
        foreach ($data as $key => $value) {
            $xml = dirname(__DIR__) . '/data/' . $key . '.xml';
            if(file_exists($xml)){
                $xml = simplexml_load_file($xml);
                if(count($value['item'])){
                    foreach ($value['item'] as $item) {
                        $xml = $xml->$item;
                    }
                }
                $children = $xml->children();
                if(count($children)){
                    foreach ($children as $v) {
                         foreach ($value['attribute'] as $return_key => $attribute) {
                             if(in_array($v[$attribute['id']], $attribute['value'])){
                                 $index = $v[$attribute['id']];
                                 if(is_numeric($return_key)){
                                     $return_value = $v;
                                 }else{
                                     $return_value = $v[$return_key];
                                 }
                                 array_push($result, $index . '@' . $return_value);
                                 break;
                             }
                         }
                    }
                }
                if(count($result)){
                    foreach ($result as $v) {
                        $arr = explode('@', $v);
                        $list[$key][$arr[0]] = $arr[1];
                    }
                }
            }else{
                throw new CException("File {$xml} not exist");
            }
        }
        return count($data) > 1 ? $list : $list[$key];
    }

    /**
     * 根据主键获取服务器名称
     * @param int $server_id
     */
    public static function getServerName($server_id){
        if(empty($server_id)){
            return '全区全服';
        }else{
            Yii::import('passport.models.Server');
            $server = Server::model()->findByPk(intval($server_id));
            return empty($server) ? '' : $server->sname;
        }
    }

    /**
     * 获取服务器下拉框数据
     */
    public static function getServerSelect($flag = true){
        Yii::import('passport.models.Server');
        $criteria = new EMongoCriteria();
        $criteria->addCond('status', '==', 1);
        $criteria->addCond('recommend', '==', '1');
        $criteria->sort('id', EMongoCriteria::SORT_DESC);
        $servers = Server::model()->findAll($criteria);
        $select = array();
        if(count($servers)){
            foreach ($servers as $k => $v) {
                $select[$v->id] = $v->sname;
            }
        }
        if($flag){
            $select[0] = '全区全服';
        }
        return $select;
    }

    /**
     * 根据server_id获取服务器信息
     * @param int $server_id
     */
    public static function getServerAttribute($server_id, $attribute = null){
        if(empty($server_id)){
            return '';
        }else{
            Yii::import('passport.models.Server');
            $server = Server::model()->findByAttributes(array('server_id' => intval($server_id)));
            return empty($attribute) || empty($server) ? $server : ($server->$attribute);
        }
    }

    /**
     * 获取server_id对应服务器下拉框数据
     */
    public static function getRealServerSelect($flag = true){
        Yii::import('passport.models.Server');
        $criteria = new EMongoCriteria();
        $criteria->addCond('status', '==', 1);
        $criteria->addCond('recommend', '==', '1');
        $criteria->sort('id', EMongoCriteria::SORT_DESC);
        $servers = Server::model()->findAll($criteria);
        $select = array();
        if(count($servers)){
            foreach ($servers as $k => $v) {
                $select[$v->server_id] = $v->sname;
            }
        }
        if($flag){
            $select[0] = '全区全服';
        }
        return $select;
    }

    /**
     * 获取用户角色类型数组键值对
     * @return array
     */
    public static function getRoleGroupArr(){
        $result = array();
        Yii::import('passport.models.RoleGroup');
        $groups = RoleGroup::model()->findAll();
        if(count($groups)){
            foreach ($groups as $group) {
                $result[$group['id']] = $group['name'];
            }
        }
        return $result;
    }

    /**
     * 获取用户角色类型数组键值对
     * @return array
     */
    public static function getRoleArr(){
        $result = array();
        Yii::import('passport.models.Role');
        $roles = Role::model()->findAll();
        if(count($roles)){
            foreach ($roles as $role) {
                $result[$role['id']] = $role['name'];
            }
        }
        return $result;
    }

    /**
     * 获取用户角色类型数组键值对
     * @return array
     */
    public static function getResourceArr(){
        $result = array();
        Yii::import('passport.models.Resource');
        $resources = Resource::model()->findAll();
        if(count($resources)){
            foreach ($resources as $resource) {
                $result[$resource['id']] = $resource['name'];
            }
        }
        return $result;
    }

    /**
     * 获取流程数组键值对
     * @return array
     */
    public static function getFlowArr(){
        $result = array();
        Yii::import('approve.models.Flow');
        $flows = Flow::model()->findAll();
        if(count($flows)){
            foreach ($flows as $flow) {
                $result[$flow['id']] = $flow['name'];
            }
        }
        return $result;
    }

    /**
     * 获取用户数组键值对
     * @return array
     */
    public static function getUserArr(){
        $result = array();
        $users = Account::allUser();
        if(count($users)){
            foreach ($users as $user) {
                $result[$user->id] = $user->username;
            }
        }
        return $result;
    }

    /**
     * 根据游戏玩家角色名称获取角色ID
     * @param string $role_name
     * @param int $server_id 服务器ID
     * @return int
     */
    public static function getPlayerRoleId($role_name, $server_id){
        Yii::app()->getController()->setDbConnection($server_id);
        Yii::import('realtime.models.UserRoleAR');
        $model = UserRoleAR::model()->find('role_name = BINARY :role_name',array(':role_name' => $role_name));
        return empty($model) ? '' : $model->role_id;
    }

    /**
     * 根据游戏玩家账号名称获取角色名称
     * @param string $user_account
     * @param int $server_id 服务器ID
     * @return int
     */
    public static function getPlayerRoleName($user_account, $server_id){
        Yii::app()->getController()->setDbConnectionByServerId($server_id);
        Yii::import('realtime.models.UserRoleAR');
        $model = UserRoleAR::model()->find('user_account = BINARY :user_account',array(':user_account' => $user_account));
        return empty($model) ? '' : $model->role_name;
    }

    /**
     * 根据游戏玩家角色名称获取账号ID
     * @param string $role_name
     * @param int $server_id 服务器ID
     * @return int
     */
    public static function getPlayerAccount($role_name, $server_id){
        Yii::app()->getController()->setDbConnectionByServerId($server_id);
        Yii::import('realtime.models.UserRoleAR');
        $model = UserRoleAR::model()->find('role_name = BINARY :role_name',array(':role_name' => $role_name));
        return empty($model) ? '' : $model->user_account;
    }

    /**
     * 数据翻译 获取子标签的value
     * $file_name 文件名称
     * $item 递归循环的xml选项
     * $attribute 匹配的属性
     * $return_child 返回的子标签值
     * $attribute_value 匹配的属性值
     * @return string
     */
     public static function translationChildLabel($file_name, $item, $attribute, $attribute_value, $return_child){
        $xml = dirname(__DIR__) . '/data/' . $file_name . '.xml';
        if(file_exists($xml)){
            $result = null;
            $xml = simplexml_load_file($xml);
            if(count($item)){
                foreach ($item as $value) {
                    $xml = $xml->$value;
                }
            }
            $childrens = $xml->children();
            if(count($childrens)){
                foreach ($childrens as $k => $v) {
                    if($v[$attribute] == $attribute_value){
                        $label = $v->children();
                        if(count($label)){
                            foreach ($label as $key => $value) {
                                if($key == $return_child){
                                    $result = $value;
                                    break;
                                }
                            }
                        }
                        break;
                    }
                }
            }
            return strval($result);
        }else{
            throw new CException("File {$xml} not exist");
        }
    }

    /*
     * 导出的类
     * $array   标题数组  不要索引的
     * $list 数据
     * $arr   需要显示的数据的索引
     */
    public static function export($array, $list, $arr){
        $header = '';
        $res = '';
        if(count($array)){
            foreach($array as $k => $v){
                    $header .= iconv("UTF-8","GB2312//IGNORE",$v)."\t";
            }
        }
        $header = substr($header, 0, (strlen($header) - 1))."\n";
        if(count($list)){
            foreach ($list as $k => $v){
                if(count($arr)){
                    $server = Util::getServerAttribute($v['server_id']);
                    foreach ($arr as $key => $val){
                        if($val == 'server_id'){
                           $v[$val] = Util::getServerAttribute($v['server_id'])->sname;
                        }
                        if($val == 'children_type'){
                           $children_type = AppConst::$gold_children_type;
                           $v[$val] = $children_type[$v['children_type']];
                        }
                        if($val == 'type'){
                            $v[$val] = empty($v[$val]) ? '产出' : '消费';
                        }
                        if($val == 'time'){
                            $v[$val] = date('Y-m-d H:i:s', $v[$val]);
                        }
                        $res .= iconv("UTF-8","GB2312//IGNORE",(isset($v[$val]) ? $v[$val] : ''))."\t" ;
                    }
                    $res = substr($res, 0, (strlen($res) - 1))."\n";
                }
            }
        }
        return $header.$res;
    }

    /**
     * 获取所有服务器
     * @param string $recommend '0' 为测试服 '1' 为正式服
     * @param $status $status 0 为异常  1为正常
     */
    public static function getAllServers($recommend = '1', $status = 1){
        Yii::import('passport.models.Server');
        return Server::model()->findAllByAttributes(array('recommend' => $recommend, 'status' => $status));
    }

}
