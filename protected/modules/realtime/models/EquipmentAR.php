<?php

/**
 * This is the model class for table "equipment".
 *
 * The followings are the available columns in table 'equipment':
 * @property string $id
 * @property string $equip_id
 * @property string $role_id
 * @property string $server_group_id
 * @property string $attributes
 * @property integer $is_delete
 * @property string $update_time
 */
class EquipmentAR extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EquipmentAR the static model class
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
		return 'equipment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('equip_id, update_time', 'required'),
			array('is_delete', 'numerical', 'integerOnly'=>true),
			array('equip_id, role_id, server_group_id', 'length', 'max'=>10),
			array('attributes', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, equip_id, role_id, server_group_id, attributes, is_delete, update_time', 'safe', 'on'=>'search'),
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
			'equip_id' => 'Equip',
			'role_id' => 'Role',
			'server_group_id' => 'Server Group',
			'attributes' => 'Attributes',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('equip_id',$this->equip_id,true);
		$criteria->compare('role_id',$this->role_id,true);
		$criteria->compare('server_group_id',$this->server_group_id,true);
		$criteria->compare('attributes',$this->attributes,true);
		$criteria->compare('is_delete',$this->is_delete);
		$criteria->compare('update_time',$this->update_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}