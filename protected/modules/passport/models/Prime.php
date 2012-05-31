<?php

/**
 * This is the MongoDB Document model class based on table "{{prime}}".
 */
class Prime extends MongoDocument
{
    public $uid;
    public $channel_id;
    public $resource_id;
    public $prime;

    /**
     * Returns the static model of the specified AR class.
     * @return Prime the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated collection name
     */
    public function getCollectionName()
    {
        return 'bl_prime';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('channel_id, resource_id, prime', 'required'),
            array('uid, channel_id, resource_id, prime', 'numerical', 'integerOnly'=>true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('uid, channel_id, resource_id, prime', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'uid' => 'Uid',
            'channel_id' => 'Channel',
            'resource_id' => 'Resource',
            'prime' => 'Prime',
        );
    }
}