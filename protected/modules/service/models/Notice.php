<?php

/**
 * This is the MongoDB Document model class based on table "bl_notice".
 */
class Notice extends MongoDocument
{
    public $id;
    public $server_id;
    public $interval_time = 3;
    public $play_times = 1;
    public $content;
    public $status = 0; //0 审核中  1 通过   2 拒绝   3 已发送
    public $send_time;
    public $create_time;

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
        return 'bl_notice';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id, server_id, interval_time, play_times, content, status, send_time, create_time', 'required'),
            array('send_time', 'compare', 'compareValue' => time(), 'operator' => '>', 'message' => '公告发送时间必须大于当前时间', 'on'=>'insert'),
            array('server_id, interval_time, play_times, status, send_time, create_time', 'numerical', 'integerOnly'=>true),
            array('content', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, server_id, interval_time, play_times, content, status, send_time, create_time', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'server_id' => '服务器',
            'interval_time' => '间隔时间',
            'play_times' => '播放次数',
            'content' => '公告内容',
            'status' => '状态',
            'send_time' => '发送时间',
            'create_time' => '创建时间',
        );
    }
    
    /**
     * 获取公告状态
     * @param int $status
     */
    public function getStatus($status = ''){
        $list = array('审核中', '通过', '拒绝', '已发送');
        return $status === '' ? $list : $list[$status];
    }
}