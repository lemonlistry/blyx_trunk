<?php

/**
 * This is the MongoDB Document model class based on table "bl_notice".
 */
class Notice extends MongoDocument
{
    public $id;                 //主键
    public $server_id;          //服务器ID
    public $interval_time = 60; //间隔时间(秒)
    public $play_times = 1;     //废弃字段 按照时间区间和间隔轮询发送公告 最短间隔1分钟
    public $content;            //公告内容
    public $status = 0;         //0 审核中  1 通过   2 拒绝   3 已发送
    public $send_time = 0;      //公告发送时间 发送一次更新一次
    public $begin_time;         //公告发送开始时间
    public $end_time;           //公告发送结束时间
    public $create_time;        //创建时间

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
            array('id, server_id, interval_time, play_times, content, status, send_time, create_time, begin_time, end_time', 'required'),
            array('begin_time', 'compare', 'compareValue' => time(), 'operator' => '>', 'message' => '公告发送开始时间必须大于当前时间', 'on'=>'insert'),
            array('server_id, interval_time, play_times, status, send_time, create_time', 'numerical', 'integerOnly'=>true),
            array('content', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, server_id, interval_time, play_times, content, status, send_time, create_time, begin_time, end_time', 'safe', 'on'=>'search'),
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
            'begin_time' => '公告发送开始时间',
            'end_time' => '公告发送结束时间',
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