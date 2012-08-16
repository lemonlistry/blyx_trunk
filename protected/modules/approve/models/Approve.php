<?php

/**
 * This is the MongoDB Document model class based on table "bl_approve".
 */
class Approve extends MongoDocument
{
    public $id;
    public $task_id;
    public $flow_id;
    public $node_id;
    public $user_id;
    public $comment;
    public $status;  // 1 通过   2 拒绝
    public $create_time;

    /**
     * Returns the static model of the specified AR class.
     * @return Approve the static model class
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
        return 'bl_approve';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id, task_id, flow_id, node_id, user_id, comment, status, create_time', 'required'),
            array('id, task_id, flow_id, node_id, user_id, status, create_time', 'numerical', 'integerOnly'=>true),
            array('comment', 'length', 'max'=>255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, task_id, flow_id, node_id, user_id, comment, status, create_time', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'task_id' => 'Task',
            'flow_id' => 'Flow',
            'node_id' => 'Node',
            'user_id' => 'User ID',
            'comment' => '评论',
            'status' => '状态',
            'create_time' => 'Create Time',
        );
    }
    
	/**
     * 获取审批状态
     */
    public function getStatus($status = ''){
        $list = array(1 => '通过', 2 => '拒绝');
        return '' === $status ? $list : $list[$status];
    }
    
}