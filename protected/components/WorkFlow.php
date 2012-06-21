<?php

class WorkFlow {

    /**
     * 根据flow_id获取流程节点信息
     * @param int $flow_id
     * @return string
     */
    public static function getNodeInfo($flow_id)
    {
        Yii::import('approve.models.Node');
        $nodes = Node::model()->findAllByAttributes(array('flow_id' => $flow_id));
        $str = '';
        if(count($nodes)){
            foreach ($nodes as $node) {
                $username = Account::user('id', $node->user_id, 'username');
                $str .= $username . '&nbsp;';
            }
        }
        return $str;
    }
    
    /**
     * 流程初始化
     * @param string $tag 流程标签
     * @param int  $relate_id  关联ID
     */
    public static function initFlow($tag, $relate_id)
    {
        Yii::import('approve.models.*');
        $flow = Flow::model()->findByAttributes(array('tag' => $tag, 'status' => 2));
        if(empty($flow)){
            return array('flag' => 0, 'msg' => "标签为{$tag}的审批流程不存在");
        }
        $node = Node::model()->findByAttributes(array('flow_id' => $flow->id));
        if(empty($node)){
            return array('flag' => 0, 'msg' => "标签为{$tag}的审批流程未创建相关节点");
        }
        $task = new Task();
        $task->id = Yii::app()->getController()->getAutoIncrementKey('bl_task');
        $task->flow_id = $flow->id;
        $task->create_time = time();
        $task->status = 0;
        $task->user_id = Yii::app()->user->getUid();
        $task->relate_id = $relate_id;
        if($task->validate()){
            $task->save();
            Util::log($flow->name . '审批流程添加成功', 'approve', __FILE__, __LINE__);
            return array('flag' => 1, 'msg' => '操作成功');
        }else{
            return array('flag' => 0, 'msg' => '参数验证失败');
        }
    }
    
    /**
     * 验证任务审批权限
     * @param int $task_id
     * @param $flow_id 流程ID
     * @return boolean
     */
    public static function verifyAuth($flow_id, $task_id)
    {
        $node = self::getCurrentNode($flow_id, $task_id);
        if(empty($node)){
            return false;
        }else{
            return Yii::app()->user->getUid() == $node->user_id ?  true : false;
        }
    }
    
    /**
     * 验证是否是最后一个节点
     */
    public static function isLastNode($flow_id, $node_id)
    {
        $last_node_id = self::getLastNode($flow_id, $node_id);
        return $last_node_id == $node_id ? true : false;
    }
    
    /**
     * 获取当前流转的节点
     * @param $flow_id 流程ID
     * @param $task_id 任务ID
     */
    public static function getCurrentNode($flow_id, $task_id)
    {
        Yii::import('approve.models.*');
        $criteria = new EMongoCriteria();
        $criteria->addCond('flow_id', '==', $flow_id);
        $criteria->addCond('task_id', '==', $task_id);
        $criteria->sort('id', EMongoCriteria::SORT_DESC)->limit(1);
        $record = Approve::model()->findAll($criteria);
        $node_id = null;
        if(empty($record)){
            $node_id = self::getFirstNode($flow_id);
        }else{
            $record = $record[0];
            if(!self::isLastNode($flow_id, $record->node_id)){
                $node_id = self::getNextNode($flow_id, $record->node_id);
            }
        }
        return empty($node_id) ? '' : Node::model()->findByPk($node_id);
    }
    
    /**
     * 获取流程的第一个节点
     */
    protected static function getFirstNode($flow_id){
        Yii::import('approve.models.Node');
        $node = Node::model()->findByAttributes(array('flow_id' => $flow_id));
        if(empty($node)){
            throw new CException('flow node is not exists ...');
        }else{
            return $node->id;
        }
    }
    
    /**
     * 获取流程的下一个节点
     */
    protected static function getNextNode($flow_id, $node_id){
        Yii::import('approve.models.Node');
        $criteria = new EMongoCriteria();
        $criteria->addCond('flow_id', '==', $flow_id);
        $criteria->addCond('id', '>', $node_id);
        $node = Node::model()->find($criteria);
        if(empty($node)){
            throw new CException('flow node is not exists ...');
        }else{
            return $node->id;
        }
    }
    
    /**
     * 获取流程的最后一个节点
     */
    protected static function getLastNode($flow_id, $node_id){
        Yii::import('approve.models.Node');
        $criteria = new EMongoCriteria();
        $criteria->addCond('flow_id', '==', $flow_id);
        $criteria->sort('id', EMongoCriteria::SORT_DESC)->limit(1);
        $node = Node::model()->findAll($criteria);
        if(empty($node)){
            throw new CException('flow node is not exists ...');
        }else{
            $node = $node[0];
            return $node->id;
        }
    }
    
}