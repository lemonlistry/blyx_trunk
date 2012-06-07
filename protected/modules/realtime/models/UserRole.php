<?php

/**
 * This is the model class for table "user_role".
 *
 * The followings are the available columns in table 'user_role':
 * @property string $id
 * @property string $role_id
 * @property string $user_account
 * @property integer $server_group_id
 * @property string $role_name
 * @property string $role_level
 * @property string $role_reputation
 * @property string $role_silver
 * @property string $role_gold
 * @property string $role_fightpower
 * @property string $attributes
 * @property string $scene_info
 * @property string $update_time
 */
class UserRole extends ActiveRecord
{
    public $server_group_id;
    public $role_name;
    public $user_account;
    public $role_id;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return UserRole the static model class
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
        return 'user_role';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('role_id, role_name, role_level, role_reputation, role_silver, role_gold, role_fightpower, attributes, scene_info, update_time', 'required'),
            array('server_group_id', 'numerical', 'integerOnly'=>true),
            array('role_id', 'length', 'max'=>11),
            array('user_account, scene_info', 'length', 'max'=>255),
            array('role_name', 'length', 'max'=>33),
            array('role_level, role_reputation, role_silver, role_gold, role_fightpower', 'length', 'max'=>10),
            array('attributes', 'length', 'max'=>2048),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, role_id, user_account, server_group_id, role_name, role_level, role_reputation, role_silver, role_gold, role_fightpower, attributes, scene_info, update_time', 'safe', 'on'=>'search'),
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
            'user_account' => 'User Account',
            'server_group_id' => 'Server Group',
            'role_name' => 'Role Name',
            'role_level' => 'Role Level',
            'role_reputation' => 'Role Reputation',
            'role_silver' => 'Role Silver',
            'role_gold' => 'Role Gold',
            'role_fightpower' => 'Role Fightpower',
            'attributes' => 'Attributes',
            'scene_info' => 'Scene Info',
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
        $criteria->compare('user_account',$this->user_account,true);
        $criteria->compare('server_group_id',$this->server_group_id);
        $criteria->compare('role_name',$this->role_name,true);
        $criteria->compare('role_level',$this->role_level,true);
        $criteria->compare('role_reputation',$this->role_reputation,true);
        $criteria->compare('role_silver',$this->role_silver,true);
        $criteria->compare('role_gold',$this->role_gold,true);
        $criteria->compare('role_fightpower',$this->role_fightpower,true);
        $criteria->compare('attributes',$this->attributes,true);
        $criteria->compare('scene_info',$this->scene_info,true);
        $criteria->compare('update_time',$this->update_time,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}