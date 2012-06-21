<?php

/**
 * This is the MongoDB Document model class based on table "bl_task".
 */
class Task extends MongoDocument
{
    public $id;
    public $flow_id;
    public $user_id;
    public $status;  // 0 审批中  1 通过  2 拒绝
    public $create_time;
    public $relate_id; //关联ID

    /**
     * Returns the static model of the specified AR class.
     * @return Task the static model class
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
        return 'bl_task';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id, flow_id, user_id, status, create_time, relate_id', 'required'),
            array('id, flow_id, user_id, status, create_time, relate_id', 'numerical', 'integerOnly'=>true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, flow_id, user_id, status, create_time, relate_id', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'flow_id' => 'Flow',
            'user_id' => 'User',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'relate_id' => 'Relate ID',
        );
    }
    
    /**
     * 获取任务状态
     */
    public function getStatus($status = ''){
        $list = array('审批中 ', '通过', '拒绝');
        return '' === $status ? $list : $list[$status];
    }
}