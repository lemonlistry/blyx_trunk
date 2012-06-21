<?php

/**
 * This is the MongoDB Document model class based on table "bl_node".
 */
class Node extends MongoDocument
{
    public $id;
    public $name;
    public $flow_id;
    public $user_id;

    /**
     * Returns the static model of the specified AR class.
     * @return Node the static model class
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
        return 'bl_node';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id, name, flow_id, user_id', 'required'),
            array('id, flow_id, user_id', 'numerical', 'integerOnly'=>true),
            array('name', 'length', 'max'=>25),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, flow_id, user_id', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => '名称',
            'flow_id' => '流程',
            'user_id' => '用户',
        );
    }
}