<?php

/**
 * This is the model class for table "role_formation".
 *
 * The followings are the available columns in table 'role_formation':
 * @property string $id
 * @property string $role_id
 * @property integer $server_group_id
 * @property string $role_formationlist
 * @property string $update_time
 */
class RoleFormationAR extends ActiveRecord
{
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RoleFormationAR the static model class
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
		return 'role_formation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('role_id, server_group_id, update_time', 'required'),
			array('server_group_id', 'numerical', 'integerOnly'=>true),
			array('role_id', 'length', 'max'=>11),
			array('role_formationlist', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, role_id, server_group_id, role_formationlist, update_time', 'safe', 'on'=>'search'),
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
			'role_id' => 'Role',
			'server_group_id' => 'Server Group',
			'role_formationlist' => 'Role Formationlist',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('role_id',$this->role_id,true);
		$criteria->compare('server_group_id',$this->server_group_id);
		$criteria->compare('role_formationlist',$this->role_formationlist,true);
		$criteria->compare('update_time',$this->update_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}