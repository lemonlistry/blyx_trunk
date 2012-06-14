<?php

/**
 * This is the model class for table "role_bookinfo".
 *
 * The followings are the available columns in table 'role_bookinfo':
 * @property integer $id
 * @property integer $role_id
 * @property integer $server_group_id
 * @property string $packagebooks
 * @property string $equipedbooks
 * @property integer $packopenslot
 * @property string $openmasters
 * @property integer $equipopenslot
 * @property string $tempackage
 * @property string $update_time
 */
class RoleBookinfoAR extends ActiveRecord
{
    public $equipedbooks;
    public $packageinfo;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RoleBookinfo the static model class
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
		return 'role_bookinfo';
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
			array('role_id, server_group_id, packopenslot, equipopenslot', 'numerical', 'integerOnly'=>true),
			array('packagebooks, equipedbooks, openmasters, tempackage', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, role_id, server_group_id, packagebooks, equipedbooks, packopenslot, openmasters, equipopenslot, tempackage, update_time', 'safe', 'on'=>'search'),
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
			'packagebooks' => 'Packagebooks',
			'equipedbooks' => 'Equipedbooks',
			'packopenslot' => 'Packopenslot',
			'openmasters' => 'Openmasters',
			'equipopenslot' => 'Equipopenslot',
			'tempackage' => 'Tempackage',
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
		$criteria->compare('role_id',$this->role_id);
		$criteria->compare('server_group_id',$this->server_group_id);
		$criteria->compare('packagebooks',$this->packagebooks,true);
		$criteria->compare('equipedbooks',$this->equipedbooks,true);
		$criteria->compare('packopenslot',$this->packopenslot);
		$criteria->compare('openmasters',$this->openmasters,true);
		$criteria->compare('equipopenslot',$this->equipopenslot);
		$criteria->compare('tempackage',$this->tempackage,true);
		$criteria->compare('update_time',$this->update_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}