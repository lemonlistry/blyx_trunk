<?php

/**
 * This is the model class for table "faction".
 *
 * The followings are the available columns in table 'faction':
 * @property integer $id
 * @property integer $faction_id
 * @property integer $server_group_id
 * @property string $faction_name
 * @property integer $faction_master_id
 * @property string $faction_master_name
 * @property string $faction_recruit
 * @property integer $faction_level
 * @property integer $faction_contribution
 * @property string $faction_introduction
 * @property string $faction_announcement
 * @property string $faction_master_qq
 * @property string $contribution_record
 * @property string $event_record
 * @property string $faction_attrib
 * @property integer $is_delete
 * @property string $update_time
 */
class FactionAR extends ActiveRecord
{
    public $faction_name;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FactionAR the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'faction';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('update_time', 'required'),
			array('faction_id, server_group_id, faction_master_id, faction_level, faction_contribution, is_delete', 'numerical', 'integerOnly'=>true),
			array('faction_name', 'length', 'max'=>30),
			array('faction_master_name', 'length', 'max'=>50),
			array('faction_recruit', 'length', 'max'=>10),
			array('faction_introduction', 'length', 'max'=>100),
			array('faction_announcement', 'length', 'max'=>250),
			array('faction_master_qq', 'length', 'max'=>20),
			array('contribution_record, event_record, faction_attrib', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, faction_id, server_group_id, faction_name, faction_master_id, faction_master_name, faction_recruit, faction_level, faction_contribution, faction_introduction, faction_announcement, faction_master_qq, contribution_record, event_record, faction_attrib, is_delete, update_time', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'faction_id' => 'Faction',
			'server_group_id' => 'Server Group',
			'faction_name' => 'Faction Name',
			'faction_master_id' => 'Faction Master',
			'faction_master_name' => 'Faction Master Name',
			'faction_recruit' => 'Faction Recruit',
			'faction_level' => 'Faction Level',
			'faction_contribution' => 'Faction Contribution',
			'faction_introduction' => 'Faction Introduction',
			'faction_announcement' => 'Faction Announcement',
			'faction_master_qq' => 'Faction Master Qq',
			'contribution_record' => 'Contribution Record',
			'event_record' => 'Event Record',
			'faction_attrib' => 'Faction Attrib',
			'is_delete' => 'Is Delete',
			'update_time' => 'Update Time',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('faction_id',$this->faction_id);
		$criteria->compare('server_group_id',$this->server_group_id);
		$criteria->compare('faction_name',$this->faction_name,true);
		$criteria->compare('faction_master_id',$this->faction_master_id);
		$criteria->compare('faction_master_name',$this->faction_master_name,true);
		$criteria->compare('faction_recruit',$this->faction_recruit,true);
		$criteria->compare('faction_level',$this->faction_level);
		$criteria->compare('faction_contribution',$this->faction_contribution);
		$criteria->compare('faction_introduction',$this->faction_introduction,true);
		$criteria->compare('faction_announcement',$this->faction_announcement,true);
		$criteria->compare('faction_master_qq',$this->faction_master_qq,true);
		$criteria->compare('contribution_record',$this->contribution_record,true);
		$criteria->compare('event_record',$this->event_record,true);
		$criteria->compare('faction_attrib',$this->faction_attrib,true);
		$criteria->compare('is_delete',$this->is_delete);
		$criteria->compare('update_time',$this->update_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}