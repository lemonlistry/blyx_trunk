<?php

/**
 * This is the MongoDB Document model class based on table "award_activity".
 */
class AwardActivity extends MongoDocument
{
	public $id;
	public $name;
	public $startTime;
	public $endTime;
	public $duration;
	public $isHot;
    public $serverId;
    public $isEnable;
    public $activityId;

	/**
	 * Returns the static model of the specified AR class.
	 * @return AwardActivity the static model class
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
		return 'bl_award_activity';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('duration, isHot, serverId, isEnable, activityId', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>1024),
			array('startTime, endTime', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, startTime, endTime, duration, isHot, serverId, isEnable', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'startTime' => 'Start Time',
			'endTime' => 'End Time',
			'duration' => 'Duration',
			'isTot' => 'Is Hot',
            'serverId' => 'Server ID',
            'isEnable' => 'Is Enable',
            'activityId' => 'Activity ID'
		);
	}
}
