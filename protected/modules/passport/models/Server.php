<?php

/**
 * This is the MongoDB Document model class based on table "bl_server_info".
 */
class Server extends MongoDocument
{
    public $id;
    public $gname;
    public $sname;
    public $create_time;
    public $status;
    public $recommend;
    public $type;
    public $db_ip;
    public $db_port;
    public $db_name;
    public $db_user;
    public $db_passwd;
    public $web_ip;
    public $web_socket_port;
    public $server_id;
    public $gateway_ip;
    public $gateway_socket_port;

    /**
     * Returns the static model of the specified AR class.
     * @return Server the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * returns the primary key field for this model
     */
    public function primaryKey()
    {
        return 'id';
    }

    /**
     * @return string the associated collection name
     */
    public function getCollectionName()
    {
        return 'bl_server';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id, gname, sname, create_time, status, recommend, type, db_ip, db_port, db_name, db_user, db_passwd, web_ip, web_socket_port, server_id,
                    gateway_socket_port, gateway_ip', 'required'),
            array('id, status, recommend, type, db_port, web_socket_port, gateway_socket_port', 'numerical', 'integerOnly'=>true),
            array('gname, db_name, db_user, db_passwd', 'length', 'max'=>19),
            array('sname', 'length', 'max'=>33),
            array('web_ip, db_ip, gateway_ip', 'length', 'max'=>100),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, gname, sname, create_time, status, recommend, type, db_ip, db_port, db_name, db_user, db_passwd, web_ip, web_socket_port, server_id,
                    gateway_socket_port, gateway_ip', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'gname' => '游戏名称',
            'sname' => '服务器名称',
            'create_time' => '开服时间',
            'status' => '服务器状态',
            'recommend' => '服务器标记',
            'type' => '服务器类型',
            'db_ip' => '数据库地址',
            'db_port' => '数据库端口',
            'db_name' => '数据库名称',
            'db_user' => '数据库账号名',
            'db_passwd' => '数据库密码',
            'web_ip' => 'web服务器IP',
            'web_socket_port' => 'socket端口',
            'server_id' => '服务器ID',
            'gateway_socket_port' => '网关服务器端口',
            'gateway_ip' => '网关服务器IP',
        );
    }

    /**
     * @see MongoDocument::afterSave()
     */
    public function afterSave(){
        $this->generateDbConfig();
        return parent::afterSave();
    }

    /**
     * @see EMongoDocument::afterDelete()
     */
    public function afterDelete(){
        $this->generateDbConfig();
        return parent::afterDelete();
    }

    /**
     * 生成数据库配置文件
     */
    protected function generateDbConfig(){
        $content = '<?php return array();';
        $list = $this->findAll();
        if(count($list)){
            $content = '<?php return array("components"=>array(';
            foreach ($list as $v) {
                $content .= <<<EOF
'db{$v->id}' => array(
    'class' => 'CDbConnection',
    'connectionString' => 'mysql:host={$v->db_ip};dbname={$v->db_name};port={$v->db_port}',
    'emulatePrepare' => true,
    'username' => '{$v->db_user}',
    'password' => '{$v->db_passwd}',
    "charset" => "utf8",
),
EOF;
            }
            $content .= '));';
        }

        file_put_contents(dirname(__DIR__) . '/../../config/db_config.php', $content);
    }

    /**
     * 返回服务器状态
     */
    public function getServerStatus($status = ''){
        $list = array('异常', '正常');
        return $status === '' ? $list : $list[$status];
    }

    /**
     * 返回服务器类型
     */
    public function getServerType($type = ''){
        $list = array('日志服', '逻辑服', '网关服', '游戏服');
        return $type === '' ? $list : $list[$type];
    }

    /**
     * 返回服务器标记
     */
    public function getServerRecommend($status = ''){
        $list = array('测试服', '正式服');
        return $status === '' ? $list : $list[$status];
    }
}