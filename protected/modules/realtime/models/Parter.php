<?php

/**
 * This is the model class for table "parter".
 *
 * The followings are the available columns in table 'parter':
 * @property string $id
 * @property string $parter_id
 * @property string $role_id
 * @property string $server_group_id
 * @property string $attributes
 * @property string $orgin_attribute
 * @property string $extra_attribute
 * @property string $ratio_attribute
 * @property string $parter_equipmentlist
 * @property string $parter_booklist
 * @property string $parter_energy
 * @property string $update_time
 * @property integer $booklist_open_slot
 */
class Parter extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Parter the static model class
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
		return 'parter';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('parter_id, role_id, server_group_id, update_time', 'required'),
			array('booklist_open_slot', 'numerical', 'integerOnly'=>true),
			array('parter_id, role_id, server_group_id', 'length', 'max'=>11),
			array('attributes, orgin_attribute, extra_attribute, ratio_attribute', 'length', 'max'=>1024),
			array('parter_equipmentlist, parter_booklist, parter_energy', 'length', 'max'=>512),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, parter_id, role_id, server_group_id, attributes, orgin_attribute, extra_attribute, ratio_attribute, parter_equipmentlist, parter_booklist, parter_energy, update_time, booklist_open_slot', 'safe', 'on'=>'search'),
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
			'parter_id' => 'Parter',
			'role_id' => 'Role',
			'server_group_id' => 'Server Group',
			'attributes' => 'Attributes',
			'orgin_attribute' => 'Orgin Attribute',
			'extra_attribute' => 'Extra Attribute',
			'ratio_attribute' => 'Ratio Attribute',
			'parter_equipmentlist' => 'Parter Equipmentlist',
			'parter_booklist' => 'Parter Booklist',
			'parter_energy' => 'Parter Energy',
			'update_time' => 'Update Time',
			'booklist_open_slot' => 'Booklist Open Slot',
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
		$criteria->compare('parter_id',$this->parter_id,true);
		$criteria->compare('role_id',$this->role_id,true);
		$criteria->compare('server_group_id',$this->server_group_id,true);
		$criteria->compare('attributes',$this->attributes,true);
		$criteria->compare('orgin_attribute',$this->orgin_attribute,true);
		$criteria->compare('extra_attribute',$this->extra_attribute,true);
		$criteria->compare('ratio_attribute',$this->ratio_attribute,true);
		$criteria->compare('parter_equipmentlist',$this->parter_equipmentlist,true);
		$criteria->compare('parter_booklist',$this->parter_booklist,true);
		$criteria->compare('parter_energy',$this->parter_energy,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('booklist_open_slot',$this->booklist_open_slot);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}