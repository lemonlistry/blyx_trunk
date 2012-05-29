<?php

/**
 * This is the MongoDB Document model class based on table "{{user}}".
 */
class User extends MongoDocument
{
    public $username;
    public $password;
    private $__identity;

    /**
     * Returns the static model of the specified AR class.
     * @return User the static model class
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
        return 'username';
    }

    /**
     * @return string the associated collection name
     */
    public function getCollectionName()
    {
        return 'bl_user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('username, password', 'required'),
            array('username', 'length', 'max'=>20),
            array('password', 'length', 'max'=>32),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, username, password', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'username' => 'Username',
            'password' => 'Password',
        );
    }

    /**
     * 设置mongodb组件
     */
    public function getDbComponent(){
        return 'mongodb';
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login() {
        if ($this->__identity === null) {
            $this->__identity = new UserIdentity($this->username, $this->password);
            $this->__identity->authenticate();
        }
        if ($this->__identity->errorCode === UserIdentity::ERROR_NONE) {
            Yii::app()->user->login($this->__identity);
            return true;
        }else{
            return false;
        }
    }
}