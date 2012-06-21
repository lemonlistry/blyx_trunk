<?php

/**
 * This is the MongoDB Document model class based on table "bl_flow".
 */
class Flow extends MongoDocument
{
    public $id;
    public $tag;
    public $name;
    public $desc;
    public $status = 2;  //0 无效流程  1 历史流程   2 正常流程
    public $create_time;

    /**
     * Returns the static model of the specified AR class.
     * @return Flow the static model class
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
        return 'bl_flow';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id, tag, name, desc, status, create_time', 'required'),
            array('status, create_time', 'numerical', 'integerOnly'=>true),
            array('tag', 'length', 'max'=>25),
            array('name, desc', 'length', 'max'=>255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, tag, name, desc, status, create_time', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'tag' => '标签',
            'name' => '名称',
            'desc' => '描述',
            'status' => '状态',
        );
    }
    
    /**
     * 获取任务状态
     */
    public function getStatus($status = ''){
        $list = array('无效', '历史', '正常');
        return '' === $status ? $list : $list[$status];
    }
}