<?php

/**
 * This is the MongoDB Document model class based on table "bl_notice".
 */
class GmActionRecord extends MongoDocument
{
    public $id;                 //主键
    public $server_id;          //服务器ID
    public $user_account;         //账号名
    public $role_id;               //角色ID
    public $role_name;           //角色名
    public $begin_time;          //开始时间
    public $seconds;            //禁言多长时间seconds
    public $operator;            //操作人
    public $comment;             //备注
    public $type;         //操作类型  允许聊天 1 禁止聊天 2  允许登陆 3 禁止登陆4

    /**
     * Returns the static model of the specified AR class.
     * @return Notice the static model class
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
        return 'bl_gm_action_record';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id, server_id, user_account, role_id, role_name, begin_time, seconds, operator, type', 'required'),
            array('server_id, seconds, type, role_id','numerical'),
            array('comment', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, server_id,  user_account, role_id, role_name, begin_time, seconds, operator, type', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
}