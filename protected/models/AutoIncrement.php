<?php

/**
 * This is the MongoDB Document model class based on table "{{auto_increment}}".
 */
class AutoIncrement extends MongoDocument
{
    public $table;
    public $index;

    /**
     * Returns the static model of the specified AR class.
     * @return AutoIncrement the static model class
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
        return 'table';
    }

    /**
     * @return string the associated collection name
     */
    public function getCollectionName()
    {
        return 'bl_auto_increment';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('index', 'numerical', 'integerOnly'=>true),
            array('table', 'length', 'max'=>25),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('table, index', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'table' => 'Table',
            'index' => 'Index',
        );
    }
}