<?php

/**
 * This is the MongoDB Document model class based on table "bl_gift".
 */
class Gift extends MongoDocument
{
    public $id;
    public $server_id;
    public $role_id;
    public $role_name;
    public $name;
    public $item_id;
    public $num;
    public $time = 86400;
    public $status = 0; //0 审核中  1 通过   2 拒绝
    public $user_id;
    public $create_time;

    /**
     * Returns the static model of the specified AR class.
     * @return Gift the static model class
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
        return 'bl_gift';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id, server_id, role_id, role_name, name, item_id, num, time, status, create_time, user_id', 'required'),
            array('id, server_id, item_id, num, time, status, create_time', 'numerical', 'integerOnly'=>true),
            array('name', 'length', 'max'=>255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, server_id, role_id, role_name, name, item_id, num, time, status, create_time, user_id', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'role_id' => '角色ID',
            'role_name' => '角色名称',
            'name' => '礼包名称',
            'item_id' => '物品ID',
            'num' => '数量',
            'time' => '有效时间',
            'server_id' => '服务器',
            'status' => 'Status',
            'create_time' => 'Create Time',
        );
    }

   /**
     * 获取礼包状态
     * @param int $status
     */
    public function getStatus($status = ''){
        $list = array('审核中', '通过', '拒绝');
        return $status === '' ? $list : $list[$status];
    }

}